<?php

namespace App\Http\Controllers;

use App\Http\Resources\DeskResource3;
use App\Http\Resources\DeskResource2;
use App\Http\Resources\DeskResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\buse;
use App\Models\route;
use App\Models\trip;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Rules\StrMustContain;



class MainController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'status' => 'required',
            'password' => 'required',
        ]);
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'status' => $fields['status'],
            'password' => bcrypt($fields['password']),
        ]);
        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];
        return response($response, 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        //Проверка email

        $user = User::where('email', $fields['email'])->first();

        //Проверка password

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('myapptoken')->plainTextToken;

            $response = [
                'message' => 'Log in',
                'token' => $token,
            ];
            return response($response, 200);
        } else {
            return response('You are not an authenticated user!', 403);
        }
    }

    public function logout()
    {
        if (Auth::user()) {
            auth()->user()->currentAccessToken()->delete();
            return [
                'message' => 'Log out'
            ];
        } else {
            return [
                'message' => 'Not Auth'
            ];
        }
    }

    public function show($id)
    {
        return buse::find($id);
    }

    public function index()
    {
        return buse::all();
    }

    public function route($id)
    {
        return new DeskResource(route::with('lists')->findOrFail($id));
    }

    public function route2()
    {
        return DeskResource::collection(route::with('lists')->get());
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'number_route' => 'required|unique:users|max:10',
            'start_stop' => 'required',
            'end_stop' => 'required',
            'price' => 'required|numeric',
        ]);
        Route::create([
            'number_route' => $fields['number_route'],
            'start_stop' => $fields['start_stop'],
            'end_stop' => $fields['end_stop'],
            'price' => $fields['price'],
        ]);

        $response = [
            'status' => true
        ];
        return response($response, 201);
    }

    public function auth(Request $request)
    {
        return Auth::user();
    }

    public function update(Request $request)
    {
        $fields = $request->validate([
            'number_route' => 'max:10',
            'start_stop' => '',
            'end_stop' => '',
            'price' => '',
        ]);
        Route::where('id', $request->id)->update([
            'number_route' => $fields['number_route'],
            'start_stop' => $fields['start_stop'],
            'end_stop' => $fields['end_stop'],
            'price' => $fields['price'],
        ]);

        $response = [
            'status' => true
        ];
        return response($response, 200);
    }

    public function destroy(Request $request)
    {
        route::find($request->id)->delete();
        $response = [
            'status' => true
        ];
        return response($request, 204);
    }

    public function bstore(Request $request)
    {
        $fields = $request->validate([
            'registration_number' => 'required|max:20',
            'model' => 'required',
            'seats' => 'required|numeric',
        ]);
        buse::create([
            'registration_number' => $fields['registration_number'],
            'model' => $fields['model'],
            'seats' => $fields['seats'],
        ]);

        $response = [
            'status' => true
        ];
        return response($response, 201);
    }

    public function bupdate(Request $request)
    {
        $fields = $request->validate([
            'registration_number' => 'max:20',
            'model' => '',
            'seats' => 'numeric',
        ]);
        buse::where('id', $request->id)->update([
            'registration_number' => $fields['registration_number'],
            'model' => $fields['model'],
            'seats' => $fields['seats'],
        ]);

        $response = [
            'status' => true
        ];
        return response($response, 200);
    }

    public function bdestroy(Request $request)
    {
        buse::find($request->id)->delete();
        $response = [
            'status' => true
        ];
        return response($response, 204);
    }

    public function ustore(Request $request)
    {
        $input = [
            'status' => new StrMustContain,
        ];
        $fields = $request->validate([
            'name' => 'required|max:70',
            'email' => 'required|email',
            'status' => 'required',
            'password' => 'required',
        ], $input);
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'status' => $fields['status'],
            'password' => bcrypt($fields['password']),
        ]);
        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'status' => true,
            'token' => $token,
        ];
        return response($response, 201);
    }

    public function uupdate(Request $request)
    {
        $input = [
            'status' => new StrMustContain,
        ];
        $fields = $request->validate([
            'name' => 'required|max:70',
            'email' => 'required|email',
            'status' => 'required',
        ], $input);
        user::where('email', $request->email)->update([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'status' => $fields['status'],
        ]);

        $response = [
            'status' => true
        ];
        return response($response, 200);
    }

    public function password(Request $request)
    {

        $fields = $request->validate([
            'email' => 'required|email',
            'old_password' => 'required',
            'password' => 'required',
        ]);
        
        $us = User::where('email', $request->email)->get();
        user::where('email', $request->email)->update([
            'password' => $fields['password'],
        ]);

        $response = [
            'status' => true
        ];
        return response($response, 200);
    }

    public function udestroy(Request $request)
    {
        user::find($request->id)->delete();
        $response = [
            'status' => true
        ];
        return response($response, 200);
    }

    public function user()
    {
        return DeskResource3::collection(user::all());
    }
}
