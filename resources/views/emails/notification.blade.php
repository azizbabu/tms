@extends('emails.master', ['app_name' => $todo_list->task->company->title])

@section('content')
	<p>Dear {{ $todo_list->employee->boss ? $todo_list->employee->boss->full_name : $todo_list->employee->full_name }},</p>
	<p>A new task has been completed.</p>
	{{--  
	<p>You can visit <a href="{{ url('todo/'.$todo_list->id) }}">this page</a> to approve the task.</p>
	--}}
	<p>You can visit <a href="{{ url('todo/'.$todo_list->id) }}">this page</a> to view the task.</p>
@endsection
