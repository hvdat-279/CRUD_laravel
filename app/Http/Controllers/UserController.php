<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Contracts\Service\Attribute\Required;

class UserController extends Controller
{
    public function loadAllUser()
    {
        $all_user = User::all();
        return view('user', compact('all_user')); // compact gửi sang bên user
    }
    public function loadAddUserForm()
    {
        return view('add-user');
    }
    public function AddUser(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'password' => 'required|confirmed|min:4|max:8'
        ]);


        try {
            $new_user = new User;
            $new_user->name = $request->full_name;
            $new_user->email = $request->email;
            $new_user->phone = $request->phone;
            $new_user->password = Hash::make($request->password);
            $new_user->save();

            return redirect('/user')->with('success', 'User Added Successfully');
            // làm đúng thì đi tới trang user và hiển thị alert thành công
        } catch (\Exception $e) {
            return redirect('/add-user')->with('fail', $e->getMessage());
        }
    }
    public function deleteUser($id)
    {
        try {
            User::where('id', $id)->delete();
            return redirect('/user')->with('success', 'User Deleted successfully!');
        } catch (\Exception $e) {
            return redirect('/user')->with('fail', $e->getMessage());
        }
    }
    public function loadEditForm($id)
    {
        $user = User::find($id);
        return view('/edit-user', compact('user'));
    }
    public function EditUser(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'required'

        ]);


        try {
            $update_user = User::where('id', $request->user_id)->update([
                'name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone

            ]);



            return redirect('/user')->with('success', 'User Updated Successfully');
            // làm đúng thì đi tới trang user và hiển thị alert thành công
        } catch (\Exception $e) {
            return redirect('/edit/user')->with('fail', $e->getMessage());
        }
    }
}
