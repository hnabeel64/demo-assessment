@extends('Layout.dashboard')

@section('page')

<div class="card shadow mb-4">
<div class="card-header py-3">Create Domain</div>
<div class="card-body">
<form id="bookingForm" action="{{route('domains.store')}}" method="POST" class="needs-validation" autocomplete="off">
    @csrf
    <div class="form-group">
      <label for="inputName">Name</label>
      <input type="text" class="form-control" id="inputName" name="domain_name" placeholder="Name" required />
    </div>
    <div class="form-group">
      <label for="inputPhone">Assign To</label>
      <select class="form-control" name="user_id">
        <option selected disabled>Select User</option>
        @foreach ($users as $user)
            <option value="{{$user->id}}">{{$user->name}}</option>
        @endforeach
    </select>
    </div>
    <input type="submit" value="Add Domain" class="btn btn-primary px-4">
</form>
</div>
</div>
@endsection
