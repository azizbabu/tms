@extends('layouts.master')

@section('title') Target Achievement Report @endsection 

@section('content')
<div class="panel panel-default margin-top-20">
	<div class="panel-heading">
		<div class="panel-title">Target Achievement Report</div>
	</div>
	<div class="panel-body">
		{!! Form::open(array('url' => Request::url(), 'role' => 'form','id'=>'target-achievement-report-form')) !!}
			<div class="row">
                @if(count($employees) > 1)
                <div class="col-sm-4">
                    <div class="form-group">
                        {!! Form::select('employee_id',$employees, Request::input('employee_id') ? Request::input('employee_id') :Auth::user()->employee_id,['class'=>'form-control chosen-select']) !!}
                    </div>
                </div>
                @endif
				<div class="col-sm-4">
					<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
					    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
					    <span></span> <b class="caret"></b>
					</div>
					{!! Form::hidden('date_range', Request::input('date_range')) !!}
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<button class="btn btn-default"> Generate Report</button>
					</div>
				</div>
			</div>
		{!! Form::close() !!}
		
		@if(!empty($from_date) && !empty($to_date))
		<h3><strong>Target Achievement Report from {{ $from_date }} to {{ $to_date }}</strong></h3>
		@endif 
		<div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th width="10%" class="text-center">Type</th>
                        <th width="9%" class="text-center">Target</th>
                        <th width="9%" class="text-center">Achievement</th>
                        <th class="text-center" width="7%">%</th>
                    </tr>
                </thead>
                <tbody> 
                @if(!empty($employee_tasks))
                @php $i=1 @endphp
                @forelse($employee_tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td class="text-center">{{ config('constants.job_type.'.$task->job_type) }}</td>
                        <td class="text-center">{{ $task->target ? $task->target : '__' }}</td>
                        <td class="text-center">{{ $task->target ? $task->achievement : '__'  }}</td>
                        <td class="text-center">{{ $task->target ? $task->achievement/$task->target * 100 : '__' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" align="center">No Data Found!</td>
                    </tr>
                @endforelse
                @else
					<tr>
                        <td colspan="5" align="center">No Data Found!</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
  
        @if(!empty($employee_tasks) && $employee_tasks->isNotEmpty())
        <div class="btn-group margin-top-20">
        	<a href="{{ url('reports/target-achievement/print').(count(Request::all()) ? '?employee_id='.Request::input('employee_id').'&date_range='.Request::input('date_range') : '') }}" class="btn btn-primary" target="_blank"><i class="fa fa-print" aria-hdden="true"></i> Print</a>
            <a href="{{ url('reports/target-achievement/pdf').(count(Request::all()) ? '?employee_id='.Request::input('employee_id').'&date_range='.Request::input('date_range') : '') }}" class="btn btn-primary" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>
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
