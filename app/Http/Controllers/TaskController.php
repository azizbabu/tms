<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Branch;
use App\Company;
use App\Country;
use App\Department;
use App\TodoList;
use App\Task;
use App\TaskActivity;
use App\User;
use Carbon, File, Validator;

class TaskController extends Controller
{
    /**
    * For user access control
    */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('department_admin', ['except' => ['taskDetails']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Task::query();

        if(!isSuperAdmin()){
            $query->whereCompanyId($request->user()->company_id);

            if(isDepartmentAdmin()) {
                $query->whereDepartmentId($request->user()->employee->department_id);
            }
        }
        
        $tasks = $query->whereParentId(0)->latest('id')->paginate(25);
        $tasks->paginationSummery = getPaginationSummery($tasks->total(), $tasks->perPage(), $tasks->currentPage());

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(isSuperAdmin()) {
            $companies = Company::getDropDownList();
        }
        $parent_tasks = Task::getDropDownList();
        $parent_tasks = array_set($parent_tasks, '', 'Parent');
        
        return view('tasks.create', compact('companies', 'parent_tasks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [];
        if(isSuperAdmin()) {
            $rules = [
                'company_id'    => 'required|integer',
            ];
        }

        if(isSuperAdminOrAdmin()) {
            $rules = [
                'branch_id'    => 'required|integer',
                'department_id'    => 'required|integer',
            ];
        }

        $rules = $rules + array(
            'job_type'     => 'required|string',
            'title'        => 'required|string|max:255',
            'description'  => 'required',
        );

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            // store
            $task = !$request->has('task_id') ? new Task : Task::findOrFail($request->task_id);
            if(isSuperAdmin()) {
                $task->company_id = trim($request->company_id);
            }else {
                $task->company_id = $request->user()->company_id;
            }

            if(isSuperAdminOrAdmin()) {
                $task->branch_id = trim($request->branch_id);
                $task->department_id = trim($request->department_id);
            }else {
                $task->branch_id = $request->user()->branch_id;
                $task->department_id = $request->user()->employee->department_id;
            }
            
            $task->parent_id = $request->has('parent_id') ? trim($request->parent_id) : 0;
            $task->job_type = trim($request->job_type);
            $task->frequency = trim($request->frequency);
            $task->title = trim($request->title);
            $task->description = trim($request->description);
            $task->status = 'pending';
            
            if(!$request->has('task_id')) {
                $msg = 'added';
                $task->created_by = $request->user()->id;
            }else {
                $msg = 'updated';
                $task->updated_by = $request->user()->id;
            }
            if($task->save()) { 
                $task->slug = $task->id . '-' . str_slug($task->title);
                $task->save();
                $message = toastMessage ( " Task information has been successfully $msg", 'success' );

            }else{
                $message = toastMessage ( " Task information has not been successfully $msg", 'error' );
            }
            // redirect
            session()->flash('toast', $message);
            
            return redirect('tasks');
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
        $task = Task::findOrFail($id);

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        if(isSuperAdmin()) {
            $companies = Company::getDropDownList();
        }
        $parent_tasks = Task::getDropDownList($id);

        return view('tasks.edit', compact('task', 'companies','parent_tasks'));
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        if(Task::destroy($request->hdnResource)){
            $message = toastMessage('Task has been successfully removed.','success');
        }else{
            $message = toastMessage('Task has not been removed.','error');
        }

        // Redirect
        session()->flash('toast',$message);
        
        return back();
    }

    /**
    * Display task details page
    *
    * @param \Illuminate\Http\Request $request
    * @param int $task_id
    * @return \Illuminate\Http\Response
    */
    public function taskDetails(Request $request, $slug)
    {
        $task= Task::whereSlug($slug)->firstOrFail();
        $task_id = $task->id;
        $todo_list = TodoList::whereTaskId($task_id)->first();
        if($request->isMethod('POST')) {
            if($request->has('status')) {
                // update todo list
                $todo_list->status = trim($request->status);
                $todo_list->save();

                // insert
                $task_activity = new TaskActivity;
                $task_activity->employee_id = $request->user()->id;
                $task_activity->task_id = $task_id;
                $task_activity->comments = 'changes task status to '. $request->status;
                if($task_activity->save()) {
                    $message = toastMessage('Your task status has been updated.', 'success');
                }else {
                    $message = toastMessage('Your task status has not been updated.', 'error');
                }

                session()->flash('toast', $message);

                return back();

            }elseif($request->has('comments')) {
                // insert
                $task_activity = new TaskActivity;
                $task_activity->employee_id = $request->user()->id;
                $task_activity->task_id = $task_id;
                $task_activity->comments = trim($request->comments);
                if($task_activity->save()) {
                    $message = toastMessage('Your comments has been successfully added.', 'success');
                }else {
                    $message = toastMessage('Your comments has not been added.', 'error');
                }

                session()->flash('toast', $message);

                return back();
            }
        }
                
        if(!$todo_list) {

            session()->flash('toast', toastMessage('You are not allowed to view this page', 'error'));

            return back();
        }

        $task_activities = TaskActivity::whereTaskId($task_id)->get();

        return view('tasks.details', compact('todo_list','task_activities'));
    }

    /**
    * Get taskes based on company id
    *
    * @param int $id
    * @param int $task_id
    * @return \Illuminate\Http\Response
    */
    public function getBranches($id, $task_id=null)
    {
        $branches = Branch::whereCompanyId($id)->pluck('title', 'id')->all();

        $branch_options = '<option value="">Select a branch</option>';
        if($task_id) {
            $task = Task::find($task_id);
        }
        $selected = '';
        foreach($branches as $branch_id=>$title) {
            if(!empty($task) && $task->branch_id == $branch_id) {
                $selected = ' selected="selected"';
            }else {
                $selected = '';
            }
            $branch_options .= '<option value="'.$branch_id.'"'.$selected.'>'.$title.'</option>';
        }

        return response()->json([
            'branch_options' => $branch_options
        ]);
    }

    /**
    * Get departments based on branch id
    *
    * @param int $id
    * @param int $task_id
    * @return \Illuminate\Http\Response
    */
    public function getDepartments($id, $task_id=null)
    {
        if($task_id) {
            $task = Task::find($task_id);
        }

        $departments = Department::whereBranchId($id)->pluck('title', 'id')->all();

        $department_options = '<option value="">Select a department</option>';
        
        $selected = '';
        foreach($departments as $department_id=>$title) {
            if(!empty($task) && $task->department_id == $department_id) {
                $selected = ' selected="selected"';
            }else {
                $selected = '';
            }
            $department_options .= '<option value="'.$department_id.'"'.$selected.'>'.$title.'</option>';
        }

        return response()->json([ 
            'department_options' => $department_options
        ]);
    }

    /**
    * Get parent tasks based on department id
    *
    * @param int $id
    * @param int $task_id
    * @return \Illuminate\Http\Response
    */
    public function getTasks($id, $task_id=null)
    {
        if($task_id) {
            $task = Task::find($task_id);
        }

        $parent_tasks = Task::whereDepartmentId($id)->pluck('title', 'id');

        if(!empty($task)) {
            $parent_tasks = $parent_tasks->except($task->id);
        }

        $parent_tasks = $parent_tasks->all();

        $parent_task_options = '<option value="">Parent</option>';
        
        $selected = '';
        foreach($parent_tasks as $parent_task_id=>$title) {
            if(!empty($task) && $task->parent_id == $parent_task_id) {
                $selected = ' selected="selected"';
            }else {
                $selected = '';
            }
            $parent_task_options .= '<option value="'.$parent_task_id.'"'.$selected.'>'.$title.'</option>';
        }

        return response()->json([ 
            'parent_task_options' => $parent_task_options
        ]);
    }

    /**
     * Description: This function will load bulk task create form
     */
    public function getBulkTaskCreate(){
        if(isSuperAdmin()) {
            $companies = Company::getDropDownList();
        }
        $parent_tasks = Task::getDropDownList();
        $parent_tasks = array_set($parent_tasks, '', 'Parent');
        
        return view('tasks.bulk', compact('companies', 'parent_tasks'));
    }
    
    /**
     * Description: This function will receive bulk task save request 
     * and then it will explode bulk task title using new line 
     * and insert them one by on in task table
     */
    public function bulkTaskSave(Request $request){
        
        $rules = [];

        /** Preparing validation rules based on user label */

        if(isSuperAdmin()) {
            $rules = [
                'company_id'    => 'required|integer',
            ];
        }

        if(isSuperAdmin() || isAdmin()) {
            $rules = [
                'branch_id'    => 'required|integer',
                'department_id'    => 'required|integer',
            ];
        }

        $rules = $rules + array(
            'job_type'     => 'required|string',
            'title'        => 'required|string',
            'description'  => 'required'
        );

        //validating data
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{

            //exploding task tiles using new line (\n)
            $taskArr = explode(PHP_EOL, trim($request->title));

            $saveCounter = 0;

            foreach($taskArr as $taskTitle){

                //skiping empty task title
                if(!empty($taskTitle)){
                    //init task model to store data
                    $task = new Task();
                    
                    if(isSuperAdmin()) {
                        //for super admin taking company_id from request
                        $task->company_id = trim($request->company_id);
                    }else {
                        //taking company id from loggedin user's object
                        $task->company_id = $request->user()->company_id;
                    }

                    if(isSuperAdmin() || isAdmin()) {
                        //for super admin and admin taking branch and depratment from request
                        $task->branch_id = trim($request->branch_id);
                        $task->department_id = trim($request->department_id);
                    }else {
                        //branch and depratment from loggedin user's object
                        $task->branch_id = $request->user()->branch_id;
                        $task->department_id = $request->user()->employee->department_id;
                    }
                    
                    $task->parent_id = $request->has('parent_id') ? trim($request->parent_id) : 0;
                    $task->job_type = trim($request->job_type);
                    $task->title = trim($taskTitle);
                    $task->description = trim($request->description);
                    $task->priority = trim($request->priority);
                    $task->status = 'pending';
                    $task->created_by = $request->user()->id;

                    if($task->save()){
                        $saveCounter++;
                    }
                }
            }

            $message = toastMessage ( "$saveCounter Tasks has been successfully created", 'success' );
            session()->flash('toast', $message);

            // redirect            
            return redirect()->back();
        }
    }
}
