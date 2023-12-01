@extends('layouts.main')

@push('page-title')
    <title>All Call Trade Customer</title>
@endpush

@push('heading')
    {{ 'All Call Trade Customer' }}
@endpush

@section('content')
    @push('style')
        <style>
            .dataTables_filter {
                display: none;
            }
        </style>
    @endpush

    <x-status-message />

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="justify-content-end d-flex">
                    <x-search.table-search action="{{ route('callTrades') }}" method="get" name="search"
                        value="{{ isset($_REQUEST['search']) ? $_REQUEST['search'] : '' }}" btnClass="search_btn" />
                </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>{{ 'Trade Name' }}</th>
                                        <th>{{ 'Amount' }}</th>
                                        <th>{{ 'Commition' }}</th>
                                        <th>{{ 'Status' }}</th>
                                        <th>{{ 'Actions' }}</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($callTrade as $trade)
                                        <tr>

                                            <td>{{ $trade->trade_name }} </td>
                                            <td>{{ $trade->amount }}</td>
                                            <td>{{ $trade->commission }}</td>

                                            <td>
                                                @if ($trade->status == 'unpaid')
                                                <span  class="btn btn-danger btn-sm">Unpaid</span>
                                                @else
                                                    <a href="#" class="btn btn-primary btn-sm">Paid</a>
                                                @endif

                                            </td>

                                            <td>
                                                <div class="action-btns " role="group">
                                                    <a href="{{ route('callTrade.view', ['id' => $trade->id]) }}"
                                                        class="btn btn-primary waves-effect waves-light view">
                                                        <i class="ri-eye-line"></i>
                                                    </a>

                                                    <a href="{{ route('callTrades.edit', ['callTrade' => $trade->id]) }}"
                                                        class="btn btn-info waves-effect waves-light edit">
                                                        <i class="ri-pencil-line"></i>
                                                    </a>
                                                    {{-- <a href="{{ route('callTrades.delete', ['callTrade' => $trade->id]) }}"
                                                        class="btn btn-danger waves-effect waves-light del" onclick="return confirm('Are you sure delete this recode.!')">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </a> --}}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $callTrade->onEachSide(5)->links() }}
                        </div>
                    </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
@push('script')

@endpush
