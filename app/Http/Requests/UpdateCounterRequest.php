<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCounterRequest extends FormRequest
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
        if(request('from') === 'officer'){
            return [
                'counter_id' => 'required',
                'user_id' => 'required'
            ];
        }else if(request('from') === 'admin'){
            return [
            'number' => 'required',
            ];
        }
        
    }
}