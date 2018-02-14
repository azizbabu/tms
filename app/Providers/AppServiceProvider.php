<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Notification;
use App\TodoList;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.master', function($view) {
            
            if(Auth::check() && Auth::user()->employee) {
                $notifications = Notification::whereStatus('unread')->whereTo(Auth::user()->employee->id)->latest('id')->get();

                $total_todo_lists_today = TodoList::join('tasks', 'todo_lists.task_id', '=', 'tasks.id')
                ->select('todo_lists.id', 'todo_lists.assigned_at','tasks.title', 'tasks.frequency','tasks.job_type', 'todo_lists.deadline', 'todo_lists.status', 'todo_lists.achievement')
                ->where('todo_lists.employee_id', '=', Auth::user()->employee_id)
                ->whereDate('todo_lists.deadline', '<=', date('Y-m-d'))
                ->where(function($q) {
                    $q->where('todo_lists.status', '=', 'new')
                      ->orWhere('todo_lists.status', '=', 'accepted');
                })->orderBy('todo_lists.deadline')->get()->count();
            }

            $view->with(compact('notifications', 'total_todo_lists_today'));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
