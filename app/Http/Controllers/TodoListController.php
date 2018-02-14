<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Employee;
use App\EmployeeTask;
use App\Notification;
use App\Task;
use App\TaskActivity;
use App\TodoList;
use App\User;
use Helpers\Classes\EmailSender;
use App\AchievementLog;

use Carbon, stdClass, Validator;

class TodoListController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = TodoList::query();

        if(!isSuperAdmin()){
            $query->whereAssignedBy($request->user()->id);
        }

        $todo_lists = $query->select('id', 'employee_id', 'assigned_at')
            ->groupBy('employee_id')->latest('id')->paginate(10);
        $todo_lists->paginationSummery = getPaginationSummery($todo_lists->total(), $todo_lists->perPage(), $todo_lists->currentPage());

        $tasks     = Task::getDropDownList(NULL, false);
        $employees = Employee::getDropDownList();

        return view('todo_lists.index', compact('todo_lists', 'tasks', 'employees'));
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
            'task_id'     => 'required',
        );

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            
            return response()->json(['status' => 400, 'error' => $validator->errors()]);
        }else{
            // store
            if($request->has('todo_list_id')) {
                $todo_list = TodoList::find($request->todo_list_id);
                if($todo_list) {
                    TodoList::whereEmployeeId($todo_list->employee_id)->whereAssignedBy($request->user()->id)->forceDelete();
                }
            }
            
            $i = 0;
            foreach($request->task_id as $todo_list->task_id) {
                $todo_list = new TodoList;
                $todo_list->employee_id = $request->employee_id;
                $todo_list->task_id = $todo_list->task_id;
                $todo_list->assigned_by = $request->user()->id;
                $todo_list->assigned_at = Carbon::now();
                if($todo_list->save()) {
                    $i++;
                }
            }
            if(!$request->has('todo_list_id')) {
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
     * @param \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $todo_list = TodoList::findOrFail($id);
        $employee_task = EmployeeTask::join('frequencies', 'employee_tasks.frequency_id', '=', 'frequencies.id')->whereTaskId($todo_list->task_id)->whereEmployeeId($todo_list->employee_id)->first(['frequencies.title']);
        $frequency = $employee_task->title;
        $role_weight = $todo_list->task_role ? $todo_list->task_role->role_weight : 0;
        $earned_point = 0;
        $audit_system = getOption('audit_sytem');

        if($audit_system && $audit_system == 'disable' && $role_weight) {
            if($frequency == 'Daily') {
                $total_working_days = getWorkingDays();
                $earned_point = $role_weight/$total_working_days;
            }
            if($frequency == 'Weekly') {
                $earned_point = $role_weight/4;
            }
            if($frequency == 'Monthly') {
                $earned_point = $role_weight;
            }
        }else {
            $earned_point = $role_weight;
        }
        
        if($request->isMethod('POST')) {
            if($request->has('status')) {
                // update todo list
                if($todo_list->status == trim($request->status) && trim($request->status) == 'approved') {
                    $task_activity_comments = 'updates earned point';
                }
                $todo_list->status = trim($request->status);
                if($request->status == 'completed') {
                    $todo_list->earned_point = $earned_point;
                    $todo_list->finished_at = Carbon::now();
                    $todo_list->achievement = trim($request->achievement);
                }elseif($request->status == 'approved') {
                    // check whether role weight greater than earned point 
                    if($todo_list->task_role && $todo_list->task_role->role_weight < trim($request->earned_point)) {

                        session()->flash('toast', toastMessage('earned point can not be larger than '.$todo_list->task_role->role_weight, 'error'));

                        return back();
                    }
                    
                    $todo_list->approved_by = $request->user()->id;
                    $todo_list->approved_on = Carbon::now();
                    $todo_list->earned_point = trim($request->earned_point);
                }elseif($request->status == 'new') {
                    $todo_list->earned_point = 0;
                    $todo_list->finished_at = null;
                    $todo_list->approved_by = 0;
                    $todo_list->approved_on = null;
                }
                $todo_list->save();

                // insert
                $task_activity = new TaskActivity;
                $task_activity->employee_id = $request->user()->employee->id;
                $task_activity->task_id = $todo_list->task_id;
                $task_activity->todo_list_id = $todo_list->id;
                $task_activity->comments = !empty($task_activity_comments) ? $task_activity_comments : config('todo_status_msg.' . $request->status);
                if($task_activity->save()) {

                    if($request->status == 'completed') {
                        $obj = new stdClass;
                        $obj->resource_id   = $todo_list->id;
                        // $obj->type  = 'task_approval';
                        $obj->type  = 'task_completed';
                        // $obj->title = 'New Task Approval:'.$todo_list->task->title;
                        $obj->title = 'Task Completed:'.$todo_list->task->title;
                        $obj->short_description = '';
                        // $obj->from  = $todo_list->employee->id;
                        $obj->from  = $request->user()->employee_id;
                        $obj->to    = $todo_list->employee->boss ? $todo_list->employee->boss->id : $todo_list->employee->id;

                        Notification::AddOrUpdate($obj);

                        if($todo_list->employee->user) {

                            $data = [
                                'blade' => 'notification',
                                'body'  =>  [
                                    'todo_list' => $todo_list
                                ],
                                'toUser'    =>  $todo_list->employee->boss ? $todo_list->employee->boss->user->email : $todo_list->employee->user->email,
                                'toUserName'    =>  $todo_list->employee->boss ? $todo_list->employee->boss->full_name : $todo_list->employee->full_name,
                                'subject'   =>  env('APP_NAME') . ' New Task Approval!',
                            ];

                            EmailSender::send($data);
                        }
                    }
                    
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
                $task_activity->task_id = $todo_list->task_id;
                $task_activity->todo_list_id = $todo_list->id;
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
                
        if($request->has('notification_id')) {
            $nofication = Notification::find($request->notification_id);
            if($nofication) {
                $nofication->status = 'read';
                $nofication->save();
            }
        }

        $task_activities = TaskActivity::whereTaskId($todo_list->task_id)->whereTodoListId($todo_list->id)->get();

        $achievementLogs = null;
        $targetEnabled = false;
        
        if(!empty($todo_list->employeeTask->target)){
            $achievementLogs = AchievementLog::whereTodoListId($id)->orderBy('date','desc')->get(['id','date','achievement']);
            $targetEnabled = true;
        }

        return view('todo_lists.show', compact('todo_list','task_activities','achievementLogs','targetEnabled'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $employee_task = TodoList::find($request->hdnResource);
        if($employee_task) {
            if(TodoList::whereEmployeeId($employee_task->employee_id)->whereAssignedBy($request->user()->id)->delete()) {

                $message = toastMessage('Todo list info has been successfully removed.','success');
            }else {
                $message = toastMessage('Todo list info has not been removed.','error');
            }
        }else {
            $message = toastMessage('Todo list info not found.','error');
        }
        
        // Redirect
        session()->flash('toast',$message);
        
        return back();
    }

    /**
     * Change todo status
     *
     * @param \Illuminate\Http\Request $request
     * @param  int $id
     * @return json
     */
    public function changeStatus(Request $request, $id)
    {
        if($request->has('status')) {
            $todo_list = TodoList::findOrFail($id);
            $employee_task = EmployeeTask::join('frequencies', 'employee_tasks.frequency_id', '=', 'frequencies.id')->whereTaskId($todo_list->task_id)->whereEmployeeId($todo_list->employee_id)->first(['frequencies.title']);
            $frequency = $employee_task->title;
            $role_weight = $todo_list->task_role ? $todo_list->task_role->role_weight : 0;
            $earned_point = 0;
            $audit_system = getOption('audit_sytem');

            if($audit_system && $audit_system == 'disable' && $role_weight) {
                if($frequency == 'Daily') {
                    $total_working_days = getWorkingDays();
                    $earned_point = $role_weight/$total_working_days;
                }
                if($frequency == 'Weekly') {
                    $earned_point = $role_weight/4;
                }
                if($frequency == 'Monthly') {
                    $earned_point = $role_weight;
                }
            }else {
                $earned_point = $role_weight;
            }
            
            // update todo list
            if($todo_list->status == trim($request->status) && trim($request->status) == 'approved') {
                $task_activity_comments = 'updates earned point';
            }
            $todo_list->status = trim($request->status);
            if($request->status == 'completed') {
                $todo_list->earned_point = $earned_point;
                $todo_list->finished_at = Carbon::now();
                $todo_list->achievement = trim($request->achievement);
            }elseif($request->status == 'approved') {
                // check whether role weight greater than earned point 
                if($todo_list->task_role && $todo_list->task_role->role_weight < trim($request->earned_point)) {

                    return response()->json(['type'=>'error', 'message' => 'Earned point can not be larger than '.$todo_list->task_role->role_weight]);
                }
                
                $todo_list->approved_by = $request->user()->id;
                $todo_list->approved_on = Carbon::now();
                $todo_list->earned_point = trim($request->earned_point);
            }elseif($request->status == 'new') {
                $todo_list->earned_point = 0;
                $todo_list->finished_at = null;
                $todo_list->approved_by = 0;
                $todo_list->approved_on = null;
            }
            $todo_list->save();

            // insert
            $task_activity = new TaskActivity;
            $task_activity->employee_id = $request->user()->id;
            $task_activity->task_id = $todo_list->task_id;
            $task_activity->todo_list_id = $todo_list->id;
            $task_activity->comments = !empty($task_activity_comments) ? $task_activity_comments : config('todo_status_msg.' . $request->status);
            if($task_activity->save()) {

                if($request->status == 'completed') {
                    $obj = new stdClass;
                    $obj->resource_id   = $todo_list->id;
                    $obj->type  = 'task_completed';
                    $obj->title = 'Task Completed:'.$todo_list->task->title;
                    $obj->short_description = '';
                    $obj->from  = $request->user()->employee_id;
                    $obj->to    = $todo_list->employee->boss ? $todo_list->employee->boss->id : $todo_list->employee->id;

                    Notification::AddOrUpdate($obj);

                    if($todo_list->employee->user) {

                        $data = [
                            'blade' => 'notification',
                            'body'  =>  [
                                'todo_list' => $todo_list
                            ],
                            'toUser'    =>  $todo_list->employee->boss ? $todo_list->employee->boss->user->email : $todo_list->employee->user->email,
                            'toUserName'    =>  $todo_list->employee->boss ? $todo_list->employee->boss->full_name : $todo_list->employee->full_name,
                            'subject'   =>  env('APP_NAME') . ' New Task Approval!',
                        ];

                        EmailSender::send($data);
                    }
                }
                
                $json = response()->json(['type'=>'success', 'message' => 'Your task status has been updated.']);
            }else {
                $json = response()->json(['type'=>'error', 'message' => 'Your task status has not been updated.']);
            }
        }else {
            $json = response()->json(['type'=>'error', 'message' => 'Your task status has not been updated.']);
        }

        return $json;
    }

    /**
     * Get next assigned tasks
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getNextAsignedTasks(Request $request)
    {
        $employee_tasks = EmployeeTask::join('frequencies', 'employee_tasks.frequency_id','=','frequencies.id')
            ->where('employee_tasks.employee_id', $request->user()->id)
            ->orderBy('employee_tasks.deadline')
            ->get(['employee_tasks.*', 'frequencies.title as frequency_title']);
        $j = 0;
        $total_todo_lists_next_30_days = [];
        $total_todo_lists_next_7_days = [];
        if($employee_tasks->isNotEmpty()) {
            foreach($employee_tasks as $employee_task) {
                $todo_lists_next_30_days = [];
                $todo_lists_next_7_days = [];
                $task = $employee_task->task;
                // Only predefined tasks will be assigned
                if($task->job_type == 'pre_defined') {
                    // Get necessary option values
                    $options = $task->options()
                        ->where('name','week_starts_on')
                        ->orWhere('name','day_off')
                        ->orWhere('name','extended_time_1')
                        ->orWhere('name','extended_time_2')
                        ->groupBy('name')->get();
                    if($options->isNotEmpty()) {
                        foreach($options as $option) {
                            if($option->name == 'day_off') {
                                $day_off = explode(',',$option->value);
                            }elseif($option->name == 'week_starts_on') {
                                $week_starts_on = $option->value;
                            }elseif($option->name == 'extended_time_1') {
                                $extended_time_1 = $option->value;
                            }elseif($option->name == 'extended_time_2') {
                                $extended_time_2 = $option->value;
                            }
                        }
                    }

                    // Loop for next 30 days
                    
                    $todo_list_item = [];
                    for ($i=1; $i <= 30; $i++) {

                        if(($employee_task->frequency_title == 'Daily' && !empty($day_off) && !in_array(Carbon::now()->addDays($i)->format('w'), $day_off)) || ($employee_task->frequency_title == 'Weekly' && !empty($week_starts_on) && $week_starts_on==Carbon::now()->addDays($i)->format('w')) || ($employee_task->frequency_title == 'Monthly' && getMonthlyTaskAssinedDate($i, $day_off)) || (!in_array($employee_task->frequency_title, ['Daily', 'Weekly', 'Monthly']))) {

                            $todo_list_item['title'] = $task->title;
                            $todo_list_item['job_type'] = config('constants.job_type.'.$task->job_type);
                            $todo_list_item['achievement'] = 0;
                            $todo_list_item['status'] = 'New';
                            if($employee_task->frequency_title == 'Monthly') {
                                $assigned_at = getMonthlyTaskAssinedDate($i, $day_off);
                            }else {
                                $assigned_at = Carbon::now()->addDays($i);
                            }
                            $todo_list_item['assigned_at'] = $assigned_at;
                            $assigned_at = Carbon::parse($assigned_at);
                            if($employee_task->frequency_title == 'Daily') {
                                $deadline = $assigned_at->addDays(1);
                            }elseif($employee_task->frequency_title == 'Weekly') {
                                $deadline = $assigned_at->addDays(7);
                            }elseif($employee_task->frequency_title == 'Monthly') {
                                $deadline = $assigned_at->lastOfMonth();
                            }else {
                                $deadline = $employee_task->deadline;
                            }
                            $todo_list_item['deadline'] = $deadline;
                            if($i <= 7) {
                                $todo_lists_next_7_days[$i] = $todo_list_item;
                            }
                            $todo_lists_next_30_days[$i] = $todo_list_item;
                            $j++;
                        }
                    }

                    $total_todo_lists_next_7_days[$employee_task->id] = $todo_lists_next_7_days;
                    $total_todo_lists_next_30_days[$employee_task->id] = $todo_lists_next_30_days;
                }
                
            }  
        }

        $total_todo_lists_next_7_days = array_filter($total_todo_lists_next_7_days);
        $total_todo_lists_next_30_days = array_filter($total_todo_lists_next_30_days);

        dd($total_todo_lists_next_7_days, $total_todo_lists_next_30_days);
    }

    /**
     * Add Dummy todo list item
     *
     * @param string $username
     * @return  \Illuminate\Http\Response
     */
    public function assignDummyTasks(Request $request, $username)
    {
        $user = User::whereUsername($username)->first(['id', 'employee_id','company_id']);
        if(!$user) {
            return response()->json("No user found.");
        }

        if($user && !$user->active) {
            return response()->json("User is not active yet!");
        }

        $employee_tasks = EmployeeTask::join('frequencies', 'employee_tasks.frequency_id','=','frequencies.id')
            ->where('employee_tasks.employee_id', $user->employee_id)
            ->orderBy('employee_tasks.deadline')
            ->get(['employee_tasks.*', 'frequencies.title as frequency_title']);

        $j = 0;
        // $total_todo_lists_next_30_days = [];
        // $total_todo_lists_next_7_days = [];
        if($employee_tasks->isNotEmpty()) {
            foreach($employee_tasks as $employee_task) {
                
                $todo_lists_next_30_days = [];
                $todo_lists_next_7_days = [];
                $task = $employee_task->task;
                // Only predefined tasks will be assigned
                if($task->job_type == 'pre_defined') {
                    // Get necessary option values
                    $options = $task->options()
                        ->where('name','week_starts_on')
                        ->orWhere('name','day_off')
                        ->orWhere('name','extended_time_1')
                        ->orWhere('name','extended_time_2')
                        ->groupBy('name')->get();
                    if($options->isNotEmpty()) {
                        foreach($options as $option) {
                            if($option->name == 'day_off') {
                                $day_off = explode(',',$option->value);
                            }elseif($option->name == 'week_starts_on') {
                                $week_starts_on = $option->value;
                            }elseif($option->name == 'extended_time_1') {
                                $extended_time_1 = $option->value;
                            }elseif($option->name == 'extended_time_2') {
                                $extended_time_2 = $option->value;
                            }
                        }
                    }

                    // Get Earned Point
                    $frequency = $employee_task->frequency_title;
                    $role_weight = $employee_task->task_role ? $employee_task->task_role->role_weight : 0;
                    $earned_point = 0;
                    $audit_system = getOption('audit_sytem');

                    if($audit_system && $audit_system == 'disable' && $role_weight) {
                        if($frequency == 'Daily') {
                            $total_working_days = getWorkingDays();
                            $earned_point = $role_weight/$total_working_days;
                        }
                        if($frequency == 'Weekly') {
                            $earned_point = $role_weight/4;
                        }
                        if($frequency == 'Monthly') {
                            $earned_point = $role_weight;
                        }
                    }else {
                        $earned_point = $role_weight;
                    }

                    // Loop for next 30 days
                    
                    $todo_list_item = [];
                    for ($i=0; $i < 30; $i++) {

                        if(($employee_task->frequency_title == 'Daily' && !empty($day_off) && !in_array(Carbon::now()->subMonths(1)->startOfMonth()->addDays($i)->format('w'), $day_off)) || ($employee_task->frequency_title == 'Weekly' && !empty($week_starts_on) && $week_starts_on==Carbon::now()->subMonths(1)->startOfMonth()->addDays($i)->format('w')) || ($employee_task->frequency_title == 'Monthly' && getLastMonthlyTaskAssinedDate($i, $day_off)) || (!in_array($employee_task->frequency_title, ['Daily', 'Weekly', 'Monthly']))) {

                            // $todo_list_item['title'] = $task->title;
                            // $todo_list_item['job_type'] = config('constants.job_type.'.$task->job_type);
                            // $todo_list_item['achievement'] = 0;
                            // $todo_list_item['status'] = 'New';
                            // if($employee_task->frequency_title == 'Monthly') {
                            //     $assigned_at = getLastMonthlyTaskAssinedDate($i, $day_off);
                            // }else {
                            //     $assigned_at = Carbon::now()->subMonths(1)->startOfMonth()->addDays($i);
                            // }
                            // $todo_list_item['assigned_at'] = $assigned_at;
                            // $assigned_at = Carbon::parse($assigned_at);
                            // if($employee_task->frequency_title == 'Daily') {
                            //     $deadline = $assigned_at->addDays(1);
                            // }elseif($employee_task->frequency_title == 'Weekly') {
                            //     $deadline = $assigned_at->addDays(7);
                            // }elseif($employee_task->frequency_title == 'Monthly') {
                            //     $deadline = $assigned_at->lastOfMonth();
                            // }else {
                            //     $deadline = $employee_task->deadline;
                            // }
                            // $todo_list_item['deadline'] = $deadline;
                            // if($i < 7) {
                            //     $todo_lists_next_7_days[$i] = $todo_list_item;
                            // }
                            // $todo_lists_next_30_days[$i] = $todo_list_item;

                            // Insert data 
                            $todo_list = new TodoList;
                            $todo_list->employee_id = $employee_task->employee_id;
                            $todo_list->task_id = $employee_task->task_id;
                            $todo_list->task_role_id = $employee_task->task_role_id;
                            $todo_list->earned_point = $earned_point;
                            $todo_list->status = 'completed';
                            if($employee_task->frequency_title == 'Monthly') {
                                $assigned_at = getLastMonthlyTaskAssinedDate($i, $day_off);
                            }else {
                                $assigned_at = Carbon::now()->subMonths(1)->startOfMonth()->addDays($i);
                            }
                            $todo_list->assigned_at = $assigned_at;
                            $assigned_at = Carbon::parse($assigned_at);

                            if($employee_task->frequency_title == 'Daily') {
                                $deadline = $assigned_at->addDays(1);
                            }elseif($employee_task->frequency_title == 'Weekly') {
                                $deadline = $assigned_at->addDays(7);
                            }elseif($employee_task->frequency_title == 'Monthly') {
                                $deadline = $assigned_at->lastOfMonth();
                            }else {
                                $deadline = $employee_task->deadline;
                            }
                            $todo_list->deadline = $deadline;
                            $todo_list->finished_at = $deadline;
                            $todo_list->assigned_by = $employee_task->assigned_by;
                            
                            if(!empty($extended_time_1)) {
                                $todo_list->extended_dateline_1 = $deadline->addDays($extended_time_1);
                            }
                            if(!empty($extended_time_2)) {
                                $todo_list->extended_dateline_2 = $deadline->addDays($extended_time_2);
                            }
                            if($todo_list->save()) { 

                                // insert task activity
                                $task_activity = new TaskActivity;
                                $task_activity->employee_id = $todo_list->employee_id;
                                $task_activity->task_id = $todo_list->task_id;
                                $task_activity->todo_list_id = $todo_list->id;
                                $task_activity->comments = config('todo_status_msg.completed' );
                                $task_activity->save();

                                $j++;
                            }
                        }
                    }

                    // $total_todo_lists_next_7_days[$employee_task->id] = $todo_lists_next_7_days;
                    // $total_todo_lists_next_30_days[$employee_task->id] = $todo_lists_next_30_days;
                }
                
            } 

            if($j) {
                $message = toastMessage($j.' no tasks have been successfully assigned');
            }else {
                $message = toastMessage('No tasks has not been assigned', 'error');
            }
        }else {
            $message = toastMessage('No data found from employee tasks table.Please allocate tasks for employee', 'error');
        }

        // $total_todo_lists_next_7_days = array_filter($total_todo_lists_next_7_days);
        // $total_todo_lists_next_30_days = array_filter($total_todo_lists_next_30_days);

        // dd($total_todo_lists_next_7_days, $total_todo_lists_next_30_days);
        session()->flash('toast', $message);
        
        return redirect('/');
    }

    /* */

    public function saveAchievementLog(Request $request){

        if(!empty($request->id)){
            //we have id in request, that means this request is for edit record
            $al = AchievementLog::whereId($request->id)->first();
        }else{
            //new record need to add
            $al = new AchievementLog();
            $al->todo_list_id = $request->todo_id;
        }

        $al->date = $request->date;
        $al->achievement = $request->point;

        if($al->save()){
            return response()->json('ok');
        }else{
            return response()->json('error');
        }
    }
}
