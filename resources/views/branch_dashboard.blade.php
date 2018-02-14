@extends('layouts.master')

@section('title') Branch Dashboard @endsection

@section('content')
<section>
    <h1>Branch Dashboard : <strong>{{ $branch->title }}</strong></h1>

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

    <div class='row'>
        <div class='col-md-12 margin-top-20'>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title"><strong><i class="fa fa-area-chart"></i> Department Wise  Target Vs Achievement <small>(last 30 days)</small></strong></div>
                </div>
                <div class="panel-body">
                    <div id="area-chart-point-statistics"></div>
                </div>

                <div id='legend' class="panel-footer">
                    <ul class='list-inline'>
                        <li><i style="color: #5691D6;" class="fa fa-circle-o"></i> Target</li>
                        <li><i style="color: #F97612;" class="fa fa-circle-o"></i> Achievement</li>
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

    var departmentDashboard = "{{url('department-dashboard')}}";

    Morris.Bar({
      element: 'area-chart-point-statistics',
      data: [ {!! $pointStatisticsPayload !!} ],
      xkey: 'x',
      ykeys: ['y', 'z'],
      labels: ['Target', 'Achievement'],
      barColors: ['#5691D6', '#F97612'],
      hoverCallback: function (index, options, content, row) {
            return row.x+" <br>Achievement: " + row.z+"% out of 100%";
      },
      axes:"y"
    });

    Morris.Bar({
        element: 'departmentWiseEarnedPoint',
        data: [ {!! $departmentWiseEarnedPoint !!} ],
        xkey: 'x',
        ykeys: ['y', 'z'],
        labels: ['Task Point (%)', 'Earned Point (%)'],
        barColors: ['#5691D6', '#F97612'],
                hoverCallback: function (index, options, content, row) {
           return "<a target='_blank' href='"+ departmentDashboard +"/"+ row.id +"'>"+row.x + "</a> <br> Earned: " + row.z+"% out of 100%";
        },
        axes:"y"
    });
})();
</script>
@endsection

