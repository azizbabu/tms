@extends('layouts.master')

@section('title') Edit Employee @endsection 

@section('content')

{!! Form::model($employee, array('url' => 'employees', 'role' => 'form','files' => true, 'id'=>'employee-form')) !!}
	<div class="panel panel-default margin-top-20">
		<div class="panel-heading">
			<div class="panel-title">Edit Employee</div>
		</div>
		<div class="panel-body">
			@include('employees.form')
		</div>
		<div class="panel-footer">
			{!! Form::hidden('file_remove', false) !!}
			{!! Form::hidden('employee_id', $employee->id) !!}
			<button class="btn btn-info"><i class="fa fa-save" aria-hidden="true"></i> Update</button>
		</div>
	</div>		
{!! Form::close() !!}

@endsection



