<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
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

    public function parent()
    {
        return $this->belongsTo('App\Task', 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany('App\Task', 'parent_id', 'id');
    }

    /**
     * Define a one-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employee_tasks()
    {
        return $this->hasMany('App\EmployeeTask');
    }

    public function task_activities()
    {
        return $this->hasMany('App\TaskActivity');
    }

    public function todo_lists()
    {
        return $this->hasMany('App\TodoList');
    }

    public function options()
    {
        return $this->hasMany('App\Option', 'company_id', 'company_id');
    }

    /**
     * Get the task's deadline.
     *
     * @param  string  $value
     * @return string
     */
    public function getDeadlineAttribute($value)
    {
        return \Carbon::parse($value)->format(session('date_format','Y-m-d'));
    }

    /**
     * Get the task's created at.
     *
     * @param  string  $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return \Carbon::parse($value)->format(getOption('date_format') ? getOption('date_format') : session('date_format','Y-m-d'));
    }

    public static function getDropDownList($id = null,$prepend=true, $job_type=null, $query_column_name=null, $query_column_value=null)
    {
        $query = Task::query();

        if($query_column_name && $query_column_value) {
            if($query_column_name == 'company_id') {
                $query->whereCompanyId($query_column_value);
            }else if($query_column_name == 'department_id') {
                $query->whereDepartmentId($query_column_value);
            }
        }else {
            if(!isSuperAdmin()) {
                $query->whereCompanyId(\Auth::user()->company_id);
            }
        }

        if($job_type) {
            $query->whereJobType($job_type);
        }

        $tasks = $query->pluck('title', 'id');
        if($prepend) {
            $tasks = $tasks->prepend('Select a Task', '');
        }
        
        if($id) {
            $tasks = $tasks->except($id);
        }
        $tasks = $tasks->all();  

        return $tasks;
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($task) { 
            // before delete() method call this
            $task->employee_tasks()->delete();
            $task->task_activities()->delete();
            $task->todo_lists()->forceDelete();
        });
    }

    /**
     * Display rows of tables of tasks
     *
     * @param obj $tasks
     * @return string
     */
    public static function getTaskList($tasks)
    {
        $task_list = '';
        static $counter;
        $counter = !empty($counter) ? $counter : 1;
        
        if($tasks->isNotEmpty()) {
            foreach($tasks as $task) {
                $task_list .= '<tr>'
                .'<td><span class="glyphicon glyphicon-minus"></span>'. $task->title .'</td>';
                if(isSuperAdmin()) {
                    $task_list .= '<td>'. ($task->company ? $task->company->title : 'N/A').'</td>';
                }
                $task_list .= '<td>'. ($task->branch ? $task->branch->title : 'N/A') .'</td>
                    <td>'. ($task->department ? $task->department->title : 'N/A') .'</td>
                    <td>'. ($task->parent ? $task->parent->title : 'N/A'). '</td>
                    
                    <td class="action-column">
                        <!-- show the tasks (uses the show method found at GET /tasks/{id} -->
                        <a class="btn btn-xs btn-success" href="'. url('tasks/' . $task->id) .'" title="View Task"><i class="fa fa-eye"></i></a>

                        <!-- edit this tasks (uses the edit method found at GET /tasks/{id}/edit -->
                        <a class="btn btn-xs btn-default" href="'. url('tasks/' . $task->id . '/edit') .'" title="Edit Task"><i class="fa fa-pencil"></i></a>
                        
                        <!-- Delete -->
                        <a href="#" data-id="'.$task->id.'" data-action="'. url('tasks/delete') .'" data-message="Are you sure, You want to delete this task?" class="btn btn-danger btn-xs alert-dialog" title="Delete Task"><i class="fa fa-trash white"></i></a>
                    </td>
                </tr>';

                $child_tasks = $task->children;

                if($child_tasks->IsNotEmpty()) {
                    // $counter++;
                    // $task_list .= Self::getTaskList($child_tasks);
                    foreach($child_tasks as $task) {
                        $task_list .= '<tr>'
                        
                            // .'<td>'.self::addHash($counter). $task->title .'</td>';
                        .'<td><span class="glyphicon glyphicon-minus"></span><span class="glyphicon glyphicon-minus"></span>'. $task->title .'</td>';
                        if(isSuperAdmin()) {
                            $task_list .= '<td>'. ($task->company ? $task->company->title : 'N/A').'</td>';
                        }
                        $task_list .= '<td>'. ($task->branch ? $task->branch->title : 'N/A') .'</td>
                            <td>'. ($task->department ? $task->department->title : 'N/A') .'</td>
                            <td>'. ($task->parent ? $task->parent->title : 'N/A'). '</td>
                            
                            <td class="action-column">
                                <!-- show the tasks (uses the show method found at GET /tasks/{id} -->
                                <a class="btn btn-xs btn-success" href="'. url('tasks/' . $task->id) .'" title="View Task"><i class="fa fa-eye"></i></a>

                                <!-- edit this tasks (uses the edit method found at GET /tasks/{id}/edit -->
                                <a class="btn btn-xs btn-default" href="'. url('tasks/' . $task->id . '/edit') .'" title="Edit Task"><i class="fa fa-pencil"></i></a>
                                
                                <!-- Delete -->
                                <a href="#" data-id="'.$task->id.'" data-action="'. url('tasks/delete') .'" data-message="Are you sure, You want to delete this task?" class="btn btn-danger btn-xs alert-dialog" title="Delete Task"><i class="fa fa-trash white"></i></a>
                            </td>
                        </tr>';

                        $child_tasks = $task->children;

                        if($child_tasks->IsNotEmpty()) {
                            $counter++;
                            $task_list .= Self::getTaskList($child_tasks);
                        }
                    }
                }
            }    
        }

        return $task_list;
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
}
