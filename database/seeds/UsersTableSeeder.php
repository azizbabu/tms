<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\User::class, 8)->create();
        //\App\EmployeeTask::truncate();
        \App\TaskActivity::truncate();
        \App\TodoList::truncate();
        \App\Notification::truncate();
        // \App\Task::truncate();
        
        // factory(App\EmployeeTask::class, 8)->create();
        // $tasks = \App\Task::all();
        // foreach($tasks as $task) {
        //     $task->slug = $task->id . '-' . str_slug($task->title);
        //     $task->save();
        // }
    }
}
