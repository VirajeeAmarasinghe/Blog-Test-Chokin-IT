@extends('user-site.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-4">My Blogs</div>
                        <div class="col-4 offset-4"><a class="btn btn-primary btn-sm" href="{{ route('blogs.create') }}">Add New Blog Post</a></div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Content</th>
                                <th scope="col">Image</th>
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach($myBlogs as $key=>$myBlog)
                                <tr>
                                    <th scope="row">{{ $key+1 }}</th>
                                    <td>{{ $myBlog->title }}</td>
                                    <td>{{ substr($myBlog->content, 0, 100) }}</td>
                                    <td><img src="{{ asset('/images/'.$myBlog->image.'') }}" alt="Blog Image" class="w-100 h-100"></td>
                                    <td style="width: 150px">
                                        <a class="btn btn-success btn-sm" href="{{ route('blogs.edit',['blog'=>$myBlog->id]) }}">Edit</a>
                                        <a class="btn btn-danger btn-sm" href="{{ route('blogs.delete',['blog'=>$myBlog->id]) }}">Delete</a>
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
