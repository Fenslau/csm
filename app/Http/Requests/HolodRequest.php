<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HolodRequest extends FormRequest
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
     protected function prepareForValidation()
     {
       if ($this->defrost) {
         $this->merge([
             'temperature' => 'Разморозка',
         ]);
       }
     }

      public function rules()
      {
          return [
            'holodilnik'  => ['required'],
            'time'        => ['required'],
            'temperature' => ['required']
          ];
      }
}
