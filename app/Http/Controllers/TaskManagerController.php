<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Department;
use App\Employee;
use App\EmployeeTask;
use App\TodoList;

use Carbon, DB;

class TaskManagerController extends Controller
{
    /**
     * Display a list of tasks
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	// Get todays tasks
        $todo_lists_today = TodoList::join('tasks', 'todo_lists.task_id', '=', 'tasks.id')
            ->select('todo_lists.id', 'todo_lists.assigned_at','tasks.title', 'tasks.frequency','tasks.job_type', 'todo_lists.deadline', 'todo_lists.status', 'todo_lists.achievement')
            ->where('todo_lists.employee_id', '=', $request->user()->employee_id)
            ->whereDate('todo_lists.deadline', '<=', date('Y-m-d'))
            ->where(function($q) {
                $q->where('todo_lists.status', '=', 'new')
                  ->orWhere('todo_lists.status', '=', 'accepted');
            })->orderBy('todo_lists.deadline')->get();
        
        // Get last 7 days tasks
        $todo_lists_last_seven_days = TodoList::join('tasks', 'todo_lists.task_id', '=', 'tasks.id')
            ->select('todo_lists.id', 'todo_lists.assigned_at','tasks.title', 'tasks.frequency','tasks.job_type', 'todo_lists.deadline', 'todo_lists.status', 'todo_lists.achievement')
            ->where('todo_lists.employee_id', '=', $request->user()->employee_id)
            ->where('todo_lists.assigned_at', '>=', Carbon::now()->subWeek())
            ->orderBy('todo_lists.deadline')->get();

        // Get last 30 days tasks
        $todo_lists_last_thirty_days = TodoList::join('tasks', 'todo_lists.task_id', '=', 'tasks.id')
            ->select('todo_lists.id', 'todo_lists.assigned_at','tasks.title', 'tasks.frequency','tasks.job_type', 'todo_lists.deadline', 'todo_lists.status', 'todo_lists.achievement')
            ->where('todo_lists.employee_id', '=', $request->user()->employee_id)
            ->where('todo_lists.assigned_at', '>=', Carbon::now()->subMonth())
            ->orderBy('todo_lists.deadline')->get();

        if($request->user()->employee && $request->user()->employee->servants->isNotEmpty()) {
            $employee_ids = array_except(Employee::getEmployeeIds(Employee::tree()), [array_search($request->user()->employee->id, Employee::getEmployeeIds(Employee::tree()))]);
            $employees = Employee::whereIn('id',$employee_ids)->get();
            $todo_lists = TodoList::fetch($request)->get();
        }
        
        $my_todo_lists = TodoList::join('tasks', 'todo_lists.task_id', '=', 'tasks.id')
            ->join('departments', 'tasks.department_id', '=', 'departments.id')
            ->join('employees', 'todo_lists.employee_id', '=', 'employees.id')
            ->where('todo_lists.employee_id', '=', $request->user()->employee_id)
            ->select('todo_lists.id','todo_lists.status', 'todo_lists.assigned_at', 'todo_lists.finished_at', 'todo_lists.deadline', 'todo_lists.achievement', 'tasks.title', 'tasks.frequency','tasks.job_type', 'employees.full_name', 'departments.title AS department_title')
            ->latest('todo_lists.id')->get();

        /**
         * Get tasks of next 7 days or 30 days
         */
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
                            $todo_list_item['job_type'] = $task->job_type;
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

        return view('task_manager', compact('todo_lists_today', 'todo_lists_last_seven_days', 'todo_lists_last_thirty_days', 'employees', 'todo_lists', 'my_todo_lists', 'total_todo_lists_next_7_days', 'total_todo_lists_next_30_days'));
    }
}
