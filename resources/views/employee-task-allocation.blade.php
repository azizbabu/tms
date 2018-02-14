@extends('layouts.master')

@section('title') Task Allocation of Employee @endsection

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">Task Allocation</div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    {!! Form::label('employee_id','Employee') !!}
                    {!! Form::select('employee_id',$employees, !empty($employee) ? $employee->id : null,['class'=>'form-control chosen-select', 'onchange' => 'getEmployee();']) !!}
                </div>
                @if(!empty($employee))
                    <div class="details-info">
                        <strong>Depertment: </strong> {{ $employee->department ? $employee->department->title : 'N/A' }} <br>
                        <strong>Designation: </strong> {{ $employee->designation ? $employee->designation->title : 'N/A' }} <br>
                    </div>
                @endif
            </div>
        </div>

        @if(!empty($employee))
        <div class="row margin-top-20">
            <div class="col-sm-12">
                {!! Form::open(['url' => 'employee-task-allocation/'.$employee->id, 'role' => 'form', 'id' => 'task-assign-form']) !!}
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Task</th>
                                <th width="10%">Target</th>
                                <th width="13%">Unit</th>
                                <th>Frequency</th>
                                <th>Task Role</th>
                                <th>Report To</th>
                                <th width="18%">Deadline</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="task-table-body">
                            <tr id="task-row-1">
                                <td>
                                    {!! Form::select('task_id[]',$tasks, null,['class'=>'form-control']) !!}
                                </td>
                                <td>
                                    {!! Form::number('target[]',null,['class'=>'form-control','min'=>0]) !!}
                                </td>
                                <td>
                                    {!! Form::select('target_unit[]',config('constants.target_unit'), null,['class'=>'form-control']) !!}
                                </td>
                                <td>
                                    {!! Form::select('frequency_id[]',$frequencies, null,['class'=>'form-control']) !!}
                                </td>
                                <td>
                                    {!! Form::select('task_role_id[]',$task_roles, null,['class'=>'form-control']) !!}
                                </td>
                                <td>
                                    {!! Form::select('report_to[]',$report_to_employees, null,['class'=>'form-control']) !!}
                                </td>
                                <td>  
                                    {!! Form::text('deadline_date[]',date('Y-m-d'),['class'=>'deadline-date']) !!}
                                    {{--  
                                    <div class='input-group date datetimepicker'>
                                        {!! Form::text('deadline[]',date('Y-m-d H:i'),['class'=>'form-control']) !!}
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                    --}}
                                    {!! Form::text('deadline_time[]',date('h:i A'),['class'=>'deadline-time', 'data-date-format' => 'LT']) !!}
                                </td>
                                <td class="vertical-middle"><button class="btn btn-danger btn-xs btn-remove-row btn-remove-row1 hide"><i class="fa fa-times" aria-hidden="true"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <button type="button" class="btn btn-primary btn-xs btn-add"> <i class="fa fa-plus-circle" aria-hidden="true"></i> Add New</button>

                        <button type="button" class="btn btn-info pull-right" onclick="assignTasks();"> <i class="fa fa-save" aria-hidden="true"></i> Submit</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('custom-style')
{{-- Bootstrap Datepicker --}}
{!! Html::style($assets . '/plugins/datepicker/datepicker3.css') !!}
{{-- Bootstrap Datetimepicker --}}
{!! Html::style($assets . '/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') !!}
{{-- Bootstrap Timepicker --}}
{!! Html::style($assets . '/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css') !!}
@endsection

@section('custom-script')
{{-- Bootstrap Datepicker --}}
{!! Html::script($assets . '/plugins/datepicker/bootstrap-datepicker.js') !!}
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script> -->
{{-- Bootstrap Datetimepicker --}}
{!! Html::script($assets . '/plugins/bootstrap-datetimepicker/js/moment-with-locales.js') !!}
{{-- Bootstrap Datetimepicker --}}
{!! Html::script($assets . '/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') !!}
{{-- Bootstrap Timepicker --}}
{!! Html::script($assets . '/plugins/bootstrap-timepicker/bootstrap-timepicker.min.js') !!}
<script>
function getEmployee()
{
    var employeeId = $('#employee_id').val();
    window.location = '{{ url('employee-task-allocation') }}'+(employeeId ? '/'+employeeId:'');
}

function assignTasks()
{   
    $('#ajaxloader').removeClass('hide');
    $.ajax({
        url:'{{ url('employee-task-allocation'.(!empty($employee) ? '/'.$employee->id : null)) }}',
        method:'POST',
        data:$('#task-assign-form').serialize(),
        dataType:'JSON',
        success:function(response) {
            toastMsg(response.message, response.type);
            if(response.type == 'success') {
                setTimeout(function(){
                    location.reload();
                }, 1500); // delay 1.5s
            }
        },
        complete:function() {
            $('#ajaxloader').addClass('hide');
        },
        error:function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + ' ' + thrownError);
        }
    });
}   

(function() {
    {{-- Initialize Datepicker --}}
    $('.deadline-date').datepicker({
        autoclose:true,
        format:'yyyy-mm-dd',
    });

    $('.deadline-time').timepicker({
        minuteStep: 5,
        showInputs: false,
        disableFocus: true
    });
    
    @if(!empty($employee))
    var taskRow = 1;
    $('.btn-add').on('click', function() {
        taskRow++;
        if(taskRow >= 2) {
            $('.btn-remove-row').removeClass('hide');
        }
        $('<tr id="task-row-'+taskRow+'"><td>{!! Form::select('task_id[]',$tasks, null,['class'=>'form-control']) !!}</td><td>{!! Form::number('target[]',null,['class'=>'form-control','min'=>0]) !!}</td><td>{!! Form::select('target_unit[]',config('constants.target_unit'), null,['class'=>'form-control']) !!}</td><td>{!! Form::select('frequency_id[]',$frequencies, null,['class'=>'form-control']) !!}</td><td>{!! Form::select('task_role_id[]',$task_roles, null,['class'=>'form-control']) !!}</td><td>{!! Form::select('report_to[]',$report_to_employees, null,['class'=>'form-control']) !!}</td><td><div class="input-group date datetimepicker">{!! Form::text('deadline_date[]',date('Y-m-d'),['class'=>'deadline-date']) !!} {!! Form::text('deadline_time[]',date('h:i A'),['class'=>'deadline-time datetimepicker', 'data-date-format' => 'LT']) !!}</div></td><td class="vertical-middle"><button class="btn btn-danger btn-xs btn-remove-row"><i class="fa fa-times" aria-hidden="true"></i></button></td></tr>').appendTo('#task-table-body');

        $('.deadline-date').datepicker({
            autoclose:true,
            format:'yyyy-mm-dd',
        });

        $('.deadline-time').timepicker({
            minuteStep: 5,
            showInputs: false,
            disableFocus: true
        });
    });

    $('#task-table-body').delegate('.btn-remove-row','click', function() {
        
        $(this).closest('tr').remove();
        taskRow--;
        if(taskRow == 1) {
            $('.btn-remove-row').addClass('hide');

            return;
        }
    });

    @endif
})();

</script>
@endsection




