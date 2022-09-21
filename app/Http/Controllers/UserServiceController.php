<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserServiceController extends Controller
{
    public function signIn(Request $request)
    {
        try {
            $validator = Validator::make($request->all() ,[
                'email' => ['email', 'required'],
                'password' => ['required']
            ]);

            if ($validator->fails()) {
                return ResponseFormatter::error(null, $validator->errors());
            }

            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ], 'Authentication Failed', 500);
            }

            $user = User::where('email', $request->email)->first();
            if (!Hash::check($request->password, $user->password)) {
                throw new \Exception('Invalid Credentials');
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Authenticated');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error
            ], 'Authentication Failed', 500);
        }
    }

    public function signUp(Request $request)
    {
        try {
            $validator =  Validator::make($request->all() ,[
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' =>  ['required', 'min:8']
            ]);

            if ($validator->fails()) {
                return ResponseFormatter::error(null, $validator->errors());
            }

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'image' => $request->image,
                'role' => $request->role,
                'level' => $request->level,
                'password' => Hash::make($request->password),
            ]);

            $user = User::where('email', $request->email)->first();

            $tokenResult = $user->createToken('authToken')->plainTextToken;
            
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ]);
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Authentication Failed', 500);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();

        return ResponseFormatter::success($token, 'Token Revoked');
    }

    public function fetch(Request $request)
    {
        return ResponseFormatter::success($request->user(), 'Data profile user berhasil diambil');
    }

    public function update(Request $request)
    {
        $data = $request->all();

        $user = User::firstWhere('id', Auth::user()->id);
        $user->update($data);

        return ResponseFormatter::success($user, 'Profile Updated');
    }

    public function updatePhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => ['required', 'image', 'max:2048']
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(
                ['error' => $validator->errors()],
                'Update Photo Failed',
                401
            );
        }

        if ($request->file('file')) {
            $file = $request->file->store('assets/user', 'public');

            $user =  User::firstWhere('id', Auth::user()->id);
            $user->image = $file;
            $user->update();

            return ResponseFormatter::success([$file], 'File successfully uploaded');
        }
    }
}
