<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OtkazRequest extends FormRequest
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
        session($this->request->all());
        return [
            'reason_id' => ['required'],
            'theme_id' => ['required'],
            'omsdms' => ['required'],
            'department' => ['required']
        ];
    }
}
