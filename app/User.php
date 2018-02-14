<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['last_login'];

    public function permission()
    {
        return $this->hasOne(Permission::class);
    }

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function branches()
    {
        return $this->hasMany('App\Branch', 'created_by');
    }

    public function departments()
    {
        return $this->hasMany('App\Department', 'created_by');
    }

    public function designations()
    {
        return $this->hasMany('App\Designation', 'created_by');
    }

    public function frequencies()
    {
        return $this->hasMany('App\Frequency', 'created_by');
    }

    public function tasks()
    {
        return $this->hasMany('App\Task', 'created_by');
    }

    public function task_roles()
    {
        return $this->hasMany('App\TaskRole', 'created_by');
    }

    /**
    * Deleting relational model
    */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($user) {
            $user->permission()->delete();
            // $user->branches()->forceDelete();
            // $user->departments()->forceDelete();
            // $user->designations()->forceDelete();
            // $user->tasks()->forceDelete();
            // $user->task_roles()->forceDelete();
        });
    }

    public static function getDropDownList()
    {
        $query = User::join('employees as e', 'users.employee_id', '=', 'e.id');

        if(!isSuperAdmin()){
            $query->where('users.company_id',Auth::user()->company_id);
        }

        $userList = $query->pluck('e.full_name', 'users.id')->all();

        return $userList;
    }
}
