@extends('layouts.master')

@section('title') Create Employee @endsection 

@section('content')

{!! Form::open(array('url' => 'employees', 'role' => 'form','files' => true, 'id'=>'employee-form')) !!}
	<div class="panel panel-default margin-top-20">
		<div class="panel-heading">
			<div class="panel-title">Create Employee</div>
		</div>
		<div class="panel-body">
			@include('employees.form')
		</div>
		<div class="panel-footer">
			<button class="btn btn-info"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
		</div>
	</div>		
{!! Form::close() !!}

@endsection



