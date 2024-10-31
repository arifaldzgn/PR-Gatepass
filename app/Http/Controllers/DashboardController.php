<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\deptList;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(Request $request)
    {
        $request->session()->put('menu', 'dashboard');
        return view('dashboard');
    }

    public function account()
    {
        return view('account', [
            'data' => User::all(),
            'deptList' => deptList::all()
        ]);
    }

    public function create_account(Request $request)
    {
        try{

            $request->validate([
                'name' => 'required',
                'email' => 'required|email:dns',
                'badge_no' => 'required',
                'role' => 'required',
                'deptList_id' => 'required'
            ]);

            User::create([
                'name' => $request->name,
                'badge_no' => $request->badge_no,
                'email' => $request->email,
                'role' => $request->role,
                'password' => bcrypt(12345),
                'deptList_id' => $request->deptList_id
            ]);

            return response()->json(['message' => 'New Account Successfully added']);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to Create New Account'], 500);
        }
    }

    public function delete_account($id)
    {
        try{
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json(['message' => 'New Account Successfully added']);

        } catch (\Exception $e){
            return response()->json(['error' => 'Failed to Create New Account'], 500);
        }
    }

    public function user_details($id)
    {
        $user = User::find($id);

        if ($user) {
            return response()->json([
                'user' => $user,
                'dept' => $user->deptList,
                'hod' => $user->deptList->hod->email,
                'dept_list' => deptList::get()
            ]);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    public function update_account(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'badge_no' => 'required',
            'role' => 'required',
            'deptList_id' => 'required',
        ]);
        $findID = User::where('badge_no', $request->badge_no)->get()->first();
        $user = User::find($findID->id);
        if ($user) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->badge_no = $request->badge_no;
            $user->role = $request->role;
            $user->deptList_id = $request->deptList_id;
            $user->save();

            return response()->json(['message' => 'User updated successfully']);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    public function menu()
    {
        return view('menu');
    }
}
