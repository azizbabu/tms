<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="logo" class="control-label">Logo {!! validation_error($errors->first('logo'),' logo', true) !!}</label> <br>
            <div class="fileinput {{empty($company->logo) ? 'fileinput-new':'fileinput-exists'}}" data-provides="fileinput">
               <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                  <img alt="Company Logo" src="{{ $assets . '/images/avatar/profile.svg' }}">
               </div>
               <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                  @if(!empty($company->logo) && @getimagesize(url($company->logo)))
                    <img src="{{url($company->logo)}}" alt="Employee logo">
                  @endif
               </div>
               <div>
                  <span class="btn btn-default btn-file">
                  <span class="fileinput-new">Select logo</span>
                  <span class="fileinput-exists">Change</span>
                  <input type="file" name="logo" id='logo'>
                  </span>
                  <a href="#" class="btn btn-default btn-remove fileinput-exists" data-dismiss="fileinput">Remove</a>
               </div>
            </div><!-- end fileinput -->
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="title" class="control-label">Title {!! validation_error($errors->first('title'),'title') !!}</label>
            {!! Form::text('title', null, ['class'=>'form-control', 'placeholder' => 'Title']) !!}
        </div>
        <div class="form-group">
            <label for="description" class="control-label">Description </label>
            {!! Form::textarea('description', null, ['class'=>'form-control', 'placeholder' => 'Description', 'size' => '30x3']) !!}
        </div>
        <div class="form-group">
            <label for="contact_person_name" class="control-label">Contact Person Name </label>
            {!! Form::text('contact_person_name', null, ['class'=>'form-control', 'placeholder' => 'Contact Person Name', 'onchange' => 'addFullName();']) !!}
        </div>
        <div class="form-group">
            <label for="contact_person_phone" class="control-label">Contact Person Phone </label>
            {!! Form::text('contact_person_phone', null, ['class'=>'form-control', 'placeholder' => 'Contact Person Phone', 'onchange' => 'addPhone();']) !!}
        </div>
        <div class="form-group">
            <label for="contact_person_email" class="control-label">Contact Person Email </label>
            {!! Form::text('contact_person_email', null, ['class'=>'form-control', 'placeholder' => 'Contact Person Email', 'onchange' => 'addEmail();']) !!}
        </div>
        <div class="form-group">
            <label for="established_year" class="control-label">Established Year </label>
            {!! Form::text('established_year', null, ['class'=>'form-control datepicker', 'placeholder' => 'yyyy-mm-dd']) !!}
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="country" class="control-label">Country {!! validation_error($errors->first('country'),'country') !!}</label>
            {!! Form::select('country', $countries, null, ['class'=>'form-control chosen-select', 'onchange' => 'addBranchCountry();']) !!}
            <em id="country-err"></em>
        </div>
        <div class="form-group">
            <label for="state" class="control-label">State {!! validation_error($errors->first('state'),'state') !!}</label>
            {!! Form::text('state', null, ['class'=>'form-control', 'placeholder' => 'State', 'onchange' => 'addBranchState();']) !!}
        </div>
        <div class="form-group">
            <label for="city" class="control-label">City {!! validation_error($errors->first('city'),'city') !!}</label>
            {!! Form::text('city', null, ['class'=>'form-control', 'placeholder' => 'City', 'onchange' => 'addBranchCity();']) !!}
        </div>
        <div class="form-group">
            <label for="zip" class="control-label">Zip {!! validation_error($errors->first('zip'),'zip') !!}</label>
            {!! Form::text('zip', null, ['class'=>'form-control', 'placeholder' => 'Zip', 'onchange' => 'addBranchZip();']) !!}
        </div>
        <div class="form-group">
            <label for="address" class="control-label">Address {!! validation_error($errors->first('address'),'address') !!}</label>
            {!! Form::textarea('address', null, ['class'=>'form-control', 'placeholder' => 'Address', 'size' => '30x3', 'onchange' => 'addBranchAddress();']) !!}
        </div>
    </div>
</div>


