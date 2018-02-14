<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Auth;

class Employee extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * Define a one-to-one relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
    	return $this->hasOne('App\User');
    }

    /**
     * Define an inverse one-to-one or many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
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

    public function designation()
    {
    	return $this->belongsTo('App\Designation');
    }

    public function employee_tasks()
    {
        return $this->hasMany(EmployeeTask::class);
    }

    public function notification_from()
    {
        return $this->hasMany('App\Notification', 'from');
    }

    public function notification_to()
    {
        return $this->hasMany('App\Notification', 'to');
    }

    public function task_activities()
    {
        return $this->hasMany(TaskActivity::class);
    }

    public function todo_lists()
    {
        return $this->hasMany(TodoList::class);
    }

    protected static function boot() 
    {
        parent::boot();

        static::deleting(function($employee) { 
        	// before delete() method call this

            // get all sub employee ids
            $employees = Employee::whereIn('id', [$employee->id])->get();
            $employee_ids = array_diff(Self::getEmployeeIds($employees), [\Auth::id()]);
            $employees = Employee::whereIn('id', $employee_ids)->get();
            $arr = [];

            foreach($employees as $employee_item) {
                $user = $employee_item->user;
                if($user) {
                    // $user->permission()->delete();
                    // $user->branches()->forceDelete();
                    // $user->departments()->forceDelete();
                    // $user->designations()->forceDelete();
                    // $user->tasks()->forceDelete();
                    // $user->task_roles()->forceDelete();

                    $user->forceDelete();
                }
                $employee_item->employee_tasks()->delete();
                $employee_item->notification_from()->delete();
                $employee_item->notification_to()->delete();
                $employee_item->task_activities()->delete();
                $employee_item->task_activities()->delete();
                $employee_item->todo_lists()->delete();

                $todo_lists = $employee_item->todo_lists;
                if($todo_lists->isNotEmpty()) {
                    foreach($todo_lists as $todo_list) {
                        $todo_list->achievement_logs()->delete();
                    }
                    $employee_item->todo_lists()->delete();
                }
            }
        });
    }

    public static function getDropDownList($id = null, $prepend=true, $company_id=null)
    {
        $query = Employee::query();

        if($company_id) {
            $query->whereCompanyId($company_id);
        }else {
            if(!isSuperAdmin()) {
                $query->whereCompanyId(\Auth::user()->company_id);

                if(isDepartmentAdmin()) {
                    $query->whereDepartmentId(\Auth::user()->employee->department_id);
                }
            }
        }
        
        $employees = $query->pluck('full_name', 'id');
        if($prepend) {
            $employees = $employees->prepend('Select a Employee', '');
        }
        
        if($id) {
            $employees = $employees->except($id);
        }
        $employees = $employees->all();  

        return $employees;
    }

    public function boss()
    {
        return $this->belongsTo('App\Employee', 'reporting_boss');
    }

    public function servants()
    {
        return $this->hasMany('App\Employee', 'reporting_boss', 'id');
    }

    /**
    * making tree for category
    */
    public static function tree()
    {
        return static::with(implode('.', array_fill(0, 100, 'servants')))->where('reporting_boss', '=', \Auth::user()->employee->id)->get();
    }

    public static function  getEmployeeIds($employees)
    {
        if(\Auth::check()) {
            static $employee_ids;
            if(!isset($employee_ids)) {
                $employee_ids = [];
            }
            if(!in_array(\Auth::user()->employee->id, $employee_ids)) {
                $employee_ids[] = \Auth::user()->employee->id;
            }
            if($employees->isNotEmpty()) {
                foreach($employees as $employee) {
                    if($employee->servants->isNotEmpty()) {
                        $employee_ids[] = $employee->id;
                        self::getEmployeeIds($employee->servants);
                    }else {
                        if(!in_array($employee->id, $employee_ids)) {
                            $employee_ids[] = $employee->id;
                            
                        }
                    }
                }
            }

            return $employee_ids;
        }
    }

    /**
     * Display a dropdown list of employee for report
     *
     * @return Array
     */
    public static function getReportDropdownList($id = null,$prepend=false)
    {
        $query = Employee::query();

        if(!isSuperAdmin()) {
            $query->whereCompanyId(\Auth::user()->company_id);

            if(isDepartmentAdmin()) {
                $query->whereDepartmentId(\Auth::user()->employee->department_id);
            }

            if(isEmployee()) {
                $employee_ids = self::getEmployeeIds(self::tree());
                $query->whereIn('id', $employee_ids);
            }
        }

        $employees = $query->pluck('full_name', 'id');
        if($prepend) {
            $employees = $employees->prepend('Select a Employee', '');
        }

        if($id) {
            $employees = $employees->except($id);
        }
        $employees = $employees->all();  

        return $employees;
    }

    /**
     * Display a dropdown list of reporting boss
     *
     * @return Array
     */
    public static function getReportingBossDropdownList($prepend=true, $company_id=null, $key='')
    {
        $query = Employee::query();

        if($company_id) {
            $query->whereCompanyId($company_id);
        }else {
            if(!isSuperAdmin()) {
                $query->whereCompanyId(Auth::user()->company_id);

                if(isDepartmentAdmin()) {
                    $query->whereDepartmentId(Auth::user()->employee->department_id);
                }
            }
        }
        
        $employees = $query->orderBy('full_name')->get(['id', 'department_id', 'full_name']);  

        $reporting_boss = [];
        if($employees) {
            foreach($employees as $employee) {
                if($employee->user) {
                    if($key == 'username') {
                        $reporting_boss[$employee->user->username] = $employee->full_name .( $employee->department ? ' ('. $employee->department->title .')' : '');
                    }else {
                        $reporting_boss[$employee->id] = $employee->full_name .( $employee->department ? ' ('. $employee->department->title .')' : '');
                    }
                }
            }
        }

        if($prepend) {
            $reporting_boss = array_prepend($reporting_boss, 'Select a Emloyee', '');
        }

        return $reporting_boss;
    }

    /**
     * Get the employee's created at.
     *
     * @param  string  $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return \Carbon::parse($value)->format(getOption('date_format') ? getOption('date_format') : session('date_format','Y-m-d'));
    }
}
