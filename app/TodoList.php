<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TodoList extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $dates = ['deleted_at', 'assigned_at', 'finished_at'];

    public function setAssignedAtAttribute($value)
    {
        $this->attributes['assigned_at'] = $value ? $value : Carbon::now();
    }

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

    public function assigner()
    {
    	return $this->belongsTo('App\User', 'assigned_by');
    }

    public function task_role()
    {
        return $this->belongsTo('App\TaskRole');
    }

    public function employeeTask(){
        return $this->belongsTo(EmployeeTask::class);
    }

    public function achievement_logs()
    {
        return $this->hasMany(AchievementLog::class);
    }

    /**
     * Get the todo's assigned at.
     *
     * @param  string  $value
     * @return string
     */
    public function getAssignedAtAttribute($value)
    {
        return $value ? \Carbon::parse($value)->format('d M, Y H:i A') : $value;
    }

    /**
    * Return array of ids or string of task names
    *
    * @param string $item
    * @return array|string
    */
    public function getTaskItems($item = 'name')
    {
    	$task_names = '';
    	$query = TodoList::whereEmployeeId($this->employee_id);
    	if(!isSuperAdmin()) {
    		$query->whereAssignedBy(\Auth::id());
    	}

    	$task_ids = $query->pluck('task_id')->all();

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

    /**
     * Return string of assigned task names with coresponding link
     *
     * @return string
     */
    public function getAssignedTaskNames()
    {
    	$task_names = '';
    	$task_ids = TodoList::whereEmployeeId(\Auth::user()->employee->id)->whereAssignedBy($this->assigned_by)->pluck('task_id')->all();

    	if($task_ids) {
    		$tasks = Task::whereIn('id', $task_ids)->pluck('title', 'slug');
    		if($tasks->isNotEmpty()) {
    			foreach($tasks as $task_slug => $task_name) {
    				$task_names .= '<a href="'.url('tasks/'.$task_slug).'" target="_blank">'.$task_name . '</a><br/>';
    			}
    		}
    	}

    	return rtrim($task_names, '<br/>');
    }

    /**
     * Return string of assigned employee names
     *
     * @return string 
     */
    public function getAssignedEmployeeNames()
    {
    	$assigned_employee_names = '';
    	$employee_ids = TodoList::whereTaskId($this->task_id)->pluck('employee_id')->all();
    	$employees= Employee::whereIn('id', $employee_ids)->pluck('full_name');
    	if($employees->isNotEmpty()) {
    		foreach($employees as $employee_name) {
    			$assigned_employee_names .= '<span class="label label-success">'.$employee_name .'</span><br/>';
    		}
    	}

    	return rtrim($assigned_employee_names);
    }

    public static function fetch($request=null)
    {
    	$query = TodoList::join('tasks', 'todo_lists.task_id', '=', 'tasks.id')
    			->join('departments', 'tasks.department_id', '=', 'departments.id')
    			->join('employees', 'todo_lists.employee_id', '=', 'employees.id');

    	if(isAdmin()) {
            // Take data from todo_list based on company id
    		$query->where('tasks.company_id', \Auth::user()->company_id);
    		
    	}else if(isDepartmentAdmin()) {
            // Take data from todo_list based on department id
            $query->where('tasks.department_id', \Auth::user()->employee->department_id);
        }else if(isEmployee()){
    		// Take data from todo_list based on reporting boss
    		$employee_ids = Employee::getEmployeeIds(Employee::tree());
    		$query->whereIn('employee_id', $employee_ids);
    	}

        if($request->has('title')) {
            $query->where('tasks.title', 'LIKE', '%' . trim($request->title) .'%');
        }
        if($request->has('employee_id')) {
            $query->where('todo_lists.employee_id', '=', $request->employee_id);
        }
        if($request->has('department_id')) {
            $query->where('tasks.department_id', '=', $request->department_id);
        }
        if($request->has('status')) {
            $query->where('todo_lists.status', '=', $request->status);
        }
        if($request->has('date_range')) {
            $date_range  = explode(' - ',$request->date_range);
            $from_date = \Carbon::parse($date_range[0])->format('Y-m-d');
            $to_date = \Carbon::parse($date_range[1])->format('Y-m-d');
            $query->whereRaw('DATE_FORMAT(assigned_at, "%Y-%m-%d") >= "'.$from_date.'" AND DATE_FORMAT(assigned_at, "%Y-%m-%d") <="'.$to_date.'"');
        }

        $query->select('todo_lists.id','todo_lists.achievement', 'todo_lists.status', 'todo_lists.assigned_at', 'todo_lists.finished_at', 'tasks.title', 'employees.full_name', 'departments.title AS department_title');
    	
        return $query->latest('todo_lists.id');
    }

    
}
