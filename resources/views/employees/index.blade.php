@extends('layouts.master')

@section('title') List of Employees @endsection 

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default margin-top-20">
			<div class="panel-heading clearfix">
				List of Employees
				<a class="btn btn-danger btn-xs pull-right" href="{!!url('employees/create')!!}"><i class="fa fa-plus-circle"></i> Add New</a>
			</div>

			<div class="panel-body">
			@if(!isDepartmentAdmin())
				{!! Form::open(['url' => Request::url(), 'role'=>'form']) !!}
				<div class="row">
					@if(isSuperAdmin())
					<div class="col-sm-3">
						<div class="form-group">
                            {!! Form::select('company_id',$companies, Request::input('company_id') ? Request::input('company_id') :'',['class'=>'form-control chosen-select']) !!}
                        </div>
					</div>
					@endif
					<div class="col-sm-3">
						<div class="form-group">
                            {!! Form::select('branch_id',$branches, Request::input('branch_id') ? Request::input('branch_id') :'',['class'=>'form-control chosen-select']) !!}
                        </div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
                            {!! Form::select('department_id',$departments, Request::input('department_id') ? Request::input('department_id') :'',['class'=>'form-control chosen-select']) !!}
                        </div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<button class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
							<a href="{{ Request::url() }}" class="btn btn-info">Reset</a>
						</div>
					</div>
				</div>
				{!! Form::close() !!}
			@endif
				
				<div class="table-responsive">
					<table id="employee-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
					    <thead>
					        <tr>
					        	<th>ID</th>
					        	<th>Name</th>
					        	@if(isSuperAdmin())
					            	<th>Company</th>
					           	@endif
					            <th>Branch</th>
					            <th>Department</th>
					            <th>Phone</th>
					            <th>Email</th>
					            <th width="15%">Actions</th>
					        </tr>
					    </thead>
					    <tbody>
					    @forelse($employees as $employee)
					        <tr>
					        	<td>{{ $employee->id }}</td>
					            <td>{{ $employee->full_name }}</td>
					            @if(isSuperAdmin())
					            	<td>{{ $employee->company ? $employee->company->title : 'N/A' }}</td>
					            @endif
					            <td>{{ $employee->branch ? $employee->branch->title : 'N/A' }}</td>
					            <td>{{ $employee->department ? $employee->department->title : 'N/A' }}</td>
					            <td>{{ $employee->phone }}</td>
					            <td>{{ $employee->user ? $employee->user->email : 'N/A' }}</td>

					            <td class="action-column">
					            	@php $user = $employee->user @endphp
									
									@if($user)
					            	{{-- Display Employee Dashboard --}}
					            	<a class="btn btn-xs btn-warning" href="{{ URL::to('employee-dashboard/' . $user->username) }}" title="View Employee Dashboard" target="_blank"><i class="fa fa-dashboard"></i></a>
					            	@else
					            	<a class="btn btn-xs btn-warning disabled" href="#" title="View Employee Dashboard" target="_blank"><i class="fa fa-dashboard"></i></a>
					            	@endif
									
									@if(isSuperAdminOrAdmin())
									@if($user)
					            	{{-- Assign Employee Permission --}}
					            	<a class="btn btn-xs btn-default" href="{{ URL::to('permission/' . $user->id) }}" title="Assign Employee Permission"><i class="fa fa-power-off"></i></a>
					            	@else
									<a class="btn btn-xs btn-default disabled" href="#/" title="Assign Employee Permission"><i class="fa fa-power-off"></i></a>
					            	@endif
					            	@endif

					            	{{-- Display Employee Task --}}
					            	<a class="btn btn-xs btn-primary" href="{{ URL::to('employee-tasks/employee/' . $employee->id) }}" title="View Employee Task"><i class="fa fa-tasks"></i></a>
					                <!-- show the users (uses the show method found at GET /users/{id} -->
					                <a class="btn btn-xs btn-success" href="{{ URL::to('employees/' . $employee->id) }}" title="View Company"><i class="fa fa-eye"></i></a>

					                <!-- edit this users (uses the edit method found at GET /users/{id}/edit -->
					                <a class="btn btn-xs btn-default" href="{{ URL::to('employees/' . $employee->id . '/edit') }}" title="Edit Employee"><i class="fa fa-pencil"></i></a>
					                
					                {{-- Activate/Deactivate --}}
					                @if($user)
                                		<!-- <a href="{{url('users/change-active/'.$user->id)}}" class="btn btn-xs btn-{{$user->active ? 'danger':'info'}}" title="{{$user->active ? 'Deactivate User':'Activate User'}}"><i class="fa fa-{{$user->active ? 'ban':'check'}}"></i></a> -->

                                		<a href="#" data-id="{{$user->id}}" data-action="{{ url('users/change-active') }}" data-message="Are you sure, You want to {{$user->active ? 'deactivate' : 'activate' }} this employee?" class="btn btn-xs btn-{{$user->active ? 'danger':'info'}} alert-dialog" title="{{$user->active ? 'Deactivate User':'Activate User'}}"><i class="fa fa-{{$user->active ? 'ban':'check'}}"></i></a>
                                	@else
                                		<a href="#" class="btn btn-xs btn-danger disabled"><i class="fa fa-ban"></i></a>
                                	@endif

					                {{-- Delete --}}
									<a href="#" data-id="{{$employee->id}}" data-action="{{ url('employees/delete') }}" data-message="Are you sure, You want to delete this employee? If you delete this employee, all its sub employee will be deleted." class="btn btn-danger btn-xs alert-dialog" title="Delete Employee"><i class="fa fa-trash white"></i></a>
					            </td>
					        </tr>
					    @empty
					    	<!-- <tr>
					        	<td colspan="7" align="center">No Record Found!</td>
					        </tr> -->
					    @endforelse
					    </tbody>
					</table>
				</div>
			</div><!-- end panel-body -->

			{{--  
			@if($employees->total() > 10)
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-4">
						{{ $employees->paginationSummery }}
					</div>
					<div class="col-sm-8 text-right">
						{!! $employees->links() !!}
					</div>
				</div>
			</div>
			@endif
			--}}
		</div><!-- end panel panel-default -->
	</div>
</div>
@endsection

@section('custom-style')
{{-- Data table --}}
{!! Html::style($assets . '/plugins/datatables/css/dataTables.bootstrap.min.css') !!}
@endsection

@section('custom-script')
{{-- Data table --}}
{!! Html::script($assets . '/plugins/datatables/js/jquery.dataTables.min.js') !!}
{!! Html::script($assets . '/plugins/datatables/js/dataTables.bootstrap.min.js') !!}
<script>
(function() {
    $('#employee-table').DataTable({
    	"columnDefs": [
		    { "visible": false, "targets": 0 },
		    { "width": "20%", "targets": {{ isSuperAdmin() ? 7 : 6}} },
		],
		"order": [[0, 'desc']]
    });
})();
</script>
@endsection

