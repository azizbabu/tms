<div class="row">
    <div class="col-sm-6">
        @if(isSuperAdmin())
        <div class="form-group">
            <label for="company_id" class="control-label">Company {!! validation_error($errors->first('company_id'),'company_id') !!}</label>
            {!! Form::select('company_id', $companies, null, ['class'=>'form-control chosen-select']) !!}
        </div>
        @endif
        <div class="form-group">
            <label for="title" class="control-label">Title {!! validation_error($errors->first('title'),'title') !!}</label>
            {!! Form::text('title', null, ['class'=>'form-control', 'placeholder' => 'Title']) !!}
        </div>
        <div class="form-group">
            <label for="description" class="control-label">Description {!! validation_error($errors->first('description'),'description') !!}</label>
            {!! Form::textarea('description', null, ['class'=>'form-control', 'placeholder' => 'Description', 'size' => '30x3']) !!}
        </div>
        <div class="form-group">
            <label for="contact_person_name" class="control-label">Contact Person Name </label>
            {!! Form::text('contact_person_name', null, ['class'=>'form-control', 'placeholder' => 'Contact Person Name']) !!}
        </div>
        <div class="form-group">
            <label for="contact_person_phone" class="control-label">Contact Person Phone </label>
            {!! Form::text('contact_person_phone', null, ['class'=>'form-control', 'placeholder' => 'Contact Person Phone']) !!}
        </div>
        <div class="form-group">
            <label for="contact_person_email" class="control-label">Contact Person Email </label>
            {!! Form::text('contact_person_email', null, ['class'=>'form-control', 'placeholder' => 'Contact Person Email']) !!}
        </div>
        <div class="form-group">
            <label for="established_year" class="control-label">Established Year {!! validation_error($errors->first('established_year'),'established_year', true) !!}</label>
            {!! Form::text('established_year', null, ['class'=>'form-control datepicker', 'placeholder' => 'yyyy-mm-dd']) !!}
        </div>
        
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="country" class="control-label">Country {!! validation_error($errors->first('country'),'country') !!}</label>
            {!! Form::select('country', $countries, old('country') ? old('country') : (!empty($branch->country) ? $branch->country : Auth::user()->company->country), ['class'=>'form-control chosen-select']) !!}
        </div>
        <div class="form-group">
            <label for="state" class="control-label">State {!! validation_error($errors->first('state'),'state') !!}</label>
            {!! Form::text('state', null, ['class'=>'form-control', 'placeholder' => 'State']) !!}
        </div>
        <div class="form-group">
            <label for="city" class="control-label">City {!! validation_error($errors->first('city'),'city') !!}</label>
            {!! Form::text('city', null, ['class'=>'form-control', 'placeholder' => 'City']) !!}
        </div>
        <div class="form-group">
            <label for="zip" class="control-label">Zip {!! validation_error($errors->first('zip'),'zip') !!}</label>
            {!! Form::text('zip', null, ['class'=>'form-control', 'placeholder' => 'Zip']) !!}
        </div>
        <div class="form-group">
            <label for="address" class="control-label">Address {!! validation_error($errors->first('address'),'address') !!}</label>
            {!! Form::textarea('address', null, ['class'=>'form-control', 'placeholder' => 'Address', 'size' => '30x3']) !!}
        </div>
        
    </div>
</div>

@section('custom-style')
{{-- Bootstrap Datepicker --}}
{!! Html::style($assets .'/plugins/datepicker/datepicker3.css') !!}
@endsection

@section('custom-script')
{{-- Bootstrap Datepicker --}}
{!! Html::script($assets .'/plugins/datepicker/bootstrap-datepicker.js') !!}
<script>
(function() {
    {{-- Initialize Datepicker --}}
    $('.datepicker').datepicker({
        autoclose:true,
        format:'yyyy-mm-dd',
    });
})();
</script>
@endsection

