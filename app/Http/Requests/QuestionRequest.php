<?php

namespace App\Http\Requests;

use App\Item;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuestionRequest extends FormRequest
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
            'lesson_id' => [
                $this->route()->question ? 'nullable' : 'required',
                Rule::exists('lessons','id'),
            ],
            'title' => [ 'required', 'string' ],
            'description' => ['nullable'],
            'order' => ['nullable', 'integer'],
            'data' => [ 'required', 'json'],
            //'data.type' => [ 'required', Rule::in(['multiple', 'boolean']) ],
            //'data.answer-type' => [ 'required_if:data.*.type,!=,boolean' ],
            //'data.*.options' => [ 'required_if:data.*.type,==,multiple', 'array' ],
            'value' => 'nullable'
        ];
    }
}
