@extends('layouts.master')

@section('title') Edit Branch @endsection 

@section('content')

{!! Form::model($branch, array('url' => 'branches', 'role' => 'form','files' => true, 'id'=>'branch-form')) !!}
	<div class="panel panel-default margin-top-20">
		<div class="panel-heading">
			<div class="panel-title">Edit Branch</div>
		</div>
		<div class="panel-body">
			@include('branches.form')
		</div>
		<div class="panel-footer">
			{!! Form::hidden('branch_id', $branch->id) !!}
			<button class="btn btn-info"><i class="fa fa-save" aria-hidden="true"></i> Update</button>
		</div>
	</div>		
{!! Form::close() !!}

@endsection



