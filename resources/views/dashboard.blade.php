@extends('layouts.main')

@push('page-title')
    <title>{{'Dashboard'}}</title>
@endpush

@push('heading')
    {{ 'Dashboard'}}
@endpush

@section('content')

{{-- quick info --}}
<div class="row">
    <x-design.card heading="Total Customer" value="{{$total['customer']}}" desc="Customer" icon="mdi-account-convert"/>
    <x-design.card heading="Total" value="{{$total['activeCustomer']}}" desc="Active Customer" icon="mdi mdi-account-box"  />
    <x-design.card heading="Total Trade" value="{{$total['callTrade']}}" color="primary" desc="Call Trade"/>

</div>


{{-- <div class="row mt-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Pie Chart</h4>

                <div id="pie_chart" class="apex-charts" dir="ltr"></div>
            </div>
        </div>
    </div>

</div> --}}
@endsection
