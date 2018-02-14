@extends('layouts.master')

@section('title') Department Dashboard @endsection

@section('content')
<section>
    <h1>Department Dashboard: <strong>{{ $department->title }}</strong></h1>
    <div class='row'>
        <div class='col-md-12 margin-top-20'>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title"><strong><i class="fa fa-area-chart"></i> Target Vs Achievement <small>(last 30 days)</small></strong></div>
                </div>
                <div class="panel-body">
                    <div id="area-chart-point-statistics"></div>
                </div>

                <div id='legend' class="panel-footer">
                    <ul class='list-inline'>
                        <li><i style="color: #8851A1;" class="fa fa-circle-o"></i> Target</li>
                        <li><i style="color: #37CE5D;" class="fa fa-circle-o"></i> Achievement</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Graph of Task role weight vs Earned Point in this month --}}
        <div class="col-md-12 margin-top-20">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title"><strong><i class="fa fa-bar-chart"></i> Task point Vs Earned point <small>(last 30 days)</small></strong></div>
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
      data: [ {!! $taskPointsEarnedPointsStaticsPayload !!} ],
      xkey: 'x',
      ykeys: ['y', 'z'],
      labels: ['Task Point', 'Earned Point'],
      barColors: ['#5691D6', '#F97612'],
      axes:"y"
    });

    Morris.Area({
        element: 'area-chart-point-statistics',
        data: [{!! $pointStatisticsPayload !!}],
        xkey: 'x',
        ykeys: ['y', 'z'],
        labels: ['Target', 'Achievement'],
        xLabelFormat: function(x) {
          return x.getFullYear()+'-'+(x.getMonth()+1)+'-'+x.getDate(); 
        },
        lineColors: ['#8851A1', '#37CE5D'],
        hoverCallback: function (index, options, content, row) {
            return row.x+" <br>Achievement: " + row.z+"% out of 100%";
        },
        axes:"y"
    });
})();
</script>
@endsection

