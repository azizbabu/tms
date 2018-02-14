@extends('layouts.master')

@section('title') Employee Task @endsection

@section('content')
<div id="panel-1" class="panel panel-default margin-top-20">
    <div class="panel-heading">
        <div class="panel-title">Employee Task: {{ $employee->full_name}} | Dept.: {{ $employee->department->title }} | Br.:{{ $employee->branch->title }} | Company: {{ $employee->company->title }}</div>
    </div>
    <div class="panel-body">

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-offset-6 col-sm-6 text-right">
                        <a href="javascript:openPredefinedTaskModal();" class="btn btn-info">Assign predefined task</a><a href="javascript:openNeedBasisTaskModal();" class="btn btn-success">Assign need basis task</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <!-- <th width="15%">Task Frequency</th> -->
                                <th width="9%">Type</th>
                                <th width="8%"> Achievement</th>
                                <th width="7%">Status</th>
                                <th width="17%">Assigned at</th>
                                <th width="17%">Deadline</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $i=1 @endphp
                        @forelse($todo_lists as $todo_list)
                            <tr>
                                <td><a href="{{ url('todo/'.$todo_list->id) }}" target="_blank">{{ $todo_list->title }}</a></td>
                                <!-- <td>{{ config('constants.frequency.'.$todo_list->frequency) }}</td> -->
                                <td>{{ config('constants.job_type.'.$todo_list->job_type) }}</td>
                                <td class="text-center">{{ $todo_list->achievement }}</td>
                                <td class="text-center">{{ ucfirst($todo_list->status) }}</td>
                                <td>{{ $todo_list->assigned_at }}</td>
                                <td>{{ Carbon::parse($todo_list->deadline)->format('d M, Y H:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" align="center">No Assigned Task Found!</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                @if($todo_lists->total() > 10)
                <div class="row">
                    <div class="col-sm-4">{{ $todo_lists->paginationSummery }}</div>
                    <div class="col-sm-8 text-right">
                        {!! $todo_lists->links() !!}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Predefined Task Modal -->
<div id="predefinedTaskModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Assign Predefined Task(s)</h4>
      </div>
      {!! Form::open(['url' => '', 'role' => 'form', 'id' => 'predefined-task-assign-form']) !!}
          <div class="modal-body">
                <div class="form-group">
                    <label for="task_id" class="control-label">Task {!! validation_error($errors->first('task_id'),'task_id') !!}</label>
                    {!! Form::select('task_id[]', $tasks, null, ['class'=>'form-control chosen-select', 'multiple']) !!}
                </div>
                <div class="form-group">
                    <label for="task_role_id" class="control-label">Task Role {!! validation_error($errors->first('task_role_id'),'task_role_id') !!}</label>
                    {!! Form::select('task_role_id', array_prepend($task_roles, 'Select a task role', ''), null, ['class'=>'form-control chosen-select']) !!}
                </div>   
          </div>
          <div class="modal-footer">
            {!! Form::hidden('employee_id', $employee->id) !!}
            <button type="button" class="btn btn-info btn-submit" onclick="assignPredefinedTask();">Save</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
      {!! Form::close() !!}
    </div>

  </div>
</div>

<!-- Need Basis Task Modal -->
<div id="needBasisTaskModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Assign Need Basis Task</h4>
      </div>
      {!! Form::open(['url' => '', 'role' => 'form', 'id' => 'need-basis-task-assign-form']) !!}
          <div class="modal-body">
                <div class="form-group">
                    <label for="parent_id" class="control-label">Parent Job </label>
                    {!! Form::select('parent_id', $parent_tasks, null, ['class'=>'form-control chosen-select']) !!}
                </div>
                <div class="form-group">
                    <label for="title" class="control-label">Title {!! validation_error($errors->first('title'),'title') !!}</label>
                    {!! Form::text('title', null, ['class'=>'form-control', 'placeholder' => 'Title']) !!}
                </div>
                <div class="form-group">
                    <label for="description" class="control-label">Description {!! validation_error($errors->first('description'),'description') !!}</label>
                    {!! Form::textarea('description', null, ['class'=>'form-control', 'placeholder' => 'Description', 'size' => '30x3']) !!}
                </div>
                {{--  
                <div class="form-group">
                    <label for="established_year" class="control-label">Deadline </label>
                    {!! Form::text('deadline', null, ['class'=>'form-control datepicker', 'placeholder' => 'yyyy-mm-dd']) !!}
                </div>
                <div class="form-group">
                    <label for="priority" class="control-label">Priority  {!! validation_error($errors->first('priority'),'priority') !!}</label>
                    {!! Form::select('priority', config('constants.priority'), null, ['class'=>'form-control chosen-select']) !!}
                </div>
                --}}
                <div class="form-group">
                    <label for="task_role_id" class="control-label">Task Role {!! validation_error($errors->first('task_role_id2'),'task_role_id2') !!}</label>
                    {!! Form::select('task_role_id2', array_prepend($task_roles, 'Select a task role', ''), null, ['class'=>'form-control chosen-select']) !!}
                </div>
          </div>
          <div class="modal-footer">
            {!! Form::hidden('employee_id', $employee->id) !!}
            <button type="button" class="btn btn-info btn-submit" onclick="assignNeedBasisTask();">Save</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
      {!! Form::close() !!}
    </div>

  </div>
</div>
@endsection

@section('custom-style')
{{-- Bootstrap Datepicker --}}
{!! Html::style($assets . '/plugins/datepicker/datepicker3.css') !!}
@endsection

@section('custom-script')
{{-- Bootstrap Datepicker --}}
{!! Html::script($assets . '/plugins/datepicker/bootstrap-datepicker.js') !!}
<script>
{{-- open predefined task modal --}}
function openPredefinedTaskModal()
{
    $('#predefinedTaskModal').modal();
}

function assignPredefinedTask() {

    $(".validation-error").text('*');
    $("#ajaxloader").removeClass('hide');
    $.ajax({
        url: "{{ url('employee-tasks/assign-predefined-task') }}",
        type: "POST",
        data: $("#predefined-task-assign-form").serialize(),
        success: function(response){
            if(response.status === 400){
                //validation error
                $.each(response.error, function(index, value) {
                    $("#ve-"+index).html('['+value+']');
                });
            }else{
                toastMsg(response.message, response.type);
                if(response.status === 200){
                    setTimeout(function(){
                        location.reload();

                    }, 1500); // delay 1.5s
                }
            }
            $("#ajaxloader").addClass('hide');
        },
        error:function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + ' ' + thrownError);
        }
    });
}

$("#openPredefinedTaskModal").on('hide.bs.modal', function () {
    
    $(".validation-error").text('*');
    $('select[name^=task_id]').val('').trigger('chosen:updated');
});

{{-- open need basis task modal --}}
function openNeedBasisTaskModal()
{
    $('#needBasisTaskModal').modal();
}

function assignNeedBasisTask() {

    $(".validation-error").text('*');
    $("#ajaxloader").removeClass('hide');
    $.ajax({
        url: "{{ url('employee-tasks/assign-need-basis-task') }}",
        type: "POST",
        data: $("#need-basis-task-assign-form").serialize(),
        success: function(response){
            if(response.status === 400){
                //validation error
                $.each(response.error, function(index, value) {
                    $("#ve-"+index).html('['+value+']');
                });
            }else{
                toastMsg(response.message, response.type);
                if(response.status === 200){
                    setTimeout(function(){
                        location.reload();

                    }, 1500); // delay 1.5s
                }
            }
            $("#ajaxloader").addClass('hide');
        },
        error:function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + ' ' + thrownError);
        }
    });
}

$("#openPredefinedTaskModal").on('hide.bs.modal', function () {
    
    $(".validation-error").text('*');
    $('select[name^=task_id]').val('').trigger('chosen:updated');
});

(function() {
    {{-- Initialize Datepicker --}}
    $('.datepicker').datepicker({
        autoclose:true,
        format:'yyyy-mm-dd',
    });
})();
</script>
@endsection
