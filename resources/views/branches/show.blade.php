@extends('layouts.master')

@section('title') Branch Details @endsection 

@section('content')
<div id="panel-1" class="panel panel-default">
	<div class="panel-heading">
		<div class="panel-title">Branch Details</div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
		        <div class="details-info">
		        	<h4><strong>Title: </strong>{{ $branch->title }}</h4>
		        	<strong>Company:</strong> {{ $branch->company ? $branch->company->title : 'N/A' }} <br>
		        	<strong>Contact Person Name:</strong> {{ $branch->contact_person_name ? $branch->contact_person_name : 'N/A' }}<br>
		        	<strong>Contact Person Phone:</strong> {{ $branch->contact_person_phone ? $branch->contact_person_phone : 'N/A' }}<br>
		        	<strong>Contact Person Email:</strong> {{ $branch->contact_person_email ? $branch->contact_person_email : 'N/A' }}<br>
		        	<strong>Established Year:</strong> {{ $branch->established_year ? Carbon::parse($branch->established_year)->format('d M, Y') :'N/A' }}<br>
		        	<strong>Address:</strong> {!! $branch->address !!}<br>
		        	<strong>City:</strong> {{ $branch->city }}<br>
		        	<strong>State:</strong> {{ $branch->state }}<br>
		        	<strong>Zip:</strong> {{ $branch->zip }}<br>
		        	<strong>Country:</strong> {{ $branch->country_obj->name }}<br>
		        </div>
			</div>
		</div>	
	</div>
	<div class="panel-footer">
		<a class="btn btn-default btn-sm" href="{{ URL::to('branches/' . $branch->id . '/edit') }}" title="Edit Employee"><i class="fa fa-pencil"></i> Edit</a>
		<a class="btn btn-info btn-sm" href="{{ URL::to('branches') }}" title="Go Back"><i class="fa fa-backward"></i> Go Back</a>
	</div>
</div>

@endsection


