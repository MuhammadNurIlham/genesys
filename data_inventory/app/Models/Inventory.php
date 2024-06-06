<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventories';
    protected $primaryKey = 'inventory_id';

    protected $fillable = [
        'inventory_id',
        'name',
        'price',
        'total_price',
        'stock'
    ];
}
