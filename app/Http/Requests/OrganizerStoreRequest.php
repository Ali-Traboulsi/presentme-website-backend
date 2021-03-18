<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class OrganizerStoreRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'first-name' => 'required|string|max:50',
            'last-name' => 'required|string|max:50',
            'why-to-join' => 'required',
            'date-of-birth' => 'required|date',
            'previous-experience' => 'required',
            'gender_id' => 'required',
            'password' => 'required',
            'avatar' => 'mimes:jpeg,jpg,png,gif|max:3000',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email is required!',
            'username.required' => 'Username is required!',
            'first-name.required' => 'First name is required!',
            'last-name.required' => 'Last name is required!',
            'password.required' => 'Password is required!',
            'why-to-join.required' => 'why-to-join is required!',
            'date-of-birth.required' => 'Date-of-birth is required!',
            'previous-experience.required' => 'Previous Experience is required!',
        ];
    }

    /**
     *  Filters to be applied to the input.
     *
     * @return array
     */
    public function filters()
    {
        return [
            'email' => 'trim|lowercase',
            'username' => 'trim|capitalize|escape',
            'first-name' => 'trim|capitalize|escape',
            'last-name' => 'trim|capitalize|escape'
        ];
    }

}
