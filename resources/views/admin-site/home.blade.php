@extends('admin-site.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-4">Users</div>
                        <div class="col-4 offset-4"><a class="btn btn-primary btn-sm" href="{{ route('users.create') }}">Add New User</a></div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $key=>$user)
                                <tr>
                                    <th scope="row">{{ $key+1 }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role==1?'Admin':'Normal User' }}</td>
                                    <td>
                                        <a class="btn btn-success btn-sm" href="{{ route('users.edit',['user'=>$user->id]) }}">Edit</a>
                                        <a class="btn btn-danger btn-sm" href="{{ route('users.delete',['user'=>$user->id]) }}">Delete</a>
                                    </td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
