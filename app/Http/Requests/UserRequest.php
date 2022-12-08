<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
	public function authorize(): bool
	{
		return true;
	}

   public function rules(): array
   {
   	$rules = [
   		'username' => ['required', 'unique:users'],
   		'password' => ['required', 'min:6'],
   		'firstName' => ['required'],
   		'lastName' => ['required'],
   		'email' => ['required', 'email', 'unique:users'],
   	];

   	if ($this->route()->getActionMethod() === 'store') {
   		$rules['password'] = [];
   		$rules['username'][1] = 'unique:users,username,'.request()->id;
   		$rules['email'] = 'unique:users,email,'.request()->id;
   	} elseif ($this->route()->getActionMethod() === 'updateGeneral') {
   		$rules['password'] = [];
   		$rules['username'] = ['required', 'unique:users,username,'.auth()->id()];
   		$rules['email'] = ['required', 'email', 'unique:users,email,'.auth()->id()];
   	} elseif ($this->route()->getActionMethod() === 'updatePassword') {
   		$rules = [];
   		$rules['currentPassword'] = ['required', 'current_password'];
   		$rules['newPassword'] = ['required', 'min:6'];
   		$rules['confirmPassword'] = ['required', 'same:newPassword'];
   	}

   	return $rules;
   }

   public function filters(): array
   {
       return [
           'email' => 'trim|lowercase',
           'name' => 'trim|capitalize|escape'
       ];
   }
}
