@extends('layouts.master')

@section('title') Company Setup @endsection 

@section('content')

{!! Form::open(array('url' => 'companies', 'role' => 'form','files' => true, 'id'=>'company-form')) !!}
	<div class="panel panel-default margin-top-20">
		<div class="panel-heading">
			<div class="panel-title">Company Setup</div>
		</div>
		<div class="panel-body">
			<div id="rootwizard">
				<ul id="tab-list">
				  	<li><a href="#tab1" data-toggle="tab">Company Info</a></li>
					<li><a href="#tab2" data-toggle="tab">Branch Info</a></li>
					<li><a href="#tab3" data-toggle="tab">Department and Designation Info</a></li>
					<li><a href="#tab4" data-toggle="tab">Employee Info</a></li>
				</ul>
				<div class="tab-content margin-top-20">
				    <div class="tab-pane" id="tab1">
				    	<fieldset>
				    		<legend>Company Info</legend>
				    		@include('companies.form')
				    	</fieldset>
				    </div>

				    {{-- Tab 2 --}}
				    <div class="tab-pane" id="tab2">
				    	<fieldset>
				    		<legend>Branch</legend>
				    		<div class="row">
				    			<div class="col-sm-12"><small class="text-danger">[Please add your branch information. If you don't have any branch, add head office/main office information.]</small></div>
				    		</div>
				    		<div class="row margin-top-20">
				    			<div class="col-md-6">
				    				<div class="form-group">
							            <label for="branch_title" class="control-label">Title {!! validation_error($errors->first('branch_title'),'branch_title') !!}</label>
							            {!! Form::text('branch_title', null, ['class'=>'form-control', 'placeholder' => 'Branch Title']) !!}
							        </div>
							        <div class="form-group">
							            <label for="branch_description" class="control-label"> Description </label>
							            {!! Form::textarea('branch_description', null, ['class'=>'form-control', 'placeholder' => 'Branch Description', 'size' => '30x3']) !!}
							        </div>
							        <div class="form-group">
							            <label for="branch_established_year" class="control-label"> Established Year </label>
							            {!! Form::text('branch_established_year', null, ['class'=>'form-control datepicker', 'placeholder' => 'yyyy-mm-dd']) !!}
							        </div>
				    			</div>
				    			<div class="col-md-6"> 
				    				<div class="form-group">
							            <label for="branch_country" class="control-label">Country {!! validation_error($errors->first('branch_country'),'branch_country') !!}</label>
							            {!! Form::select('branch_country', $countries, null, ['class'=>'form-control chosen-select']) !!}
							            <em id="branch-country-err"></em>
							        </div>
							        <div class="form-group">
							            <label for="branch_state" class="control-label">State {!! validation_error($errors->first('branch_state'),'branch_state') !!}</label>
							            {!! Form::text('branch_state', null, ['class'=>'form-control', 'placeholder' => 'Branch State']) !!}
							        </div>
							        <div class="form-group">
							            <label for="branch_city" class="control-label">City {!! validation_error($errors->first('branch_city'),'branch_city') !!}</label>
							            {!! Form::text('branch_city', null, ['class'=>'form-control', 'placeholder' => 'Branch City']) !!}
							        </div>
							        <div class="form-group">
							            <label for="branch_zip" class="control-label">Zip {!! validation_error($errors->first('branch_zip'),'branch_zip') !!}</label>
							            {!! Form::text('branch_zip', null, ['class'=>'form-control', 'placeholder' => 'Branch Zip']) !!}
							        </div>
							        <div class="form-group">
							            <label for="branch_address" class="control-label">Address {!! validation_error($errors->first('branch_address'),'branch_address') !!}</label>
							            {!! Form::textarea('branch_address', null, ['class'=>'form-control', 'placeholder' => 'Address', 'size' => '30x3']) !!}
							        </div>
				    			</div>
				    		</div>
					    	
				    	</fieldset>
				      	
				    </div>
				    {{-- /Tab 2 --}}

				    {{-- Tab 3 --}}
					<div class="tab-pane" id="tab3">
						<fieldset class="margin-top-20">
				    		<legend>Department and Designation Info</legend>
				    		<div class="row">
				    			<div class="col-sm-6">
				    				<div class="form-group">
						            	<label for="department_title" class="control-label">Department Title {!! validation_error($errors->first('department_title'),'department_title') !!}</label>
						            	{!! Form::text('department_title', null, ['class'=>'form-control', 'placeholder' => 'Department Title']) !!}
							        </div>
				    			</div>
				    			<div class="col-sm-6">
				    				<div class="form-group">
						            	<label for="designation_title" class="control-label">Designation Title {!! validation_error($errors->first('designation_title'),'title') !!}</label>
						            	{!! Form::text('designation_title', null, ['class'=>'form-control', 'placeholder' => 'Designation Title']) !!}
							        </div>
				    			</div>
				    		</div>
				    	</fieldset>
					</div>
					{{-- Tab 3 --}}

				    {{-- Tab 4 --}}
					<div class="tab-pane" id="tab4">
						<fieldset>
							<legend>Employee Info</legend>
							<div class="row">
								<div class="col-sm-12"><small class="text-danger">[Add your company admin details]</small></div>
							</div>
							<div class="row margin-top-20">
								<div class="col-sm-6">
									<div class="form-group">
									    <label for="full_name" class="control-label">Full Name {!! validation_error($errors->first('full_name'),'full_name') !!}</label>
									    {!! Form::text('full_name', null, ['class'=>'form-control', 'placeholder' => 'Full Name']) !!}
									</div>
									<div class="form-group">
							            <label for="phone" class="control-label">Phone {!! validation_error($errors->first('phone'),'phone') !!}</label>
							            {!! Form::text('phone', null, ['class'=>'form-control', 'placeholder' => 'Phone']) !!}
							        </div>
							        <div class="form-group">
					                    <label for="email" class="control-label">Email {!! validation_error($errors->first('email'),'email') !!}</label>
					                    {!! Form::email('email', null, ['class'=>'form-control', 'placeholder' => 'Email']) !!}
					                </div>
					                
								</div>
								<div class="col-sm-6">
									<div class="form-group">
							            <label class="control-label">Gender {!! validation_error($errors->first('gender'),'gender') !!}</label> <br>
							            <label class="radio-inline">
							                {!! Form::radio('gender', 'male', !empty($employee->gender) && $employee->gender=='male' ? true : (old('gender') ? old('gender') : true)) !!} Male
							            </label>
							            <label class="radio-inline">
							                {!! Form::radio('gender', 'female', old('gender')) !!} Female
							            </label>
							            <div><em id="gender-err"></em></div>
							        </div>
							        {{--  
									<div class="form-group">
					                    <label for="role" class="control-label">Role {!! validation_error($errors->first('role'),'role') !!}</label>
					                    {!! Form::select('role', array_except(config('constants.role'),['super-admin']), null, ['class'=>'form-control chosen-select']) !!}
					                    <em id="role-err"></em>
					                </div>
					                --}}
							        <div class="form-group">
					                    <label for="password" class="control-label">Password {!! validation_error($errors->first('password'),'password') !!}</label>
					                    {!! Form::password('password',['class'=>'form-control', 'placeholder' => 'Password']) !!}
					                </div>
								</div>
							</div>
						</fieldset>

						<button class="btn btn-info margin-top-20"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
				    </div>
				    {{-- /Tab 4 --}}
					<ul class="pager wizard">
						<li class="previous first" style="display:none;"><a href="#">First</a></li>
						<li class="previous"><a href="#">Previous</a></li>
						<li class="next last" style="display:none;"><a href="#">Last</a></li>
					  	<li class="next"><a href="#">Next</a></li>
					</ul>
				</div>
			</div>
		</div>
		<!-- <div class="panel-footer hide">
			<button class="btn btn-info"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
		</div> -->
	</div>		
{!! Form::close() !!}

@endsection

@section('custom-style')
{{-- Bootstrap Datepicker --}}
{!! Html::style($assets.'/plugins/datepicker/datepicker3.css') !!}
{{-- Jasny Bootstrap --}}
{!! Html::style($assets. '/plugins/jasny-bootstrap/jasny-bootstrap.min.css') !!}

@endsection

@section('custom-script')
{{-- Bootstrap Datepicker --}}
{!! Html::script($assets. '/plugins/datepicker/bootstrap-datepicker.js') !!}
{{-- Jasny Bootstrap --}}
{!! Html::script($assets. '/plugins/jasny-bootstrap/jasny-bootstrap.min.js') !!}
{{-- jquery Validation --}}
{!! Html::script($assets. '/plugins/jquery-validate/jquery.validate.min.js') !!}
{{-- Jquery Bootstrap Wizard  --}}
{!! Html::script($assets. '/jquery.bootstrap.wizard.min.js') !!}
<script>
function addFullName()
{
	if($('input[name=contact_person_name]').length) {
		var name = $('input[name=contact_person_name]').val();
		$('input[name=full_name]').val(name);
	}
}

function addPhone()
{
	if($('input[name=contact_person_phone]').length) {
		var phone = $('input[name=contact_person_phone]').val();
		$('input[name=phone]').val(phone);
	}
}

function addEmail()
{
	if($('input[name=contact_person_email]').length) {
		var email = $('input[name=contact_person_email]').val();
		$('input[name=email]').val(email);
	}
}

function addBranchCountry()
{
	if($('select[name=branch_country]').length) {
		var companyCountry = $('select[name=country]').val();
		$('select[name=branch_country]').val(companyCountry).trigger('chosen:updated');
	}
}

function addBranchState()
{
	if($('input[name=branch_state]').length) {
		var companyState = $('input[name=state]').val();
		$('input[name=branch_state]').val(companyState);
	}
}

function addBranchCity()
{
	if($('input[name=branch_city]').length) {
		var companyCity = $('input[name=city]').val();
		$('input[name=branch_city]').val(companyCity);
	}
}

function addBranchZip()
{
	if($('input[name=branch_zip]').length) {
		var companyZip = $('input[name=zip]').val();
		$('input[name=branch_zip]').val(companyZip);
	}
}

function addBranchAddress()
{
	if($('textarea[name=branch_address]').length) {
		var companyAddress = $('textarea[name=address]').val();
		$('textarea[name=branch_address]').val(companyAddress);
	}
}

(function() {
    {{-- Initialize Datepicker --}}
    $('.datepicker').datepicker({
        autoclose:true,
        format:'yyyy-mm-dd',
    });

    $('.btn-remove').on('click', function() {
        $('input[name=file_remove]').val(true);
    });

    {{-- Initialize validation --}}
    $.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" }) //for all select having class .chosen-select
    
  	var $validator = $("#company-form").validate({
	  rules: {
	    title: {
	      required: true,
	      minlength: 3,
	      maxlength: 255,
	    },
	    // description: {
	    //   required: true,
	    //   minlength: 3
	    // },
	    country: {
	    	required:true,
	    },
	    state: {
	    	required:true,
	    	maxlength:50,
	    },
	    city: {
	    	required:true,
	    	maxlength:50,
	    },
	    zip: {
	    	required:true,
	    	maxlength:50,
	    },
	    address: {
	    	required:true,
	    	minlength:3,
	    },
	    branch_title: {
	      required: true,
	      minlength: 3,
	      maxlength: 255,
	    },
	    // branch_description: {
	    //   required: true,
	    //   minlength: 3
	    // },
	    branch_country: {
	    	required:true,
	    },
	    branch_state: {
	    	required:true,
	    	maxlength:50,
	    },
	    branch_city: {
	    	required:true,
	    	maxlength:50,
	    },
	    branch_zip: {
	    	required:true,
	    	maxlength:50,
	    },
	    branch_address: {
	    	required:true,
	    	minlength:3,
	    },
	    department_title: {
	    	required:true,
	    	maxlength:255,
	    },
	    designation_title: {
	    	required:true,
	    	maxlength:255,
	    },
	    full_name: {
	    	required:true,
	    	minlength:3,
	    	maxlength:255,
	    },
	    email: {
	    	required:true,
	    	email:true,
	    	minlength:3,
	    	maxlength:255,
	    },
	    password: {
	    	required:true,
	    	minlength:6,
	    	maxlength:255,
	    },
	    // role: {
	    // 	required:true,
	    // },
	    gender: {
	    	required:true,
	    },
	    phone: {
	    	required:true,
	    	minlength:3,
	    	maxlength:50,
	    }
	  },

	  {{-- Do not change code below --}}
        errorPlacement: function(error, element)
        {
            if(element.attr('name') == 'country'){
                $("em#country-err").html( error ).addClass('error');
            }else if(element.attr('name') == 'branch_country'){
                $("em#branch-country-err").html( error ).addClass('error');
            }else if(element.attr('name') == 'role'){
                $("em#role-err").html( error ).addClass('error');
            }else if(element.attr('name') == 'gender'){
                $("em#gender-err").html( error ).addClass('error');
            }else {
                error.insertAfter(element);
            }       
        }
	});

  	var $totalTab = $('#tab-list').find('li').length-1;

  	{{-- Initialize bootstrap wizard --}}
  	$('#rootwizard').bootstrapWizard({
  		'tabClass': 'nav nav-pills',
  		'onNext': function(tab, navigation, index) {
  			var $valid = $("#company-form").valid();
  			console.log($validator);
  			if(!$valid) {
  				$validator.focusInvalid();
  				return false;
  			}
  			if(index >=$totalTab) {
	            $('.panel-footer').removeClass('hide');
	        }else {
	            $('.panel-footer').addClass('hide');
	        }
  		}
  	});
})();
</script>
@endsection

