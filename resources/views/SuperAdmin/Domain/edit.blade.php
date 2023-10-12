@extends('Layout.dashboard')

@section('page')

@php
    // $domain->users->each(fn($item, $key)=>  dd($item->id))
    // $users[1]->domains->each(fn($item, $key) => dd($item))
@endphp
{{-- @dd($domain->users->each(fn($item, $key)=> return $key)) --}}
@if ($errors->any())
    <div class="alert alert-success" id="alert">
        {{ $errors }}
    </div>
@endif
<div class="card shadow mb-4">
<div class="card-header py-3">Edit Domain</div>
<div class="card-body">
<form id="bookingForm" action="{{route('domains.update', $domain->id)}}" method="POST" class="needs-validation" autocomplete="off">
    @method('PUT')
    @csrf
    <div class="form-group">
      <label for="inputName">Name</label>
      <input type="text" class="form-control" id="inputName" name="domain_name" value="{{ $domain->domain_name }}" required />
    </div>
    <div class="form-group">
      <label for="inputPhone">Select Users To Assign</label>
    <select class="form-control" name="user_id[]" multiple>
        <option selected disabled>Select User</option>
        @foreach ($users as $user)
            <option value="{{$user->id}}" @selected($user->domains->contains('id', $domain->id))>{{$user->name}}</option>
        @endforeach
    </select>
    </div>
    <input type="submit" value="Update" class="btn btn-primary px-4">
</form>
</div>
</div>
@endsection
