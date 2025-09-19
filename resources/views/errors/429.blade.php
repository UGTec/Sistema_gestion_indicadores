@extends('errors::illustrated-layout')

@section('code', '429')
@section('title', __('errors-page.Too Many Requests'))

@section('image')
<div style="background-image: url({{ asset('/svg/403.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
</div>
@endsection

@section('message', __('errors-page.Sorry, you are making too many requests to our servers.'))
