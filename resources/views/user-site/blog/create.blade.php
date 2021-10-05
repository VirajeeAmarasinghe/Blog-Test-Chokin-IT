@extends('user-site.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add New Blog</div>
                <div class="card-body">
                    <form name="create_update_blog_form" id="create-update-blog-form" method="post" action="{{route('blogs.store')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $blog->id }}">
                        <div class="form-group">
                           <label for="title" class="form-label">Title</label>
                           <input type="text" id="title" name="title" class="form-control" value="{{ old('title',$blog->title) }}" required="">
                           @error("title")
                                <span class="text-danger">{{ $message }}</span>
                           @enderror
                        </div>
                        <div class="form-group">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="5" required="">{{ old('content',$blog->content) }}</textarea>
                            @error("content")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                            @error("image")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="cetegory" class="form-label">Categories</label> 
                            <?php 
                                $val="";
                                foreach($blog->categories as $category){
                                    $val.=$category->name.",";
                                }

                            ?>
                            <input type="text" value="{{implode(',', $categories)}}" data-role="tagsinput" name="category" id="category" class="form-control" />
                            @error("category")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                         
                         <button type="submit" class="btn btn-success">Submit</button>
                         <a href="{{ route("blog.home") }}" class="btn btn-primary">Cancel</a>
                       </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection