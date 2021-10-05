<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('index','show');
    }

    public function index(){
        $blogs=Blog::orderBy('id', 'DESC')->get();
        $categories=Category::all();
        return view('user-site.home')->with('blogs',$blogs)->with('categories',$categories);
    }

    public function create(){
        $blog=new Blog();
        $categories=[];

        foreach ($blog->categories as $category) {
            array_push($categories, $category->name);
        }
        
        return view('user-site.blog.create')->with("blog",$blog)->with('categories',$categories);
    }

    public function show($id){
        $blog=Blog::find($id);
        return view('user-site.blog.show')->with("blog",$blog);
    }

    public function store(Request $request){ 
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:1000'],
            'image'=>['required_if:id,null'],
            'category'=>['required']
        ]); 

        DB::beginTransaction(); 

        try {
            $blog=null;
            if($request->hasFile('image')){ 
                $imageName = time().'.'.$request->image->getClientOriginalExtension();
                $request->image=$imageName;
                $request->file('image')->move(public_path('images'), $imageName);
                $blog=Blog::updateOrCreate(['id'=>$request->id],['title'=>$request->title,'content'=>$request->content,'image'=>$request->image,'user_id'=>Auth::user()->id]);
            }else{
                $blog=Blog::updateOrCreate(['id'=>$request->id],['title'=>$request->title,'content'=>$request->content,'user_id'=>Auth::user()->id]);
            }

            $categories = explode(",", $request->category);

            $entered_cats=[];

            foreach($categories as $category){
                $cat=Category::updateOrCreate(['name'=>$category],['name'=>$category]);
                array_push($entered_cats,$cat->id);
            }

            $blog->categories()->detach();
            $blog->categories()->attach($entered_cats); 

            DB::commit();

            if($blog){
                return redirect()->route("blog.home")->with("message","Blog post saved successfully!");
            }else{
                DB::rollBack();
                return redirect()->back()->with("errorMessage","Error Occurred.Try Again!")->withInput();
            }
            
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with("errorMessage",$e->getMessage())->withInput();
        }
    }

    public function myBlogs(){  
        $myBlogs=Auth::user()->blogs;
        return view('user-site.blog.myblogs')->with('myBlogs',$myBlogs);
    }

    public function edit($id){
        $blog=Blog::find($id);

        $categories=[];

        foreach ($blog->categories as $category) {
            array_push($categories, $category->name);
        }

        return view('user-site.blog.create')->with("blog",$blog)->with("categories",$categories);
    }

    public function delete($id){ 

        DB::beginTransaction(); 

        try {
            $result=Blog::find($id)->delete(); 
            DB::commit();

            if($result){
                return redirect()->route("blogs.myblogs")->with("message","Blog Post deleted successfully!");
            }else{
                DB::rollBack();
                return redirect()->route("blogs.myblogs")->with("error","Error Occurred.Try Again!");
            }
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with("error",$e->getMessage());
        }
       
    }

    //Search using Ajax-Not Completed
    public function search(Request $request, $category){
                
        $blogs=Blog::whereHas('categories', function($q) use($request) {
            $q->where('category_id', "=",$request->get("selected_cat"));
        })->get();

        return response()->json(["blogs"=>$blogs]);
    }
}
