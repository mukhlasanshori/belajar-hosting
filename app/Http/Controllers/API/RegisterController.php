<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facade\Auth;
use Validator;
use Illuminate\Http\JsonResponse;

class RegisterController extends BaseController
{
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email'=> 'required|email',
            'password'=> 'required',
            'c_password'=>'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendError('Validasi gagal', $validator->error());
        
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user =User::create($input);
        $succes['token']=$user->createToken('MyApp')->plainTextToken;
        $succes['name']=$user->name;

        return $this->sendResponse($success,'Data Berhasil Didaftarkan');
        }
    }   
    public function login(Request $request):JsonResponse
    {
        if(Auth::attemp(['email'=> $request->email,'password'=>$request->password])){
            $user =Auth::user;
            $succes['token']=$user->createToken('MyApp')->plainTextToken;
            $success['name']=$user->name;
        return $this->sendError('Tidak Ditemukan',['error'=>'user tidak ditemukan']);

        }
    }
    
}
