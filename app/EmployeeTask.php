<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeTask extends Model
{
	public $timestamps = false;
	
    protected $dates = ['assigned_at'];

    /**
     * Define an inverse one-to-one or many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    public function task()
    {
        return $this->belongsTo('App\Task');
    }

    public function frequency()
    {
        return $this->belongsTo('App\Frequency');
    }

    public function assigner()
    {
    	return $this->belongsTo('App\User', 'assigned_by');
    }

    public function task_role()
    {
        return $this->belongsTo('App\TaskRole');
    }

    public function todo(){
        return $this->hasMany(TodoList::class);
    }

    public function getTaskItems($item = 'name')
    {
    	$task_names = '';
    	$task_ids = EmployeeTask::whereEmployeeId($this->employee_id)->whereAssignedBy(\Auth::id())->pluck('task_id')->all();

    	if($item == 'id') {
    		return $task_ids;
    	}

    	if($task_ids) {
    		$tasks = Task::whereIn('id', $task_ids)->pluck('title');
    		if($tasks->isNotEmpty()) {
    			foreach($tasks as $task_name) {
    				$task_names .= $task_name . '<br/>';
    			}
    		}
    	}

    	return rtrim($task_names, '<br/>');
    }

    public function getAssignedTaskNames()
    {
    	$task_names = '';
    	$task_ids = EmployeeTask::whereEmployeeId(\Auth::user()->employee->id)->whereAssignedBy($this->assigned_by)->pluck('task_id')->all();

    	if($task_ids) {
    		$tasks = Task::whereIn('id', $task_ids)->pluck('title', 'id');
    		if($tasks->isNotEmpty()) {
    			foreach($tasks as $task_id => $task_name) {
    				$task_names .= '<a href="'.url('tasks/details/'.$task_id).'" target="_blank">'.$task_name . '</a><br/>';
    			}
    		}
    	}

    	return rtrim($task_names, '<br/>');
    }

    public function getAssignedEmployeeNames()
    {
    	$assigned_employee_names = '';
    	$employee_ids = EmployeeTask::whereAssignedBy($this->assigned_by)->pluck('employee_id')->all();
    	$employees= Employee::whereIn('id', $employee_ids)->pluck('full_name');
    	if($employees->isNotEmpty()) {
    		foreach($employees as $employee_name) {
    			$assigned_employee_names .= $employee_name .'<br/>';
    		}
    	}

    	return rtrim($assigned_employee_names, '<br/>');
    }

    /**
     * Get the employee task's assigned at.
     *
     * @param  string  $value
     * @return string
     */
    public function getAssignedAtAttribute($value)
    {
        return \Carbon::parse($value)->format(getOption('date_format') ? getOption('date_format') : session('date_format','Y-m-d'));
    }
}
