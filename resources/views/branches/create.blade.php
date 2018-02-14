@extends('layouts.master')

@section('title') Create Branch @endsection 

@section('content')

{!! Form::open(array('url' => 'branches', 'role' => 'form','files' => true, 'id'=>'branch-form')) !!}
	<div class="panel panel-default margin-top-20">
		<div class="panel-heading">
			<div class="panel-title">Create Branch</div>
		</div>
		<div class="panel-body">
			@include('branches.form')
		</div>
		<div class="panel-footer">
			<button class="btn btn-info"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
		</div>
	</div>		
{!! Form::close() !!}

@endsection



