@extends('layouts.master')

@section('title') Branch Dashboard @endsection

@section('content')
<section>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title"><strong><i class="fa fa-bar-chart"></i> Total Task point Vs Total earned point <small>(current year)</small></strong></div>
        </div>
        <div class="panel-body">
            <div id="monthWiseRoleWeightEarnedPoinPayload"></div>
        </div>
        <div id='legend' class="panel-footer">
            <ul class='list-inline'>
                <li><i style="color: #5691D6;" class="fa fa-square-o"></i> Task Point</li>
                <li><i style="color: #F97612;" class="fa fa-square-o"></i> Earned Point</li>
            </ul>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title"><strong><i class="fa fa-bar-chart"></i> Department Wise Performance (Task point Vs Earned point)</strong></div>
        </div>
        <div class="panel-body">
            <div id="departmentWiseEarnedPoint"></div>
        </div>
        <div id='legend' class="panel-footer">
            <ul class='list-inline'>
                <li><i style="color: #5691D6;" class="fa fa-square-o"></i> Task Point</li>
                <li><i style="color: #F97612;" class="fa fa-square-o"></i> Earned Point</li>
            </ul>
        </div>
    </div>

</section>

@endsection

@section('custom-style')

<style>
    #legend ul{
        font-size: 11px;
    }
</style>

{{-- Chart Morris --}}
{!! Html::style($assets . '/plugins/chart.morris/morris.css') !!}

{{-- Material Design Bootstrap --}}
{!! Html::style($assets . '/plugins/mdb/css/mdb.min.css') !!}
@endsection

@section('custom-script')
{{-- Data table --}}
{!! Html::script($assets . '/raphael-min.js') !!}

{{-- Chart Morris --}}
{!! Html::script($assets . '/plugins/chart.morris/morris.min.js') !!}

{{-- Material Design Bootstrap --}}
{!! Html::script($assets . '/plugins/mdb/js/mdb.min.js') !!}
<script>
(function() {
    {{-- Morris Graph for month wise role weight and earned point --}}
    Morris.Bar({
        element: 'monthWiseRoleWeightEarnedPoinPayload',
        data: [ {!! $monthWiseRoleWeightEarnedPoinPayload !!} ],
        xkey: 'x',
        ykeys: ['y', 'z'],
        labels: ['Task Point (%)', 'Earned Point (%)'],
        barColors: ['#5691D6', '#F97612'],
        hoverCallback: function (index, options, content, row) {
           return row.x + "<br> Earned: " + row.z+"% out of 100%";
        }
    });

    {{-- Morris graph for department wise task point and earned point --}}
    var departmentDashboard = "{{url('department-dashboard')}}";
    Morris.Bar({
        element: 'departmentWiseEarnedPoint',
        data: [ {!! $departmentWiseEarnedPoint !!} ],
        xkey: 'x',
        ykeys: ['y', 'z'],
        labels: ['Task Point (%)', 'Earned Point (%)'],
        barColors: ['#5691D6', '#F97612'],
        hoverCallback: function (index, options, content, row) {
           return "<a target='_blank' href='"+ departmentDashboard +"/"+ row.id +"'>"+row.x + "</a> <br> Earned: " + row.z+"% out of 100%";
        }
    });
})();
</script>
@endsection

