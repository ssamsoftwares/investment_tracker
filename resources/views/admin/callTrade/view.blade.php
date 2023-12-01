@extends('layouts.main')
@push('page-title')
    <title>{{ 'Call Trade - ' }} {{ $callTrade->trade_name }}</title>
@endpush

@push('heading')
    {{ 'Call Trade Detail' }}
@endpush

@push('heading-right')
@endpush

@section('content')

    {{-- Call Trade customers details --}}
    <div class="row mt-2">
        <div class="col-lg-8">
            <div class="card">
                <h5 class="card-header">Call Trade Details</h5>
                <div class="card-body">
                    <h5 class="card-title">
                        <span>{{ 'Trade Name' }} : </span>
                        <span>{{ Str::ucfirst($callTrade->trade_name) }}</span>
                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>{{ 'Amount' }} : </span>
                        <span>{{ $callTrade->amount }}</span>
                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>{{ 'Commission' }} : </span>
                        <span>{{ $callTrade->commission }}</span>
                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>{{ 'Status' }} : </span>
                        @if ($callTrade->status == 'unpaid')
                            <span class="btn btn-danger btn-sm">Unpaid</span>
                        @else
                        <span class="btn btn-primary btn-sm">Paid</span>
                        @endif

                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>{{ 'Created at' }} :</span>
                        <span> {{ \Carbon\Carbon::parse($callTrade['created_at'])->format('d-m-Y') }}</span>
                    </h5>
                    <hr>


                </div>
            </div>
        </div>

    </div>



    <h4 class="card-title mt-4 mb-4">{{ __('Call Trade Customer Details') }}</h4>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>{{ 'Name' }}</th>
                                <th>{{ 'Email' }}</th>
                                <th>{{ 'Phone' }}</th>
                                <th>{{ 'City' }}</th>
                                <th>{{ 'Actions' }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if ($customers && count($customers) > 0)
                                @foreach ($customers as $c)
                                    <tr>
                                        <td>{{ $c->title }} {{ $c->first_name }} {{ $c->last_name }}</td>
                                        <td>{{ $c->email }}</td>
                                        <td>{{ $c->phone }}</td>
                                        <td>{{ $c->city }}</td>
                                        <td>
                                            <div class="action-btns " role="group">
                                                <a href="{{ route('customer.view', ['customer' => $c->id]) }}"
                                                    class="btn btn-primary waves-effect waves-light view">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <p class="text-center">No customers found.</p>
                            @endif
                        </tbody>
                    </table>
                    {{ $customers->onEachSide(5)->links() }}

                </div>
            </div>
        </div> <!-- end col -->
    </div>

@endsection
