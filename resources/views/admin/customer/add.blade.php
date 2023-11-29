@extends('layouts.main')

@push('page-title')
    <title>{{ __('Add Customer') }}</title>
@endpush

@push('heading')
    {{ __('Add Customer') }}
@endpush

@section('content')
    <x-status-message />

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <form method="post" action="{{ route('customer.store') }}" enctype="multipart/form-data">
                        @csrf
                        <h4 class="card-title mb-3">{{ __('Customer Details') }}</h4>

                        <div class="row">
                            <div class="col-lg-2">
                                <x-form.select name="title" label="Title" chooseFileComment="--Select Title--"
                                    :options="[
                                        'Ms' => 'Ms',
                                        'Mr' => 'Mr',
                                        'Miss' => 'Miss',
                                        'Mrs' => 'Mrs',
                                        'Other' => 'Other',
                                    ]" />
                            </div>
                            <div class="col-lg-5">
                                <x-form.input name="first_name" label="First Name" />
                            </div>

                            <div class="col-lg-5">
                                <x-form.input name="last_name" label="Last Name" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <x-form.input name="email" label="Email Address" />
                            </div>
                            <div class="col-lg-6">
                                <x-form.input name="phone" label="Phone" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <x-form.input name="adhaar_number" label="Adhaar Card Number"/>
                            </div>

                            <div class="col-lg-6">
                                <x-form.input name="pan_number" label="PAN Card Number"/>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <x-form.textarea name="address" label="Address" />
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                               <x-form.input name="city" label="City"/>
                            </div>
                            <div class="col-lg-4">
                                <x-form.input name="state" label="State"/>
                            </div>
                            <div class="col-lg-4">
                                <x-form.input name="zip" label="Postal Code / Zip"/>
                            </div>
                        </div>


                        <div>
                            <button class="btn btn-primary mt-2" type="submit">{{ __('Add Customer') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
@endpush
