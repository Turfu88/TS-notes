<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register', 'userInfo']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);

    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'coef_low' => $request->coef_low,
            'coef_high' => $request->coef_high,
            'projects' => $request->projects
        ]);

        $token = Auth::login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    public function userInfo()
    {
        $user = Auth::user();
        if (null === $user) {
            return response()->json([
                'status' => 'failed',
                'user' => null,
            ]);
        }
        return response()->json([
            'status' => 'success',
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'coef_low' => $user->coef_low,
                'coef_high' => $user->coef_high,
                'projects' => $user->projects
            ],
        ]);
    }

    public function user()
    {
        $user = Auth::user();
        return response()->json([
                'status' => 'success',
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'name' => $user->name,
                    'coef_low' => $user->coef_low,
                    'coef_high' => $user->coef_high,
                    'projects' => $user->projects
                ],
                'timesheets' => $user->timesheets
            ]);
    }


    public function update(Request $request)
    {
        // $request->validate([
        //     'worktime' => 'required|string|max:255',
        //     'note' => 'required|string|max:255',
        // ]);

        $user = Auth::user();
        $user->coef_low = $request->coef_low;
        $user->coef_high = $request->coef_high;
        $user->projects = $request->projects;

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'user updated successfully',
            'user' => $user,
        ]);
    }
}
