@extends('layouts.master')

@section('title') Dashboard @endsection

@section('content')
<section>

    <div class="row">

        {{-- Graph of Total Task role weight vs Total Earned Point in financial year --}}
        <div class="col-md-12 margin-top-20">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title"><strong><i class="fa fa-bar-chart"></i> Total Task point Vs Total earned point <small>(financial year)</small></strong></div>
                </div>
                <div class="panel-body">
                    <div id="graph-year-task"></div>
                </div>
                <div id='legend' class="panel-footer">
                    <ul class='list-inline'>
                        <li><i style="color: #00D474;" class="fa fa-square-o"></i> Task Point</li>
                        <li><i style="color: #F39634;" class="fa fa-square-o"></i> Earned Point</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Graph of Task role weight vs Earned Point in this month --}}
        <div class="col-md-12 margin-top-20">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title"><strong><i class="fa fa-bar-chart"></i> Task point Vs Earned point <small>(this month)</small></strong></div>
                </div>
                <div class="panel-body">
                    <div id="graph-current-month-task"></div>
                </div>
                <div id='legend' class="panel-footer">
                    <ul class='list-inline'>
                        <li><i style="color: #5691D6;" class="fa fa-square-o"></i> Task Point</li>
                        <li><i style="color: #F97612;" class="fa fa-square-o"></i> Earned Point</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class='row'>
        <div class='col-md-6'>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title"><strong><i class="fa fa-pie-chart"></i> Deadline Vs Deadline fail <small>(last 30 days)</small></strong></div>
                </div>
                <div class="panel-body">
                    <div id="donut-example"></div>
                </div>
                <div id='legend' class="panel-footer">
                    <ul class='list-inline'>
                        <li><i style="color: #37CE5D;" class="fa fa-smile-o"></i> Done Within Deadline</li>
                        <li><i style="color: #FFBC6F;" class="fa fa-frown-o"></i> Done Within Ex. Deadline1</li>
                        <li><i style="color: #FF7700;" class="fa fa-frown-o"></i> Done Within Ex. Deadline2</li>
                        <li><i style="color: #FC5152;" class="fa fa-meh-o"></i> Failed</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class='col-md-6'>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title"><strong><i class="fa fa-area-chart"></i> My earned point <small>(last 15 days)</small></strong></div>
                </div>
                <div class="panel-body">
                    <div id="area-chart-point-statistics"></div>
                </div>

                <div id='legend' class="panel-footer">
                    <ul class='list-inline'>
                        <li><i style="color: #8851A1;" class="fa fa-circle-o"></i> Earned Point</li>
                    </ul>
                </div>
            </div>
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

    {{-- Morris Graph for current month --}}
    Morris.Bar({
        element: 'graph-current-month-task',
        data: [ {!! $chart_current_month_data !!} ],
        xkey: 'x',
        ykeys: ['y', 'z'],
        labels: ['Task Point (%)', 'Earned Point (%)'],
        barColors: ['#5691D6', '#F97612'],
        hoverCallback: function (index, options, content, row) {
            return row.x+" <br>Earned: " + row.z+"%";
        },
        axes:"y"
    });

    {{-- Morris Graph for full year --}}
    Morris.Bar({
        element: 'graph-year-task',
        data: [ {!! $chart_year_data !!} ],
        xkey: 'x',
        ykeys: ['y', 'z'],
        labels: [],
        barColors: ['#00D474', '#F39634'],
        hoverCallback: function (index, options, content, row) {
            return "Earned: " + row.z+"%";
        }
    });

    Morris.Area({
        element: 'area-chart-point-statistics',
        data: [{!! $pointStatisticsPayload !!}],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['Earned Point'],
        lineColors: ['#8851A1'],
        axes:"y"
    });

    Morris.Donut({
        element: 'donut-example',
        data: [{!! $deadlineStatisticsPayload !!}],
        colors: ['#37CE5D', '#FFBC6F', '#FF7700', '#FC5152'],
        xkey: 'y',
        ykeys: ['vaue']
    });

})();
</script>
@endsection

