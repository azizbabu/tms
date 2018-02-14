@extends('layouts.master')

@section('title') Create Task @endsection 

@section('content')

{!! Form::open(array('url' => 'tasks', 'role' => 'form', 'id'=>'task-form')) !!}
	<div class="panel panel-default margin-top-20">
		<div class="panel-heading">
			<div class="panel-title">Create Task</div>
		</div>
		<div class="panel-body">
			@include('tasks.form')
		</div>
		<div class="panel-footer">
			<button class="btn btn-info"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
		</div>
	</div>		
{!! Form::close() !!}

@endsection


