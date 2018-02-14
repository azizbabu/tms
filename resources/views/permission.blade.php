@extends('layouts.master')

@section('title') Prmission Setting @endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">Permission Setting for <strong>{{ $employee->full_name}}</strong> | Dept.: <strong>{{ $employee->department->title }}</strong> | Br.: <strong>{{ $employee->branch->title }}</strong> | Role: <strong>{{ config('constants.role.'.$user->role) }}</strong></div>
            </div>
            {!! Form::model($permission, ['url' => Request::url(), 'role'=>'form', 'class' => 'margin-top-20']) !!}
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('branches','Branches') !!} {!! validation_error($errors->first('branch_id'),'branch_id', true) !!}
                            @foreach($branches as $branch_id=>$branch_title)
                                <div class="checkbox">
                                  <label><input type="checkbox" name="branch_id[]" value="{{ $branch_id }}"{{ !empty($permission->branch_ids) && in_array($branch_id, explode(',', $permission->branch_ids)) ? ' checked=checked':'' }}>{{ $branch_title }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('departments','Departments') !!} {!! validation_error($errors->first('department_id'),'department_id', true) !!} 
                            <p><small class="text-danger">If you assign access to any parent department, then all the child departments under this parent will get permission by default. </small></p>
                            {!! $department_list !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-footer">
                <button class="btn btn-info"><i class="fa fa-save"></i> {{ empty($permission->id) ? 'Save': 'Update' }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

@section('custom-style')

@endsection

@section('custom-script')
<script>
    // Selecting Parent automatically selects all Children 
    jQuery('.parent-departments input').on('change', function(event) {
        if(jQuery(this).is(':checked')) {
            jQuery(this).closest('li').find('.child-departments input').prop('checked', true);
        }else {
            jQuery(this).closest('li').find('.child-departments input').prop('checked', false);
        }
    });
</script>
@endsection
