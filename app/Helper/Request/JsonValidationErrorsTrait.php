<?php

namespace App\Helper\Request;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

trait JsonValidationErrorsTrait
{
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json(
                [
                    'success' => false,
                    'messages' => 'Error! Invalid Data.',
                    'errors' => array_pop($errors)
                ],
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            )
        );

    }

}
