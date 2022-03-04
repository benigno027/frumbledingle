<?php

namespace App\Http\Requests\Items;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Request;

class AddItemFormRequest extends FormRequest
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
