<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

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

    public function parent()
    {
        return $this->belongsTo('App\Department', 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany('App\Department', 'parent_id', 'id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function task_roles()
    {
        return $this->hasMany(TaskRole::class);
    }

    public static function getDropDownList($prepend=true)
    {
        $query = Department::query();

        if(!isSuperAdmin()) {
             $query->whereCompanyId(\Auth::user()->company_id);
        }

        $departments = $query->pluck('title', 'id');
        if($prepend) {
            $departments = $departments->prepend('Select a Department', '');
        }
        $departments = $departments->all();

        return $departments;
    }

    /**
     * Delete related model
     */
    protected static function boot()
    {
        parent::boot();
        
        // before delete() method call this
        static::deleting(function($department) {

            // get all child departments id
            $departments = Department::whereIn('id', [$department->id])->get();
            $department_ids[] = Self::getDepartmentIds($departments);

            $departments = Department::whereIn('id', $department_ids)->get();

            foreach($departments as $department_item) {
                $employees = $department_item->employees;
                $employee_ids = array_diff(Employee::getEmployeeIds($employees), [\Auth::user()->employee_id]);
                $employees = Employee::whereIn('id', $employee_ids)->get();

                if($employees->isNotEmpty()) {
                    foreach($employees as $employee) {
                        $user = $employee->user;
                        if($user) {
                            $user->permission()->delete();
                            // $user->branches()->forceDelete();
                            // $user->departments()->forceDelete();
                            // $user->departments()->forceDelete();
                            // $user->tasks()->forceDelete();
                            // $user->task_roles()->forceDelete();

                            $user->forceDelete();
                        }
                        $employee->employee_tasks()->delete();
                        $employee->notification_from()->delete();
                        $employee->notification_to()->delete();
                        $employee->task_activities()->delete();
                        $employee->todo_lists()->delete();

                        $todo_lists = $employee->todo_lists;
                        if($todo_lists->isNotEmpty()) {
                            foreach($todo_lists as $todo_list) {
                                $todo_list->achievement_logs()->delete();
                            }
                            $employee->todo_lists()->delete();
                        }

                        $employee->delete();
                    }
                }
            }
        });
    }

    /**
     * Get the department's created at.
     *
     * @param  string  $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return \Carbon::parse($value)->format(getOption('date_format') ? getOption('date_format') : session('date_format','Y-m-d'));
    }

    /**
     * Display rows of tables of departments
     *
     * @param obj $departments
     * @return string
     */
    public static function getDepartmentList($departments)
    {
        $department_list = '';
        static $counter;
        $counter = !empty($counter) ? $counter : 1;
        
        if($departments->isNotEmpty()) {
            foreach($departments as $department) {
                $department_list .= '<tr>'
                
                    // .'<td>'.self::addHash($counter). $department->title .'</td>';
                    .'<td><span class="glyphicon glyphicon-minus"></span>'. $department->title .'</td>';
                if(isSuperAdmin()) {
                    $department_list .= '<td>'. ($department->company ? $department->company->title : 'N/A').'</td>';
                }
                $department_list .= '<td>'. ($department->branch ? $department->branch->title : 'N/A') .'</td>
                    <td>'. ($department->parent ? $department->parent->title : 'N/A'). '</td>
                    <td>'. $department->created_at .'</td>
                    <td class="action-column">
                        <!-- show the departments (uses the show method found at GET /departments/{id} -->
                        <a class="btn btn-xs btn-success" href="javascript:showDepartmentInfo( '. $department->id .');" title="View Company"><i class="fa fa-eye"></i></a>

                        <!-- edit this departments (uses the edit method found at GET /departments/{id}/edit -->
                        <a class="btn btn-xs btn-default" href="javascript:openDepartmentModal('. $department->id. ')" title="Edit Employee"><i class="fa fa-pencil"></i></a>
                        
                        <!-- Delete -->
                        <a href="#" data-id="'.$department->id.'" data-action="'. url('departments/delete') .'" data-message="Are you sure, You want to delete this department?" class="btn btn-danger btn-xs alert-dialog" title="Delete department"><i class="fa fa-trash white"></i></a>
                    </td>
                </tr>';

                $child_departments = $department->children;

                if($child_departments->IsNotEmpty()) {
                    // $counter++;
                    // $department_list .= Self::getDepartmentList($child_departments);
                    foreach($child_departments as $department) {
                        $department_list .= '<tr>'
                        
                            // .'<td>'.self::addHash($counter). $department->title .'</td>';
                            .'<td><span class="glyphicon glyphicon-minus"></span><span class="glyphicon glyphicon-minus"></span>'. $department->title .'</td>';
                        if(isSuperAdmin()) {
                            $department_list .= '<td>'. ($department->company ? $department->company->title : 'N/A').'</td>';
                        }
                        $department_list .= '<td>'. ($department->branch ? $department->branch->title : 'N/A') .'</td>
                            <td>'. ($department->parent ? $department->parent->title : 'N/A'). '</td>
                            <td>'. $department->created_at .'</td>
                            <td class="action-column">
                                <!-- show the departments (uses the show method found at GET /departments/{id} -->
                                <a class="btn btn-xs btn-success" href="javascript:showDepartmentInfo( '. $department->id .');" title="View Company"><i class="fa fa-eye"></i></a>

                                <!-- edit this departments (uses the edit method found at GET /departments/{id}/edit -->
                                <a class="btn btn-xs btn-default" href="javascript:openDepartmentModal('. $department->id. ')" title="Edit Employee"><i class="fa fa-pencil"></i></a>
                                
                                <!-- Delete -->
                                <a href="#" data-id="'.$department->id.'" data-action="'. url('departments/delete') .'" data-message="Are you sure, You want to delete this department?" class="btn btn-danger btn-xs alert-dialog" title="Delete department"><i class="fa fa-trash white"></i></a>
                            </td>
                        </tr>';

                        $child_departments = $department->children;

                        if($child_departments->IsNotEmpty()) {
                            $counter++;
                            $department_list .= Self::getDepartmentList($child_departments);
                        }
                    }
                }
            }    
        }

        return $department_list;
    }

    /**
     * Add hash accordingto counter
     *
     * @param int $counter
     * @return string
     */
    private static function addHash($counter)
    {
        $str = '';
        if($counter) {
            for ($i=0; $i < $counter; $i++) { 
                $str .= '<span class="glyphicon glyphicon-minus"></span>';
                // $str = '<span style="display:inline-block;margin-left:'.($i++*20).'px"></span>';
            }
        }

        return '<span class="hash">'. $str .'</span>';
    }

    /**
     * Display table rows of as a collapsible format
     *
     * @param object $departments
     * @return string
     */
    public static function getDepartmentCollapsibleList($departments) {

        static $counter;
        $counter = !empty($counter) ? $counter : 1;
        $department_list = '';

        if($departments->isNotEmpty()) {
            foreach($departments as $department) {
                
                if(!$department->parent) {
                    $counter = 0;
                }
                if($department->parent && !$department->parent->parent) {
                    $counter = 1;
                }

                $child_departments = $department->children()->orderBy('title')->get();

                $department_list .= '<tr>'
                    .'<td>'. (Self::addHash($counter)).($child_departments->isNotEmpty() ? 
                        '<button type="button" class="btn btn-success btn-xs btn-collapse" data-toggle="collapse" data-target="#department'.$department->id.'">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i> 
                </button> ' : ''). $department->title .'</td>';

                if(isSuperAdmin()) {
                    $department_list .= '<td width="20%">'. ($department->company ? $department->company->title : 'N/A').'</td>';
                }

                $department_list .= '<td width="12%">'. ($department->branch ? $department->branch->title : 'N/A') .'</td>
                    <td width="12%">'. ($department->parent ? $department->parent->title : 'N/A'). '</td>
                    <td width="12%">'. $department->created_at .'</td>
                    <td width="10%" class="action-column">

                        <!-- show the departments (uses the show method found at GET /departments/{id} -->
                        <a class="btn btn-xs btn-success" href="javascript:showDepartmentInfo( '. $department->id .');" title="View Company"><i class="fa fa-eye"></i></a>

                        <!-- edit this departments (uses the edit method found at GET /departments/{id}/edit -->
                        <a class="btn btn-xs btn-default" href="javascript:openDepartmentModal('. $department->id. ')" title="Edit Employee"><i class="fa fa-pencil"></i></a>
                        
                        <!-- Delete -->
                        <a href="#" data-id="'.$department->id.'" data-action="'. url('departments/delete') .'" data-message="Are you sure, You want to delete this department?" class="btn btn-danger btn-xs alert-dialog" title="Delete department"><i class="fa fa-trash white"></i></a>
                    </td>
                </tr>';

                if($child_departments->IsNotEmpty()) {
                    $counter++;
                    $department_list .= '<tr  id="department'.$department->id.'" class="collapse">
                        <td colspan="'.(isSuperAdmin() ? 6 : 5).'" class="no-padding">
                            <table class="table table-bordered table-striped no-margin padding-left-10">';

                    $department_list .= Self::getDepartmentCollapsibleList($child_departments);

                    $department_list .= '
                            </table>
                        </td>
                    </tr>';
                }
            }
        }else {
            $department_list = '<tr>
                <td colspan="'.(isSuperAdmin() ? 6 : 5).'">No Data Found!</td>
            </tr>';
        }

        return $department_list;
    }

    /**
    * Display dynamic department list
    */
    public static function getDepartmentCheckboxList($departments, $class="list-unstyled", $department_ids = null)
    {
        if(count($departments)) {
            $output = '<ul class="'.$class.'">';
            foreach ($departments as $department){ 
                if(count($department->children) > 0){
                    $output .= '<li class="parent-departments"><label class="bold"><input class="parent_checkbox" type="checkbox" name="department_id[]" value="'.$department->id.'" '.(!empty($department_ids) && in_array($department->id, $department_ids) ? ' checked="checked"':'').'> '.$department->title.'</label>';
                    $output .= self::getDepartmentCheckboxList($department->children,'child-departments no-list-type',$department_ids);
                    $output .='</li>';
                }else {
                    $output .='<li><label class="bold"><input type="checkbox" name="department_id[]" value="'.$department->id.'"'.(old('department_id.'.$department->id) ? 'checked="checked"':(!empty($department_ids) && in_array($department->id, $department_ids) ? ' checked="checked"': '')).'> '.$department->title.'</label></li>';
                }
            }
            $output .='</ul>';
        }else {
            $output = 'No department found. Please create department first.';
        }

        return $output;
    }

    /**
     * Get all child department id
     *
     * @return array
     */
    public static function  getDepartmentIds($departments)
    {
        static $department_ids;

        if(!isset($department_ids)) {
            $department_ids = [];
        }

        if($departments->isNotEmpty()) {
            foreach($departments as $department) {
                if($department->children->isNotEmpty()) {
                    $department_ids[] = $department->id;
                    self::getDepartmentIds($department->children);
                }else {
                    if(!in_array($department->id, $department_ids)) {
                        $department_ids[] = $department->id;
                    }
                }
            }
        }

        return array_unique($department_ids);
    }

    /**
     * Get all parent department id
     *
     * @return array
     */
    public static function  getParentDepartmentIds($department)
    {
        static $department_ids;

        if(!isset($department_ids)) {
            $department_ids = [];
        }

        $parent = $department->parent;
        if($parent) {
            $department_ids[] = $parent->id;
            $grand_parent = $parent->parent;
            if($grand_parent) {
                self::getParentDepartmentIds($parent);
            }
        }

        return array_unique($department_ids);
    }

    public static function getMainRootIds($ids) 
    {
        $root_ids=[];
        $departments = Department::whereIn('id', $ids)->get();

        if($departments->isNotEmpty()) {
            foreach($departments as $department) {
                if(self::getParentDepartmentIds($department) && !array_intersect(self::getParentDepartmentIds($department),$ids)) {
                    $root_ids[] = $department->id;
                }else {

                }
            }
        }

        return array_unique($root_ids);
    }
}
