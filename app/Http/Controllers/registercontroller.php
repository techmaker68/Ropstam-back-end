<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



use App\Register;
use App\Models\User;
use App\Notifications\passwordNotification;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class registercontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function login(LoginRequest $request)
    {

        $user = User::where('email', $request->email)->first();
        if ($user) {
            if ((Hash::check($request->password, $user->password))) {
                $token = $user->createToken($user)->plainTextToken;
                $data['id'] = $user->id;
                $data['name'] = $user->name;
                $data['email'] = $user->email;
                $data['token'] = $token;
                $data['role'] = $user->role;
                return response()->json($data, 201);
            }
        }
        return response()->json(['error' => 'The provided credentials do not match our records.'], 400);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function Register(UserRegisterRequest $request)
    {
        try {
            $str =  Str::random(10);
            DB::beginTransaction();
            $password=$request->password.$str;
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($password),
                'role' => $request->role,
            ]);
            $user->notify(new passwordNotification($user,$password));
            DB::commit();
        return response()->json(['success' => 'user registered successfully'], 200);

        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $id)
    {
        $key = $id->id;
        $user = DB::table('registers')->find($key);

        return view('show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(request $id)
    {
        // $email=$id->email;
        DB::table('registers')
            ->where('email', $id->id)
            ->delete();
        return view('delete');
    }
}
