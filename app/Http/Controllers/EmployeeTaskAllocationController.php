<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Helpers\Classes\EmailSender;
use App\Employee;
use App\EmployeeTask;
use App\Frequency;
use App\Task;
use App\TaskRole;

use Carbon, Validator;

class EmployeeTaskAllocationController extends Controller
{
	/**
    * For user access control
    */
    public function __construct()
    {
        $this->middleware('department_admin');
    }

	/**
	 * Allocate task to employee
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param int $employee_id
	 * @return \illuminate\Http\Response
	 */
    public function index(Request $request, $employee_id=null)
    {
    	if($request->isMethod('POST')) {            

    		$total_task_ids = count($request->task_id);
    		$total_frequency_ids = count($request->frequency_id);
    		$total_task_role_ids = count($request->task_role_id);
    		$total_report_tos = count($request->report_to);
            // $total_deadlines = count($request->deadline);
            $total_deadline_dates = count($request->deadline_date);
    		$total_deadline_times = count($request->deadline_time);

    		if($total_task_ids == $total_frequency_ids && $total_frequency_ids == $total_task_role_ids && $total_task_role_ids == $total_report_tos && $total_report_tos == $total_deadline_dates && $total_deadline_dates == $total_deadline_times) {
    			for ($i=0; $i < $total_task_ids; $i++) { 
    				$rules['task_id.'.$i] = 'required|integer';
    				$rules['frequency_id.'.$i] = 'required|integer';
    				$rules['task_role_id.'.$i] = 'required|integer';
    				$rules['report_to.'.$i] = 'required|integer';
                    $rules['deadline_date.'.$i] = 'required|date_format:Y-m-d';
    				$rules['deadline_time.'.$i] = 'required';
    			}
    			$validator = Validator::make($request->all(), $rules);
    			if($validator->fails()) {
    				$messages = $validator->messages()->all();
    				$validation_error = '';
    				foreach($messages as $value) {
    					$validation_error .= $value . '<br/>';
    				}

                    return response()->json([
                        'type'    => 'error',
                        'message' => $validation_error
                    ]);
    			}else {
    				// insert data 

    				$j = 0;
    				for ($i=0; $i < $total_task_ids; $i++) { 
                        $task = Task::findOrFail($request->task_id[$i]);
    					$employee_task = new EmployeeTask;
    					$employee_task->employee_id = $employee_id;
    					$employee_task->task_id = $request->task_id[$i];
    					$employee_task->target = $request->target[$i];
    					$employee_task->target_unit = $request->target_unit[$i];
    					$employee_task->frequency_id = $request->frequency_id[$i];
    					$employee_task->task_role_id = $request->task_role_id[$i];
    					$employee_task->report_to = $request->report_to[$i];
                        $dealine_times_arr = explode(' ', $request->deadline_time[$i]);
                        $hour_minutes_arr = explode(':', $dealine_times_arr[0]);
                        $hour = $hour_minutes_arr[0];
                        $minute = $hour_minutes_arr[1];
                        if($dealine_times_arr[1] == 'PM' && $hour!=12) {
                            $hour+=12;
                        }
                        $employee_task->deadline = $request->deadline_date[$i] . ' '. $hour. ':'.$minute . ':00';
    					$employee_task->assigned_by = $request->user()->id;
                        $employee_task->assigned_at = Carbon::now();
    					if($employee_task->save()) {
    						$j++;

                            // check whether task is need basis
                            $task = Task::findOrFail($request->task_id[$i]);
                            if($task->job_type == 'need_basis') {
                                $todo_list = new \App\TodoList;

                                $todo_list->employee_id = $employee_task->employee_id;
                                $todo_list->task_id = $employee_task->task_id;
                                $todo_list->task_role_id = $employee_task->task_role_id;

                                $todo_list->deadline = $employee_task->deadline;
                                $todo_list->assigned_by = $employee_task->assigned_by;
                                $todo_list->assigned_at = \Carbon::now();
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
                                }
                            }
    					}
    				}
    				if($j) {
                        
                        return response()->json([
                            'type' => 'success',
                            'message' => 'Task has been successfully assigned.',
                        ]);
    				}else {

                        return response()->json([
                            'type' => 'error',
                            'message' => 'Task has not been assigned.',
                        ]);
    				}
    			}
    		}else {

                return response()->json([
                    'type'    => 'error',
                    'message' => 'Please fill the form correctly',
                ]);
    		}
    	}

    	$employees = Employee::getDropDownList();

    	if($employee_id) {
    		$employee = Employee::findOrFail($employee_id);
            // if($employee->user->role == 'admin') {
            //     $tasks = Task::getDropDownList(null, true, null, 'company_id', $employee->company_id);
            // }else {
            //     $tasks = Task::getDropDownList(null, true, null, 'department_id', $employee->department_id);
            // }
            $tasks = Task::getDropDownList(null, true, null, 'company_id', $employee->company_id);
    		
    		$frequencies = Frequency::getDropDownList();
            
    		$task_roles = TaskRole::getDropDownListForTaskAssign($employee->department);
            if(isSuperAdmin()) {
                $report_to_employees = Employee::getDropDownList(null, true, $employee->company_id);
            }else {
                $report_to_employees = Employee::getDropDownList();
            }
    	}

    	return view('employee-task-allocation', compact('employees', 'employee', 'tasks', 'frequencies', 'task_roles', 'report_to_employees'));
    }
}
