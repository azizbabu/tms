<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Auth;

class TaskRole extends Model
{
	use SoftDeletes;

	protected $dates = ['deleted_at'];

    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }

    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    /**
     * Get the task role's created at.
     *
     * @param  string  $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return \Carbon::parse($value)->format(getOption('date_format') ? getOption('date_format') : session('date_format','Y-m-d'));
    }

    public static function getDropDownList($prepend=true, $department_id=null)
    {
        $query = TaskRole::query();

        if($department_id) {
            $query->whereDepartmentId($department_id);
        }else {
            $query->whereDepartmentId(Auth::user()->employee->department_id);
        }

        $task_roles = $query->pluck('role_name', 'id');

        if($prepend) {
            $task_roles = $task_roles->prepend('Select a task role', '');
        }
        $task_roles = $task_roles->all();

        return $task_roles;
    }

    /**
     * Get list of task roles for task assign for specific employee 
     *
     * @param obj $employee
     * @return string $task_roles
     */
    public static function getDropDownListForTaskAssign($department)
    {
        $task_roles = Self::getDropDownList(false,$department->id);

        if(!count($task_roles) && ($parent_department = $department->parent)) {;

            $task_roles = $task_roles + Self::getDropDownListForTaskAssign($parent_department);
        }

        return array_prepend($task_roles, 'Select a task role', '');
    }   
}
