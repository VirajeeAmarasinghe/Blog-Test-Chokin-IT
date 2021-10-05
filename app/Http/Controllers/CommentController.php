<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request){ 
        $request->validate([
            'comment' => ['required', 'string', 'max:255']            
        ]);

        DB::beginTransaction(); 

        $user_id=Auth::user()->id;
        $blog_id=(int)$request->blog_id;

        try {
            $comment=Comment::updateOrCreate(['id'=>$request->id],['comment'=>$request->comment,'user_id'=>$user_id,'blog_id'=>$blog_id]);

            DB::commit();

            if($comment){
                return response()->json(["message"=>"Comment saved successfully!"]);
            }else{
                DB::rollBack();
                return response()->json(['error'=>'Error Occurred.Try Again!']);
            }
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['error'=>'Error Occurred.Try Again!']);
        }
    }

    public function destroy($id){ 

        DB::beginTransaction(); 

        try {
            $result=Comment::find($id)->delete(); 
            DB::commit();

            if($result){
                return response()->json(["message"=>"Comment deleted successfully!"]);
            }else{
                DB::rollBack();
                return response()->json(['error'=>'Error Occurred.Try Again!']);
            }
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['error'=>'Error Occurred.Try Again!']);
        }
       
    }
}
