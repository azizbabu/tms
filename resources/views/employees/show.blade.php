@extends('layouts.master')

@section('title') Employee Details @endsection 

@section('content')
<div id="panel-1" class="panel panel-default margin-top-20">
	<div class="panel-heading">
		<div class="panel-title">Employee Details</div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
		        <div class="details-info">
		        	<h4><strong>Name:</strong>{{ $employee->full_name }}</h4>
		        	<strong>Father's Name:</strong> {{ $employee->fathers_name }}<br>
		        	<strong>Mother's Name:</strong> {{ $employee->mothers_name }}<br>
		        	<strong>Company:</strong> {{ $employee->company ? $employee->company->title : 'N/A' }}<br>
		        	<strong>Branch:</strong> {{ $employee->branch ? $employee->branch->title : 'N/A' }}<br>
		        	<strong>Department:</strong> {{ $employee->department ? $employee->department->title : 'N/A' }}<br>
		        	<strong>Designation:</strong> {{ $employee->designation ? $employee->designation->title : 'N/A' }}<br>
		        	<strong>Reporting Boss:</strong> {{ config('constants.reporting_bosses.'.$employee->reporting_boss) }}<br>
		        	<strong>Code:</strong> {{ $employee->code }}<br>
		            <strong>Joining Date:</strong> {{ $employee->joining_date ? Carbon::parse($employee->joining_date)->format('d M, Y') : 'N/A' }}<br>
		            <strong>Date of Birth:</strong> {{ $employee->dob ? Carbon::parse($employee->dob)->format('d M, Y') : 'N/A' }}<br>
		            <strong>Religion:</strong> {{ $employee->religion }}<br>
		            <strong>Nationality:</strong> {{ $employee->nationality }}<br>
		            <strong>Gender:</strong> {{ ucfirst($employee->gender) }}<br>
		            <strong>National ID:</strong> {{ $employee->nid }}<br>
		            <strong>Phone:</strong> {{ $employee->phone }}<br>
		            <strong>Blood Group:</strong> {{ $employee->blood_group ? $employee->blood_group : 'N/A' }}<br>
		            <strong>Passport No:</strong> {{ $employee->passport_no ? $employee->passport_no : 'N/A' }}<br>
		            <strong>Tin:</strong> {{ $employee->tin ? $employee->tin : 'N/A' }}<br>
		            <strong>Present Address:</strong> {!! $employee->present_address ? $employee->present_address : 'N/A' !!}<br>
		            <strong>Permanent Address:</strong> {!! $employee->present_address ? $employee->present_address : 'N/A' !!}<br>
		            @if(@getimagesize($employee->photo))
		            	<strong>Photo:</strong> <div class="employee-photo"><img class="img-responsive" src="{{ url($employee->photo) }}" alt="Employee Photo"></div>
					@endif
		        </div>
			</div>
		</div>	
	</div>
	<div class="panel-footer">
		<a class="btn btn-default btn-sm" href="{{ URL::to('employees/' . $employee->id . '/edit') }}" title="Edit Employee"><i class="fa fa-pencil"></i> Edit</a>
		<a class="btn btn-info btn-sm" href="{{ URL::to('employees/list') }}" title="Go Back"><i class="fa fa-backward"></i> Go Back</a>
	</div>
</div>

@endsection


