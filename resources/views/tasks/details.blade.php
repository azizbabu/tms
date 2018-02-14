@extends('layouts.master')

@section('title') Task Details @endsection 

@section('content')

<div class="panel panel-default margin-top-20">
	<div class="panel-heading">
		<div class="panel-title"><strong>{{ $todo_list->task->title }}</strong></div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-5"><strong>Task Status:</strong></div>
					<div class="col-sm-7 padding-left-0">
					{!! Form::open(['url' => Request::url(), 'role' => 'form']) !!}
						{!! Form::select('status',config('constants.task_status'),$todo_list->status,['class'=>'form-control chosen-select', 'id' => 'status', 'onchange' => 'this.form.submit();']) !!}
					{!! Form::close() !!}
					</div>
				</div>
				<div class="row margin-top-10">
					<div class="col-sm-5">
						<strong>Assigned by: </strong>
					</div>
					<div class="col-sm-7 padding-left-0">
						{{ $todo_list->assigner->employee->full_name }} 
					</div>
				</div>
				<div class="row margin-top-10">
					<div class="col-sm-5">
						<strong>Assigned on: </strong>
					</div>
					<div class="col-sm-7 padding-left-0">
						{!! $todo_list->assigned_at->format('d M, Y H:i A') !!}
					</div>
				</div>
				<div class="row margin-top-10">
					<div class="col-sm-5">
						<strong>Deadline: </strong>
					</div>
					<div class="col-sm-7 padding-left-0">
						{{ Carbon::parse($todo_list->task->deadline)->format('d M, Y') }}
					</div>
				</div>
				<div class="row margin-top-10">
					<div class="col-sm-5">
						<strong>Priority: </strong>
					</div>
					<div class="col-sm-7 padding-left-0">
						{{ ucfirst($todo_list->task->priority) }}
					</div>
				</div>
				<div class="row margin-top-10">
					<div class="col-sm-5">
						<strong>Assigned to: </strong>
					</div>
					<div class="col-sm-7 padding-left-0">
						{!! $todo_list->getAssignedEmployeeNames() !!}
					</div>
				</div>
			</div>
			<div class="col-sm-8">
				<h2 class="margin-top-0"><strong>#{{$todo_list->task->id}} {{ $todo_list->task->title }}</strong></h2>
				<div class="details-info">
					{!! $todo_list->task->description !!} 
				</div>

				@if($task_activities->isNotEmpty())
				<div class="task-activities margin-top-40">
					@foreach($task_activities as $task_activity)
						{{--  
						<div class="row{{ $loop->index ? ' margin-top-20' : '' }}">
							<div class="col-sm-3"><img class="img-responsive inline-block" src="{{ $assets .'/images/avatar/dummy_profpic.jpg' }}" alt="" width="40" height="30"> {{ $task_activity->employee->full_name }}</div>
							<div class="col-sm-9">{{ $task_activity->comments }}</div>
						</div>
						--}}
						<div class="task-activity{{ $loop->index ? ' margin-top-20' : '' }}">
							<img class="img-responsive inline-block pull-left" src="{{ $assets .'/images/avatar/dummy_profpic.jpg' }}" alt="" width="40" height="30">
							<div class="activity-content">
								<h4><strong>{{ $task_activity->employee->full_name }}</strong> <span class="activity-date pull-right">{{ $task_activity->created_at->format('d-m-Y H:i A') }}</span></h4>
								<div class="activity-comment text-justify">{!! $task_activity->comments !!}</div>
							</div>
						</div>
					@endforeach
				</div>
				@endif

				{!! Form::open(['url' => Request::url(), 'role' => 'form', 'class' => 'margin-top-20']) !!}
					
					<div class="form-group">
						<label for="comments" class="control-label">Comments {!! validation_error($errors->first('comments'),'comments') !!}</label>
						{!! Form::textarea('comments',old('comments'),['class'=>'form-control', 'size' => '30x3', 'id' => 'comments']) !!}
					</div>
					<div class="form-group">
						<button class="btn btn-info"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>		

@endsection

@section('custom-style')
{{-- Summernote --}}
{!! Html::style($assets . '/plugins/summernote/summernote.css') !!}
@endsection

@section('custom-script')
{{-- Summernote --}}
{!! Html::script($assets . '/plugins/summernote/summernote.min.js') !!}
<script>
(function() {
    {{-- Initialize Summernote --}}
    $('#comments').summernote({
    	height: 150
    });
})();
</script>
@endsection






