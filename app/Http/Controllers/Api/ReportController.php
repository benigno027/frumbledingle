<?php

namespace App\Http\Controllers\Api;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ReportController extends Controller
{

    private function getReport($price = null)
    {
        $query = Item::join('locations', 'locations.id', 'items.location_id')
            ->join('categories', 'categories.id', 'items.category_id')
            ->leftJoin('categories as c2', 'categories.parent_id', 'c2.id')
            ->selectRaw('locations.name as location, categories.name as category, c2.name as parent_category, count(items.id) as item_count')
            ->whereRaw('items.deleted_at is null and locations.deleted_at is null and categories.deleted_at is null and c2.deleted_at is null')
            ->groupBy('locations.name', 'categories.name', 'c2.name', 'items.category_id');

        if (!empty($price)) {
            $query = $query->where('items.price', '>=', $price);
        }

        return $query->get();
    }

    public function index()
    {
        try {
            $report = $this->getReport();

            return response()->json($report, 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function filter(Request $request)
    {
        try {

            $report = $this->getReport($request->input('price'));

            return response()->json($report, 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
