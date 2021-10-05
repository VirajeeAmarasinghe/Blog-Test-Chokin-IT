@extends('admin-site.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add New User</div>
                <div class="card-body">
                    <form name="create_update_user_form" id="create-update-user-form" method="post" action="{{route('users.store')}}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <div class="form-group">
                           <label for="name">Name</label>
                           <input type="text" id="name" name="name" class="form-control" value="{{ old('name',$user->name) }}">
                           @error("name")
                                <span class="text-danger">{{ $message }}</span>
                           @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email',$user->email) }}">
                            @error("email")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                         </div>
                         <div class="form-group">
                            <label for="email">Password</label>
                            <input type="password" id="password" name="password" class="form-control" value="{{ old('password',$user->password) }}">
                            @error("password")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                         </div>
                         <div class="form-group">
                            <label for="role-select">Role</label>
                            <select class="form-select form-select-sm form-control" aria-label=".form-select-sm example" id="role" name="role">
                                <option>Select Role</option>
                                <option value="0" {{ (old('role')==0 || $user->role==0) ? "selected" : "" }}>Normal User</option>
                                <option value="1" {{ (old('role')==1 || $user->role==1) ? "selected" : "" }}>Admin</option>
                            </select>
                            @error("role_select")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                         </div>
                         
                         <button type="submit" class="btn btn-success">Submit</button>
                         <a href="{{ route("admin.home") }}" class="btn btn-primary">Cancel</a>
                       </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection