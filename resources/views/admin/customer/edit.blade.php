@extends('layouts.main')

@push('page-title')
    <title>{{ __('Edit Customer') }}</title>
@endpush

@push('heading')
    {{ __('Edit Customer - ') }} {{ $customer->title }} {{ $customer->first_name }} {{ $customer->last_name }}
@endpush

@push('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        input[switch]+label:after {

            left: -22px;
            margin-left: 25px;

        }

        input[switch]+label {
            width: 80px !important;
        }
    </style>
@endpush

@section('content')
    <x-status-message />

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <form method="post" action="{{ route('customer.update', $customer->id) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $customer->id }}">
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
                                    ]" :selected="$customer->title" />
                            </div>
                            <div class="col-lg-5">
                                <x-form.input name="first_name" label="First Name" :value="$customer->first_name" />
                            </div>

                            <div class="col-lg-5">
                                <x-form.input name="last_name" label="Last Name" :value="$customer->last_name" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <x-form.input name="email" label="Email Address" :value="$customer->email" />
                            </div>
                            <div class="col-lg-6">
                                <x-form.input name="phone" label="Phone" :value="$customer->phone" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <x-form.input name="adhaar_number" label="Adhaar Card Number" :value="$customer->adhaar_number"/>
                            </div>

                            <div class="col-lg-6">
                                <x-form.input name="pan_number" label="PAN Card Number" :value="$customer->pan_number"/>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <x-form.textarea name="address" label="Address" :value="$customer->address" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                               <x-form.input name="city" label="City" :value="$customer->city" />
                            </div>
                            <div class="col-lg-4">
                                <x-form.input name="state" label="State" :value="$customer->state" />
                            </div>
                            <div class="col-lg-4">
                                <x-form.input name="zip" label="Postal Code / Zip" :value="$customer->zip" />
                            </div>
                        </div>


                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <label for="status">Status</label>
                                <div class="status switch-container">
                                    <input type="checkbox" id="status" name="status" switch="bool" value="active"
                                        {{ $customer->status === 'active' ? 'checked' : '' }} style="width:100px;">
                                    <label for="status" data-on-label="active" data-off-label="inactive"></label>
                                </div>
                            </div>
                        </div>



                        <div>
                            <button class="btn btn-primary mt-2" type="submit">{{ __('Update Customer') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
@endpush
