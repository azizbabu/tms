@extends('layouts.master')

@section('title') List of Designation @endsection 

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default margin-top-20">
			<div class="panel-heading clearfix">
				List of Designation
				<a class="btn btn-danger btn-xs pull-right" href="javascript:openDesignationModal();"><i class="fa fa-plus-circle"></i> Add New</a>
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
				            <th>Created at</th>
				            <th>Actions</th>
				        </tr>
				    </thead>
				    <tbody>
				    <?php 
				    /*
				    @forelse($designations as $designation)
				        <tr>
				            <td>{{ $designation->title }}</td>
				            @if(isSuperAdmin())
				            	<td>{{ $designation->company ? $designation->company->title : 'N/A' }}</td>
				            @endif
				            <td>{{ $designation->branch ? $designation->branch->title : 'N/A' }}</td>
				            <td>{{ $designation->parent ? $designation->parent->title : 'N/A' }}</td>
				            <td>{{ $designation->created_at }}</td>

				            <td class="action-column">
				                <!-- show the users (uses the show method found at GET /users/{id} -->
				                <a class="btn btn-xs btn-success" href="javascript:showdesignationInfo({{ $designation->id }});" title="View Company"><i class="fa fa-eye"></i></a>

				                <!-- edit this users (uses the edit method found at GET /users/{id}/edit -->
				                <a class="btn btn-xs btn-default" href="javascript:openDesignationModal({{ $designation->id}})" title="Edit Employee"><i class="fa fa-pencil"></i></a>
				                
				                <!-- delete the users (uses the destroy method DESTROY /users/{id} -->
								

								{{-- Delete --}}
								<a href="#" data-id="{{$designation->id}}" data-action="{{ url('designations/delete') }}" data-message="Are you sure, You want to delete this designation?" class="btn btn-danger btn-xs alert-dialog" title="Delete designation"><i class="fa fa-trash white"></i></a>
				            </td>
				        </tr>

				        {!! \App\Designation::getDesignationList($designation->children) !!} 
				    @empty
				    	<tr>
				        	<td colspan="5" align="center">No Record Found!</td>
				        </tr>
				    @endforelse
				    */
				     ?>

				     {!! \App\Designation::getDesignationCollapsibleList($designations) !!}
				    </tbody>
				</table>
			</div><!-- end panel-body -->

			@if($designations->total() > 10)
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-4">
						{{ $designations->paginationSummery }}
					</div>
					<div class="col-sm-8 text-right">
						{!! $designations->links() !!}
					</div>
				</div>
			</div>
			@endif
		</div><!-- end panel panel-default -->
	</div>
</div>

<!-- Modal -->
<div id="designationModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create Designation</h4>
      </div>
      {!! Form::open(['url' => '', 'role' => 'form', 'id' => 'designation-form']) !!}
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
	        @if(isSuperAdminOrAdmin())
	        <div class="form-group">
            	<label for="branch_id" class="control-label">Branch {!! validation_error($errors->first('branch_id'),'branch_id') !!}</label>
            	{!! Form::select('branch_id', [], null, ['class'=>'form-control chosen-select', 'disabled' => 'disabled', 'onchange' => 'loadDesignations();']) !!}
	        </div>
	        @endif
	        <div class="form-group">
            	<label for="parent_id" class="control-label">Parent Designation </label>
            	{!! Form::select('parent_id', [], null, ['class'=>'form-control chosen-select', 'disabled'=>'disabled']) !!}
	        </div>
	        <div class="form-group">
	            <label for="description" class="control-label">Description </label>
	            {!! Form::textarea('description', null, ['class'=>'form-control', 'placeholder' => 'Description', 'size' => '30x3']) !!}
	        </div>     
      </div>
      <div class="modal-footer">
      	{!! Form::hidden('designation_id', '') !!}
      	<button type="button" class="btn btn-info btn-submit" onclick="save();">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      {!! Form::close() !!}
    </div>

  </div>
</div>


<!-- Display Modal -->
<div id="designationDisplayModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Designation Details</h4>
      </div>
      <div class="modal-body">
      	<h4 id="designation-title"></h4>
      	<div class="details-info">
      		<p id="designation-description"></p>
      		<strong>Company:</strong> <span id="designation-company"></span> <br>
      		<strong>Branch:</strong> <span id="designation-branch"></span> <br>
      		<strong>Parent:</strong> <span id="designation-parent"></span> <br>
      		<strong>Created at:</strong> <span id="designation-created-date"></span>
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
function openDesignationModal(id=null)
{
	$('#designationModal .modal-title').html('Create designation');
    $(".validation-error").text('*');
    $("#designation-form").trigger('reset');
    $('input[name=designation_id]').val('');
    $('select[name=branch_id]').prop('disabled', true);
    $('select[name=parent_id]').prop('disabled', true);
    $('select').val('').trigger('chosen:updated');
    $('.btn-submit').text('Save');

	if(id && typeof id == 'number') {
		$("#ajaxloader").removeClass('hide');
		$('.btn-submit').text('Update');
		$.ajax({
			url:'{{ url('designations') }}/'+id,
			dataType:'JSON',
			success:function(response) {
				$('#designationModal .modal-title').html('Edit designation: '+response.title);
				$('input[name=title').val(response.title);
				$('select[name=company_id').val(response.company_id).trigger('chosen:updated');
				loadBranches(id, response.company_id);
				loadDesignations(id, response.branch_id);
				// $('select[name=branch_id').val(response.branch_id).trigger('chosen:updated');
				$('textarea[name=description').val(response.description);
				$('input[name=designation_id]').val(response.id);
				$("#ajaxloader").addClass('hide');
			},
			complete:function() {
				$('#designationModal').modal();
			},
			error:function(xhr, ajaxOptions, thrownError) {
				alert(xhr. status + ' ' +thrownError);
			}
		});
	}else {
		@if(isAdmin())
			loadBranches(null, {{ Auth::user()->company->id }})
		@endif
		@if(isDepartmentAdmin())
			loadDesignations(null, {{ Auth::user()->branch_id }});
		@endif
		$('#designationModal').modal();
	}
}

function save() {

	$(".validation-error").text('*');
	$("#ajaxloader").removeClass('hide');
	$.ajax({
		url: "{{ url('designations') }}",
		type: "POST",
		data: $("#designation-form").serialize(),
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

function showdesignationInfo(id)
{
	$("#ajaxloader").removeClass('hide');
	$.ajax({
		url:'{{ url('designations') }}/'+id,
		dataType:'JSON',
		success:function(data) {
			$('#designationDisplayModal #designation-title').html(data.title);
			$('#designationDisplayModal #designation-description').html('<strong>Description: </strong>'+ data.description ? data.description : 'N/A');
			$('#designationDisplayModal #designation-company').html(data.company_title);
			$('#designationDisplayModal #designation-branch').html(data.branch_title);
			$('#designationDisplayModal #designation-parent').html(data.designation_parent);
			$('#designationDisplayModal #designation-created-date').html(data.created_date);
		},
		complete:function() {
			$("#ajaxloader").addClass('hide');
			$('#designationDisplayModal').modal();
		},
		error:function(xhr, ajaxOptions, thrownError) {
			alert(xhr.status + ' ' + thrownError);
		}
	});
}

function loadBranches(designationId=null, companyId = null)
{
	if(!companyId)  {
		var companyId = $('select[name=company_id]').val();
	}
    if(companyId) {
        $('#ajaxloader').removeClass('hide');
        $.ajax({
            url:'{{ url('designations/branches') }}/'+companyId+(designationId ? '/'+designationId : ''),
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

function loadDesignations(designationId=null, branchId=null)
{
	if(!branchId) {
		var branchId = $('select[name=branch_id]').val();
	}
    if(branchId) {
        $('#ajaxloader').removeClass('hide');
        $.ajax({
            url:'{{ url('designations/parent-designations') }}/'+branchId+(designationId ? '/'+designationId : ''),
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

