<?php
/**
 * Created by PhpStorm.
 * User: nakama
 * Date: 11/02/18
 * Time: 23:33
 */

namespace App\Http\Controllers;

use App\Models\RoleAccess;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Exception;
use PhpParser\Node\Expr\New_;
use Session;

class AuthController extends Controller
{
    public function redir()
    {
        if (Auth::user() == null){
            return redirect("/login");
        }
        $role = Auth::user()->role_id;

        switch ($role) {
            case 1 : return redirect("/designer/insert"); break;
            case 2 : return redirect("/kasir/data"); break;
            case 3 : return redirect("/operator/data"); break;
            case 4 : return redirect("/user/list"); break;
        }
    }

    public function profile($id)
    {
        $user = User::where(["id"=>$id])->first();
        $positions = RoleAccess::get();
        return view('auth.profile', ["user"=>$user, 'positions'=>$positions]);
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'id'             => "required",
            'name'           => "required",
            'email'          => "required",
            "password"       => "required"
        ]);
        $id         = $request->input("id");
        $name       = $request->input("name");
        $email      = $request->input("email");
        $password   = $request->input("password");
        $repassword = $request->input("re-password");
        $photo      = $request->file("photo");

        if ($password != $repassword){
            Session::flash('message_profile_update_error','Password Tidak Sama');
            return redirect("/profile/".$id);
        }
        $fileName = User::where(["id" => $id])->first()->image;
        if ($photo) {
            $fileName = $this->saveImage($photo);
        }

        try {
            $user = User::where(["id" => $id]);
            $user->update([
                    "name" => $name,
                    "email" => $email,
                    "password" => bcrypt($password),
                    "image" => $fileName
                ]);

            Session::flash('message_profile_update_success','Berhasil mengubah data');
            return redirect("/profile/".$id);
        }catch (Exception $e){
            Session::flash('message_profile_update_error','Error mengubah data');
            return redirect("/profile/".$id);
        }

    }

    public function updateAdmin(Request $request)
    {
        $this->validate($request,[
            'id'             => "required",
            'name'           => "required",
            'email'          => "required",
            'position'       => "required"
        ]);
        $id         = $request->input("id");
        $name       = $request->input("name");
        $email      = $request->input("email");
        $password   = $request->input("password");
        $repassword = $request->input("re-password");
        $photo      = $request->file("photo");
        $position   = $request->input("position");

        if ($password){
            if ($password != $repassword){
                Session::flash('message_profile_update_error','Password Tidak Sama');
                return redirect("/profile/".$id);
            }
        }

        $fileName = User::where(["id" => $id])->first()->image;
        if ($photo) {
            $fileName = $this->saveImage($photo);
        }

        try {
            $user = User::where(["id" => $id]);
            if ($password){
                $user->update([
                    "name" => $name,
                    "email" => $email,
                    "password" => bcrypt($password),
                    "image" => $fileName,
                    "role_id"=>$position
                ]);
            }else{
                $user->update([
                    "name" => $name,
                    "email" => $email,
                    "image" => $fileName,
                    "role_id"=>$position
                ]);
            }

            Session::flash('message_profile_update_success','Berhasil mengubah data');
            return redirect("/profile/".$id);
        }catch (Exception $e){
            Session::flash('message_profile_update_error',$e->getMessage());
            return redirect("/profile/".$id);
        }

    }

    private function saveImage($file) {
        if($file) {
            $extension = $file->getClientOriginalExtension();
            $namaFile = sha1(date("Y-m-d H:i:s")).".".$extension;
            $file->move('images/profile', $namaFile);
            return $namaFile;
        }
        return "";

    }

    public function userList(Request $request)
    {
        $users = User::get();
        return view('auth.userlist', ["users"=>$users]);
    }

    public function userAdd(Request $request)
    {
        $positions = RoleAccess::all();
        return view('auth.add', ['positions'=>$positions]);
    }

    public function userInsert(Request $request)
    {
        $this->validate($request,[
            'name'           => "required",
            'email'          => "required",
            'position'       => "required",
            'password'       => "required"
        ]);

        $name       = $request->input("name");
        $email      = $request->input("email");
        $position   = $request->input("position");
        $password   = $request->input("password");

        $user       = New User();
        $user->name         = $name;
        $user->email        = $email;
        $user->position     = $position;
        $user->password     = $password;
        if ($user->save()) {
            Session::flash('message_profile_update_success','Berhasil menambahkan user');
            return redirect("/user/list");
        }else{
            Session::flash('message_profile_update_error',"Error saat menambahkan user");
            return redirect("/user/add");
        }
        
    }

    public function userDelete($id)
    {
        try{
            User::where(["id"=>$id])->delete();
            Session::flash('message_profile_update_success','Berhasil menghapus user');
            return redirect('/user/list');
        }catch (Exception $e) {
           Session::flash('message_profile_update_error','Error saat menghapus user');
           return redirect('/user/list');
        }

    }
}