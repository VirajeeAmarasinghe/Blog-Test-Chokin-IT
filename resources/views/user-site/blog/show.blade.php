@extends('user-site.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $blog->title }}</div>
                <div class="card-body">
                    <img src="{{ asset('/images/'.$blog->image.'') }}" class="card-img-top" alt="Blog Image">
                    <div class="card-body">
                        <h5 class="card-title">{{ $blog->title }}</h5>
                        <p class="card-text">{{ $blog->content }}</p>
                        <div>
                            <p class="text-small">Posted by: {{ $blog->user->name }} on {{ \Carbon\Carbon::parse($blog->created_date)->format('d/m/Y H:m') }}</p>
                        </div>
                        <div class="card" id="comment-card">
                            <div class="card-header">Comments</div>
                            @foreach($blog->comments as $comment)
                                <div class="card-body">
                                    <p class="text-small">Commented by: {{ $comment->user->name }} on {{ \Carbon\Carbon::parse($comment->created_date)->format('d/m/Y H:m') }}</p>
                                    <p class="card-text">{{ $comment->comment }}</p>
                                    @if(Auth::user()->id==$comment->user->id)
                                        <i class="far fa-edit" onclick="editComment('{{ $comment->id }}')"></i>
                                        <i class="far fa-trash-alt" onclick="deleteComment('{{ $comment->id }}')"></i>
                                    @endif
                                    <div id="updateCommentDiv-{{ $comment->id }}" style="display:none;">
                                        <form id="commentUpdateForm-{{ $comment->id }}" onsubmit="event.preventDefault();">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $comment->id }}">
                                            <input type="hidden" id="blog-id" name="blog_id" value="{{ $blog->id }}"/>
                                            <div class="form-group">
                                                <label for="comment-box" class="form-label">Edit Comment</label>
                                                <textarea class="form-control" id="comment-box" cols="30" rows="4" name="comment">{{ $comment->comment }}</textarea>
                                                <span class="text-danger" id="comment_error"></span>
                                            </div>
                                            <button type="submit" class="btn btn-primary" onclick="updateComment('{{ $comment->id }}')">Update</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                            @if(Auth::check())
                                <div class="card rounded-0">
                                    <div class="card-header">Add new comment</div>
                                    <div class="card-body">
                                        <form id="commentForm">
                                            @csrf
                                            <input type="hidden" name="id" value="">
                                            <input type="hidden" id="blog-id" name="blog_id" value="{{ $blog->id }}"/>
                                            <div class="form-group">
                                                <label for="comment-box" class="form-label">Comment</label>
                                                <textarea class="form-control" id="comment-box" cols="30" rows="4" name="comment"></textarea>
                                                <span class="text-danger" id="comment_error"></span>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection