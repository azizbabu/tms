@extends('layouts.master')

@section('title') List of Task Roles @endsection 

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default margin-top-20">
			<div class="panel-heading clearfix">
				List of Task Roles
				<a class="btn btn-danger btn-xs pull-right" href="javascript:openTaskRolesModal();"><i class="fa fa-plus-circle"></i> Add New</a>
			</div>

			<div class="panel-body">
				<table class="table table-striped table-bordered">
				    <thead>
				        <tr>
				        	@if(isSuperAdmin())
				        		<th>Company</th>
				        	@endif
				        	<th>Branch</th>
					        <th>Department</th>
				            <th>Task Role Name</th>
				            <th>Task Role Weight</th>
				            <th>Created at</th>
				            <th width="10%">Actions</th>
				        </tr>
				    </thead>
				    <tbody>
				    @php $i=1 @endphp
				    @forelse($task_roles as $task_role)
				        <tr>
				            @if(isSuperAdmin())
				            	<td>{{ $task_role->company ? $task_role->company->title : 'N/A' }}</td>
				            @endif
				            <td>{{ $task_role->branch ? $task_role->branch->title : 'N/A' }}</td>
					        <td>{{ $task_role->department ? $task_role->department->title : 'N/A' }}</td>
				            <td>{{ $task_role->role_name }}</td>
				            <td>{{ $task_role->role_weight }}</td>
				            <td>{{ $task_role->created_at }}</td>

				            <td class="action-column">
				                <!-- show the users (uses the show method found at GET /users/{id} -->
				                <a class="btn btn-xs btn-success" href="javascript:showTaskRoleInfo({{ $task_role->id }});" title="View Task Role"><i class="fa fa-eye"></i></a>

				                <!-- edit this users (uses the edit method found at GET /users/{id}/edit -->
				                <a class="btn btn-xs btn-default" href="javascript:openTaskRolesModal({{ $task_role->id}})" title="Edit Task Role"><i class="fa fa-pencil"></i></a>
				                
				                <!-- delete the users (uses the destroy method DESTROY /users/{id} -->
								

								{{-- Delete --}}
								<a href="#" data-id="{{$task_role->id}}" data-action="{{ url('task-roles/delete') }}" data-message="Are you sure, You want to delete this task role?" class="btn btn-danger btn-xs alert-dialog" title="Delete task role"><i class="fa fa-trash white"></i></a>
				            </td>
				        </tr>
				    @empty
				    	<tr>
				        	<td colspan="6" align="center">No Record Found!</td>
				        </tr>
				    @endforelse
				    </tbody>
				</table>
			</div><!-- end panel-body -->

			@if($task_roles->total() > 10)
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-4">
						{{ $task_roles->paginationSummery }}
					</div>
					<div class="col-sm-8 text-right">
						{!! $task_roles->links() !!}
					</div>
				</div>
			</div>
			@endif
		</div><!-- end panel panel-default -->
	</div>
</div>

<!-- Modal -->
<div id="taskRoleFormModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create Task Role</h4>
      </div>
      {!! Form::open(['url' => '', 'role' => 'form', 'id' => 'task-role-form']) !!}
      <div class="modal-body">
        	<div class="form-group">
            	<label for="role_name" class="control-label">Role Name {!! validation_error($errors->first('role_name'),'role_name') !!}</label>
            	{!! Form::text('role_name', null, ['class'=>'form-control', 'placeholder' => 'Role Name']) !!}
	        </div>
	        @if(isSuperAdmin())
			<div class="form-group">
            	<label for="company_id" class="control-label">Company {!! validation_error($errors->first('company_id'),'company_id') !!}</label>
            	{!! Form::select('company_id', $companies, null, ['class'=>'form-control chosen-select','onchange' => 'loadBranches();']) !!}
	        </div>
	        @endif
	        @if(isSuperAdminOrAdmin())
	        <div class="form-group">
	            <label for="branch_id" class="control-label">Branch {!! validation_error($errors->first('branch_id'),'branch_id') !!}</label>
	            {!! Form::select('branch_id', [], null, ['class'=>'form-control chosen-select', 'placeholder' => 'Select a Branch', 'onchange'=>'loadDepartments();', 'disabled']) !!}
	        </div>
	        <div class="form-group">
	            <label for="department_id" class="control-label">Department {!! validation_error($errors->first('department_id'),'department_id') !!}</label>
	            {!! Form::select('department_id', [], null, ['class'=>'form-control chosen-select', 'placeholder' => 'Select a Department', 'disabled']) !!}
	        </div>
	        @endif
	        <div class="form-group">
	            <label for="role_weight" class="control-label">Role Weight {!! validation_error($errors->first('role_weight'),'role_weight') !!}</label>
	            <input id="role_weight" type="range" name="role_weight" min="1" max="{{ getOption('task_weight_scale', Auth::user()->company_id) ? getOption('task_weight_scale', Auth::user()->company_id) : 100 }}" value="10">
	        </div>     
      </div>
      <div class="modal-footer">
      	{!! Form::hidden('task_role_id', '') !!}
      	<button type="button" class="btn btn-info btn-submit" onclick="save();">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      {!! Form::close() !!}
    </div>

  </div>
</div>

<!-- Display Modal -->
<div id="taskRolesModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Task Role Details</h4>
      </div>
      <div class="modal-body">
      	<h4 id="role-name"></h4>
      	<div class="details-info">
      		<strong>Role Weight:</strong> <span id="role-weight"></span> <br>
      		<strong>Created at:</strong> <span id="task-role-created-at"></span>
      	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      {!! Form::close() !!}
    </div>

  </div>
</div>
@endsection

@section('custom-style')
{{-- Range Slider --}}
{!! Html::style($assets . '/plugins/rangeslider/rangeslider.css') !!}
@endsection

@section('custom-script')
{{-- Range Slider --}}
{!! Html::script($assets . '/plugins/rangeslider/rangeslider.min.js') !!}
<script>
function openTaskRolesModal(id=null)
{
	$('#taskRoleFormModal .modal-title').html('Create Task Role');
    $(".validation-error").text('*');
    $("#task-role-form").trigger('reset');
    $('select[name=company_id]').val('').trigger("chosen:updated");
    $('select[name=branch_id]').val('').trigger("chosen:updated");
    $('select[name=department_id]').val('').trigger("chosen:updated");
    $('input[name=role_weight').val(1).change();
    $('input[name=task_role_id]').val('');
    $('.btn-submit').text('Save');

	if(id && typeof id == 'number') {
		$("#ajaxloader").removeClass('hide');
		$('.btn-submit').text('Update');
		$.ajax({
			url:'{{ url('task-roles') }}/'+id,
			dataType:'JSON',
			success:function(response) {
				$('#taskRoleFormModal .modal-title').html('Edit Task Role: '+response.role_name);
				$('select[name=company_id]').val(response.company_id).trigger("chosen:updated");
				loadBranches(id, response.company_id);
        		loadDepartments(id, response.branch_id);
				$('input[name=role_name').val(response.role_name);
				$('input[name=role_weight').val(response.role_weight).change();
				$('input[name=task_role_id]').val(response.id);
				$("#ajaxloader").addClass('hide');
			},
			complete:function() {
				$('#taskRoleFormModal').modal();
			},
			error:function(xhr, ajaxOptions, thrownError) {
				alert(xhr. status + ' ' +thrownError);
			}
		});
	}else {
		$('input[type="range"]').rangeslider({
             polyfill : false,
            onInit : function() {
                this.output = $( '<div class="range-output" />' ).insertAfter( this.$range ).html( this.$element.val() );
            },
            onSlide : function( position, value ) {
                this.output.html( value );
            }
        });
		$('#taskRoleFormModal').modal();
	}
}

function save() {

	$(".validation-error").text('*');
	$("#ajaxloader").removeClass('hide');
	$.ajax({
		url: "{{ url('task-roles') }}",
		type: "POST",
		data: $("#task-role-form").serialize(),
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

$("#taskRoleFormModal").on('hide.bs.modal', function () {
	
});

function showTaskRoleInfo(id)
{
	$("#ajaxloader").removeClass('hide');
	$.ajax({
		url:'{{ url('task-roles') }}/'+id,
		dataType:'JSON',
		success:function(data) {
			$('#taskRolesModal #role-name').html(data.role_name);
			$('#taskRolesModal #role-weight').html(data.role_weight);
			$('#taskRolesModal #task-role-created-at').html(data.created_at);
		},
		complete:function() {
			$("#ajaxloader").addClass('hide');
			$('#taskRolesModal').modal();
		},
		error:function(xhr, ajaxOptions, thrownError) {
			alert(xhr.status + ' ' + thrownError);
		}
	});
}

function loadBranches(taskRoleId=null)
{
    $('select[name=department_id]').html('<option>Select a department</option>').prop('disabled', true).trigger("chosen:updated");
    @if(isSuperAdmin())
    var companyId = $('select[name=company_id]').val();
    @else
    var companyId = "{{ \Auth::user()->company_id }}";
    @endif
    if(companyId) {
        $('#ajaxloader').removeClass('hide');
        $.ajax({
            url:"{{ url('task-roles/branches') }}/"+companyId+(taskRoleId ? '/'+taskRoleId : ''),
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

function loadDepartments(taskRoleId=null, branchId=null)
{
    if(!branchId) {
        branchId = $('select[name=branch_id]').val();
    }
    
    if(branchId) {
        $('#ajaxloader').removeClass('hide');
        $.ajax({
            url:"{{ url('task-roles/departments') }}/"+branchId+(taskRoleId ? '/'+taskRoleId : ''),
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
        $('select[name=department_id]').html('<option>Select a department</option>').prop('disabled', true).trigger("chosen:updated");
    }
}

(function() {
    $('input[type="range"]').rangeslider({
         polyfill : false,
        onInit : function() {
            this.output = $( '<div class="range-output" />' ).insertAfter( this.$range ).html( this.$element.val() );
        },
        onSlide : function( position, value ) {
            this.output.html( value );
        }
    });

    @if(!empty($task_role))
        var taskRoleId = {{ $task_role->id }};
    @else
        var taskRoleId = null;
    @endif
    
    @if(old('branch_id'))
        branchId = {{ old('branch_id') }};
    @elseif(!empty($task_role))
        branchId = {{ $task_role->branch_id }};
    @elseif(isDepartmentAdmin())
        branchId = {{ Auth::user()->branch_id }};
    @else
        branchId = null;
    @endif

    @if(isSuperAdmin())
    var companyId = $('select[name=company_id]').val();
    @else
    var companyId = "{{ Auth::user()->company_id }}";
    @endif
    if(companyId) {
        loadBranches(taskRoleId);
        loadDepartments(taskRoleId, branchId);
    }
})();
</script>
@endsection

