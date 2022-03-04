<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes;
    
    protected $table = 'locations';
    
    protected $guarded = ['id'];

    protected $fillable =
    [
        'name',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
    
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}