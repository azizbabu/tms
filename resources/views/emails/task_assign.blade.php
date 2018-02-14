@extends('emails.master', ['app_name' => $todo_list->task->company->title])

@section('content')
	<p>Hi {{ $todo_list->employee->full_name }}, you have a new task alert.</p>
	<h1><a href="{{ url('todo/'.$todo_list->id) }}"><strong>#{{ $todo_list->task->id .':'. $todo_list->task->title }}</strong></a></h1>
	<p>Was assigned by {{ $todo_list->assigner->employee->full_name }}</p>
	<p>Description: {!! $todo_list->task->description !!}</p>
@endsection


