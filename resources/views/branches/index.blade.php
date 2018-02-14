@extends('layouts.master')

@section('title') List of Branches @endsection 

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default margin-top-20">
			<div class="panel-heading clearfix">
				List of Branches
				<a class="btn btn-danger btn-xs pull-right" href="{!!url('branches/create')!!}"><i class="fa fa-plus-circle"></i> Add New</a>
			</div>

			<div class="panel-body">
				<table class="table table-striped table-bordered">
				    <thead>
				        <tr>
				        	<th>Title</th>
				        	@if(isSuperAdmin())
				            	<th>Company</th>
				            @endif
				            <th>Established Year</th>
				            <th>City</th>
				            <th>Zip</th>
				            <th>Country</th>
				            <th width="10%">Actions</th>
				        </tr>
				    </thead>
				    <tbody>
				    @forelse($branches as $branch)
				        <tr>
				            <td>{{ $branch->title }}</td>
				            @if(isSuperAdmin())
				            	<td>{{ $branch->company ? $branch->company->title : 'N/A' }}</td>
				            @endif
				            <td>{{ Carbon::parse($branch->established_year)->format('d M, Y') }}</td>
				            <td>{{ $branch->city }}</td>
				            <td>{{ $branch->zip }}</td>
				            <td>{{ $branch->country_obj->name }}</td>

				            <td class="action-column">
				                <!-- show the users (uses the show method found at GET /users/{id} -->
				                <a class="btn btn-xs btn-success" href="{{ URL::to('branches/' . $branch->id) }}" title="View Branch"><i class="fa fa-eye"></i></a>

				                <!-- edit this users (uses the edit method found at GET /users/{id}/edit -->
				                <a class="btn btn-xs btn-default" href="{{ URL::to('branches/' . $branch->id . '/edit') }}" title="Edit Branch"><i class="fa fa-pencil"></i></a>
				                
				                {{-- Delete --}}
								<a href="#" data-id="{{$branch->id}}" data-action="{{ url('branches/delete') }}" data-message="Are you sure, You want to delete this branch?" class="btn btn-danger btn-xs alert-dialog" title="Delete Branch"><i class="fa fa-trash white"></i></a>
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

			@if($branches->total() > 10)
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-4">
						{{ $branches->paginationSummery }}
					</div>
					<div class="col-sm-8 text-right">
						{!! $branches->links() !!}
					</div>
				</div>
			</div>
			@endif
		</div><!-- end panel panel-default -->
	</div>
</div>
@endsection