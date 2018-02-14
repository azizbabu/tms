@extends('layouts.master')

@section('title') List of Companies @endsection 

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default margin-top-20">
			<div class="panel-heading clearfix">
				List of Companies
				<a class="btn btn-danger btn-xs pull-right" href="{!!url('companies/create')!!}"><i class="fa fa-plus-circle"></i> Add New</a>
			</div>

			<div class="panel-body">
				<table class="table table-striped table-bordered">
				    <thead>
				        <tr>
				        	<th>Title</th>
				            <th>Contact Person Name</th>
				            <th width="12%">Established Year</th>
				            <th>City</th>
				            <th>Zip</th>
				            <th>Country</th>
				            <th width="10%">Actions</th>
				        </tr>
				    </thead>
				    <tbody>
				    @forelse($companies as $company)
				        <tr>
				            <td>{{ $company->title }}</td>
				            <td>{{ $company->contact_person_name ? $company->contact_person_name : 'N/A' }}</td>
				            <td>{{ Carbon::parse($company->established_year)->format('d M, Y') }}</td>
				            <td>{{ $company->city }}</td>
				            <td>{{ $company->zip }}</td>
				            <td>{{ $company->country_obj->name }}</td>

				            <td class="action-column">
				                <!-- show the users (uses the show method found at GET /users/{id} -->
				                <a class="btn btn-xs btn-success" href="{{ URL::to('companies/' . $company->id) }}" title="View Company"><i class="fa fa-eye"></i></a>

				                <!-- edit this users (uses the edit method found at GET /users/{id}/edit -->
				                <a class="btn btn-xs btn-default" href="{{ URL::to('companies/' . $company->id . '/edit') }}" title="Edit Company"><i class="fa fa-pencil"></i></a>
				                
				                {{-- Delete --}}
								<a href="#" data-id="{{$company->id}}" data-action="{{ url('companies/delete') }}" data-message="Are you sure, You want to delete this company?" class="btn btn-danger btn-xs alert-dialog" title="Delete Company"><i class="fa fa-trash white"></i></a>
				            </td>
				        </tr>
				    @empty
				    	<tr>
				        	<td colspan="7" align="center">No Record Found!</td>
				        </tr>
				    @endforelse
				    </tbody>
				</table>
			</div><!-- end panel-body -->

			@if($companies->total() > 10)
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-4">
						{{ $companies->paginationSummery }}
					</div>
					<div class="col-sm-8 text-right">
						{!! $companies->links() !!}
					</div>
				</div>
			</div>
			@endif
		</div><!-- end panel panel-default -->
	</div>
</div>
@endsection