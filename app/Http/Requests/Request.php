<?php


namespace App\Http\Requests;


use App\Exceptions\BaseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class Request extends FormRequest
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
     * Configure the validator instance.
     *
     * @param Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function($validator) {
            $errors = $validator->errors()->all();
            if (!empty($errors)) {
                throw new BaseException($errors[0]);
            }
        });
    }

    /**
     * 驼峰转化为下划线
     * @return array
     */
    public function convertKeys()
    {
        $params = [];
        $request = $this->all();
        foreach ($request as $key => $value) {
            $newKey = strtolower(implode('_', preg_split("/(?=[A-Z])/", $key)));

            $params[$newKey] = $value;

        }

        return $params;
    }

}
