@extends('layouts.main')

@push('page-title')
    <title>All Active Customers</title>
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
                    <x-search.table-search action="{{ route('customer.activeCustomers') }}" method="get" name="search"
                        value="{{ isset($_REQUEST['search']) ? $_REQUEST['search'] : '' }}" btnClass="search_btn" />
                </div>

                <form method="post" action="{{route('callTrades.nextBtn')}}">
                    @csrf
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" class="form-check-input" id="selectAll">
                                        </th>
                                        <th>{{ 'Name' }}</th>
                                        <th>{{ 'Email' }}</th>
                                        <th>{{ 'Phone' }}</th>
                                        <th>{{ 'City' }}</th>
                                        <th>{{ 'Actions' }}</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($activeCustomers as $active_cust)
                                        <tr>
                                            <th>
                                                <input type="checkbox" class="form-check-input" name="selected_customers[]"
                                                    value="{{ $active_cust->id }}">
                                            </th>

                                            <td>{{ $active_cust->title }} {{ $active_cust->first_name }}
                                                {{ $active_cust->last_name }}</td>
                                            <td>{{ $active_cust->email }}</td>
                                            <td>{{ $active_cust->phone }}</td>
                                            <td>{{ $active_cust->city }}</td>

                                            <td>
                                                <div class="action-btns " role="group">
                                                    <a href="{{ route('customer.view', ['customer' => $active_cust->id]) }}"
                                                        class="btn btn-primary waves-effect waves-light view">
                                                        <i class="ri-eye-line"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $activeCustomers->onEachSide(5)->links() }}
                        </div>
                    </div>
                    <div class="next-btn m-4">
                        <button type="submit" id="callTrade" class="btn btn-info">{{ 'Next' }}</button>
                    </div>
                </form>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
@push('script')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#callTrade').on('click', function(e) {
                if ($('input[name="selected_customers[]"]:checked').length === 0) {
                    e.preventDefault();
                    alert('Please select at least one customer.');
                }
            });
            $('#selectAll').on('change', function() {
                $('input[name="selected_customers[]"]').prop('checked', $(this).prop('checked'));
            });
        });
    </script>

    <!-- Rest of your HTML code -->
@endpush
