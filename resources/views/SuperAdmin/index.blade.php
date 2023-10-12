@extends('Layout.dashboard')
@section('page')

<h1 class="h3 mb-4 text-gray-800">Welcome {{Auth::user()->name}}</h1>


@endsection
