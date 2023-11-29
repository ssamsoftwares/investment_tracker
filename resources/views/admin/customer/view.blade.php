@extends('layouts.main')
@push('page-title')
    <title>{{ 'User Details - ' }} {{ $customer->title }} {{ $customer->first_name }} {{ $customer->last_name }}</title>
@endpush

@push('heading')
    {{ 'User Details : ' }} {{ $customer->title }} {{ $customer->first_name }} {{ $customer->last_name }}
@endpush

@push('heading-right')
@endpush

@section('content')
    {{-- User details --}}
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <h5 class="card-header">{{ ' Customer Details' }}</h5>
                <div class="card-body">

                    <h5 class="card-title">
                        <span>Full Name :</span>
                        <span>
                            {{ $customer->title }} {{ $customer->first_name }} {{ $customer->last_name }}
                        </span>
                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>Email :</span>
                        <span>
                           {{ $customer->email}}
                        </span>
                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>Phone:</span>
                        <span>
                            {{ $customer->phone }}
                        </span>
                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>adhaar_number:</span>
                        <span>
                            {{ $customer->adhaar_number }}
                        </span>
                    </h5>
                    <hr>


                    <h5 class="card-title">
                        <span>pan_number:</span>
                        <span>
                            {{ $customer->pan_number }}
                        </span>
                    </h5>
                    <hr>


                    <h5 class="card-title">
                        <span>Address:</span>
                        <span>
                            {{ $customer->address }}, {{ $customer->city }}, {{ $customer->state }}, {{ $customer->zip }}
                        </span>
                    </h5>
                    <hr>
                </div>
            </div>
        </div>
    </div>


    <h4 class="card-title mt-4 mb-4">{{ __('Call Trade Details') }}</h4>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>{{ 'Trade Name' }}</th>
                                <th>{{ 'Amount' }}</th>
                                <th>{{ 'Created at' }}</th>
                                <th>{{ 'Actions' }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if ($callTrades && count($callTrades) > 0)
                                @foreach ($callTrades as $trade)
                                    <tr>
                                        <td>{{ $trade->trade_name }}</td>
                                        <td>{{ $trade->amount }}</td>
                                        <td> {{ \Carbon\Carbon::parse($trade['created_at'])->format('d-m-Y') }}</td>
                                        <td>
                                            <div class="action-btns " role="group">
                                                <a href="{{ route('callTrade.view', ['id' => $trade->id]) }}"
                                                    class="btn btn-primary waves-effect waves-light view">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <p class="text-center">No Call Trade found.</p>
                            @endif
                        </tbody>
                    </table>
                    {{ $callTrades->onEachSide(5)->links() }}

                </div>
            </div>
        </div> <!-- end col -->
    </div>

@endsection
