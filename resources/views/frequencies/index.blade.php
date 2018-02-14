@extends('layouts.master')

@section('title') List of Frequencies @endsection 

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default margin-top-20">
			<div class="panel-heading clearfix">
				List of Frequencies
				<a class="btn btn-danger btn-xs pull-right" href="javascript:openFrequencyModal();"><i class="fa fa-plus-circle"></i> Add New</a>
			</div>

			<div class="panel-body">
				<table class="table table-striped table-bordered">
				    <thead>
				        <tr>
				        	<th>Title</th>
				            <th>Description</th>
				            <th width="9%">Status</th>
				            <th width="12%">Created at</th>
				            <th width="10%">Actions</th>
				        </tr>
				    </thead>
				    <tbody>
				    @forelse($frequencies as $frequency)
				        <tr>
				            <td>{{ $frequency->title }}</td>
				            <td>{{ $frequency->description ? $frequency->description : 'N/A' }}</td>
				            <td><span class="label label-{{ $frequency->status == 'requested' ? 'warning' : 'success' }}"><i class="fa fa-{{ $frequency->status == 'requested' ? 'ban'  :'check' }}"></i> {{ ucfirst($frequency->status) }}</span></td>
				            <td>{{ $frequency->created_at }}</td>

				            <td class="action-column">
				                <!-- show the users (uses the show method found at GET /users/{id} -->
				                <a class="btn btn-xs btn-success hide" href="javascript:showFrequencyInfo({{ $frequency->id }});" title="View Company"><i class="fa fa-eye"></i></a>
								@if(isSuperAdmin())
				                	{{-- Change status --}}
				                	<!-- <a class="btn btn-xs btn-{{ $frequency->status == 'requested' ? 'success'  :'warning' }}" href="{{ url('frequencies/change-status/'.$frequency->id) }}" title="Change Status"><i class="fa fa-{{ $frequency->status == 'requested' ? 'check'  :'ban' }}"></i></a> -->

				                	<a href="#" data-id="{{$frequency->id}}" data-action="{{ url('frequencies/change-status') }}" data-message="Are you sure, You want to {{ $frequency->status == 'requested' ? 'approve' : 'unapprove' }} this frequency?" class="btn btn-xs btn-{{ $frequency->status == 'requested' ? 'success'  :'warning' }} alert-dialog" title="Change Status"><i class="fa fa-{{ $frequency->status == 'requested' ? 'check'  :'ban' }}"></i></a>
				                @endif

				                <!-- edit this users (uses the edit method found at GET /users/{id}/edit -->
				                <a class="btn btn-xs btn-default" href="javascript:openFrequencyModal({{ $frequency->id}})" title="Edit Employee"><i class="fa fa-pencil"></i></a>
				                
				                <!-- delete the users (uses the destroy method DESTROY /users/{id} -->
								

								{{-- Delete --}}
								<a href="#" data-id="{{$frequency->id}}" data-action="{{ url('frequencies/delete') }}" data-message="Are you sure, You want to delete this frequency?" class="btn btn-danger btn-xs alert-dialog" title="Delete frequency"><i class="fa fa-trash white"></i></a>
				            </td>
				        </tr>
				    @empty
				    	<tr>
				        	<td colspan="5" align="center">No Record Found!</td>
				        </tr>
				    @endforelse
				    </tbody>
				</table>
			</div><!-- end panel-body -->

			@if($frequencies->total() > 10)
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-4">
						{{ $frequencies->paginationSummery }}
					</div>
					<div class="col-sm-8 text-right">
						{!! $frequencies->links() !!}
					</div>
				</div>
			</div>
			@endif
		</div><!-- end panel panel-default -->
	</div>
</div>

<!-- Modal -->
<div id="frequencyModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create Frequency</h4>
      </div>
      {!! Form::open(['url' => '', 'role' => 'form', 'id' => 'frequency-form']) !!}
      <div class="modal-body">
        	<div class="form-group">
            	<label for="title" class="control-label">Title {!! validation_error($errors->first('title'),'title') !!}</label>
            	{!! Form::text('title', null, ['class'=>'form-control', 'placeholder' => 'Title']) !!}
	        </div>
	        
	        <div class="form-group">
	            <label for="description" class="control-label">Description {!! validation_error($errors->first('description'),'description', true) !!}</label>
	            {!! Form::textarea('description', null, ['class'=>'form-control', 'placeholder' => 'Description', 'size' => '30x2']) !!}
	        </div>     
      </div>
      <div class="modal-footer">
      	{!! Form::hidden('frequency_id', '') !!}
      	<button type="button" class="btn btn-info btn-submit" onclick="save();">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      {!! Form::close() !!}
    </div>

  </div>
</div>


<!-- Display Modal -->
<div id="frequencyDisplayModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">frequency Details</h4>
      </div>
      <div class="modal-body">
      	<h4 id="frequency-title"></h4>
      	<div class="details-info">
      		<p id="frequency-description"></p>
      		<strong>Company:</strong> <span id="frequency-company"></span> <br>
      		<strong>Branch:</strong> <span id="frequency-branch"></span> <br>
      		<strong>Created at:</strong> <span id="frequency-created-date"></span>
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
function openFrequencyModal(id=null)
{
	if(id && typeof id == 'number') {
		$("#ajaxloader").removeClass('hide');
		$('.btn-submit').text('Update');
		$.ajax({
			url:'{{ url('frequencies') }}/'+id,
			dataType:'JSON',
			success:function(response) {
				$('#frequencyModal .modal-title').html('Edit frequency: '+response.title);
				$('input[name=title').val(response.title);
				$('select[name=branch_id').val(response.branch_id);
				$('textarea[name=description').val(response.description);
				$('input[name=frequency_id]').val(response.id);
				$("#ajaxloader").addClass('hide');
			},
			complete:function() {
				$('#frequencyModal').modal();
			},
			error:function(xhr, ajaxOptions, thrownError) {
				alert(xhr. status + ' ' +thrownError);
			}
		});
	}else {
		$('#frequencyModal').modal();
	}
}

function save() {

	$(".validation-error").text('*');
	$("#ajaxloader").removeClass('hide');
	$.ajax({
		url: "{{ url('frequencies') }}",
		type: "POST",
		data: $("#frequency-form").serialize(),
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

$("#frequencyModal").on('hide.bs.modal', function () {
	$('#frequencyModal .modal-title').html('Create frequency');
    $(".validation-error").text('*');
    $("#frequency-form").trigger('reset');
    $('input[name=frequency_id]').val('');
    $('.btn-submit').text('Save');
});

function showFrequencyInfo(id)
{
	$("#ajaxloader").removeClass('hide');
	$.ajax({
		url:'{{ url('frequencies') }}/'+id,
		dataType:'JSON',
		success:function(data) {
			$('#frequencyDisplayModal #frequency-title').html(data.title);
			$('#frequencyDisplayModal #frequency-description').html('<strong>Description: </strong>'+ data.description ? data.description : 'N/A');
			$('#frequencyDisplayModal #frequency-company').html(data.company_title);
			$('#frequencyDisplayModal #frequency-branch').html(data.branch_title);
			$('#frequencyDisplayModal #frequency-created-date').html(data.created_date);
		},
		complete:function() {
			$("#ajaxloader").addClass('hide');
			$('#frequencyDisplayModal').modal();
		},
		error:function(xhr, ajaxOptions, thrownError) {
			alert(xhr.status + ' ' + thrownError);
		}
	});
}
</script>
@endsection

