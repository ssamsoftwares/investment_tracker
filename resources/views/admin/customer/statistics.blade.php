@extends('layouts.main')
@push('page-title')
    <title>{{ 'Customer Statistics Details' }}</title>
@endpush

@push('heading')
    {{ 'Customer Statistics Details : ' }}
@endpush

@push('heading-right')
@endpush

@section('content')
    {{-- Customer details --}}
    <x-status-message />
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('customer.statistics') }}" method="get">
                        <div class="row">
                            <div class="col-3">
                                <x-form.select label="Current Weekly & Monthly Filter" chooseFileComment="All"
                                    name="commition_filter" id="commition_filter" :options="[
                                        'weekly' => 'Weekly',
                                        'monthly' => 'Monthly',
                                    ]" :selected="isset($_REQUEST['commition_filter']) ? $_REQUEST['commition_filter'] : ''" />
                            </div>

                            <div class="col-3">
                                <x-form.input name="from_date" label="From" type="date"
                                    value="{{ isset($_REQUEST['from_date']) ? $_REQUEST['from_date'] : '' }}"

                                    />
                            </div>

                            <div class="col-3">
                                <x-form.input name="to_date" label="To" type="date"
                                    value="{{ isset($_REQUEST['to_date']) ? $_REQUEST['to_date'] : '' }}" />
                            </div>

                            <div class="col-3">
                                <x-form.input name="search" label="Search" type="text" placeholder="Search....."
                                    value="{{ isset($_REQUEST['search']) ? $_REQUEST['search'] : '' }}" />
                            </div>

                            <div class="col-2">
                                <input type="submit" class="btn btn-info mt-lg-4" value="Filter">
                            </div>
                                <div class="col-4 mt-4">
                                    <span>Total Commissions : <b>{{ $totalCommission }}</b></span>
                                </div>

                                <div class="col-lg-4 mt-4">
                                    <span>Total Amount : <b>{{ $totalAmount }}</b></span>
                                </div>
                        </div>
                    </form>
                    <hr>

                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>{{ 'Trade Name' }}</th>
                                <th>{{ 'Amount' }}</th>
                                <th>{{ 'Commission' }}</th>
                                <th>{{ 'Created at' }}</th>
                                <th>{{ 'Status' }}</th>
                                <th>{{ 'Customer List' }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if ($callTrades && count($callTrades) > 0)
                                @foreach ($callTrades as $trade)
                                    <tr>
                                        <td>{{ $trade->trade_name }}</td>
                                        <td>{{ $trade->amount }}</td>
                                        <td>{{ $trade->commission }}</td>
                                        <td> {{ \Carbon\Carbon::parse($trade['created_at'])->format('d-m-Y') }}</td>
                                        <td>
                                            @if ($trade->status == 'unpaid')
                                                <a href="{{ route('callTrades.updateStatus', $trade->id) }}"
                                                    class="btn btn-danger btn-sm">Unpaid</a>
                                            @else
                                                <a href="{{ route('callTrades.updateStatus', $trade->id) }}"
                                                    class="btn btn-primary btn-sm">Paid</a>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('callTrade.view', ['id' => $trade->id]) }}"
                                                class="btn btn-primary waves-effect waves-light view">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                        </td>

                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    {{ $callTrades->onEachSide(5)->links() }}
                </div>
            </div>
        </div> <!-- end col -->
    </div>

    {{-- {{ $callTrades->appends(['search' => request('search'), 'search' => request('search')])->links() }} --}}

@endsection

@push('script')

@endpush
