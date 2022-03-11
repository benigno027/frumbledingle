<?php

namespace App\Http\Controllers\Api;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\Location\AddLocationFormRequest;
use App\Http\Requests\Location\EditLocationFormRequest;

class LocationController extends Controller
{
    public function index()
    {
        return response()->json(Location::get());
    }

    public function store(AddLocationFormRequest $data)
    {
        try {

            $data = $data->getData();
            $location = Location::create($data);

            return response()->json($location, 201);

        } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update($id, EditLocationFormRequest $data)
    {
        try {

            $data = $data->getData();
            $location = Location::findOrFail($id);
            $location->update($data);

            return response()->json($location, 200);

        } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Location $location)
    {
        try {

            $location->delete();
            return response()->json('Delete Success', 200);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}