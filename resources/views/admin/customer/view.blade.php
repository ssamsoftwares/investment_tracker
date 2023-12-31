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
    <x-status-message />
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
                            {{ $customer->email }}
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
                        <span>Adhaar Number:</span>
                        <span>
                            {{ $customer->adhaar_number }}
                        </span>
                    </h5>
                    <hr>


                    <h5 class="card-title">
                        <span>Pan Number:</span>
                        <span>
                            {{ $customer->pan_number }}
                        </span>
                    </h5>
                    <hr>

                    <h5 class="card-title">
                        <span>Address:</span>
                        <span>
                            {{ $customer->address }}, {{ $customer->city }}, {{ $customer->state }},
                            {{ $customer->zip }}
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


                    <div class="row container mt-4 mb-4" style="display:flex; justify-content: space-between;">

                        <div class="col-lg-5 mx-1">
                            <x-form.select label="Current Weekly & Monthly Filter" chooseFileComment="All"
                                name="commition_filter" id="commition_filter" :options="[
                                    'weekly' => 'Weekly',
                                    'monthly' => 'Monthly',
                                ]" :selected="request('commition_filter')" />
                        </div>
                    </div>

                    <div class="row container mt-4 mb-4" style="display:flex; justify-content: space-between;">
                        <form action="{{ route('customer.view', ['customer' => $customer]) }}" method="get">
                            {{-- @csrf --}}
                            <div class="row">
                                <strong class="m-2 text-primary">Select Date Filter Commitions</strong>
                                <input type="hidden" id="cust_id" value="{{ $customer->id }}">
                                <div class="col-lg-4 mx-1">
                                    <x-form.input name="from_date" label="From" type="date"
                                        value="{{ request('from_date') }}" />
                                </div>

                                <div class="col-lg-4 mx-1">
                                    <x-form.input name="to_date" label="To" type="date"
                                        value="{{ request('to_date') }}" />
                                </div>

                                <div class="col-lg-2 mx-1">
                                    <input type="submit" class="btn btn-info mt-lg-4" value="Filter">
                                </div>
                            </div>
                        </form>

                        <div class="row">
                            <div class="col-lg-3">
                                <x-form.input name="total_amount" label="Total Amount" value="{{ $totalAmount }}"
                                    readonly />
                            </div>

                            <div class="col-lg-4">
                                <x-form.input name="total_commission" label="Total Commissions"
                                    value="{{ $totalCommission }}" readonly />
                            </div>

                            <div class="col-lg-5 mt-1 mr-3" style="justify-content: end">
                                <x-search.table-search action="{{ route('customer.view', ['customer' => $customer]) }}"
                                    method="get" name="search"
                                    value="{{ isset($_REQUEST['search']) ? $_REQUEST['search'] : '' }}"
                                    btnClass="search_btn" catVal="{{ request('commition_filter') }}" roleName="commition_filter" />
                            </div>
                        </div>
                    </div>


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

@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#commition_filter').on("change", function() {
                let filterData = $(this).val();
                let url = "{{ route('customer.view', ['customer' => $customer]) }}";

                let searchParams = new URLSearchParams(window.location.search);
                searchParams.set('commition_filter', filterData);

                if (filterData === 'weekly') {
                    console.log('Weekly filter selected');
                } else if (filterData === 'monthly') {
                    console.log('Monthly filter selected');
                }

                window.location.href = `${url}?${searchParams.toString()}`;
            });
        });
    </script>



@endpush
