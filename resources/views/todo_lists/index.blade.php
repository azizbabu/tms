@extends('layouts.master')

@section('title') List of Assigned Tasks @endsection 

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default margin-top-20">
			<div class="panel-heading clearfix">
				List of Assigned Tasks
				<a class="btn btn-danger btn-xs pull-right" href="javascript:openTodoListModal();"><i class="fa fa-plus-circle"></i> Add New</a>
			</div>

			<div class="panel-body">
				<table class="table table-striped table-bordered">
				    <thead>
				        <tr>
				        	<th>SL.</th>
				            <th>Employee</th>
				            <th>Task</th>
				            <th>Created at</th>
				            <th width="14%">Actions</th>
				        </tr>
				    </thead>
				    <tbody>
				    @php $i=1 @endphp
				    @forelse($todo_lists as $todo_list)
				        <tr>
				        	<td>@php echo $i++ @endphp</td>
				            <td>{{ $todo_list->employee->full_name }}</td>
				            <td>{!! $todo_list->getTaskItems() !!}</td>
				           
				            <td>{{ $todo_list->assigned_at->format('d M, Y') }}</td>

				            <td class="action-column">

				                <!-- edit this users (uses the edit method found at GET /users/{id}/edit -->
				                <a class="btn btn-xs btn-default" href="javascript:openTodoListModal({{ $todo_list->id}})" title="Edit Task Assign"><i class="fa fa-pencil"></i></a>
				                
				                <!-- delete the users (uses the destroy method DESTROY /users/{id} -->
								

								{{-- Delete --}}
								<a href="#" data-id="{{$todo_list->id}}" data-action="{{ url('todo-lists/delete') }}" data-message="Are you sure, You want to delete this todo list?" class="btn btn-danger btn-xs alert-dialog" title="Delete todo list"><i class="fa fa-trash white"></i></a>
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

			@if($todo_lists->total() > 10)
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-4">
						{{ $todo_lists->paginationSummery }}
					</div>
					<div class="col-sm-8 text-right">
						{!! $todo_lists->links() !!}
					</div>
				</div>
			</div>
			@endif
		</div><!-- end panel panel-default -->
	</div>
</div>

<!-- Modal -->
<div id="todoListModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create Task Assign</h4>
      </div>
      {!! Form::open(['url' => '', 'role' => 'form', 'id' => 'employee-task-form']) !!}
      <div class="modal-body">
	        <div class="form-group">
            	<label for="employee_id" class="control-label">Employee {!! validation_error($errors->first('employee_id'),'employee_id') !!}</label>
            	{!! Form::select('employee_id', $employees, null, ['class'=>'form-control chosen-select']) !!}
	        </div> 
	        <div class="form-group">
            	<label for="task_id" class="control-label">Task {!! validation_error($errors->first('task_id'),'task_id') !!}</label>
            	{!! Form::select('task_id[]', $tasks, null, ['class'=>'form-control chosen-select', 'data-placeholder' => 'Choose some tasks', 'multiple']) !!}
	        </div>   
      </div>
      <div class="modal-footer">
      	{!! Form::hidden('todo_list_id', '') !!}
      	<button type="button" class="btn btn-info btn-submit" onclick="save();">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      {!! Form::close() !!}
    </div>

  </div>
</div>

@endsection

@section('custom-script')
<script>
function openTodoListModal(id=null)
{
	if(id && typeof id == 'number') {
		$("#ajaxloader").removeClass('hide');
		$('.btn-submit').text('Update');
		$.ajax({
			url:'{{ url('todo-lists') }}/'+id,
			dataType:'JSON',
			success:function(response) {
				console.log(response);
				$('#todoListModal .modal-title').html('Edit Task Assign');
				$('select[name=employee_id]').val(response.employee_id).trigger('chosen:updated');
				$('select[name^=task_id]').val(response.task_ids).trigger('chosen:updated');
				$('input[name=todo_list_id]').val(response.id);
				$("#ajaxloader").addClass('hide');
			},
			complete:function() {
				$('#todoListModal').modal();
			},
			error:function(xhr, ajaxOptions, thrownError) {
				alert(xhr. status + ' ' +thrownError);
			}
		});
	}else {
		$('#todoListModal').modal();
	}
}

function save() {

	$(".validation-error").text('*');
	$("#ajaxloader").removeClass('hide');
	$.ajax({
		url: "{{ url('todo-lists') }}",
		type: "POST",
		data: $("#employee-task-form").serialize(),
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

$("#todoListModal").on('hide.bs.modal', function () {
	$('#todoListModal .modal-title').html('Create designation');
    $(".validation-error").text('*');
    $('select[name=employee_id]').val('').trigger('chosen:updated');
	$('select[name^=task_id]').val('').trigger('chosen:updated');
    $('input[name=todo_list_id]').val('');
    $('.btn-submit').text('Save');
});

</script>
@endsection
