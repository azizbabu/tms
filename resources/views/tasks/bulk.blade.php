@extends('layouts.master')

@section('title') Bulk Task Create @endsection 

@section('content')

{!! Form::open(array('url' => 'tasks-bulk-save')) !!}
	<div class="panel panel-default margin-top-20">
		<div class="panel-heading">
			<div class="panel-title">Bulk Task Creation </div>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-6">					
					
					@if(isSuperAdmin())
					<div class="form-group">
						<label for="company_id" class="control-label">Company {!! validation_error($errors->first('company_id'),'company_id') !!}</label>
						{!! Form::select('company_id', $companies, null, ['class'=>'form-control chosen-select', 'onchange' => 'loadBranches();']) !!}
					</div>
					@endif

					@if(isSuperAdmin() || isAdmin())
					<div class="form-group">
						<label for="branch_id" class="control-label">Branch {!! validation_error($errors->first('branch_id'),'branch_id') !!}</label>
						{!! Form::select('branch_id', [], null, ['class'=>'form-control chosen-select', 'placeholder' => 'Select a Branch', 'onchange'=>'loadDepartments();', 'disabled']) !!}
					</div>
					<div class="form-group">
						<label for="department_id" class="control-label">Department {!! validation_error($errors->first('department_id'),'department_id') !!}</label>
						{!! Form::select('department_id', [], null, ['class'=>'form-control chosen-select', 'placeholder' => 'Select a Department','onchange' => 'loadTasks();', 'disabled']) !!}
					</div>
					@endif

					<div class="form-group">
						<label for="parent_id" class="control-label">Parent Task </label>
						{!! Form::select('parent_id', [], null, ['class'=>'form-control chosen-select', 'disabled' => 'disabled']) !!}
					</div>
					<div class="form-group">
						<label for="job_type" class="control-label">Task Type {!! validation_error($errors->first('job_type'),'job_type') !!}</label>
						{!! Form::select('job_type', array_prepend(config('constants.job_type'), 'Select a task type', ''), null, ['class'=>'form-control chosen-select']) !!}
					</div>
				</div>

				<div class="col-sm-6">
					<div class="form-group">
						<label for="title" class="control-label">Bulk Task Titles {!! validation_error($errors->first('title'),'title') !!}</label>
						{!! Form::textarea('title', null, ['class'=>'form-control', 'placeholder' => 'Title', 'size' => '30x3']) !!}
					</div>
					<div class="form-group">
						<label for="description" class="control-label">Description {!! validation_error($errors->first('description'),'description') !!}</label>
						{!! Form::textarea('description', null, ['class'=>'form-control', 'placeholder' => 'Description', 'size' => '30x3']) !!}
					</div>
				</div>
			</div>
		</div>
		<div class="panel-footer">
			<button class="btn btn-info"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
			<a href="{{url('tasks')}}" class="btn btn-default"><i class="fa fa-long-arrow-left"></i> Back to task list</a>
		</div>
	</div>		
{!! Form::close() !!}

@endsection

@section('custom-style')

@endsection

@section('custom-script')

<script>
function loadBranches(taskId=null)
{
    $('select[name=department_id]').html('<option value="">Select a department</option>').prop('disabled', true).trigger("chosen:updated");
    $('select[name=parent_id]').html('<option value="">Parent</option>').prop('disabled', true).trigger("chosen:updated");
    
    @if(isSuperAdmin())
        var companyId = $('select[name=company_id]').val();
    @else
        var companyId = "{{ Auth::user()->company_id }}";
    @endif

    if(companyId) {
        $('#ajaxloader').removeClass('hide');
        $.ajax({
            url:"{{ url('tasks/branches') }}/"+companyId+(taskId ? '/'+taskId : ''),
            dataType:'JSON',
            success:function(data) {
                $('select[name=branch_id]').html(data.branch_options).prop('disabled', false).trigger("chosen:updated");
            },
            complete:function() {
                $('#ajaxloader').addClass('hide');
            },
            error:function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + ' ' + thrownError);
            }
        });
    }else {
        $('select[name=branch_id]').html('<option>Select a branch</option>').prop('disabled', true).trigger("chosen:updated");
    }
}

function loadDepartments(taskId=null, branchId=null)
{
    if(!branchId) {
        branchId = $('select[name=branch_id]').val();
    }
    
    if(branchId) {
        $('#ajaxloader').removeClass('hide');
        $.ajax({
            url:"{{ url('tasks/departments') }}/"+branchId+(taskId ? '/'+taskId : ''),
            dataType:'JSON',
            success:function(data) {
                $('select[name=department_id]').html(data.department_options).prop('disabled', false).trigger("chosen:updated");
            },
            complete:function() {
                $('#ajaxloader').addClass('hide');
            },
            error:function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + ' ' + thrownError);
            }
        });
    }else {
        $('select[name=department_id]').html('<option value="">Select a department</option>').prop('disabled', true).trigger("chosen:updated");
    }
}

function loadTasks(taskId=null, departmentId=null)
{
    if(!departmentId) {
        departmentId = $('select[name=department_id]').val();
    }
    
    if(departmentId) {
        $('#ajaxloader').removeClass('hide');
        $.ajax({
            url:"{{ url('tasks/parent-tasks') }}/"+departmentId+(taskId ? '/'+taskId : ''),
            dataType:'JSON',
            success:function(data) {
                $('select[name=parent_id]').html(data.parent_task_options).prop('disabled', false).trigger("chosen:updated");
            },
            complete:function() {
                $('#ajaxloader').addClass('hide');
            },
            error:function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + ' ' + thrownError);
            }
        });
    }else {
        $('select[name=parent_id]').html('<option>Parent</option>').prop('disabled', true).trigger("chosen:updated");
    }
}

(function() {
    
    @if(!empty($task))
        var taskId = {{ $task->id }};
    @else
        var taskId = null;
    @endif

    @if(old('branch_id'))
        branchId = {{ old('branch_id') }};
    @elseif(!empty($task))
        branchId = {{ $task->branch_id }};
    @elseif(isDepartmentAdmin())
        branchId = {{ Auth::user()->branch_id }};
    @else
        branchId = null;
    @endif

    @if(!empty($task))
        departmentId = {{ $task->department_id }};
    @elseif(isDepartmentAdmin())
        departmentId = {{ Auth::user()->employee->department_id }};
    @else
        departmentId = null;
    @endif

    @if(isSuperAdmin())
        var companyId = $('select[name=company_id]').val();
    @else
        var companyId = {{ Auth::user()->company_id }};
    @endif

    if(companyId) {
        loadBranches(taskId);
        loadDepartments(taskId, branchId);
        loadTasks(taskId, departmentId);
    }
})();
</script>
@endsection


