<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;

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
        return [
            'subject' => 'required|string|max:255',
            'due_date' => 'sometimes|date',
            'label_id' => 'sometimes|exists:labels,id',
            'status' => [
                'sometimes',
                Rule::in(array_keys(config('params.task.status')))
            ],
        ];
    }
}
