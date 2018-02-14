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
				{!! Form::open(['url' => Request::url(), 'role' => 'form']) !!}
				<div class="row">
					<div class="col-sm-5"><strong>Task Status:</strong></div>
					<div class="col-sm-7 padding-left-0">
					@if(in_array($todo_list->status,['new', 'accepted']))
						{!! Form::select('status',config('constants.task_status'),$todo_list->status,['id' => 'status', 'onchange' => 'this.form.submit();']) !!}
					@else
						<strong>{{ ucfirst($todo_list->status) }}</strong>
					@endif
					</div>
				</div>
				<div class="row margin-top-10 hide">
					<div class="col-sm-5">
						<strong>Achievement: </strong>
					</div>
					<div class="col-sm-7 padding-left-0">
					@if(in_array($todo_list->status,['new', 'accepted']))
						{!! Form::number('achievement',$todo_list->achievement,['class'=>'form-control']) !!}
					@else
						<strong>{{ ucfirst($todo_list->achievement) }}</strong>
					@endif	 
					</div>
				</div>
				{!! Form::close() !!}
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
						{!! $todo_list->assigned_at !!}
					</div>
				</div>
				{{--  
				<div class="row margin-top-10">
					<div class="col-sm-5">
						<strong>Deadline: </strong>
					</div>
					<div class="col-sm-7 padding-left-0">
						{{ $todo_list->task->deadline }}
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
				--}}
				<div class="row margin-top-10">
					<div class="col-sm-5">
						<strong>Assigned to: </strong>
					</div>
					<div class="col-sm-7 padding-left-0">
						{!! $todo_list->getAssignedEmployeeNames() !!}
					</div>
				</div>
				{{--  
				@if($todo_list->status == 'approved')
				<div class="row margin-top-10">
					<div class="col-sm-5">
						<strong>Earned Point: </strong>
					</div>
					<div class="col-sm-7 padding-left-0">
						{!! Form::open(['url' => Request::url(), 'role' => 'form', 'id' => 'form-id']) !!}
							{!! $todo_list->earned_point !!}

							<button type="button" class="btn btn-success btn-xs" name="status" value="approved" onclick="processPointFields();"><i class="fa fa-edit" aria-hidden="true"></i> Edit</button>
							<button class="btn btn-danger btn-xs" name="status" value="new"><i class="fa fa-repeat" aria-hidden="true"></i> Reopen</button>
							
							<div id="point-edit-form-fields" class="margin-top-20 hide">
								<div class="form-group">
									{!! Form::label('earned_point','Earned Point') !!}
									{!! Form::number('earned_point',$todo_list->earned_point ? $todo_list->earned_point : ($todo_list->task_role ? $todo_list->task_role->role_weight : 0),['class'=>'form-control','placeholder'=>'Earned Point']) !!}
								</div>
								<div class="form-group">
									<button class="btn btn-info" name="status" value="approved"><i class="fa fa-save" aria-hidden="true"></i> Update</button>
								</div>
							</div>
						{!! Form::close() !!}
					</div>
				</div>

				@endif


				@if($todo_list->status !== 'approved')
					@if(($todo_list->assigned_by == $todo_list->employee_id && $todo_list->employee_id == Auth::id()) || ($todo_list->employee_id !== Auth::id()))
					{!! Form::open(['url' => Request::url(), 'role' => 'form', 'id' => 'form-id', 'class' => 'margin-top-40']) !!}
						<div class="form-group">
							{!! Form::label('earned_point','Earned Point') !!}
							{!! Form::number('earned_point',$todo_list->earned_point ? $todo_list->earned_point : ($todo_list->task_role ? $todo_list->task_role->role_weight : 0),['class'=>'form-control','placeholder'=>'Earned Point']) !!}
						</div>
						<div class="form-group">
							<button class="btn btn-success" name="status" value="approved"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Approved</button>
							<button class="btn btn-danger" name="status" value="new"><i class="fa fa-repeat" aria-hidden="true"></i> Reopen</button>
						</div>
					{!! Form::close() !!}
					@endif
				@endif
				--}}

				<hr>

				@if($targetEnabled)
					<!-- Achievement Log -->

					<h4><strong>Daily Achievement</strong></h4>
					@php $randomId = time() @endphp
					<div id="div-achievement-log" class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th width="40%">Date</th>
									<th width="30%">Achievement</th>
									<th width="30%"></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><input id="{{$randomId}}_achievement_date" type="text" class="datepicker al-{{$randomId}}" value="{{Carbon::now()->format('Y-m-d')}}" style="width:100%"/></td>
									<td><input id="{{$randomId}}_achieved_point" type="number" class="al-{{$randomId}}" min="1" style="width:100%"/></td>
									<td class='text-center'><a id="{{$randomId}}_save_button" data-id="{{$randomId}}" data-action="add" class='btn btn-primary btn-xs btnALSave' href="#"><i class='fa fa-save'></i></a></td>
								</tr>
								@if(count($achievementLogs) > 0)

									@php $myAchievementLogs = $achievementLogs->take(5) @endphp

									@foreach($myAchievementLogs as $al)
										<tr>
											<td><span id="al-summery-date-{{$al->id}}">{{$al->date}}</span></td>
											<td class="text-center"><span id="al-summery-point-{{$al->id}}">{{$al->achievement}}</span></td>
											<td></td>
										</tr>
									@endforeach
								@endif
							</tbody>

							@if(count($achievementLogs) > 0)
							<tfoot>
								<tr>
									<td colspan='3'><a id="btnMoreALList" href="#">more log</a></td>
								</tr>
							</tfoot>
							@endif
						</table>
					</div>

					<!-- Achievement Log END-->
				@endif
				
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
								<h4><strong>{{ $task_activity->employee->full_name }}</strong> <span class="activity-date pull-right">{{ $task_activity->created_at }}</span></h4>
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

@if($targetEnabled)
<!-- Achievement Log Modal -->
<div id="alListModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Achievement Log</h4>
      </div>
      <div class="modal-body">
			<table id="achievement-log-table" class="table">
				<thead>
					<tr>
						<th width="50%">Date</th>
						<th class="text-center" width="30%">Achievement</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@forelse($achievementLogs as $al)
						<tr>
							<td>
								<input id="{{$al->id}}_achievement_date" type="text" class="hide datepicker al-{{$al->id}} text-{{$al->id}}" value="{{$al->date}}" style="width:100%"/>
								<span id="span-date-{{$al->id}}" class='span-{{$al->id}}'>{{$al->date}}</span>
							</td>
							<td class='text-center'>
								<input id="{{$al->id}}_achieved_point" type="number" class="hide al-{{$al->id}} text-{{$al->id}}" min="1" value="{{$al->achievement}}" style="width:100%"/>
								<span id="span-point-{{$al->id}}" class='span-{{$al->id}}'>{{$al->achievement}}</span>
							</td>
							<td class='text-center'>
								<a id="{{$al->id}}_edit_button" data-id="{{$al->id}}" class='btnALEdit btn btn-primary btn-xs' href="#"><i class='fa fa-pencil'></i></a>
								<a id="{{$al->id}}_save_button" data-id="{{$al->id}}" class='hide btn btn-primary btn-xs btnALSave' href="#"><i class='fa fa-save'></i></a>
								<a id="{{$al->id}}_cancle_button" data-id="{{$al->id}}" data-action="edit" class='hide btnALCancle' href="#">Cancle</a>
								<a id="{{$al->id}}_delete_button" data-id="{{$al->id}}" data-action="delete" class='btn btn-xs btn-danger btnALDelete hide' href="#"><i class='fa fa-trash-o'></i></a>
							</td>
						</tr>
					@empty

					@endforelse
				</tbody>
			</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-xs" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Achievement Log Modal END-->
@endif

@endsection

@section('custom-style')
{{-- Summernote --}}
{!! Html::style($assets . '/plugins/summernote/summernote.css') !!}

{!! Html::style($assets . '/plugins/datatables/css/dataTables.bootstrap.min.css') !!}

<style>

/*overwriting datepicker style for achievement log*/
.datepicker {
    padding: 0px !important;
    border-radius: 0px !important;
}

.al-has-error {
    border-color: #ff0000;
}
</style>

@endsection

@section('custom-script')
{{-- Summernote --}}
{!! Html::script($assets . '/plugins/summernote/summernote.min.js') !!}

{!! Html::script($assets . '/plugins/datatables/js/jquery.dataTables.min.js') !!}
{!! Html::script($assets . '/plugins/datatables/js/dataTables.bootstrap.min.js') !!}
<script>
function processPointFields()
{
	$('#point-edit-form-fields').toggleClass('hide');
}

$(document).ready(function(){

	@if($targetEnabled)

	/* Achievement Log Script */

	$(".btnALSave").on('click', function(){

		//flag
		var validationError = false;

		//id of clicked button
		var row_id = $(this).attr('data-id');

		//removing error class from all elements of current row
		$(".al-"+row_id).removeClass('al-has-error');

		//taking date and point from current row
		var achievement_date = $("#"+row_id+"_achievement_date").val();
		var achieved_point = $("#"+row_id+"_achieved_point").val();

		//validation
		if(achievement_date === ""){
			validationError = true;
			$("#"+row_id+"_achievement_date").addClass('al-has-error');
		}

		if(achieved_point === ""){
			validationError = true;
			$("#"+row_id+"_achieved_point").addClass('al-has-error');
		}

		if(validationError){
			return false;
		}

		//showing fa-spin progress icon
		$("#"+row_id+"_save_button i").removeClass('fa-save').addClass('fa-spinner fa-spin');

		var db_record_id = $(this).attr('data-action') === 'add' ? 0 : row_id;

		var todo_id = "{{$todo_list->id}}";

		$.post("{{url('todo/save-achievement-log')}}", {id:db_record_id,todo_id:todo_id,date:achievement_date,point:achieved_point}, function(response){

			//remove progress icon and back to normal save icon
			$("#"+row_id+"_save_button i").removeClass('fa-spinner fa-spin').addClass('fa-save');

			if(response === 'ok'){
				//reload page

				if(db_record_id === 0){
					location.reload();
				}else{
					$("#span-date-"+row_id).text(achievement_date);
					$("#span-point-"+row_id).text(achieved_point);

					$("#al-summery-date-"+row_id).text(achievement_date);
					$("#al-summery-point-"+row_id).text(achieved_point);

					$(".text-"+row_id).addClass('hide');
					$(".span-"+row_id).removeClass('hide');

					$("#"+row_id+"_edit_button").removeClass('hide');
					$("#"+row_id+"_save_button").addClass('hide');
					$("#"+row_id+"_cancle_button").addClass('hide');
				}
			}
		});
	});

	$(".btnALEdit").on('click', function(){
		var row_id = $(this).attr('data-id');

		$(".text-"+row_id).removeClass('hide');
		$(".span-"+row_id).addClass('hide');

		$("#"+row_id+"_edit_button").addClass('hide');
		$("#"+row_id+"_save_button").removeClass('hide');
		$("#"+row_id+"_cancle_button").removeClass('hide');
	});

	$(".btnALCancle").on('click', function(){
		var row_id = $(this).attr('data-id');

		$(".text-"+row_id).addClass('hide');
		$(".span-"+row_id).removeClass('hide');

		$("#"+row_id+"_edit_button").removeClass('hide');
		$("#"+row_id+"_save_button").addClass('hide');
		$("#"+row_id+"_cancle_button").addClass('hide');
	});

	$("#btnMoreALList").on('click',function(){
		$("#alListModal").modal('show');
	});

	/* Achievement Log Script END */

	@endif
});

(function() {
    {{-- Initialize Summernote --}}
    $('#comments').summernote({
    	height: 150
    });
})();
</script>
@endsection






