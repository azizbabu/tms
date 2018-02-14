@extends('layouts.master')

@section('title') Todo Report @endsection 

@section('content')
<div class="panel panel-default margin-top-20">
	<div class="panel-heading">
		<div class="panel-title">Todo Report</div>
	</div>
	<div class="panel-body">
		{!! Form::open(array('url' => Request::url(), 'role' => 'form','id'=>'todo-report-form')) !!}
			<div class="row">
				@if(count($employees) > 1)
				<div class="col-sm-4">
                    <div class="form-group">
                        {!! Form::select('employee_id',$employees, Request::input('employee_id') ? Request::input('employee_id') :Auth::user()->employee_id,['class'=>'form-control chosen-select']) !!}
                    </div>
                </div>
                @endif
                {{--  
				<div class="col-sm-4 sweet-daterangepicker">
					<div class="form-group has-feedback">
					  <input type="text" name="date_range" class="form-control daterange-picker" value="{{ Request::input('date_range') ? Request::input('date_range') : '' }}" id="inputSuccess2" aria-describedby="inputSuccess2Status" placeholder="Date Range">
					  <span class="fa fa-calendar form-control-feedback" aria-hidden="true"></span>
					  <span id="inputSuccess2Status" class="sr-only">(success)</span>
					</div>
				</div>
				--}}
				<div class="col-sm-4">
					<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
					    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
					    <span></span> <b class="caret"></b>
					</div>
					{!! Form::hidden('date_range', Request::input('date_range')) !!}
				</div>
				<div class="col-sm-4">
					<div class="form-group pull-right">
						<button class="btn btn-default"> Generate Report</button>
					</div>
				</div>
			</div>
		{!! Form::close() !!}
		
		@if(!empty($from_date) && !empty($to_date))
		<h3><strong>Todo Report from {{ $from_date }} to {{ $to_date }}</strong></h3>
		@endif
		<div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Task</th>
                        @if(Auth::user()->employee->servants->isNotEmpty())
                        <th width="15%">Department</th>
                        <th width="15%">Assigned To</th>
                        @endif
                        <th width="9%">Achievement</th>
                        <th class="text-center" width="7%">Status</th>
                        <th width="16%">Assigned at</th>
                        <th width="16%">Completed at</th>
                    </tr>
                </thead>
                <tbody>
                @if(!empty($todo_lists))
                @php $i=1 @endphp
                @forelse($todo_lists as $todo_list)
                    <tr>
                        <td>{{ $todo_list->title }}</td>
                        @if(Auth::user()->employee->servants->isNotEmpty())
                        <td>{{ $todo_list->department_title }}</td>
                        <td>{{ $todo_list->full_name }}</td>
                        @endif
                        <td class="text-center">{{ $todo_list->achievement }}</td>
                        <td class="text-center">{{ ucfirst($todo_list->status) }}</td>
                        <td>{{ $todo_list->assigned_at }}</td>
                        <td>{{ $todo_list->finished_at ? $todo_list->finished_at->format('d M, Y H:i A') : 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" align="center">No Data Found!</td>
                    </tr>
                @endforelse
                @else
					<tr>
                        <td colspan="7" align="center">No Data Found!</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>

        @if(!empty($todo_lists) && $todo_lists->isNotEmpty()) 
        <div class="btn-group margin-top-20">
        	<a href="{{ url('reports/todo/print').(count(Request::all()) ? '?employee_id='.Request::input('employee_id').'&date_range='.Request::input('date_range') : '') }}" class="btn btn-primary" target="_blank"><i class="fa fa-print" aria-hdden="true"></i> Print</a>
        	<a href="{{ url('reports/todo/pdf').(count(Request::all()) ? '?employee_id='.Request::input('employee_id').'&date_range='.Request::input('date_range') : '') }}" class="btn btn-primary" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>
        </div>
        @endif
	</div>
</div>		
@endsection

@section('custom-style')
{{-- Daterange Picker --}}
{!! Html::style($assets . '/plugins/daterangepicker/daterangepicker-bs3.css') !!}
@endsection

@section('custom-script')
{{-- Date rangepicker --}}
{!! Html::script($assets . '/plugins/daterangepicker/moment.min.js') !!}
{!! Html::script($assets . '/plugins/daterangepicker/daterangepicker.js') !!}

<script>
(function() {

	@if(!empty($from_date) && !empty($to_date))
	var start = moment('{{ $from_date }}');
	var end = moment('{{ $to_date }}');
	@else
	var start = moment().subtract(29, 'days');
    var end = moment();
    @endif

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $('input[name=date_range]').val(start.format('YYYY-MM-DD')+ ' - ' + end.format('YYYY-MM-DD'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

	cb(start, end);
})();
</script>
@endsection
