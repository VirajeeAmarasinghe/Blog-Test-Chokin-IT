@extends('user-site.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-4">Recent Blog Posts</div>
                        <div class="col-3 offset-5">
                            <select class="form-select form-control" aria-label="Default select example" id="select-cat">
                                <option selected value="0">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-body" id="blog-section">
                  
                    <div class="row row-cols-1 row-cols-md-3">
                        @foreach($blogs as $key=>$blog)
                            <div class="col mb-4">
                                <div class="card h-100">
                                    <img src="{{ asset('/images/'.$blog->image.'') }}" class="card-img-top w-100" alt="Blog Image">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $blog->title }}</h5>
                                        <p class="card-text">{{ substr($blog->content, 0, 100) }}</p>
                                        <div><p class="text-small">Posted by: {{ $blog->user->name }} on {{ \Carbon\Carbon::parse($blog->created_date)->format('d/m/Y H:m') }}</p></div>
                                        <div class="mb-2 mt-0">
                                            @foreach ($blog->categories as $category)
                                                <span class="badge badge-success py-1 px-2">{{ $category->name }}</span>
                                            @endforeach
                                        </div>
                                        <a href="{{ route('blogs.show',['blog'=>$blog->id]) }}" class="btn btn-primary">View More</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection