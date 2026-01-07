<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryDestruction extends Model
{
    use HasUlids;

    protected $fillable = [
        'inventory_stock_id',
        'destruction_date',
        'reason',
        'news',
    ];

    public function casts(): array
    {
        return [
            'destruction_date' => 'date',
        ];
    }

    public function inventoryStock(): BelongsTo
    {
        return $this->belongsTo(InventoryStock::class);
    }
}
