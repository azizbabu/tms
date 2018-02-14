@extends('layouts.master')

@section('title') Task Manager @endsection

@section('content')
<div id="task-manager-panel" class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">Task Manager</div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs">
                  <li class="active"><a data-toggle="tab" href="#my-todo-list">My Todo List</a></li>
                  <li><a data-toggle="tab" href="#task-management">Task Management</a></li>
                </ul>
                <div class="tab-content">

                    {{-- My Todo List Tab --}}
                    <div id="my-todo-list" class="tab-pane fade in active">
                        <h2>My Todo List</h2>
                        <ul class="nav nav-tabs">
                          <li class="active"><a data-toggle="tab" href="#todays">Todays</a></li>
                          {{--  
                          <li><a data-toggle="tab" href="#last-seven-days">Last 7 days</a></li>
                          <li><a data-toggle="tab" href="#last-thirty-days">Last 30 days</a></li>
                          --}}
                          <li><a data-toggle="tab" href="#next-seven-days">Next 7 days</a></li>
                          <li><a data-toggle="tab" href="#next-thirty-days">Next 30 days</a></li>
                        </ul>

                        <div class="tab-content">

                            {{-- Todays Task Tab --}}
                            <div id="todays" class="tab-pane fade in active">
                                <div class="table-responsive">
                                    <table id="todays-task-table" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center" width="7%">Number</th>
                                                <th>Task Title</th>
                                                {{--  
                                                <th width="15%"> Frequency</th>
                                                --}}
                                                <th width="15%">Type</th>
                                                <th>Achievement</th>
                                                <th>Status</th>
                                                <th width="15%"> Assigned at</th>
                                                <th width="15%"> Deadline</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php $i=1 @endphp
                                        @forelse($todo_lists_today as $todo_list)
                                            <tr>
                                                <td class="text-center">@php echo '#' . $i++ @endphp</td>
                                                <td><a href="{{ url('todo/'.$todo_list->id) }}" target="_blank">{{ $todo_list->title }}</a></td>
                                                {{--  
                                                <td>{{ config('constants.frequency.'.$todo_list->frequency) }}</td>
                                                --}}
                                                <td>{{ config('constants.job_type.'.$todo_list->job_type) }}</td>
                                                <td>
                                                @if(in_array($todo_list->status,['new', 'accepted']))
                                                    {!! Form::number('achievement', 0, ['class'=>'form-control', 'min'=>0]) !!}
                                                @else
                                                    {{ $todo_list->achievement }}
                                                @endif
                                                </td>
                                                <td>
                                                @if(in_array($todo_list->status,['new', 'accepted']))
                                                    {!! Form::open(['url' => 'todo/'.$todo_list->id, 'role' => 'form']) !!}
                                                        {!! Form::select('status',config('constants.task_status'),$todo_list->status,['class'=>'form-control chosen-select status-dropdown', 'id' => 'status', 'onchange' => 'changeTodoStatus('.$todo_list->id.', this);']) !!}
                                                    {!! Form::close() !!}
                                                @else
                                                    <strong>{{ ucfirst($todo_list->status) }}</strong>
                                                @endif
                                                </td>
                                                <td>{{ $todo_list->assigned_at }}</td>
                                                <td>{{ Carbon::parse($todo_list->deadline)->format('d M, Y H:i A') }}</td>
                                            </tr>
                                        @empty
                                            <!-- <tr>
                                                <td colspan="4" align="center">No Assigned Task Found!</td>
                                            </tr> -->
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- /Todays Task Tab --}}
                            
                            <?php 
                            /*
                            {{-- Last Seven Days Task Tab --}}

                            <div id="last-seven-days" class="tab-pane fade">
                                <div id="" class="table-responsive">
                                    <table id="last-seven-days-task-table" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center" width="7%">Number</th>
                                                <th>Task Title</th>
                                                {{--  
                                                <th width="15%"> Frequency</th>
                                                --}}
                                                <th width="15%">Type</th>
                                                <th>Achievement</th>
                                                <th>Status</th>
                                                <th width="15%"> Assigned at</th>
                                                <th width="15%"> Deadline</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php $i=1 @endphp
                                        @forelse($todo_lists_last_seven_days as $todo_list)
                                            <tr>
                                                <td class="text-center">@php echo '#' . $i++ @endphp</td>
                                                <td><a href="{{ url('todo/'.$todo_list->id) }}" target="_blank">{{ $todo_list->title }}</a></td>
                                                {{--  
                                                <td>{{ config('constants.frequency.'.$todo_list->frequency) }}</td>
                                                --}}
                                                <td>{{ config('constants.job_type.'.$todo_list->job_type) }}</td>
                                                <td>
                                                @if(in_array($todo_list->status,['new', 'accepted']))
                                                    {!! Form::number('achievement', 0, ['class'=>'form-control', 'min'=>0]) !!}
                                                @else
                                                    {{ $todo_list->achievement }}
                                                @endif
                                                </td>
                                                <td>
                                                    @if(in_array($todo_list->status,['new', 'accepted']))
                                                    {!! Form::open(['url' => 'todo/'.$todo_list->id, 'role' => 'form']) !!}
                                                        {!! Form::select('status',config('constants.task_status'),$todo_list->status,['class'=>'form-control chosen-select status-dropdown', 'id' => 'status', 'onchange' => 'changeTodoStatus('.$todo_list->id.', this);']) !!}
                                                    {!! Form::close() !!}
                                                @else
                                                    <strong>{{ ucfirst($todo_list->status) }}</strong>
                                                @endif
                                                </td>
                                                <td>{{ $todo_list->assigned_at }}</td>
                                                <td>{{ Carbon::parse($todo_list->deadline)->format('d M, Y H:i A') }}</td>
                                            </tr>
                                        @empty
                                            <!-- <tr>
                                                <td colspan="4" align="center">No Assigned Task Found!</td>
                                            </tr> -->
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- /Last Seven Days Task Tab --}}

                            {{-- Last Thirty Days Task Tab --}}
                            <div id="last-thirty-days" class="tab-pane fade">
                                <div id="" class="table-responsive">
                                    <table id="last-thirty-days-task-table" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center" width="7%">Number</th>
                                                <th>Task Title</th>
                                                {{--  
                                                <th width="15%">Frequency</th>
                                                --}}
                                                <th width="15%">Type</th>
                                                <th>Achievement</th>
                                                <th>Status</th>
                                                <th width="15%"> Assigned at</th>
                                                <th width="15%"> Deadline</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php $i=1 @endphp
                                        @forelse($todo_lists_last_thirty_days as $todo_list)
                                            <tr>
                                                <td class="text-center">@php echo '#' . $i++ @endphp</td>
                                                <td><a href="{{ url('todo/'.$todo_list->id) }}" target="_blank">{{ $todo_list->title }}</a></td>
                                                {{--  
                                                <td>{{ config('constants.frequency.'.$todo_list->frequency) }}</td>
                                                --}}
                                                <td>{{ config('constants.job_type.'.$todo_list->job_type) }}</td>
                                                <td>
                                                @if(in_array($todo_list->status,['new', 'accepted']))
                                                    {!! Form::number('achievement', 0, ['class'=>'form-control', 'min'=>0]) !!}
                                                @else
                                                    {{ $todo_list->achievement }}
                                                @endif
                                                </td>
                                                <td>
                                                    @if(in_array($todo_list->status,['new', 'accepted']))
                                                    {!! Form::open(['url' => 'todo/'.$todo_list->id, 'role' => 'form']) !!}
                                                        {!! Form::select('status',config('constants.task_status'),$todo_list->status,['class'=>'form-control chosen-select status-dropdown', 'id' => 'status', 'onchange' => 'changeTodoStatus('.$todo_list->id.', this);']) !!}
                                                    {!! Form::close() !!}
                                                @else
                                                    <strong>{{ ucfirst($todo_list->status) }}</strong>
                                                @endif
                                                </td>
                                                <td>{{ $todo_list->assigned_at }}</td>
                                                <td>{{ Carbon::parse($todo_list->deadline)->format('d M, Y H:i A') }}</td>
                                            </tr>
                                        @empty
                                            <!-- <tr>
                                                <td colspan="4" align="center">No Assigned Task Found!</td>
                                            </tr> -->
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- /Last Thirty Days Task Tab --}}
                            */
                             ?>
                            
                            {{-- Next Seven Days Task Tab --}}
                            
                            <div id="next-seven-days" class="tab-pane fade">
                                <div id="" class="table-responsive">
                                    <table id="next-seven-days-task-table" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Task Title</th>
                                                <th width="9%">Type</th>
                                                <th width="8%">Achievement</th>
                                                <th width="5%">Status</th>
                                                <th width="15%"> Assigned at</th>
                                                <th width="15%"> Deadline</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($total_todo_lists_next_7_days as $parent_todo_list)
                                        @forelse($parent_todo_list as $todo_list)
                                            <tr>
                                                <td>{{ $todo_list['title'] }}</a></td>
                                                <td>{{ config('constants.job_type.'.$todo_list['job_type']) }}</td>
                                                <td class="text-center">
                                                {{ $todo_list['achievement'] }}
                                                </td>
                                                <td class="text-center">{{ ucfirst($todo_list['status']) }}
                                                </td>
                                                <td>{{ $todo_list['assigned_at']->format('d M, Y H:i A') }}</td>
                                                <td>{{ Carbon::parse($todo_list['deadline'])->format('d M, Y H:i A') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" align="center">No Record Found!</td>
                                            </tr>
                                        @endforelse
                                        @empty
                                            <tr>
                                                <td colspan="6" align="center">No Record Found!</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- /Next Seven Days Task Tab --}}

                            {{-- Last Thirty Days Task Tab --}}
                            <div id="next-thirty-days" class="tab-pane fade">
                                <div id="" class="table-responsive">
                                    <table id="next-thirty-days-task-table" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Task Title</th>
                                                <th width="9%">Type</th>
                                                <th width="8%">Achievement</th>
                                                <th width="5%">Status</th>
                                                <th width="15%"> Assigned at</th>
                                                <th width="15%"> Deadline</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($total_todo_lists_next_30_days as $parent_todo_list)
                                        @forelse($parent_todo_list as $todo_list)
                                            <tr>
                                                <td>{{ $todo_list['title'] }}</a></td>
                                                <td>{{ config('constants.job_type.'.$todo_list['job_type']) }}</td>
                                                <td class="text-center">
                                                {{ $todo_list['achievement'] }}
                                                </td>
                                                <td class="text-center">{{ ucfirst($todo_list['status']) }}
                                                </td>
                                                <td>{{ $todo_list['assigned_at']->format('d M, Y H:i A') }}</td>
                                                <td>{{ Carbon::parse($todo_list['deadline'])->format('d M, Y H:i A') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" align="center">No Record Found!</td>
                                            </tr>
                                        @endforelse
                                        @empty
                                            <tr>
                                                <td colspan="6" align="center">No Record Found!</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- /Last Thirty Days Task Tab --}}
                        </div>
                        {{-- /Tab Content --}}
                    </div>
                    {{-- /My Todo List Tab --}}

                    <div id="task-management" class="tab-pane fade">
                    @if(Auth::user()->employee && Auth::user()->employee->servants->isNotEmpty())
                        <ul class="nav nav-tabs">
                          <li class="active"><a data-toggle="tab" href="#my-team">My Team</a></li>
                          <li><a data-toggle="tab" href="#my-team-task">My Team Task</a></li>
                          <li><a data-toggle="tab" href="#my-task">My Task</a></li>
                        </ul>
                        
                        {{-- Tab Content --}}
                        <div class="tab-content">
                            {{-- My Team --}}
                            <div id="my-team" class="tab-pane fade in active">
                                <div class="table-responsive">
                                    <table id="employee-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <!-- <th>ID</th> -->
                                                <th>Name</th>
                                                <th>Branch</th>
                                                <th>Department</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th width="12%">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php $employee = Auth::user()->employee @endphp
                                            <!-- <td>{{ $employee->id }}</td> -->
                                                <td>{{ $employee->full_name }}</td>
                                                <td>{{ $employee->branch ? $employee->branch->title : 'N/A' }}</td>
                                                <td>{{ $employee->department ? $employee->department->title : 'N/A' }}</td>
                                                <td>{{ $employee->phone }}</td>
                                                <td>{{ $employee->user ? $employee->user->email : 'N/A' }}</td>

                                                <td class="action-column">
                                                    {{-- Display Employee Task --}}
                                                    <a class="btn btn-xs btn-primary btn-tm" href="{{ URL::to('employee-tasks/employee/' . $employee->id) }}" title="View Employee Task"><i class="fa fa-tasks"></i></a>
                                                </td>
                                            </tr>
                                        @forelse($employees as $employee)
                                            <tr>
                                                <!-- <td>{{ $employee->id }}</td> -->
                                                <td><span class="glyphicon glyphicon-minus"></span> {{ $employee->full_name }}</td>
                                                <td>{{ $employee->branch ? $employee->branch->title : 'N/A' }}</td>
                                                <td>{{ $employee->department ? $employee->department->title : 'N/A' }}</td>
                                                <td>{{ $employee->phone }}</td>
                                                <td>{{ $employee->user ? $employee->user->email : 'N/A' }}</td>

                                                <td class="action-column">
                                                    {{-- Display Employee Task --}}
                                                    <a class="btn btn-xs btn-primary btn-tm" href="{{ URL::to('employee-tasks/employee/' . $employee->id) }}" title="View Employee Task"><i class="fa fa-tasks"></i></a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" align="center">No Record Found!</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- /My Team --}}

                            {{-- My Team Task --}}
                            <div id="my-team-task" class="tab-pane fade">
                                <div class="table-responsive">
                                    <table id="my-team-task-table" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Task</th>
                                                <th width="15%">Department</th>
                                                <th width="15%">Assigned To</th>
                                                <th class="text-center" width="9%">Achievement</th>
                                                <th class="text-center" width="7%">Status</th>
                                                <th width="15%">Assigned at</th>
                                                <th width="15%">Finished at</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php $i= 1 @endphp
                                        @forelse($todo_lists as $todo_list)
                                            <tr>
                                                <td>{{ $todo_list->id }}</td>
                                                <td><a href="{{ url('todo/'.$todo_list->id) }}" target="_blank">{{ $todo_list->title }}</a></td>
                                                <td>{{ $todo_list->department_title }}</td>
                                                <td>{{ $todo_list->full_name }}</td>
                                                <td class="text-center">{{ $todo_list->achievement }}</td>
                                                <td class="text-center">{{ ucfirst($todo_list->status) }}</td>
                                                <td>{{ $todo_list->assigned_at }}</td>
                                                <td>{{ $todo_list->finished_at ? $todo_list->finished_at->format('d M, Y H:i A') : 'N/A' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" align="center">No Assigned Task Found!</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                {{--   
                                @if($todo_lists->total() > 10)
                                <div class="row">
                                    <div class="col-sm-4">{{ $todo_lists->paginationSummery }}</div>
                                    <div class="col-sm-8 text-right">
                                        {!! $todo_lists->links() !!}
                                    </div>
                                </div>
                                @endif
                                --}}
                            </div>
                            {{-- /My Team Task --}}

                            {{-- My Task --}}
                            <div id="my-task" class="tab-pane fade">
                                <div class="table-responsive">
                                    <table id="my-task-table" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center" width="7%">ID</th>
                                                <th>Task Title</th>
                                                {{--  
                                                <th width="15%">Task Frequency</th>
                                                --}}
                                                <th width="9%">Type</th>
                                                <th width="8%"> Achievement</th>
                                                <th width="7%">Status</th>
                                                <th width="15%">Assigned at</th>
                                                <th width="15%">Deadline</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php $i=1 @endphp
                                        @forelse($my_todo_lists as $todo_list)
                                            <tr>
                                                <td class="text-center">{{ $todo_list->id }}</td>
                                                <td><a href="{{ url('todo/'.$todo_list->id) }}" target="_blank">{{ $todo_list->title }}</a></td>
                                                {{--  
                                                <td>{{ config('constants.frequency.'.$todo_list->frequency) }}</td>
                                                --}}
                                                <td>{{ config('constants.job_type.'.$todo_list->job_type) }}</td>
                                                <td class="text-center">{{ $todo_list->achievement }}</td>
                                                <td class="text-center">{{ ucfirst($todo_list->status) }}</td>
                                                <td>{{ $todo_list->assigned_at }}</td>
                                                <td>{{ Carbon::parse($todo_list->deadline)->format('d M, Y H:i A') }}</td>
                                            </tr>
                                        @empty
                                            <!-- <tr>
                                                <td colspan="6" align="center">No Assigned Task Found!</td>
                                            </tr> -->
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- /My Task --}}
                        </div>
                        {{-- /Tab Content --}}
                    @else
                        {{-- My Task --}}
                        <h2>My Task</h2>
                        <div class="table-responsive">
                            <table id="my-task-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="7%">ID</th>
                                        <th>Task Title</th>
                                        {{--  
                                        <th width="15%">Task Frequency</th>
                                        --}}
                                        <th width="9%">Type</th>
                                        <th width="8%"> Achievement</th>
                                        <th width="7%">Status</th>
                                        <th width="20%">Assigned at</th>
                                        <th width="20%">Deadline</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php $i=1 @endphp
                                @forelse($my_todo_lists as $todo_list)
                                    <tr>
                                        <td class="text-center">{{ $todo_list->id }}</td>
                                        <td><a href="{{ url('todo/'.$todo_list->id) }}" target="_blank">{{ $todo_list->title }}</a></td>
                                        {{--  
                                        <td>{{ config('constants.frequency.'.$todo_list->frequency) }}</td>
                                        --}}
                                        <td>{{ config('constants.job_type.'.$todo_list->job_type) }}</td>
                                        <td class="text-center">{{ $todo_list->achievement }}</td>
                                        <td class="text-center">{{ ucfirst($todo_list->status) }}</td>
                                        <td>{{ $todo_list->assigned_at }}</td>
                                        <td>{{ Carbon::parse($todo_list->deadline)->format('d M, Y H:i A') }}</td>
                                    </tr>
                                @empty
                                    <!-- <tr>
                                        <td colspan="6" align="center">No Assigned Task Found!</td>
                                    </tr> -->
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    {{-- /My Task --}}
                    @endif
                    </div>
                </div>
                {{-- /Tab Content --}}
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-style')
{{-- Data table --}}
{!! Html::style($assets . '/plugins/datatables/css/dataTables.bootstrap.min.css') !!}
@endsection

@section('custom-script')
{{-- Data table --}}
{!! Html::script($assets . '/plugins/datatables/js/jquery.dataTables.min.js') !!}
{!! Html::script($assets . '/raphael-min.js') !!}
{!! Html::script($assets . '/plugins/datatables/js/dataTables.bootstrap.min.js') !!}

<script>
function changeTodoStatus(id, obj)
{
    var $this = $(obj);
    var achievementColumn = $this.closest('tr').find('td:eq(2)');
    var achievement = achievementColumn.find('input[name=achievement]').val() ? parseInt(achievementColumn.find('input[name=achievement]').val()) : 0;
    var statusValue = $this.val();

    if(statusValue) {
        $('#ajaxloader').removeClass('hide');
        $.ajax({
            url:'{{ url('todo/change-status') }}/'+id,
            method:'POST',
            data:{status:statusValue, achievement:achievement},
            dataType:'JSON',
            success:function(data) {
                toastMsg(data.message, data.type);
            },
            complete:function() {
                $('#ajaxloader').addClass('hide');
                if(statusValue == 'completed') {
                    $this.closest('td').html('<strong>'+ statusValue.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                        return letter.toUpperCase();
                    }) +'</strong>');
                    achievementColumn.html(achievement);
                    $this.remove();
                    // setTimeout(function() {
                    //     location.reload();
                    // }, 2000);
                }
            },
            error:function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + ' ' +thrownError);
            }
        });
    }else {
        alert('Please select this field correctly');
    }
}

(function() {
    {{-- Initialize DataTable --}}
    
    $('#todays-task-table').DataTable({
        "columnDefs": [
            { "targets": 0, "visible": false },
            { "width": "10%", "targets": 2 },
            // { "width": "10%", "targets": 3 },
        ],
        autoWidth: false,
        "language": {
          "emptyTable": "No data available in table"
        }
    });

    $('#last-seven-days-task-table').DataTable({
        "columnDefs": [
            { "targets": 0, "visible": false },
            { "width": "10%", "targets": 2 },
            // { "width": "10%", "targets": 3 },
        ],
        autoWidth: false
    });

    $('#last-thirty-days-task-table').DataTable({
        "columnDefs": [
            { "targets": 0, "visible": false },
            { "width": "10%", "targets": 2 },
            // { "width": "10%", "targets": 3 },
        ],
        autoWidth: false
    }); 

    $('#my-team-task-table').DataTable({
        "columnDefs": [
            { "targets": 0, "visible": false },
            { "width": "9%", "targets": 2 },
            { "width": "17%", "targets": 6 },
            { "width": "17%", "targets": 7 },
        ],
        autoWidth: false
    });

    $('#my-task-table').DataTable({
        "columnDefs": [
            { "targets": 0, "visible": false },
            { "width": "17%", "targets": 5 },
            { "width": "17%", "targets": 6 },
        ],
        autoWidth: false
    });
})();
</script>
@endsection



