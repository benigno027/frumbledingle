<?php

namespace App\Http\Requests\Items;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Request;

class EditItemFormRequest extends FormRequest
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
        $rules =
            [
                'name' => 'required|string|max:200',
                'category_id' => 'required|integer',
                'location_id' => 'required|integer',
                'price' => 'required|numeric',
            ];

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name must be less than 200 characters',
            'category_id.required' => 'Category ID is required',
            'category_id.integer' => 'Category ID must be an integer',
            'location_id.required' => 'Location ID is required',
            'location_id.integer' => 'Location ID must be an integer',
            'price.required' => 'Price is required',
            'price.numeric' => 'Price must be a number',
        ];
    }

    /**
     * Get the request's data from the request.
     *
     *
     * @return array
     */
    public function getData()
    {
        $data = $this->only([
            'name',
            'category_id',
            'location_id',
            'price'
        ]);

        return $data;
    }
}
