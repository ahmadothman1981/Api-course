<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException; 
use App\Helpers\ApiResponse;
class NewMessageRequest extends FormRequest
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

protected function failedValidation(Validator $validator)
{
    if($this->is('api/*'))
    {
        $response = ApiResponse::sendResponse(422,'Validation Erros',$validator->messages()->all());
        throw new ValidationException($validator,$response);
    }

}
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'=>'required',
            'email'=>'required|email',
            'phone'=>'required',
            'message'=>'required',

        ];
    }
}
