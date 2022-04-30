<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LampaRequest extends FormRequest
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
          'lampa'  => ['required'],
          'condition'        => ['required'],
          'rad_mode'        => ['required'],
          'time_on'        => ['required'],
          'time_off' => ['required']
        ];
    }
}
