@extends('layouts.master')

@section('title') List of Tasks @endsection 

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default margin-top-20">
			<div class="panel-heading clearfix">
				List of Tasks
				<a class="btn btn-danger btn-xs pull-right" href="{!!url('tasks/create')!!}"><i class="fa fa-plus-circle"></i> Add New</a>

				@if(isSuperAdmin())
				<a class="btn btn-danger btn-xs pull-right" href="{!!url('tasks-bulk-create')!!}"><i class="fa fa-plus-circle"></i> Create Bulk Task</a>
				@endif
			</div>

			<div class="panel-body">
				<table class="table table-striped table-bordered">
				    <thead>
				        <tr>
				        	<th>Title</th>
				        	@if(isSuperAdmin())
				            	<th>Company</th>
				            @endif
				            <th>Branch</th>
				            <th>Department</th>
				            <th>Parent</th>
				            {{--  
				            <th>Deadline</th>
				            --}}
				            <th width="10%">Actions</th>
				        </tr>
				    </thead>
				    <tbody>
				    @forelse($tasks as $task)
				        <tr>
				            <td>{{ $task->title }}</td>
				            @if(isSuperAdmin())
				            	<td>{{ $task->company ? $task->company->title : 'N/A' }}</td>
				            @endif
				            <td>{{ $task->branch ? $task->branch->title : 'N/A' }}</td>
				            <td>{{ $task->department ? $task->department->title : 'N/A' }}</td>
				            <td>{{ $task->parent ? $task->parent->title : 'N/A' }}</td>
				            {{--  
				            <td>{{ $task->deadline }}</td>
				            --}}

				            <td class="action-column">
				                <!-- show the users (uses the show method found at GET /users/{id} -->
				                <a class="btn btn-xs btn-success" href="{{ URL::to('tasks/' . $task->id) }}" title="View Task"><i class="fa fa-eye"></i></a>

				                <!-- edit this users (uses the edit method found at GET /users/{id}/edit -->
				                <a class="btn btn-xs btn-default" href="{{ URL::to('tasks/' . $task->id . '/edit') }}" title="Edit Task"><i class="fa fa-pencil"></i></a>
				                
				                {{-- Delete --}}
								<a href="#" data-id="{{$task->id}}" data-action="{{ url('tasks/delete') }}" data-message="Are you sure, You want to delete this task?" class="btn btn-danger btn-xs alert-dialog" title="Delete Task"><i class="fa fa-trash white"></i></a>
				            </td>
				        </tr>

				        {!! \App\Task::getTaskList($task->children) !!} 

				    @empty
				    	<tr>
				        	<td colspan="7" align="center">No Record Found!</td>
				        </tr>
				    @endforelse
				    </tbody>
				</table>
			</div><!-- end panel-body -->

			@if($tasks->total() > 10)
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-4">
						{{ $tasks->paginationSummery }}
					</div>
					<div class="col-sm-8 text-right">
						{!! $tasks->links() !!}
					</div>
				</div>
			</div>
			@endif
		</div><!-- end panel panel-default -->
	</div>
</div>
@endsection