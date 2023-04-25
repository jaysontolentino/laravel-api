<?php

namespace App\Http\Requests;

use App\Models\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;


class UserUpdateRequest extends FormRequest
{

    public function rules()

    {
        return [

            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($this->route()->parameter('user')->id)],

            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->route()->parameter('user')->id)],

            'phone' => ['required', 'min:11', 'max:12', 'regex:/^([0-9\s\-\+\(\)]*)$/'],

            'role' => ['required', 'in:admin,user'],

        ];
    }


    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(response([

            'success'   => false,

            'errors'    => $validator->errors()->all()

        ], 422));

    }



    public function messages()

    {
        return [];
    }

}