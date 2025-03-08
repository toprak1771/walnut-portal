<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAdminUser;
use App\Http\Requests\DeleteAdminUser;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateAdminUser;
use Illuminate\Http\Request;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function create_admin_user(CreateAdminUser $request)
    {
        $user = AdminUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Kullanıcı başarıyla oluşturuldu.',
            'data' => $user
        ]);
    }

    public function update_admin_user(UpdateAdminUser $request){    
        $user = AdminUser::find($request->user_id);
        if(!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Kullanıcı bulunamadı.'
            ]);
        }
        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Kullanıcı başarıyla güncellendi.',
            'data' => $user
        ]);
    }

    public function login(LoginRequest $request) {
        $user = Auth::guard('admin')->attempt(['email' => $request ->email,'password' => $request->password]);
        if(!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Kullanıcı bulunamadı.'
            ]);
        } else {
            $user = Auth::guard('admin')->user();
            return response()->json([
                'status' => true,
                'message' => 'Kullanıcı başarıyla giriş yaptı.',
                'data' => $user
            ]);
        }
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return response()->json([
            'status' => true,
            'message' => 'Kullanıcı başarıyla çıkış yaptı.'
        ]);
    }

    public function get_admin_user_from_id(){
        $user_id = (request()->query())['user_id'];
        $user = AdminUser::find($user_id);
        if(!$user){
            return response()->json([
                'status' => false,
                'message' => 'Kullanıcı bulunamadı.'
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Kullanıcı başarıyla bulundu.',
                'data' => $user
            ]);
        }    
    }

    public function get_all_admin_user() {
        $users = AdminUser::all();
        return response()->json([
            'status' => true,
            'message' => 'Kullanıcılar başarıyla bulundu.',
            'data' => $users
        ]);
    }

    public function delete_admin_user(DeleteAdminUser $request){
        $user = AdminUser::find($request->user_id);
        if(!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Kullanıcı bulunamadı.'
            ]);
        }
        $user->delete();
        return response()->json([
            'status' => true,
            'message' => 'Kullanıcı başarıyla silindi,'
        ]);
    }
}
