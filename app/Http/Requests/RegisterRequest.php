<?php

namespace App\Http\Requests;

use App\Rules\UserExistsRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    /** Define parameters for validation
     *
     * @return array
     */
    public function validationData() : array
    {
        $request['name'] = $this->input('name');
        $request['phone'] = $this->input('phone');
        $request['user'] = [
          'phone' =>  $this->input('phone'),
          'name'  =>  $this->input('name')
        ];

        return $request;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'phone' => 'required|string|min:18|max:18',
            'name'  => 'required|string|min:3|max:25',
            'user'  =>  new UserExistsRule()
        ];
    }
}
