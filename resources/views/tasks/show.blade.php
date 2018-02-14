@extends('layouts.master')

@section('title') Task Details @endsection 

@section('content')
<div id="panel-1" class="panel panel-default">
	<div class="panel-heading">
		<div class="panel-title">Task Details</div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
		        <div class="details-info">
		        	<h4><strong>Title: </strong>{{ $task->title }}</h4>
		        	<strong>Company:</strong> {{ $task->company ? $task->company->title : 'N/A' }} <br>
		        	<strong>Branch:</strong> {{ $task->branch ? $task->branch->title : 'N/A' }} <br>
		        	<strong>Department:</strong> {{ $task->department ? $task->department->title : 'N/A' }} <br>
		        	<strong>Description:</strong> {{ $task->description }} <br>
		        	<strong>Job Type:</strong> {{ config('constants.job_type.' . $task->job_type)  }} <br>
		        	{{--  
		        	<strong>Frequency:</strong> {{ config('constants.frequency.' . $task->frequency)  }} <br>
		        	<strong>Priority:</strong> {{ config('constants.priority.' . $task->priority)  }} <br>
		        	<strong>Deadline:</strong> {{ $task->deadline }}
		        	--}}
		        </div>
			</div>
		</div>	
	</div>
	<div class="panel-footer">
		<a class="btn btn-default btn-sm" href="{{ URL::to('tasks/' . $task->id . '/edit') }}" title="Edit Employee"><i class="fa fa-pencil"></i> Edit</a>
		<a class="btn btn-info btn-sm" href="{{ URL::to('tasks') }}" title="Go Back"><i class="fa fa-backward"></i> Go Back</a>
	</div>
</div>

@endsection


