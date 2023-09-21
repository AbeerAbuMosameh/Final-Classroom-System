<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Traits\apiResoponse;
use App\Http\Controllers\web\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccessTokensController extends Controller
{
    use apiResoponse;

    public function index(Request $request)
    {
        //     return Auth::guard('sanctum')->user()->tokens;
        return $request->user('sanctum')->tokens;
    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'device_name' => ['sometimes', 'required'],
            'abilities' => ['array'], //abilities or scopes
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $name = $request->post('device_name', $request->userAgent());
            $abilities = $request->post('abilities', ['*']);
            $token = $user->createToken($name, $abilities, now()->addDay(30));

            return $this->apiResponse(__('classrooms.true-status'), __('auth.login'), [
                'token' => $token->plainTextToken,
                'user' => $user
            ], 201);
        }


        return $this->apiResponse(__('classrooms.false-status'), __('auth.failed-login'), [], 401);
    }


    public function destroy(Request $request, $id = null)
    {
        $user = Auth::guard('sanctum')->user();


        if ($id) {
            if ($id == 'current') {
                $user->currentAccessToken()->delete();
            } else {
                $user->tokens()->findOrFail($id)->delete;
  //              $user->tokens()->destroy($id);
            }
        }else{
            //delete all tokens -- logout from all devices
            $user->tokens()->delete();

        }
    }
}
