@extends('layouts.master')

@section('title') Owner Dashboard @endsection

@section('content')

    <div class="panel panel-default owner-dashboard-panel">
        <div class="panel-heading">
            <div class="panel-title"><strong><i class="fa fa-dashboard"></i> View Dashboard</strong></div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-9">
                            {!! Form::select('branch_id',$branches, null,['class'=>'form-control chosen-select']) !!}
                        </div>
                        <div class="col-md-3 sm-margin-top-20">
                            <button class="btn btn-success btn-branch" onclick="displayBranchDashboard(this);">Go</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 sm-margin-top-20">
                    <div class="row">
                        <div class="col-md-9">
                            {!! Form::select('department_id',$departments, null,['class'=>'form-control chosen-select']) !!}
                        </div>
                        <div class="col-md-3 sm-margin-top-20">
                            <button class="btn btn-success btn-department" onclick="displayDepartmentDashboard(this);">Go</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 sm-margin-top-20">
                    <div class="row">
                        <div class="col-md-9">
                            {!! Form::select('employee_id',$employees, null,['class'=>'form-control chosen-select']) !!}
                        </div>
                        <div class="col-md-3 sm-margin-top-20">
                            <button class="btn btn-success btn-employee" onclick="displayEmployeeDashboard(this);">Go</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title"><strong><i class="fa fa-bar-chart"></i> Branch Wise Performance (Task point Vs Earned point)</strong></div>
        </div>
        <div class="panel-body">
            <div id="branchWisePerformance"></div>
        </div>
        <div class="panel-footer">
            <ul id='legend' class='list-inline'>
                <li><i style="color: #00D474;" class="fa fa-square-o"></i> Task Point</li>
                <li><i style="color: #F39634;" class="fa fa-square-o"></i> Earned Point</li>
            </ul>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title"><strong><i class="fa fa-bar-chart"></i> Top 10 BEST Employee's Performance (Task point Vs Earned point)</strong></div>
        </div>
        <div class="panel-body">
            <div id="top10BestEmployeePerformance"></div>
        </div>
        <div class="panel-footer">
            <ul id='legend' class='list-inline'>
                <li><i style="color: #CB3F46;" class="fa fa-square-o"></i> Task Point</li>
                <li><i style="color: #4F75BE;" class="fa fa-square-o"></i> Earned Point</li>
            </ul>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title"><strong><i class="fa fa-bar-chart"></i> Top 10 WORST Employee's Performance (Task point Vs Earned point)</strong></div>
        </div>
        <div class="panel-body">
            <div id="top10WorstEmployeePerformance"></div>
        </div>
        <div class="panel-footer">
            <ul id='legend' class='list-inline'>
                <li><i style="color: #FF9900;" class="fa fa-square-o"></i> Task Point</li>
                <li><i style="color: #E80000;" class="fa fa-square-o"></i> Earned Point</li>
            </ul>
        </div>
    </div>
@endsection

@section('custom-style')

<style>
    #legend{
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

{{-- Display branch dashboard --}}
function displayBranchDashboard(obj)
{
    var branchId = $(obj).closest('.row').find('select[name=branch_id]').val();

    if(branchId) {
        window.open('{{ url('branch-dashboard') }}/'+ branchId, '_blank'); 
    }else {
        alert('Please select branch!');

        return;
    }
}

{{-- Display department dashboard --}}
function displayDepartmentDashboard(obj)
{
    var departmentId = $(obj).closest('.row').find('select[name=department_id]').val();

    if(departmentId) {
        window.open('{{ url('department-dashboard') }}/'+ departmentId, '_blank'); 
    }else {
        alert('Please select department!');

        return;
    }
}

{{-- Display employee dashboard --}}
function displayEmployeeDashboard(obj)
{
    var employeeId = $(obj).closest('.row').find('select[name=employee_id]').val();

    if(employeeId) {
        window.open('{{ url('employee-dashboard') }}/'+ employeeId, '_blank'); 
    }else {
        alert('Please select employee!');

        return;
    }
}

$(document).ready(function(){

    var branchDashboard = "{{url('branch-dashboard')}}";
    var employeeDashboard = "{{url('employee-dashboard')}}";

    /*Branch wise task point vs earned point*/
    Morris.Bar({
        element: 'branchWisePerformance',
        data: [ {!! $branchWisePerformance !!} ],
        xkey: 'x',
        ykeys: ['y', 'z'],
        labels: ['Task Point (%)', 'Earned Point (%)'],
        barColors: ['#00D474', '#F39634'],
        hoverCallback: function (index, options, content, row) {
           return "<a target='_blank' href='"+ branchDashboard +"/"+ row.id+"'>"+row.x + "</a> <br> Earned: " + row.z+"% out of 100%";
        },
        axes:"y"
    });
    /*Branch wise task point vs earned point end*/

    /*Top 10 BEST Employee Performance (best employees)*/
    Morris.Bar({
        element: 'top10BestEmployeePerformance',
        data: [ {!! $top10BestEmployeePerformance !!} ],
        xkey: 'x',
        ykeys: ['y', 'z'],
        labels: ['Task Point (%)', 'Earned Point (%)'],
        barColors: ['#CB3F46', '#4F75BE'],
        hoverCallback: function (index, options, content, row) {
           return "<a target='_blank' href='"+ employeeDashboard +"/"+ row.username +"'>"+row.x + "</a> <br> Earned: " + row.z+"% out of 100%";
        },
        axes:"y"
    });
    /*Top 10 BEST Employee Performance end*/

    /*Top 10 WORST Employee Performance (best employees)*/
    Morris.Bar({
        element: 'top10WorstEmployeePerformance',
        data: [ {!! $top10WorstEmployeePerformance !!} ],
        xkey: 'x',
        ykeys: ['y', 'z'],
        labels: ['Task Point (%)', 'Earned Point (%)'],
        barColors: ['#FF9900', '#E80000'],
        hoverCallback: function (index, options, content, row) {
           return "<a target='_blank' href='"+ employeeDashboard +"/"+ row.username +"'>"+row.x + "</a> <br> Earned: " + row.z+"% out of 100%";
        },
        axes:"y"
    });
    /*Top 10 WORST Employee Performance end*/
});

</script>
@endsection

