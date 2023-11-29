@extends('layouts.main')

@push('page-title')
    <title>{{ __('Call Trade') }}</title>
@endpush

@push('heading')
    {{ __('Call Trade') }}
@endpush

@section('content')
    <x-status-message />

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <form method="post" action="{{ route('callTrades.storeTrade') }}" enctype="multipart/form-data">
                        @csrf
                        <h4 class="card-title mb-3">{{ __('Call Trade Details') }}</h4>
                        <div class="row">
                            <div class="col-lg-5">
                                <x-form.input name="trade_name" label="Trade Name" />
                            </div>

                            <div class="col-lg-5">
                                <x-form.input name="amount" label="Amount" />
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <div class="card">
                                    <h5 class="card-header">{{ 'Selected  Customers' }}</h5>
                                    <div class="card-body">
                                        {{-- @if (Session::has('selectedCustomers'))
                                        @foreach (Session::get('selectedCustomers') as $customer)
                                            <input type="hidden" name="customer_ids[]" value="{{ $customer->id }}">
                                            <li>{{ $customer->title }} {{ $customer->first_name }} {{ $customer->last_name }}</li>
                                        @endforeach
                                    @endif --}}



                                        {{-- @isset($selectedCustomers) --}}
                                            @if (isset($selectedCustomers) && count($selectedCustomers) > 0)
                                                <ul>
                                                    @foreach ($selectedCustomers as $customer)
                                                        <input type="hidden" name="customer_ids[]" value="{{ $customer->id }}">
                                                        <li>{{ $customer->title }} {{ $customer->first_name }}
                                                            {{ $customer->last_name }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p>No selected customers found.</p>
                                            @endif
                                        {{-- @endisset --}}

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <button class="btn btn-primary mt-2" type="submit">{{ __('Add Call Trade') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
@endpush
