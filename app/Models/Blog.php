<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable=["title","content","image","user_id"];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function comments(){
        return $this->hasMany(Comment::class,'blog_id','id');
    }

    public function categories(){
        return $this->belongsToMany(Category::class,'blog_category');
    }
}
