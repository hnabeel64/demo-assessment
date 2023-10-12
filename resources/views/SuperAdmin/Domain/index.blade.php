@extends('Layout.dashboard')

@section('page')
<div class="card shadow mb-4">
    @if (Session::has('success'))
    <div class="alert alert-success" id="alert">
        {{ Session::get('success') }}
    </div>
    @endif
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Domain CRUD
        <a href="{{route('domains.create')}}" class="btn btn-primary float-right">Add Domains</a></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Created At</th>
                        <th>Assign To</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Created At</th>
                        <th>Assign To</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($domains as $domain)
                    <tr>
                        <td>{{$domain->domain_name}}</td>
                        <td>{{$domain->created_at->diffForHumans()}}</td>
                        <td>
                            @if(isset($domain->users) && !count($domain->users) == 0)
                            @php
                                $userName = '';
                            @endphp
                                @foreach ($domain->users as $user)
                                    @php
                                        $userName .= $user->name.", "
                                    @endphp
                                @endforeach
                            {{ strrev(preg_replace(strrev("/, /"),strrev(''),strrev($userName), 1)) }}
                            @else
                                Not Assigned Yet
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center justify-content-start">
                                <a href="{{route('domains.edit', $domain->id)}}"><i class="fas fa-edit text-primary">  </i></a>
                                <form action="{{ route('domains.destroy', $domain->id) }}" method="POST">@method("DELETE")@csrf<button class="btn" type="submit"><i class="fa fa-trash text-danger"></i></button></form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@push('custom-js')
    <script>
        setTimeout(function(){ $("#alert").hide(); }, 3000);
    </script>
@endpush
