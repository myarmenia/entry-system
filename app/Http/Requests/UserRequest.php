<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Arr;
use Hash;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules($id=null): array
    {

        $currentRoute = Route::currentRouteName();
        $rules = [
            'name' => 'required',
            // 'email' => 'required|email|unique:users,email',
            // 'password' => 'required|min:8|same:confirm-password',
            'roles' => 'required',
        ];
        if($currentRoute=='users.store'){
            $rules['email'] = 'required|email|unique:users,email';
            $rules['password'] = 'required|min:8|same:confirm-password';
        }
        if($currentRoute == 'users.update'){

            $userId = $this->route('user');

            $rules['email']='required|email|unique:users,email,'.$userId;

            
        }
        if(request()->has('client')){

            $rules['client.name'] = 'required';

        }

        return $rules;

    }
}
