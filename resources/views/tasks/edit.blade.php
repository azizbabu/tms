@extends('layouts.master')

@section('title') Edit Task @endsection 

@section('content')

{!! Form::model($task, array('url' => 'tasks', 'role' => 'form', 'id'=>'task-form')) !!}
	<div class="panel panel-default margin-top-20">
		<div class="panel-heading">
			<div class="panel-title">Edit Task</div>
		</div>
		<div class="panel-body">
			@include('tasks.form')
		</div>
		<div class="panel-footer">
			{!! Form::hidden('task_id', $task->id) !!}
			<button class="btn btn-info"><i class="fa fa-save" aria-hidden="true"></i> Update</button>
		</div>
	</div>		
{!! Form::close() !!}

@endsection



