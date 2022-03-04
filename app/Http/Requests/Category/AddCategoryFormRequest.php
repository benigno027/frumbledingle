<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Request;

class AddCategoryFormRequest extends FormRequest
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
            'parent_id' => 'nullable|integer',
        ];

        return $rules;
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
            'parent_id',
        ]);

        return $data;
    }

}
