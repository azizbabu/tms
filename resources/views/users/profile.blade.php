@extends('layouts.master')

@section('title') User Profile @endsection 

@section('content')

{!! Form::model($user, array('url' => 'users/profile', 'role' => 'form','files' => true, 'id'=>'user-form')) !!}
	<div class="panel panel-default margin-top-20">
		<div class="panel-heading">
			<div class="panel-title">Update Profile Info</div>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-6">
					<h2>Basic Info</h2>
					<div class="form-group">
			            <label for="full_name" class="control-label">Full Name {!! validation_error($errors->first('full_name'),'full_name') !!}</label>
			            {!! Form::text('full_name', old('full_name') ? old('full_name') : ($user->employee ? $user->employee->full_name: ''), ['class'=>'form-control', 'placeholder' => 'Full Name']) !!}
			        </div>
			        <div class="form-group">
			            <label for="fathers_name" class="control-label">Father's Name </label>
			            {!! Form::text('fathers_name', old('fathers_name') ? old('fathers_name') : ($user->employee ? $user->employee->fathers_name: ''), ['class'=>'form-control', 'placeholder' => 'Father\'s Name']) !!}
			        </div>
			        <div class="form-group">
			            <label for="mothers_name" class="control-label">Mother's Name </label>
			            {!! Form::text('mothers_name', old('mothers_name') ? old('mothers_name') : ($user->employee ? $user->employee->mothers_name: ''), ['class'=>'form-control', 'placeholder' => 'Mother\'s Name']) !!}
			        </div>
			        
			        <div class="form-group">
			            <label for="code" class="control-label">Date of Birth </label>
			            {!! Form::text('dob', old('dob') ? old('dob') : ($user->employee ? $user->employee->dob: ''), ['class'=>'form-control datepicker', 'placeholder' => 'yyyy-mm-dd']) !!}
			        </div>
			        <div class="form-group">
			            <label for="religion" class="control-label">Religion </label>
			            {!! Form::text('religion', old('religion') ? old('religion') : ($user->employee ? $user->employee->religion: ''), ['class'=>'form-control', 'placeholder' => 'Religion']) !!}
			        </div>
			        <div class="form-group">
			            <label for="nationality" class="control-label">Nationality </label>
			            {!! Form::text('nationality', old('nationality') ? old('nationality') : ($user->employee ? $user->employee->nationality: ''), ['class'=>'form-control', 'placeholder' => 'Nationality']) !!}
			        </div>
			        <div class="form-group">
			            <label for="nid" class="control-label">National ID </label>
			            {!! Form::text('nid', old('nid') ? old('nid') : ($user->employee ? $user->employee->nid: ''), ['class'=>'form-control', 'placeholder' => 'National ID']) !!}
			        </div>
			        <div class="form-group">
			            <label for="tin" class="control-label">Tin </label>
			            {!! Form::text('tin', old('tin') ? old('tin') : ($user->employee && $user->employee->tin ? $user->employee->tin: ''), ['class'=>'form-control', 'placeholder' => 'Tin']) !!}
			        </div>
			        <div class="form-group">
			        	@php 
			        		$employee = $user->employee 
			        	@endphp
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

		        <div class="col-sm-6">
		        	<h2>Account Info</h2>
		        	<div class="form-group">
			            <label for="username" class="control-label">Username </label>
			            {!! Form::text('username', null, ['class'=>'form-control', 'placeholder' => 'Username', 'disabled']) !!}
			        </div>
			        <div class="form-group">
			            <label for="email" class="control-label">Email </label>
			            {!! Form::email('email', null, ['class'=>'form-control disabled', 'placeholder' => 'Email', 'disabled']) !!}
			        </div>
			        <div class="form-group">
			            <label for="password" class="control-label">Password {!! validation_error($errors->first('password'),'password', true) !!}</label>
			            {!! Form::password('password', ['class'=>'form-control', 'placeholder' => 'Password']) !!}
			        </div>
					<div class="form-group">
			            <label for="password_confirmation" class="control-label">Confirm Password </label>
			            {!! Form::password('password_confirmation', ['class'=>'form-control', 'placeholder' => 'Confirm Password']) !!}
			        </div>
		        </div>
			</div>
		</div>
		<div class="panel-footer">
			{!! Form::hidden('file_remove', false) !!}
			<button class="btn btn-info"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
		</div>
	</div>		
{!! Form::close() !!}

@endsection

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
    (function() {
        {{-- Initialize Datepicker --}}
        $('.datepicker').datepicker({
            autoclose:true,
            format:'yyyy-mm-dd',
        });

        $('.btn-remove').on('click', function() {
	        $('input[name=file_remove]').val(true);
	    });
    })();
</script>
@endsection

