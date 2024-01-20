@extends('../layout/layout')

{{-- @push('sites-leftside-menu')
@foreach ($sites as $site)
<li class="submenu-item ">
    <a href="{{ route('attendance.showlog.persite', ['siteId' => $site->id]) }}">{{
        $site->site_name }}</a>
</li>
@endforeach
@endpush --}}

@section('page-heading')
    <h4>Payroll Management</h4>
@endsection

@section('page-content')
    @livewire('payroll-management.employee-payroll-info')
@endsection



@push('css-imports')
{{-- <style>
    .in-out-error {
        font-size: 0.875em;
    }
</style> --}}
@endpush