<?php

namespace Modules\User\Http\Requests;

use App\helpers\convertToEnglish;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'roles'=>'required',
            'password' => 'required_without:oldpassword|exclude_unless:method,patch',
            'confirm' => 'required_without:oldpassword',
            'firstName'=>'required',
            'lastName'=>'required',
            'image' => 'nullable|mimes:jpeg,png,jpg|max:512',
            'mobile' => [
                'required','iran_mobile',
                Rule::unique('users', 'mobile')->ignore($this->user)->where(function ($query) {
                    return $query->where('deleted_at', null);
                }),
            ],
            'nationalCode' => [
                'nullable',
                Rule::unique('users', 'nationalCode')->ignore($this->user)->where(function ($query) {
                    return $query->where('deleted_at', null)->where('email','!=', null);
                }),
            ],
            'email' => [
                'nullable',
                Rule::unique('users', 'email')->ignore($this->user)->where(function ($query) {
                    return $query->where('deleted_at', null)->where('email','!=', null);
                }),
            ],
            'username' => [
                'nullable',
                Rule::unique('users', 'username')->ignore($this->user)->where(function ($query) {
                    return $query->where('deleted_at', null)->where('username','!=', null);
                }),
            ],

            'company_logo' => 'nullable|mimes:jpeg,png,jpg|max:512',
            'phone' => 'nullable|numeric',

        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'nationalCode'=>convertToEnglish::convertString($this->nationalCode),
            'mobile'=>convertToEnglish::convertString($this->mobile),

        ]);

    }

}
