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
    <x-design.card heading="Total User" value="#" desc="User"/>
    <x-design.card heading="Total Paid" value="#" desc="User"/>
    <x-design.card heading="Total Pending" value="#" color="primary" desc="Remaining amount to pay"/>
    <x-design.card heading="{{date('F')}} Payout" value="#" color="danger" desc="Remaining Payout"/>
</div>



@endsection
