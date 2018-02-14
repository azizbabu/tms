<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Employee;
use App\EmployeeTask;
use App\Task;
use App\TaskRole;
use App\TodoList;

use Carbon, Validator;

class EmployeeTaskController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('department_admin', ['except' => ['showEmployeeTasks', 'assignPredefinedTask', 'assignNeedBasisTask']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = EmployeeTask::query();

        if(!isSuperAdmin()){
            $query->whereAssignedBy($request->user()->id);
        }

        $employee_tasks = $query->select('id', 'employee_id', 'assigned_at')
            ->groupBy('employee_id')->latest('id')->paginate(10);
        $employee_tasks->paginationSummery = getPaginationSummery($employee_tasks->total(), $employee_tasks->perPage(), $employee_tasks->currentPage());

        $tasks     = Task::getDropDownList(NULL, false);
        $employees = Employee::getDropDownList();

        return view('employee_tasks.index', compact('employee_tasks', 'tasks', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'employee_id'  => 'required',
            'task_id'      => 'required',
        );

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            
            return response()->json(['status' => 400, 'error' => $validator->errors()]);
        }else{
            // store
            if($request->has('employee_task_id')) {
                $employee_task = EmployeeTask::find($request->employee_task_id);
                if($employee_task) {
                    EmployeeTask::whereEmployeeId($employee_task->employee_id)->whereAssignedBy($request->user()->id)->forceDelete();
                }
            }
            
            $i = 0;
            foreach($request->task_id as $task_id) {
                $employee_task = new EmployeeTask;
                $employee_task->employee_id = $request->employee_id;
                $employee_task->task_id = $task_id;
                $employee_task->assigned_by = $request->user()->id;
                $employee_task->assigned_at = Carbon::now();
                if($employee_task->save()) {
                    $i++;
                }
            }
            if(!$request->has('employee_task_id')) {
                $msg = 'added';
            }else {
                $msg = 'updated';
            }
            if($i) { 
                
                return response()->json(['status' => 200, 'type' => 'success', 'message' => $i.' task has beed successfully '.$msg.' as a assignment']);
            }else{
                
                return response()->json(['status' => 404, 'type' => 'error', 'message' => 'Task has not been '.$msg. ' for assignment']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee_task = EmployeeTask::findOrFail($id);
        $employee_task->task_ids = $employee_task->getTaskItems('id');

        return $employee_task->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $employee_task = EmployeeTask::find($request->hdnResource);
        if($employee_task) {
            if(EmployeeTask::whereEmployeeId($employee_task->employee_id)->whereAssignedBy($request->user()->id)->delete()) {

                $message = toastMessage('Employee task info has been successfully removed.','success');
            }else {
                $message = toastMessage('Employee task info has not been removed.','error');
            }
        }else {
            $message = toastMessage('Employee task info not found.','error');
        }
        
        // Redirect
        session()->flash('toast',$message);
        
        return back();
    }

    /**
     * Display Todo Tasklist
     *
     * @param \Illuminate\Http\Request 
     * @param int $employee_id 
     * @return \Illuminate\Http\Response
     */
    public function showEmployeeTasks($employee_id)
    {
        $employee = Employee::findOrFail($employee_id);
        $todo_lists = TodoList::join('tasks', 'todo_lists.task_id', '=', 'tasks.id')
            ->join('departments', 'tasks.department_id', '=', 'departments.id')
            ->join('employees', 'todo_lists.employee_id', '=', 'employees.id')
            ->where('todo_lists.employee_id', '=', $employee_id)
            ->select('todo_lists.id','todo_lists.status', 'todo_lists.assigned_at', 'todo_lists.deadline', 'todo_lists.achievement', 'tasks.title', 'tasks.frequency','tasks.job_type', 'employees.full_name', 'departments.title AS department_title')
            ->orderBy('todo_lists.deadline')->paginate(10);
        $todo_lists->paginationSummery = getPaginationSummery($todo_lists->total(), $todo_lists->perPage(), $todo_lists->currentPage());
        $tasks  = Task::join('employee_tasks', 'tasks.id', '=','employee_tasks.task_id')
                ->where('employee_tasks.employee_id', $employee_id)
                ->pluck('tasks.title', 'tasks.id');
        
        $parent_tasks = Task::getDropDownList();
        $task_roles = TaskRole::getDropDownList(true, $employee->department_id);

        return view('employee_tasks.show', compact('employee', 'todo_lists', 'tasks', 'parent_tasks', 'task_roles'));
    }

    /**
     * Store a newly created resource in todo list storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function assignPredefinedTask(Request  $request)
    {
        $rules = array(
            'employee_id'  => 'required|integer',
            'task_id'      => 'required',
            'task_role_id'      => 'required|integer',
        );

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            
            return response()->json(['status' => 400, 'error' => $validator->errors()]);
        }else{
            // store
            $i = 0;
            foreach($request->task_id as $task_id) {
                $employee_task = EmployeeTask::whereEmployeeId($request->employee_id)
                    ->whereTaskId($task_id)->first();
                $todo_list = new TodoList;
                $todo_list->employee_id = $request->employee_id;
                $todo_list->task_id = $task_id;
                $todo_list->task_role_id = $request->task_role_id;
                $todo_list->deadline = $employee_task ? $employee_task->deadline : Carbon::now()->addDay(mt_rand(1,7));
                $todo_list->assigned_by = $request->user()->id;
                $todo_list->assigned_at = Carbon::now();
                if($todo_list->save()) {
                    $i++;
                }
            }
            
            if($i) { 
                
                return response()->json(['status' => 200, 'type' => 'success', 'message' => $i.' task has beed successfully added as a assignment']);
            }else{
                
                return response()->json(['status' => 404, 'type' => 'error', 'message' => 'Task has not been added for assignment']);
            }
        }
    }

    /**
     * Store a newly created resource in tasks && todo list storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function assignNeedBasisTask(Request  $request)
    {
        $rules = array(
            'employee_id'  => 'required|integer',
            'title'        => 'required|string|max:255',
            'description'  => 'required',
            'task_role_id2' => 'required',
        );

        $messages = [
            'task_role_id2.required'  => 'The task role id field is required.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) {
            
            return response()->json(['status' => 400, 'error' => $validator->errors()]);
        }else{
            // store
            $i = 0;
            $employee = Employee::findOrFail($request->employee_id);
            // Insert data into tasks table
            $task = new Task;
            $task->company_id = $employee->company_id;
            $task->branch_id = $employee->branch_id;
            $task->department_id = $employee->department_id;
            $task->parent_id = $request->has('parent_id') ? trim($request->parent_id) : 0;
            $task->job_type = 'need_basis';
            $task->title = trim($request->title);
            $task->description = trim($request->description);
            $task->status = 'pending';
            
            $task->created_by = $request->user()->id;
            if($task->save()) { 
                $task->slug = $task->id . '-' . str_slug($task->title);
                $task->save();
                // Insert data into todo_lists table
                $todo_list = new TodoList;
                $todo_list->employee_id = $request->employee_id;
                $todo_list->task_id = $task->id;
                $todo_list->task_role_id = $request->task_role_id2;
                $todo_list->assigned_by = $request->user()->id;
                $todo_list->assigned_at = Carbon::now();
                if($todo_list->save()) {
                    $i++;
                }
            }

            if($i) { 
                
                return response()->json(['status' => 200, 'type' => 'success', 'message' => ' Task has beed successfully aasigned']);
            }else{
                
                return response()->json(['status' => 404, 'type' => 'error', 'message' => 'Task has not beed successfully aasigned']);
            }
        }
    }
}
