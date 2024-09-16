@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Users List')
@section('content_header_title', 'Admin')
@section('content_header_subtitle', 'Users List')

{{-- Content body: main page content --}}

@section('content_body')

{{-- content here --}}

@stop

{{-- Push extra CSS --}}

@push('css')
{{-- Add here extra stylesheets sms_project/public/css/custom_datatables.css --}}
<link rel="stylesheet" href="/css/custom_datatables.css">
<style>

</style>
@endpush

{{-- Push extra scripts --}}

@push('js')
<script>
    // js scrips here 
</script>
@endpush