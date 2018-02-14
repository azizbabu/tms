@extends('prints.master')

@section('title') Target Achievement Report Report @endsection 

@section('content')

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
@endsection

@section('custom-style')

@endsection

@section('custom-script')

<script>
(function() {
	window.print();
})();
</script>
@endsection
