@extends('Layout.admin')

@section('page')

@if ($errors->any())
    <div class="alert alert-success" id="alert">
        {{ $errors }}
    </div>
@endif

<div class="card shadow mb-4">
<div class="card-header py-3">Create User</div>
<div class="card-body">
<form id="bookingForm" action="{{route('users.store', $subdomain)}}" method="POST" class="needs-validation" autocomplete="off">
    @csrf
    <div class="form-group">
      <label for="inputName">Name</label>
      <input type="text" class="form-control" id="inputName" name="name" placeholder="Name" required />
    </div>
    <div class="form-group">
      <label for="inputEmail">Email</label>
      <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Enter email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required />
    </div>
    <div class="form-group">
      <label for="inputPhone">Password</label>
      <input type="password" class="form-control" id="inputPhone" name="password" required />
    </div>
    <input type="submit" value="Add" class="btn btn-primary px-4">
</form>
</div>
</div>
@endsection
