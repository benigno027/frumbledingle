<?php

namespace App\Http\Controllers\Api;

use App\Models\Item;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    private function getReport($price = null)
    {
        $locations = Location::with('items')->get();

        $report = [];

        foreach ($locations as $location) {

            $items = $location->items;

            if ($price != null) {
                $items = $location->items->where('price', '=', $price);
            }

            foreach ($items as $item) {


                $category = Category::find($item->category_id);
                $parent_category = Category::find($category->parent_id);

                $count_item = Item::where([
                    ['category_id', $item->category_id],
                    ['location_id', $item->location_id],
                ])->count();

                $report[] = [
                    'location' => $location->name,
                    'category' => $category->name,
                    'parent_category' => $parent_category->name ?? '',
                    'item' => $item->name,
                    'price' => $item->price,
                    'count_item' => $count_item,
                ];
            }
        }

        return $report;
    }

    public function index()
    {
        $report = $this->getReport();

        return response()->json($report, 200);
    }

    public function filter(Request $request)
    {
        $report = $this->getReport($request->input('price'));

        return response()->json($report, 200);
    }
}
