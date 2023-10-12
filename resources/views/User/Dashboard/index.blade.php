@extends('Layout.user')
@section('page')

<h1 class="h3 mb-4 text-gray-800">Welcome {{Auth::user()->name}}</h1>

<h4 class="h3 mb-4 text-gray-800">You are on {{ $subdomain }}</h4>

@endsection
