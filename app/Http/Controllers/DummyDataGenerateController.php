<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\TaskActivity;
use App\TodoList;
use App\User;
use Carbon;

class DummyDataGenerateController extends Controller
{
    public function createDummyTasks(Request $request, $username)
    {
        $pastDays = $request->has('past') ? $request->past : 60;

        $user = User::whereUsername($username)->first(['id', 'employee_id','company_id', 'active']);
        if(!$user) {
            return response()->json("No user found.");
        }

        if($user && !$user->active) {
            return response()->json("User is not active yet!");
        }

        $companyId = $user->company_id;
        $this->employeeId = $user->employee_id;
        $userId = $user->id;

        $startDate = Carbon::now()->subDay($pastDays);
        $endDate = Carbon::now();

        //getting allocated task from db
        $employeeTasks = \DB::table('employee_tasks as et')
        ->leftJoin('frequencies as f', 'et.frequency_id','=','f.id')
        ->leftJoin('task_roles as tr', 'et.task_role_id', '=', 'tr.id')
        ->leftJoin('tasks as t', 'et.task_id', '=', 't.id')
        ->where('et.employee_id', $user->employee_id)
        ->where('et.obsoleted', 0)
        ->where('t.job_type','pre_defined')
        ->get([
            'et.id as employee_task_id',
            't.id as task_id',
            'tr.id as task_role_id',
            'tr.role_weight as task_weight',
            'f.title as frequency',
            'et.deadline',
            'et.assigned_by',
        ]);

        if($employeeTasks->count() <= 0){
            return response()->json("No allocated task found for this employee.");
        }

        $options = \App\Option::whereCompanyId($companyId)
        ->whereIn('name', ['week_starts_on','day_off','extended_time_1','extended_time_2'])
        ->get(['name','value']);

        //storing all settings in this class
        foreach($options as $option){
            $name = $option->name;
            $this->$name = $option->value;
        }

        try{
            $offDayArr = explode(',', $this->day_off);
        }catch(\Exception $e){
            $offDayArr = [];
        }

        while($startDate->lte($endDate)){

            $currentDay = $startDate->dayOfWeek; // like int(3)

            //we are not creating to-do for company's off day, that's whay this condition is for
            if(!in_array($currentDay, $offDayArr)){
                
                //looping into allocated task
                foreach($employeeTasks as $task){

                    $this->employee_task_id = $task->employee_task_id;

                    //taking current task's frequency
                    $frequency = strtolower($task->frequency);

                    //taking current task's task weight
                    $taskWeight = $task->task_weight;
                
                    if($frequency == 'daily'){

                        //calculating total working days
                        $totalWorkingDays = $this->getWorkingDays($offDayArr);

                        //calculating earned point: task point / total working days = earned point for one day
                        $task->earned_point = $taskWeight;

                        //making deadline
                        //date should be current date and time should be from the deadline of this task (assigned in db)
                        $task->deadline = $startDate->format('Y-m-d').' '.Carbon::parse($task->deadline)->format('H:i:s');

                        $task->assigned_at = $startDate;

                        $this->createToDo($task);

                    }elseif($frequency == 'weekly'){

                        if($currentDay == $this->week_starts_on){

                            //calculating earned point: task point / number of week of this month = earned point for one day
                            $task->earned_point = $taskWeight;

                            $currentDate = $startDate->format('Y-m-d');

                            //making deadline
                            //date should be current date +1 week and time should be from the deadline of this task (assigned in db)
                            $task->deadline = Carbon::parse($currentDate)->addWeek()->format('Y-m-d').' '.Carbon::parse($task->deadline)->format('H:i:s');

                            $task->assigned_at = $startDate;

                            $this->createToDo($task);
                            
                        }

                    }elseif($frequency == 'monthly'){
                        
                        //we will assign monthly task once per month
                        //let's check first in db current task is already assigned for this month or not
                        
                        $foundRow = TodoList::whereTaskId($task->task_id)
                        ->whereRaw("DATE_FORMAT(assigned_at, '%Y-%m') = '".$startDate->format('Y-m')."'")
                        ->count();

                        if($foundRow <= 0){
                            $task->earned_point = $taskWeight;

                            $currentDate = $startDate->format('Y-m-d');

                            //making deadline
                            //date should be current date +1 month and time should be from the deadline of this task (assigned in db)
                            $task->deadline = Carbon::parse($currentDate)->addMonth()->format('Y-m-d').' '.Carbon::parse($task->deadline)->format('H:i:s');

                            $task->assigned_at = $startDate;

                            $this->createToDo($task);
                        }
                    }
                }
            }            

            $startDate = $startDate->addDay();
        }

        return response()->json('Task assigned');
    }

    private function createToDo($task){
        
        $tl = new TodoList;
        $tl->employee_task_id = $this->employee_task_id;
        $tl->employee_id = $this->employeeId;
        $tl->task_id = $task->task_id;
        $tl->task_role_id = $task->task_role_id;
        $tl->earned_point = $task->earned_point;
        $tl->deadline = $task->deadline;
        $tl->extended_dateline_1 = !empty($this->extended_time_1) ? Carbon::parse($task->deadline)->addDays($this->extended_time_1) : $task->deadline;
        $tl->extended_dateline_2 = !empty($this->extended_time_2) ? Carbon::parse($task->deadline)->addDays($this->extended_time_2) : $task->deadline;
        $tl->status = 'completed';
        $tl->assigned_by = $task->assigned_by;
        $tl->finished_at = $task->deadline;
        $tl->assigned_at = $task->assigned_at;
        $tl->save();

        $task_activity = new TaskActivity;
        $task_activity->employee_id = $this->employeeId;
        $task_activity->task_id = $task->task_id;
        $task_activity->todo_list_id = $tl->id;
        $task_activity->comments = config('todo_status_msg.completed' );
        $task_activity->save();

        return true;
    }

    private function getWorkingDays($ignore=[])
    {
        $year = date('Y');
        $month = date('n');
        
        $count = 0;
        $counter = mktime(0, 0, 0, $month, 1, $year);
        while (date("n", $counter) == $month) {
            if (in_array(date("w", $counter), $ignore) == false) {
                $count++;
            }
            $counter = strtotime("+1 day", $counter);
        }
        return $count;
    }
}
