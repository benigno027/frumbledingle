<?php

namespace App\Http\Controllers\Api;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\Items\AddItemFormRequest;

class ItemController extends Controller
{
    public function index()
    {
        return response()->json(Item::with('location', 'category')->get());
    }

    public function store(AddItemFormRequest $data)
    {
        try {

            $data = $data->getData();
            $item = Item::create($data);

            return response()->json($item, 201);

        } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Item $item)
    {
        try {

            $item->delete();

            return response()->json(null, 200);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
