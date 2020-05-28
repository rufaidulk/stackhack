<?php

namespace App\Http\Requests\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LabelRequest extends ApiBaseRequest
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
        if ($this->isMethod('post')) {
            return $this->createRules();
        }

        return $this->updateRules();
    }

    /**
     * @return array
     */
    private function createRules()
    {
        return [
            'name' => [
                'required',
                'string', 'max:255',
                Rule::unique('labels')->where(function($query){
                    $query->where('user_id', Auth::id());
                })
            ],
        ];
    }

    /**
     * @return array
     */
    private function updateRules()
    {
        return [
            'name' => [
                'required',
                'string', 'max:255',
                Rule::unique('labels')->ignore($this->route('label'))
                    ->where(function($query){
                        $query->where('user_id', Auth::id());
                    })
            ],
        ];
    }
}
