<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon;

class assignTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assignTask';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to add some data into todo_lists table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get employee tasks 
        $employee_tasks = \App\EmployeeTask::join('frequencies', 'employee_tasks.frequency_id','=','frequencies.id')
            ->leftJoin('users', 'employee_tasks.employee_id', '=', 'users.employee_id')
            ->where('users.active', 1)
            ->orderBy('employee_tasks.id')
            ->get(['employee_tasks.*', 'frequencies.title as frequency_title']);
        $i = 0;
        if($employee_tasks->isNotEmpty()) {
            foreach($employee_tasks as $employee_task) {
                
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

                    if(($employee_task->frequency_title == 'Daily' && !empty($day_off) && !in_array(date('w'), $day_off)) || ($employee_task->frequency_title == 'Weekly' && !empty($week_starts_on) && $week_starts_on==date('w')) || ($employee_task->frequency_title == 'Monthly' && getMonthlyTaskAssinedDate(0, $day_off)) || ($employee_task->frequency_title == 'Monthly' && getMonthlyTaskAssinedDate(0, $day_off)) || (!in_array($employee_task->frequency_title, ['Daily', 'Weekly', 'Monthly']))) {

                        $todo_list = new \App\TodoList;
                        $todo_list->employee_task_id = $employee_task->id;
                        $todo_list->employee_id = $employee_task->employee_id;
                        $todo_list->task_id = $employee_task->task_id;
                        $todo_list->task_role_id = $employee_task->task_role_id;
                        
                        $todo_list->assigned_by = $employee_task->assigned_by;

                        if($employee_task->frequency_title == 'Monthly') {
                            $assigned_at = getMonthlyTaskAssinedDate(0, $day_off);
                        }else {
                            $assigned_at = Carbon::now();
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
                        
                        if(!empty($extended_time_1)) {
                            $todo_list->extended_dateline_1 = \Carbon::parse($deadline)->addDays($extended_time_1);
                        }
                        if(!empty($extended_time_2)) {
                            $todo_list->extended_dateline_2 = \Carbon::parse($deadline)->addDays($extended_time_2);
                        }
                        if($todo_list->save()) {

                            if($todo_list->employee->user) {
                                
                                $data = [
                                    'blade' => 'task_assign',
                                    'body'  =>  [
                                        'todo_list' => $todo_list,
                                    ],
                                    'toUser'    =>  $todo_list->employee->user->email,
                                    'toUserName'    =>  $todo_list->employee->full_name,
                                    'subject'   =>  env('APP_NAME') . ' #'.$todo_list->task->id. ' ' . $todo_list->task->title,
                                ];

                                \Helpers\Classes\EmailSender::send($data);
                            }
                            
                            $i++;
                        }
                    }
                }
            }

            if($i) {
                $this->info('Task assigned.');
            }else {
                $this->info('Operation failed.');
            }
        }else {
            $this->info('No data found from employee_tasks table');
        }
    }
}
