@extends('layouts.main')

@push('page-title')
    <title>All Customers</title>
@endpush

@push('heading')
    {{ 'Customers' }}
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
                    <x-search.table-search action="{{ route('customers') }}" method="get" name="search"
                        value="{{ isset($_REQUEST['search']) ? $_REQUEST['search'] : '' }}" btnClass="search_btn" />
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>{{ 'Name' }}</th>
                                    <th>{{ 'Email' }}</th>
                                    <th>{{ 'Phone' }}</th>
                                    <th>{{ 'City' }}</th>
                                    <th>{{ 'Status' }}</th>
                                    <th>{{ 'Actions' }}</th>

                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($customer as $c)
                                    <tr>
                                        <td>{{ $c->title }} {{ $c->first_name }} {{ $c->last_name }}</td>
                                        <td>{{ $c->email }}</td>
                                        <td>{{ $c->phone }}</td>
                                        <td>{{ $c->city }}</td>
                                        <td>
                                            @if ($c->status == 'inactive')
                                                <a href="{{ route('customer.updateStatus', $c->id) }}"
                                                    class="btn btn-danger btn-sm">Inactive</a>
                                            @else
                                                <a href="{{ route('customer.updateStatus', $c->id) }}" class="btn btn-primary btn-sm">Active</a>
                                            @endif

                                        </td>
                                        <td>
                                            <div class="action-btns " role="group">
                                                <a href="{{ route('customer.view', ['customer' => $c->id]) }}"
                                                    class="btn btn-primary waves-effect waves-light view">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <a href="{{ route('customer.edit', ['customer' => $c->id]) }}"
                                                    class="btn btn-info waves-effect waves-light edit">
                                                    <i class="ri-pencil-line"></i>
                                                </a>

                                                {{-- <a href="{{ route('customer.delete', ['customer' => $c->id]) }}"
                                                    class="btn btn-danger waves-effect waves-light del" onclick="return confirm('Are you sure delete this recode.!')">
                                                    <i class="ri-delete-bin-line"></i>
                                                </a> --}}

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $customer->onEachSide(5)->links() }}
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
