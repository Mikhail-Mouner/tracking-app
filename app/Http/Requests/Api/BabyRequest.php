<?php

namespace App\Http\Requests\Api;

use App\Helper\Request\JsonValidationErrorsTrait;
use Illuminate\Foundation\Http\FormRequest;

class BabyRequest extends FormRequest
{
    use JsonValidationErrorsTrait;
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
            'name'=> 'required|string|min:2|max:255',
        ];
    }
}
