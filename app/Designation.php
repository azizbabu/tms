<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Designation extends Model
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
        return $this->belongsTo('App\Designation', 'parent_id', 'id');
    }

    /**
     * Define a one-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany('App\Designation', 'parent_id', 'id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    /**
     * Delete related model
     */
    protected static function boot()
    {
        parent::boot();
        
        // before delete() method call this
        static::deleting(function($designation) {

            // get all child designations id
            $designations = Designation::whereIn('id', [$designation->id])->get();
            $designation_ids[] = Self::getDesignationIds($designations);

            $designations = Designation::whereIn('id', $designation_ids)->get();

            foreach($designations as $designation_item) {
                $employees = $designation_item->employees;
                $employee_ids = array_diff(Employee::getEmployeeIds($employees), [\Auth::user()->employee_id]);
                $employees = Employee::whereIn('id', $employee_ids)->get();

                if($employees->isNotEmpty()) {
                    foreach($employees as $employee) {
                        $user = $employee->user;
                        if($user) {
                            $user->permission()->delete();
                            // $user->branches()->forceDelete();
                            // $user->departments()->forceDelete();
                            // $user->designations()->forceDelete();
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

    public static function getDropDownList()
    {
        $query = Designation::query();

        if(!isSuperAdmin()) {
            $query->whereCompanyId(\Auth::user()->company_id);
        }

        $designations = $query->pluck('title', 'id')->all();

        return $designations;
    }

    /**
     * Get the designation's created at.
     *
     * @param  string  $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return \Carbon::parse($value)->format(getOption('date_format') ? getOption('date_format') : session('date_format','Y-m-d'));
    }

    /**
     * Display rows of tables of designations
     *
     * @param obj $designations
     * @return string
     */
    public static function getDesignationList($designations)
    {
        $designation_list = '';
        static $counter;
        $counter = !empty($counter) ? $counter : 1;
        
        if($designations->isNotEmpty()) {
            foreach($designations as $designation) {
                $designation_list .= '<tr>'
                
                    // .'<td>'.self::addHash($counter). $designation->title .'</td>';
                    .'<td><span class="glyphicon glyphicon-minus"></span>'. $designation->title .'</td>';
                if(isSuperAdmin()) {
                    $designation_list .= '<td>'. ($designation->company ? $designation->company->title : 'N/A').'</td>';
                }
                $designation_list .= '<td>'. ($designation->branch ? $designation->branch->title : 'N/A') .'</td>
                    <td>'. ($designation->parent ? $designation->parent->title : 'N/A'). '</td>
                    <td>'. $designation->created_at .'</td>
                    <td class="action-column">
                        <!-- show the designations (uses the show method found at GET /designations/{id} -->
                        <a class="btn btn-xs btn-success" href="javascript:showdesignationInfo( '. $designation->id .');" title="View Designation"><i class="fa fa-eye"></i></a>

                        <!-- edit this designations (uses the edit method found at GET /designations/{id}/edit -->
                        <a class="btn btn-xs btn-default" href="javascript:openDesignationModal('. $designation->id. ')" title="Edit Designation"><i class="fa fa-pencil"></i></a>
                        
                        <!-- Delete -->
                        <a href="#" data-id="'.$designation->id.'" data-action="'. url('designations/delete') .'" data-message="Are you sure, You want to delete this designation?" class="btn btn-danger btn-xs alert-dialog" title="Delete designation"><i class="fa fa-trash white"></i></a>
                    </td>
                </tr>';

                $child_designations = $designation->children;

                if($child_designations->IsNotEmpty()) {
                    // $counter++;
                    // $designation_list .= Self::getdesignationList($child_designations);
                    foreach($child_designations as $designation) {
                        $designation_list .= '<tr>'
                        
                            // .'<td>'.self::addHash($counter). $designation->title .'</td>';
                            .'<td><span class="glyphicon glyphicon-minus"></span><span class="glyphicon glyphicon-minus"></span>'. $designation->title .'</td>';
                        if(isSuperAdmin()) {
                            $designation_list .= '<td>'. ($designation->company ? $designation->company->title : 'N/A').'</td>';
                        }
                        $designation_list .= '<td>'. ($designation->branch ? $designation->branch->title : 'N/A') .'</td>
                            <td>'. ($designation->parent ? $designation->parent->title : 'N/A'). '</td>
                            <td>'. $designation->created_at .'</td>
                            <td class="action-column">
                                <!-- show the designations (uses the show method found at GET /designations/{id} -->
                                <a class="btn btn-xs btn-success" href="javascript:showdesignationInfo( '. $designation->id .');" title="View Designation"><i class="fa fa-eye"></i></a>

                                <!-- edit this designations (uses the edit method found at GET /designations/{id}/edit -->
                                <a class="btn btn-xs btn-default" href="javascript:openDesignationModal('. $designation->id. ')" title="Edit Designation"><i class="fa fa-pencil"></i></a>
                                
                                <!-- Delete -->
                                <a href="#" data-id="'.$designation->id.'" data-action="'. url('designations/delete') .'" data-message="Are you sure, You want to delete this designation?" class="btn btn-danger btn-xs alert-dialog" title="Delete designation"><i class="fa fa-trash white"></i></a>
                            </td>
                        </tr>';

                        $child_designations = $designation->children;

                        if($child_designations->IsNotEmpty()) {
                            $counter++;
                            $designation_list .= Self::getDesignationList($child_designations);
                        }
                    }
                }
            }    
        }

        return $designation_list;
    }

    /**
     * Display rows of tables of designations
     *
     * @param obj $designations
     * @return string
     */
    public static function getDesignationCollapsibleList($designations)
    {
        $designation_list = '';
        static $counter;
        $counter = !empty($counter) ? $counter : 1;
        
        if($designations->isNotEmpty()) {
            foreach($designations as $designation) {

                if(!$designation->parent_id) {
                    $counter = 0;
                }
                if($designation->parent && !$designation->parent->parent_id) {
                    $counter = 1;
                }
                // $counter = Self::getCounterValue($designation);

                $child_designations = $designation->children()->orderBy('title')->get();
                
                $designation_list .= '<tr>'
                    .'<td>'.(Self::addHash($counter)).($child_designations->isNotEmpty() ? 
                        '<button type="button" class="btn btn-success btn-xs btn-collapse" data-toggle="collapse" data-target="#designation'.$designation->id.'">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i> 
                </button> ' : ''). $designation->title .'</td>';

                if(isSuperAdmin()) {
                    $designation_list .= '<td width="25%">'. ($designation->company ? $designation->company->title : 'N/A').'</td>';
                }

                $designation_list .= '<td width="12%">'. ($designation->branch ? $designation->branch->title : 'N/A') .'</td>
                    <td width="12%">'. ($designation->parent ? $designation->parent->title : 'N/A'). '</td>
                    <td width="10%">'. $designation->created_at .'</td>
                    <td width="9%" class="action-column">
                        <!-- show the designations (uses the show method found at GET /designations/{id} -->
                        <a class="btn btn-xs btn-success" href="javascript:showdesignationInfo( '. $designation->id .');" title="View Designation"><i class="fa fa-eye"></i></a>

                        <!-- edit this designations (uses the edit method found at GET /designations/{id}/edit -->
                        <a class="btn btn-xs btn-default" href="javascript:openDesignationModal('. $designation->id. ')" title="Edit Designation"><i class="fa fa-pencil"></i></a>
                        
                        <!-- Delete -->
                        <a href="#" data-id="'.$designation->id.'" data-action="'. url('designations/delete') .'" data-message="Are you sure, You want to delete this designation? If you delete it, all child designations & its employees will be deleted." class="btn btn-danger btn-xs alert-dialog" title="Delete designation"><i class="fa fa-trash white"></i></a>
                    </td>
                </tr>';

                if($child_designations->IsNotEmpty()) {
                    $counter++;

                    $designation_list .= '<tr  id="designation'.$designation->id.'" class="collapse">
                        <td colspan="'.(isSuperAdmin() ? 6 : 5).'" class="no-padding">
                            <table class="table table-bordered table-striped no-margin padding-left-10">';

                    $designation_list .= Self::getDesignationCollapsibleList($child_designations);

                    $designation_list .= '
                            </table>
                        </td>
                    </tr>';
                }
            }
        }else {
            $designation_list = '<tr>
                <td colspan="'.(isSuperAdmin() ? 6 : 5).'">No Data Found!</td>
            </tr>';
        }

        return $designation_list;
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
            }
        }

        return '<span class="hash">'. $str .'</span>';
    }

    /**
     * Get all child designation id
     *
     * @return array
     */
    public static function  getDesignationIds($designations)
    {
        static $designation_ids;

        if(!isset($designation_ids)) {
            $designation_ids = [];
        }

        if($designations->isNotEmpty()) {
            foreach($designations as $designation) {
                if($designation->children->isNotEmpty()) {
                    $designation_ids[] = $designation->id;
                    self::getDesignationIds($designation->children);
                }else {
                    if(!in_array($designation->id, $designation_ids)) {
                        $designation_ids[] = $designation->id;
                    }
                }
            }
        }

        return array_unique($designation_ids);
    }

    private static function getCounterValue($department) 
    {
        static $counter;
        $counter = !empty($counter) ? $counter : 0;
        
        if(!$department->parent) {
            $counter = 0;
        }else {
            $parent = $department->parent;
            if($parent && !$parent->parent) {
                $counter++;
                $grand_parent = $parent->parent;
                if($grand_parent && !$grand_parent->parent) {
                    $counter += Self::getCounterValue($grand_parent);
                }
            }
        } 

        return $counter;
    }
}
