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
<h4>Attendance sheet</h4>
@endsection

@section('page-content')
@livewire('attendance-log.attendance-sheet-model')
@endsection



@push('css-imports')
<style>
    .in-out-error {
        font-size: 0.875em;
    }
</style>
@endpush