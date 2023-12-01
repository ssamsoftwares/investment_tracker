@extends('layouts.main')

@push('page-title')
    <title>{{ __('Edit Call Trade') }}</title>
@endpush

@push('heading')
    {{ __('Edit Call Trade - ') }} {{ $callTrade->trade_name }}
@endpush

@push('style')

@endpush

@section('content')
    <x-status-message />

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <form method="post" action="{{ route('callTrades.update', $callTrade->id) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $callTrade->id }}">
                        <h4 class="card-title mb-3">{{ __('Call Trade Details') }}</h4>


                        <div class="row">
                            <div class="col-lg-12">
                                <x-form.input name="trade_name" label="Trade Name" :value="$callTrade->trade_name" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <x-form.input name="amount" label="Amount" :value="$callTrade->amount" />
                            </div>
                            <div class="col-lg-6">
                                <x-form.input name="commission" label="Commission" :value="$callTrade->commission" />
                            </div>
                        </div>

                        <div>
                            <button class="btn btn-primary mt-2" type="submit">{{ __('Update Call Trade') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
@endpush
