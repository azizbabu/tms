@extends('layouts.master')

@section('title') Company Details @endsection 

@section('content')
<div id="panel-1" class="panel panel-default">
	<div class="panel-heading">
		<div class="panel-title">Company Details</div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
		        <div class="details-info">
		        	<h4><strong>Title:</strong>{{ $company->title }}</h4>
		        	<strong>Contact Person Name:</strong> {{ $company->contact_person_name ? $company->contact_person_name : 'N/A' }}<br>
		        	<strong>Contact Person Phone:</strong> {{ $company->contact_person_phone ? $company->contact_person_phone : 'N/A' }}<br>
		        	<strong>Contact Person Email:</strong> {{ $company->contact_person_email ? $company->contact_person_email : 'N/A' }}<br>
		        	<strong>Established Year:</strong> {{ $company->established_year ? Carbon::parse($company->established_year)->format('d M, Y') : 'N/A' }}<br>
		        	<strong>Address:</strong> {!! $company->address !!}<br>
		        	<strong>City:</strong> {{ $company->city }}<br>
		        	<strong>State:</strong> {{ $company->state }}<br>
		        	<strong>Zip:</strong> {{ $company->zip }}<br>
		        	<strong>Country:</strong> {{ $company->country_obj->name }}<br>
		        	
		            @if(@getimagesize(url($company->logo)))
		            	<strong>Logo:</strong> <div class="employee-photo"><img class="img-responsive" src="{{ url($company->logo) }}" alt="Company Logo"></div>
					@endif
		        </div>
			</div>
		</div>	
	</div>
	<div class="panel-footer">
		<a class="btn btn-default btn-sm" href="{{ URL::to('companies/' . $company->id . '/edit') }}" title="Edit Employee"><i class="fa fa-pencil"></i> Edit</a>
		<a class="btn btn-info btn-sm" href="{{ URL::to('companies') }}" title="Go Back"><i class="fa fa-backward"></i> Go Back</a>
	</div>
</div>
@endsection


