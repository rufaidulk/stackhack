<?php

namespace App\Http\Requests\Api;

class TaskRequest extends ApiBaseRequest
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
            'subject' => 'required|string|max:255',
            'due_date' => 'sometimes|date',
            'label_id' => 'sometimes|exists:labels,id'
        ];
    }

    /**
     * @return array
     */
    private function updateRules()
    {
        // return [
        //     'name' => [
        //         'required',
        //         'string', 'max:255',
        //         Rule::unique('companies')->ignore($this->route('company')),
        //     ],
        //     'description' => 'required|string|max:255',
        //     'user_id' => 'required|exists:users,id'
        // ];
    }
}
