<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin.auth');
    }

    public function create(){
        $user=new User();
        $user->id=null;
        $user->name="";
        $user->email="";
        $user->password="";
        $user->role=0;

        return view('admin-site.users.create')->with("user",$user);
    }

    public function index(){
        $users=User::orderBy('id', 'DESC')->get();

        return view('admin-site.home')->with("users",$users);
    }

    public function store(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($request->id)],
            'password' => ['required', 'string', Password::min(8)
            ->mixedCase()->letters()->numbers()->symbols()->uncompromised()],
            'role'=>['required','integer']
        ]);

        DB::beginTransaction(); 

        try {
            $user=User::updateOrCreate(
                ['id'=>$request->id],
                ['name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'role'=>$request->role,
                'email_verified_at'=>Carbon::now()]);
        
            DB::commit();
            if($user){
                return redirect()->route("admin.home")->with("message","User saved successfully!");
            }else{
                DB::rollBack();
                return redirect()->back()->with("error","Error Occurred.Try Again!")->withInput();
            }
        }catch(\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with("error",$e->getMessage())->withInput();
        }

    }

    public function edit($id){ 
        $user=User::find($id);

        return view('admin-site.users.create')->with("user",$user); 
    }

    public function delete($id){ 

        DB::beginTransaction(); 

        try {
            $result=User::find($id)->delete(); 
            DB::commit();

            if($result){
                return redirect()->route("admin.home")->with("message","User deleted successfully!");
            }else{
                DB::rollBack();
                return redirect()->route("admin.home")->with("error","Error Occurred.Try Again!");
            }
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with("error",$e->getMessage());
        }
            
    }
}
