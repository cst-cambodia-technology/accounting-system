<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    /**
     * Handle a signin request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return json
     */
    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        
        $credentials = $request->only('email', 'password');

        try {
            if(!$token = JWTAuth::attempt($credentials))
            {
                return response()->json([
                    'error' => 'invalid_credentials'
                ], 401);
            }    
        } catch (JWTException $e) {
            return response()->json([
                    'error' => 'could_not_create_token'
                ], 500);
        }
        return response()->json([
                    'token' => $token
                ], 200);
    }

    /**
     * get a listing of the user.
     *
     * @return json
     */
    public function index()
    {
        if (! $auth = JWTAuth::parseToken()->authenticate()) 
        {
            return response()->json(['error' => 'user_authenticate_not_found'], 404);
        }

        $users = User::all();

        return response()->json(['users' => $users], 200);
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return json
     */
    public function create(Request $request)
    {   
        if (! $auth = JWTAuth::parseToken()->authenticate()) 
        {
            return response()->json(['error' => 'user_authenticate_not_found'], 404);
        }

        $this->validate($request, [
            'title'         => 'string|nullable|max:15',
            'givenName'     => 'required|string|max:25',
            'middleName'    => 'string|nullable|max:25',
            'familyName'    => 'required|string|max:25',
            'displayName'   => 'required|string|max:100',
            'email'         => 'required|string|email|max:100|unique:users',
            'password'      => 'required|string|min:6|max:35',
            'contactInfo'   => 'json|nullable',
            'contactAddr'   => 'json|nullable',
            'about'         => 'string|nullable|max:4000',
            'status'        => ['required', Rule::in(['Active', 'Inactive'])]
        ]);

        $user = new User();

        $user->title        =   $request->input('title');
        $user->givenName    =   $request->input('givenName');
        $user->middleName   =   $request->input('middleName');
        $user->familyName   =   $request->input('familyName');
        $user->displayName  =   $request->input('displayName');
        $user->email        =   $request->input('email');
        $user->password     =   bcrypt($request->input('password'));
        $user->contactInfo  =   $request->input('contactInfo');
        $user->contactAddr  =   $request->input('contactAddr');
        $user->about        =   $request->input('about');
        $user->status       =   $request->input('status');
        $user->createdBy    =   $auth->id;
        $user->modifiedBy   =   $auth->id;
        
        $user->save();

        return response()->json(['user' => $user], 201);
    }

    /**
     * get the specified user.
     *
     * @param  int  $id
     * @return json
     */
    public function show($id)
    {
        if (! $auth = JWTAuth::parseToken()->authenticate()) 
        {
            return response()->json(['error' => 'user_authenticate_not_found'], 404);
        }

        try {
            $user = User::findOrFail($id);
            return response()->json(['user' => $user], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'user_not_found'], 404);
        }


    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return json
     */
    public function update(Request $request, $id)
    {
        if (! $auth = JWTAuth::parseToken()->authenticate()) 
        {
            return response()->json(['error' => 'user_authenticate_not_found'], 404);
        }

        $this->validate($request, [
            'title'         => 'string|nullable|max:15',
            'givenName'     => 'required|string|max:25',
            'middleName'    => 'string|nullable|max:25',
            'familyName'    => 'required|string|max:25',
            'displayName'   => 'required|string|max:100',
            'contactInfo'   => 'json|nullable',
            'contactAddr'   => 'json|nullable',
            'about'         => 'string|nullable|max:4000',
            'status'        => ['required', Rule::in(['Active', 'Inactive'])]
        ]);

        try {
            $user = User::findOrFail($id);

            $user->title        =   $request->input('title');
            $user->givenName    =   $request->input('givenName');
            $user->middleName   =   $request->input('middleName');
            $user->familyName   =   $request->input('familyName');
            $user->displayName  =   $request->input('displayName');
            $user->contactInfo  =   $request->input('contactInfo');
            $user->contactAddr  =   $request->input('contactAddr');
            $user->about        =   $request->input('about');
            $user->status       =   $request->input('status');
            $user->modifiedBy   =   $auth->id;
            
            $user->save();
            
            return response()->json(['user' => $user], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'user_not_found'], 404);
        }   
    }

    /**
     * Inactive the specified user from storage.
     *
     * @param  \App\Name  $name
     * @return \Illuminate\Http\Response
     */
    public function inactive(Name $name)
    {
        //
    }
}   
