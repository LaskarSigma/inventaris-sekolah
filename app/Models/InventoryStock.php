<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InventoryStock extends Model
{
    use HasUlids;

    protected $fillable = [
        'item_id',
        'inventory_code',
        'incoming_stock',
        'outgoing_stock',
        'location',
    ];

    protected $casts = [
        'incoming_stock' => 'integer',
        'outgoing_stock' => 'integer',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function destruction(): HasOne
    {
        return $this->hasOne(InventoryDestruction::class);
    }
}
