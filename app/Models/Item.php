<?php

namespace App\Models;

use App\Models\Location;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

    protected $table = 'items';

    protected $guarded = ['id'];

    protected $fillable =
    [
        'name',
        'price',
        'location_id',
        'category_id',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
