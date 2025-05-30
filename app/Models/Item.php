<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = 'item';
    protected $primaryKey = 'item_id';
    public $timestamps = false;
    protected $fillable = ['description', 'cost_price', 'sell_price', 'image'];
   

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'orderline', 'item_id', 'orderinfo_id')->withPivot('quantity');
    }

    public function stock()
    {
        return $this->hasOne(stock::class, 'item_id');
    }
}