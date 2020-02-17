<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Owner;
use Illuminate\Support\Facades\Auth; 
use Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Place;
use App\Http\Resources\Place as PlaceResource;
use App\Http\Resources\PlaceCollection;


class OwnerController extends Controller
{
	protected $tokenName = 'Owner Access Token';
    public $successStatus = 200;

	public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email|unique:users', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);
		if ($validator->fails()) 
		{ 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
		$input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = Owner::create($input); 
        // $success['token'] =  $user->createToken('MyApp')->accessToken; 
        $success['name'] =  $user->name;
		return response()->json(['success'=>'you are a owner of a place in our app now'], $this->successStatus); 
    }


	public function login()
	{
	    $validatedData = request()->validate([
	        'email' => 'required',
	        'password' => 'required'
	    ]);
	    // get user object
	    $user = User::where('email', request()->email)->first();
	    // do the passwords match?
	    if (!Hash::check(request()->password, $user->password)) {
	        // no they don't
	        return response()->json(['error' => 'Unauthorized'], 401);
	    }
	    // log the user in (needed for future requests)
	    Auth::guard('owner')->login();
	    // get new token
	    $tokenResult = $user->createToken($this->tokenName);
	    // return token in json response
	    return response()->json(['success' => ['token' => $tokenResult->accessToken]], 200);
	}
	 public function logout(Request $request)
    {

        $request->user('api')->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

	public function getPlaces()
	{
		return new PlaceCollection(auth('api')->user()->places);
	}
	public function getPlace($id)
	{


		$place = Place::findOrFail($id);

		if(!$this->authorize('view', $place))
		{
			 return response()->json('Unautherized', 401);

		}
        return new PlaceResource($place);
	}
}
