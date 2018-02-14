{{-- Personal Info --}}
<fieldset id="personal-info">
    <legend>Personal Information</legend>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="full_name" class="control-label">Full Name {!! validation_error($errors->first('full_name'),'full_name') !!}</label>
                {!! Form::text('full_name', null, ['class'=>'form-control', 'placeholder' => 'Full Name']) !!}
            </div>
            <div class="form-group">
                <label for="fathers_name" class="control-label">Father's Name </label>
                {!! Form::text('fathers_name', null, ['class'=>'form-control', 'placeholder' => 'Father\'s Name']) !!}
            </div>
            <div class="form-group">
                <label for="mothers_name" class="control-label">Mother's Name </label>
                {!! Form::text('mothers_name', null, ['class'=>'form-control', 'placeholder' => 'Mother\'s Name']) !!}
            </div>
            <div class="form-group">
                <label for="code" class="control-label">Date of Birth </label>
                {!! Form::text('dob', null, ['class'=>'form-control datepicker', 'placeholder' => 'yyyy-mm-dd']) !!}
            </div>
            <div class="form-group">
                <label for="religion" class="control-label">Religion </label>
                {!! Form::text('religion', null, ['class'=>'form-control', 'placeholder' => 'Religion']) !!}
            </div>
            <div class="form-group">
                <label class="control-label">Gender {!! validation_error($errors->first('gender'),'gender') !!}</label> <br>
                <label class="radio-inline">
                    {!! Form::radio('gender', 'male', !empty($employee->gender) && $employee->gender=='male' ? true : (old('gender') ? old('gender') : true)) !!} Male
                </label>
                <label class="radio-inline">
                    {!! Form::radio('gender', 'female', old('gender')) !!} Female
                </label>
            </div>
            <div class="form-group">
                <label for="passport_no" class="control-label">Passport No </label>
                {!! Form::text('passport_no', null, ['class'=>'form-control', 'placeholder' => 'Passport No']) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="nationality" class="control-label">Nationality </label>
                {!! Form::text('nationality', null, ['class'=>'form-control', 'placeholder' => 'Nationality']) !!}
            </div>
            <div class="form-group">
                <label for="nid" class="control-label">National ID</label>
                {!! Form::text('nid', null, ['class'=>'form-control', 'placeholder' => 'National ID']) !!}
            </div>
            <div class="form-group">
                <label for="blood_group" class="control-label">Blood Group </label>
                {!! Form::text('blood_group', null, ['class'=>'form-control', 'placeholder' => 'Blood Group']) !!}
            </div>
            <div class="form-group">
                <label for="tin" class="control-label">Tin </label>
                {!! Form::text('tin', null, ['class'=>'form-control', 'placeholder' => 'Tin']) !!}
            </div>
            <div class="form-group">
                <label for="photo" class="control-label">Photo {!! validation_error($errors->first('photo'),' photo', true) !!}</label> <br>
                <div class="fileinput {{empty($employee->photo) ? 'fileinput-new':'fileinput-exists'}}" data-provides="fileinput">
                   <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                      <img alt="Employee photo" src="{{ $assets . '/images/avatar/profile.svg' }}">
                   </div>
                   <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                      @if(!empty($employee->photo))
                      <img src="{{url($employee->photo)}}" alt="Employee photo">
                      @endif
                   </div>
                   <div>
                      <span class="btn btn-default btn-file">
                      <span class="fileinput-new">Select photo</span>
                      <span class="fileinput-exists">Change</span>
                      <input type="file" name="photo" id='photo'>
                      </span>
                      <a href="#" class="btn btn-default btn-remove fileinput-exists" data-dismiss="fileinput">Remove</a>
                   </div>
                </div><!-- end fileinput -->
            </div>
        </div>
    </div>
</fieldset>
{{-- /Personal Info --}}

{{-- Professional Info --}}
<fieldset id="professional-info">
    <legend>Professional Information</legend>
    <div class="row">
        <div class="col-sm-6">
            @if(isSuperAdmin())
                <div class="form-group">
                    <label for="company_id" class="control-label">Company {!! validation_error($errors->first('company_id'),'company_id') !!}</label>
                    {!! Form::select('company_id', $companies, null, ['class'=>'form-control chosen-select' ,'onchange' => 'loadBranches();']) !!}
                </div>
            @endif

            @if(isSuperAdminOrAdmin())
                <div class="form-group">
                    <label for="branch_id" class="control-label">Branch {!! validation_error($errors->first('branch_id'),'branch_id') !!}</label>
                    {!! Form::select('branch_id', [], null, ['class'=>'form-control chosen-select', 'placeholder' => 'Select a Branch', 'onchange'=>'loadDepartments();', 'disabled']) !!}
                </div>
                <div class="form-group">
                    <label for="department_id" class="control-label">Department {!! validation_error($errors->first('department_id'),'department_id') !!}</label>
                    {!! Form::select('department_id', [], null, ['class'=>'form-control chosen-select', 'placeholder' => 'Select a Department', 'disabled']) !!}
                </div>
            @endif

            <div class="form-group">
                <label for="designation_id" class="control-label">Designation {!! validation_error($errors->first('designation_id'),'designation_id') !!}</label>
                {!! Form::select('designation_id', [], null, ['class'=>'form-control chosen-select', 'placeholder' => 'Select a Designation', 'disabled']) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="reporting_boss" class="control-label">Reporting Boss </label>
                {!! Form::select('reporting_boss', [], null, ['class'=>'form-control chosen-select', 'disabled' => 'disabled']) !!}
            </div>
            <div class="form-group">
                <label for="code" class="control-label">Code </label>
                {!! Form::text('code', null, ['class'=>'form-control', 'placeholder' => 'Code']) !!}
            </div>
            <div class="form-group">
                <label for="joining_date" class="control-label">Joining Date </label>
                {!! Form::text('joining_date', null, ['class'=>'form-control datepicker', 'placeholder' => 'yyyy-mm-dd']) !!}
            </div>
        </div>
    </div>
</fieldset>
{{-- /Professional Info --}}

{{-- Contact Info --}}
<fieldset id="contact-info">
    <legend>Contact Information</legend>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="phone" class="control-label">Phone {!! validation_error($errors->first('phone'),'phone') !!}</label>
                {!! Form::text('phone', null, ['class'=>'form-control', 'placeholder' => 'Phone']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="present_address" class="control-label">Present Address </label>
                {!! Form::textarea('present_address', null, ['class'=>'form-control', 'placeholder' => 'Present Address', 'size' => '30x3']) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="permanent_address" class="control-label">Permanent Address </label>
                {!! Form::textarea('permanent_address', null, ['class'=>'form-control', 'placeholder' => 'Permanent Address', 'size' => '30x3']) !!}
            </div>
        </div>
    </div>
</fieldset>
{{-- Contact Info --}}

@if(empty($employee) || (!empty($employee) && !$employee->user))
{{-- Login info --}}
<fieldset id="login-info">
    <legend>Login Information</legend>
    <div class="row">
        <div class="col-sm-6">
            <div class="web-access-wrapper">
                <div class="form-group">
                    <label>{!! Form::checkbox('enable_web_access', 1, null,['onclick' => 'openUserInfoSection();']) !!} Enable Web Access</label>
                </div>
                <div class="user-info hide">
                    <div class="form-group">
                        <label for="email" class="control-label">Email {!! validation_error($errors->first('email'),'email') !!}</label>
                        {!! Form::email('email', null, ['class'=>'form-control', 'placeholder' => 'Email']) !!}
                    </div>
                    <div class="form-group">
                        <label for="password" class="control-label">Password {!! validation_error($errors->first('password'),'password') !!}</label>
                        {!! Form::password('password',['class'=>'form-control', 'placeholder' => 'Password']) !!}
                    </div>
                    @if(isSuperAdminOrAdmin())
                        <div class="form-group">
                            <label for="role" class="control-label">Role {!! validation_error($errors->first('role'),'role') !!}</label>
                        @if(isSuperAdmin())
                            {!! Form::select('role', array_except(config('constants.role'),['super-admin']), null, ['class'=>'form-control chosen-select', 'placeholder' => 'Select a Role']) !!}
                        @elseif(isAdmin())
                            {!! Form::select('role', array_except(config('constants.role'),['super-admin', 'admin']), null, ['class'=>'form-control chosen-select', 'placeholder' => 'Select a Role']) !!}
                        @endif
                        </div>
                    @endif
                </div>
            </div>
            

            {{--  
            <div class="form-group">
                <label for="task_id" class="control-label">Task Assign</label>
                {!! Form::select('task_id[]', $tasks, null, ['class'=>'form-control chosen-select', 'data-placeholder' => 'Choose some tasks', 'multiple']) !!}
            </div>   
            --}}
        </div>
    </div>
</fieldset>
{{-- /Login info --}}
@endif

@section('custom-style')
{{-- Bootstrap Datepicker --}}
{!! Html::style($assets . '/plugins/datepicker/datepicker3.css') !!}
{{-- Jasny Bootstrap --}}
{!! Html::style($assets . '/plugins/jasny-bootstrap/jasny-bootstrap.min.css') !!}
@endsection

@section('custom-script')
{{-- Bootstrap Datepicker --}}
{!! Html::script($assets . '/plugins/datepicker/bootstrap-datepicker.js') !!}
{!! Html::script($assets . '/plugins/jasny-bootstrap/jasny-bootstrap.min.js') !!}
<script>
function openUserInfoSection()
{
    if($('input[name=enable_web_access]').is(':checked')) {
        $('.user-info').removeClass('hide');
    }else {
        $('.user-info').addClass('hide');
    }
}

function loadBranches(employeeId=null)
{
    $('select[name=department_id]').html('<option>Select a department</option>').prop('disabled', true).trigger("chosen:updated");
    $('select[name=designation_id]').html('<option>Select a designation</option>').prop('disabled', true).trigger("chosen:updated");
    @if(isSuperAdmin())
    var companyId = $('select[name=company_id]').val();
    @else
    var companyId = "{{ \Auth::user()->company_id }}";
    @endif
    if(companyId) {
        $('#ajaxloader').removeClass('hide');
        $.ajax({
            url:"{{ url('employees/branches') }}/"+companyId+(employeeId ? '/'+employeeId : ''),
            dataType:'JSON',
            success:function(data) {
                $('select[name=branch_id]').html(data.branch_options).prop('disabled', false).trigger("chosen:updated");
                $('select[name=reporting_boss]').html(data.reporting_boss_options).prop('disabled', false).trigger("chosen:updated");
            },
            complete:function() {
                $('#ajaxloader').addClass('hide');
            },
            error:function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + ' ' + thrownError);
            }
        });
    }else {
        $('select[name=branch_id]').html('<option>Select a branch</option>').prop('disabled', true).trigger("chosen:updated");
        $('select[name=reporting_boss]').html('<option>Select a Employee</option>').prop('disabled', true).trigger("chosen:updated");
    }
}

function loadDepartments(employeeId=null, branchId=null)
{
    if(!branchId) {
        branchId = $('select[name=branch_id]').val();
    }
    
    if(branchId) {
        $('#ajaxloader').removeClass('hide');
        $.ajax({
            url:"{{ url('employees/departments') }}/"+branchId+(employeeId ? '/'+employeeId : ''),
            dataType:'JSON',
            success:function(data) {
                $('select[name=department_id]').html(data.department_options).prop('disabled', false).trigger("chosen:updated");

                $('select[name=designation_id]').html(data.designation_options).prop('disabled', false).trigger("chosen:updated");
            },
            complete:function() {
                $('#ajaxloader').addClass('hide');
            },
            error:function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + ' ' + thrownError);
            }
        });
    }else {
        $('select[name=department_id]').html('<option>Select a department</option>').prop('disabled', true).trigger("chosen:updated");

        $('select[name=designation_id]').html('<option>Select a designation</option>').prop('disabled', true).trigger("chosen:updated");
    }
}

(function() {
    {{-- Initialize Datepicker --}}
    $('.datepicker').datepicker({
        autoclose:true,
        format:'yyyy-mm-dd',
    });
    {{-- Initialize Chosen --}}
    // $('select').chosen();
    $('.btn-remove').on('click', function() {
        $('input[name=file_remove]').val(true);
    });

    @if(old('enable_web_access'))
        openUserInfoSection();
    @endif

    @if(!empty($employee))
        var employeeId = {{ $employee->id }};
    @else
        var employeeId = null;
    @endif
    
    @if(old('branch_id'))
        branchId = {{ old('branch_id') }};
    @elseif(!empty($employee))
        branchId = {{ $employee->branch_id }};
    @elseif(isDepartmentAdmin())
        branchId = {{ Auth::user()->branch_id }};
    @else
        branchId = null;
    @endif

    @if(isSuperAdmin())
    var companyId = $('select[name=company_id]').val();
    @else
    var companyId = "{{ Auth::user()->company_id }}";
    @endif
    if(companyId) {
        loadBranches(employeeId);
        loadDepartments(employeeId, branchId);
    }
})();

</script>
@endsection

