<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);
        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user = User::create($request->all());
        return User::responseJson(null, 'Registered!', 201);
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);
        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if($user = User::where(['email' => $request->email])->first() and Hash::check($request->password, $user->password)) {
            return User::responseJson(['access_token' => $user->generateAccessToken(), 'refresh_token' => $user->generateRefreshToken()], "Logged!", 200);
        }
        return response()->json(['email' => ['Email or password incorrect']], 401);
    }

    public function refreshAccessToken(Request $request) {
        $validator = Validator::make($request->all(), [
            'refresh_token' => 'required'
        ]);
        if($validator->fails()) return response()->json($validator->errors(), 422);
        $user = User::where('refresh_token', $request->refresh_token)->first();
        return User::responseJson(['access_token' => $user->generateAccessToken()], 'Refreshed!');
    }

    public function getUsers(Request $request) {

        $lists = User::where('id', '<>', '-1');
        if($request->filter) {
            foreach ($request->filter as $item) {
//                $item = json_decode($item);
                $lists = $lists->where($item[0], $item[1], $item[2]);
            }
        }

        if($request->order) {
            foreach ($request->order as $item) {
//                $item = json_decode($item);
                $lists->orderBy($item[0], $item[1]);
            }
        }
        if($request->withs) {
            $lists = $lists->with($request->withs);
        }

        if($request->per_page) {
            $lists->paginate($request->per_page);
        }
        return User::responseJson(['items' => $lists->get()], 'Received!', 200);
    }
}
