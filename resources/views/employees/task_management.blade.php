@extends('layouts.master')

@section('title') Task Management @endsection 

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default margin-top-20">
			<div class="panel-heading">
				Task Management
			</div>

			<div class="panel-body">
				<ul class="nav nav-tabs">
				  <li class="active"><a data-toggle="tab" href="#my-team">My Team</a></li>
				  <li><a data-toggle="tab" href="#my-team-task">My Team Task</a></li>
				  <li><a data-toggle="tab" href="#my-task">My Task</a></li>
				</ul>

				<div class="tab-content">
					{{-- My Team --}}
				  	<div id="my-team" class="tab-pane fade in active">
					    <div class="table-responsive">
							<table id="employee-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
							    <thead>
							        <tr>
							        	<th>ID</th>
							        	<th>Name</th>
							            <th>Branch</th>
							            <th>Department</th>
							            <th>Phone</th>
							            <th>Email</th>
							            <th width="12%">Actions</th>
							        </tr>
							    </thead>
							    <tbody>
							    @forelse($employees as $employee)
							        <tr>
							        	<td>{{ $employee->id }}</td>
							            <td>{{ $employee->full_name }}</td>
							            <td>{{ $employee->branch ? $employee->branch->title : 'N/A' }}</td>
							            <td>{{ $employee->department ? $employee->department->title : 'N/A' }}</td>
							            <td>{{ $employee->phone }}</td>
							            <td>{{ $employee->user ? $employee->user->email : 'N/A' }}</td>

							            <td class="action-column">
							            	{{-- Display Employee Task --}}
							            	<a class="btn btn-xs btn-primary" href="{{ URL::to('employee-tasks/employee/' . $employee->id) }}" title="View Employee Task"><i class="fa fa-tasks"></i></a>
							            </td>
							        </tr>
							    @empty
							    	<!-- <tr>
							        	<td colspan="6" align="center">No Record Found!</td>
							        </tr> -->
							    @endforelse
							    </tbody>
							</table>
						</div>
				  	</div>
				  	{{-- /My Team --}}

				  	{{-- My Team Task --}}
					<div id="my-team-task" class="tab-pane fade">
					    <div class="table-responsive">
			                <table id="task-table" class="table table-bordered">
			                    <thead>
			                        <tr>
			                            <th class="text-center" width="7%">Number</th>
			                            <th>Task</th>
			                            <th width="15%">Department</th>
			                            <th width="15%">Assigned To</th>
			                            <th class="text-center" width="7%">Status</th>
			                            <th width="24%">Assigned at</th>
			                            <th width="24%">Finished at</th>
			                        </tr>
			                    </thead>
			                    <tbody>
			                    @php $i= 1 @endphp
			                    @forelse($todo_lists as $todo_list)
			                        <tr>
			                            <td class="text-center">@php echo '#' . $i++ @endphp</td>
			                            <td><a href="{{ url('todo/'.$todo_list->id) }}" target="_blank">{{ $todo_list->title }}</a></td>
			                            <td>{{ $todo_list->department_title }}</td>
			                            <td>{{ $todo_list->full_name }}</td>
			                            <td class="text-center">{{ ucfirst($todo_list->status) }}</td>
			                            <td>{{ $todo_list->assigned_at }}</td>
			                            <td>{{ $todo_list->finished_at }}</td>
			                        </tr>
			                    @empty
			                        <!-- <tr>
			                            <td colspan="6" align="center">No Assigned Task Found!</td>
			                        </tr> -->
			                    @endforelse
			                    </tbody>
			                </table>
			            </div>

						{{--  
			            @if($todo_lists->total() > 10)
			            <div class="row">
			                <div class="col-sm-4">{{ $todo_lists->paginationSummery }}</div>
			                <div class="col-sm-8 text-right">
			                    {!! $todo_lists->links() !!}
			                </div>
			            </div>
			            @endif
			            --}}
					</div>
					{{-- /My Team Task --}}

					{{-- My Task --}}
					<div id="my-task" class="tab-pane fade">
						<div class="table-responsive">
		                    <table id="my-task-table" class="table table-bordered">
		                        <thead>
		                            <tr>
		                                <th class="text-center" width="7%">Number</th>
		                                <th>Task Title</th>
		                                {{--  
		                                <th width="15%">Task Frequency</th>
		                                --}}
		                                <th width="15%">Task Type</th>
		                                <th>Assigned at</th>
		                                <th>Deadline</th>
		                            </tr>
		                        </thead>
		                        <tbody>
		                        @php $i=1 @endphp
		                        @forelse($my_todo_lists as $todo_list)
		                            <tr>
		                                <td class="text-center">@php echo '#' . $i++ @endphp</td>
		                                <td><a href="{{ url('todo/'.$todo_list->id) }}" target="_blank">{{ $todo_list->title }}</a></td>
		                                {{--  
		                                <td>{{ config('constants.frequency.'.$todo_list->frequency) }}</td>
		                                --}}
		                                <td>{{ config('constants.job_type.'.$todo_list->job_type) }}</td>
		                                <td>{{ $todo_list->assigned_at }}</td>
		                                <td>{{ $todo_list->deadline->format('d M, Y H:i A') }}</td>
		                            </tr>
		                        @empty
		                            <!-- <tr>
		                                <td colspan="4" align="center">No Assigned Task Found!</td>
		                            </tr> -->
		                        @endforelse
		                        </tbody>
		                    </table>
		                </div>
					</div>
					{{-- /My Task --}}
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
	{{-- Initialize DataTable --}}
	
    $('#employee-table').DataTable({
    	"columnDefs": [
		    { "visible": false, "targets": 0 }
		],
		"order": [[0, 'desc']]
    });

    $('#task-table').DataTable({
    	"columns": [
	    null,
	    null,
	    null,
	    { "width": "15%" },
	    null,
	    { "width": "12%" },
	    { "width": "12%" },
	  ],
	  autoWidth: false
    });

    $('#my-task-table').DataTable({
    	"columnDefs": [
    		{ "width": "7%", "targets": 0 },
		    { "width": "15%", "targets": 2 },
		    { "width": "15%", "targets": 3 },
		],
	  	autoWidth: false
    });
})();
</script>
@endsection



