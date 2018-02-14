@extends('layouts.master')

@section('title') List of Department @endsection 

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default margin-top-20">
			<div class="panel-heading clearfix">
				List of Department				
				<a class="btn btn-danger btn-xs pull-right" href="javascript:openDepartmentModal();"><i class="fa fa-plus-circle"></i> Add New</a>
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
				            <th>Parent</th>
				            <th width="12%">Created at</th>
				            <th width="10%">Actions</th>
				        </tr>
				    </thead>
				    <tbody>
				    <?php 
				    /*
				    @forelse($departments as $department)
				        <tr>
				            <td>{{ $department->title }}</td>
				            @if(isSuperAdmin())
				            	<td>{{ $department->company ? $department->company->title : 'N/A' }}</td>
				            @endif
				            <td>{{ $department->branch ? $department->branch->title : 'N/A' }}</td>
				            <td>{{ $department->parent ? $department->parent->title : 'N/A' }}</td>
				            <td>{{ $department->created_at }}</td>

				            <td class="action-column">
				                <!-- show the users (uses the show method found at GET /users/{id} -->
				                <a class="btn btn-xs btn-success" href="javascript:showDepartmentInfo({{ $department->id }});" title="View Company"><i class="fa fa-eye"></i></a>

				                <!-- edit this users (uses the edit method found at GET /users/{id}/edit -->
				                <a class="btn btn-xs btn-default" href="javascript:openDepartmentModal({{ $department->id}})" title="Edit Employee"><i class="fa fa-pencil"></i></a>
				                
				                <!-- delete the users (uses the destroy method DESTROY /users/{id} -->
								

								{{-- Delete --}}
								<a href="#" data-id="{{$department->id}}" data-action="{{ url('departments/delete') }}" data-message="Are you sure, You want to delete this department?" class="btn btn-danger btn-xs alert-dialog" title="Delete Department"><i class="fa fa-trash white"></i></a>
				            </td>
				        </tr>

				        {!! \App\Department::getDepartmentList($department->children) !!} 
				    @empty
				    	<tr>
				        	<td colspan="5" align="center">No Record Found!</td>
				        </tr>
				    @endforelse
				    */
				     ?> 
					{!! \App\Department::getDepartmentCollapsibleList($departments) !!}
				    </tbody>
				</table>
			</div><!-- end panel-body -->

			@if($departments->total() > 10)
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-4">
						{{ $departments->paginationSummery }}
					</div>
					<div class="col-sm-8 text-right">
						{!! $departments->links() !!}
					</div>
				</div>
			</div>
			@endif
		</div><!-- end panel panel-default -->
	</div>
</div>

<!-- Modal -->
<div id="departmentModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create Department</h4>
      </div>
      {!! Form::open(['url' => '', 'role' => 'form', 'id' => 'department-form']) !!}
      <div class="modal-body">
        	<div class="form-group">
            	<label for="title" class="control-label">Title {!! validation_error($errors->first('title'),'title') !!}</label>
            	{!! Form::text('title', null, ['class'=>'form-control', 'placeholder' => 'Title']) !!}
	        </div>
	        @if(isSuperAdmin())
	        <div class="form-group">
            	<label for="company_id" class="control-label">Company {!! validation_error($errors->first('branch_id'),'branch_id') !!}</label>
            	{!! Form::select('company_id', $companies, null, ['class'=>'form-control chosen-select', 'onchange' => 'loadBranches();']) !!}
	        </div>
	        @endif
	        <div class="form-group">
            	<label for="branch_id" class="control-label">Branch {!! validation_error($errors->first('branch_id'),'branch_id') !!}</label>
            	{!! Form::select('branch_id', [], null, ['class'=>'form-control chosen-select', 'disabled'=>'disabled', 'onchange' => 'loadDepartments();']) !!}
	        </div>
	        <div class="form-group">
            	<label for="parent_id" class="control-label">Parent Department </label>
            	{!! Form::select('parent_id', [], null, ['class'=>'form-control chosen-select', 'disabled'=>'disabled']) !!}
	        </div>
	        <div class="form-group">
	            <label for="description" class="control-label">Description </label>
	            {!! Form::textarea('description', null, ['class'=>'form-control', 'placeholder' => 'Description', 'size' => '30x3']) !!}
	        </div> 
	        {{--  
	        <div class="form-group">
            	<label for="priority" class="control-label">Priority {!! validation_error($errors->first('priority'),'priority') !!}</label>
            	{!! Form::number('priority', null, ['class'=>'form-control', 'placeholder' => 'Priority', 'min' => 1, 'max' => 100]) !!}
	        </div> 
	        --}}   
      </div>
      <div class="modal-footer">
      	{!! Form::hidden('department_id', '') !!}
      	<button type="button" class="btn btn-info btn-submit" onclick="save();">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      {!! Form::close() !!}
    </div>

  </div>
</div>


<!-- Display Modal -->
<div id="departmentDisplayModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Department Details</h4>
      </div>
      <div class="modal-body">
      	<h4 id="department-title"></h4>
      	<div class="details-info">
      		<p id="department-description"></p>
      		<strong>Parent:</strong> <span id="department-parent"></span> <br>
      		<strong>Company:</strong> <span id="department-company"></span> <br>
      		<strong>Branch:</strong> <span id="department-branch"></span> <br>
      		<!-- <strong>Priority:</strong> <span id="department-priority"></span> <br> -->
      		<strong>Created at:</strong> <span id="department-created-date"></span>
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

@section('custom-script')
<script>
function openDepartmentModal(id=null)
{
	$('#departmentModal .modal-title').html('Create Department');
	$(".validation-error").text('*');
    $("#department-form").trigger('reset');
    $('input[name=department_id]').val('');
    $('select[name=branch_id]').prop('disabled', true);
    $('select[name=parent_id]').prop('disabled', true);
    $('select').val('').trigger('chosen:updated');
    $('.btn-submit').text('Save');

	if(id && typeof id == 'number') {
		$("#ajaxloader").removeClass('hide');
		$('.btn-submit').text('Update');
		$.ajax({
			url:'{{ url('departments') }}/'+id,
			dataType:'JSON',
			success:function(response) {
				$('#departmentModal .modal-title').html('Edit Department: '+response.title);
				$('input[name=title').val(response.title);
				$('select[name=company_id').val(response.company_id).trigger('chosen:updated');
				
				loadBranches(id, response.company_id);
				loadDepartments(id, response.branch_id);
				$('textarea[name=description').val(response.description);
				$('input[name=priority').val(response.priority);
				$('input[name=department_id]').val(response.id);
				$("#ajaxloader").addClass('hide');
			},
			complete:function() {
				$('#departmentModal').modal();
			},
			error:function(xhr, ajaxOptions, thrownError) {
				alert(xhr. status + ' ' +thrownError);
			}
		});
	}else {
		@if(isAdmin())
			loadBranches(null, {{ Auth::user()->company->id }})
		@endif
		$('#departmentModal').modal();
	}
}

function save() {

	$(".validation-error").text('*');
	$("#ajaxloader").removeClass('hide');
	$.ajax({
		url: "{{ url('departments') }}",
		type: "POST",
		data: $("#department-form").serialize(),
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

function showDepartmentInfo(id)
{
	$("#ajaxloader").removeClass('hide');
	$.ajax({
		url:'{{ url('departments') }}/'+id,
		dataType:'JSON',
		success:function(data) {
			$('#departmentDisplayModal #department-title').html(data.title);
			$('#departmentDisplayModal #department-description').html('<strong>Description: </strong>'+ data.description);
			$('#departmentDisplayModal #department-parent').html(data.department_parent);
			$('#departmentDisplayModal #department-company').html(data.company_title);
			$('#departmentDisplayModal #department-branch').html(data.branch_title);
			// $('#departmentDisplayModal #department-priority').html(data.priority);
			$('#departmentDisplayModal #department-created-date').html(data.created_date);
		},
		complete:function() {
			$("#ajaxloader").addClass('hide');
			$('#departmentDisplayModal').modal();
		},
		error:function(xhr, ajaxOptions, thrownError) {
			alert(xhr.status + ' ' + thrownError);
		}
	});
}

function loadBranches(departmentId=null, companyId = null)
{
	$('select[name=parent_id]').html('<option>Parent</option>').prop('disabled', true).trigger("chosen:updated");
	if(!companyId)  {
		var companyId = $('select[name=company_id]').val();
	}
    if(companyId) {
        $('#ajaxloader').removeClass('hide');
        $.ajax({
            url:'{{ url('departments/branches') }}/'+companyId+(departmentId ? '/'+departmentId : ''),
            success:function(data) {
                $('select[name=branch_id]').html(data).prop('disabled', false).trigger("chosen:updated");
            },
            complete:function() {
                $('#ajaxloader').addClass('hide');
            },
            error:function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + ' ' + thrownError);
            }
        });
    }else {
        $('select[name=branch_id]').html('<option>Select a Branch</option>').prop('disabled', true).trigger("chosen:updated");
    }
}

function loadDepartments(departmentId=null, branchId=null)
{
	if(!branchId) {
		var branchId = $('select[name=branch_id]').val();
	}
    if(branchId) {
        $('#ajaxloader').removeClass('hide');
        $.ajax({
            url:'{{ url('departments/departments') }}/'+branchId+(departmentId ? '/'+departmentId : ''),
            success:function(data) {
                $('select[name=parent_id]').html(data).prop('disabled', false).trigger("chosen:updated");
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
  // $(".collapse").on("hide.bs.collapse", function(){
  // 	console.log($(this).attr('id'));
  //   $(this).prev().find(".btn-collapse").html('<i class="fa fa-plus-circle" aria-hidden="true"></i>');
  // });
  // $(".collapse").on("show.bs.collapse", function(){
  //   $(this).prev().find(".btn-collapse").html('<i class="fa fa-minus-circle" aria-hidden="true"></i>');
  // });

  $('.btn-collapse').on('click', function() {
  	var icon = $(this).find('i');
  	if(icon.hasClass('fa-plus-circle')) {
  		icon.removeClass('fa-plus-circle').addClass('fa-minus-circle');
  	}else {
  		icon.removeClass('fa-minus-circle').addClass('fa-plus-circle');
  	}
  });
})();
</script>
@endsection

