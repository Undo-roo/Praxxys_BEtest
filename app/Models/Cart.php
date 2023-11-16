<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function items(): HasMany {
       return $this->hasMany(CartItem::class);
    }

    public function total(): Attribute {
        return Attribute::get(fn() => $this->items()->sum('total'));
    }

    public function quantity(): Attribute {
        return Attribute::get(fn() => $this->items()->sum('quantity'));
    }

}
