<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Item extends Model
{
    use HasUlids;

    protected $fillable = [
        'entry_date',
        'name_address',
        'receipt_date',
        'receipt_no',
        'brand',
        'name',
        'photo',
        'quantity',
        'unit_price',
        'total_price',
        'funding',
        'inventory_code_id',
    ];

    public function casts(): array
    {
        return [
            'entry_date' => 'date',
            'receipt_date' => 'date',
            'quantity' => 'integer',
            'unit_price' => 'integer',
            'total_price' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Item $item) {
            if (empty($item->receipt_no)) {
                $item->receipt_no = $item->generateReceiptNo();
            }
        });

        static::created(function (Item $item) {
            $item->generateInventoryStocks();
        });
    }

    public function inventoryCode(): BelongsTo
    {
        return $this->belongsTo(InventoryCode::class);
    }

    public function inventoryStock(): HasMany
    {
        return $this->hasMany(InventoryStock::class);
    }

    public function generateReceiptNo(): string
    {
        $year = $this->receipt_date->format('Y');

        $lastItem = self::where('inventory_code_id', $this->inventory_code_id)
            ->where('funding', $this->funding)
            ->whereYear('receipt_date', $year)
            ->orderBy('receipt_no', 'desc')
            ->first();

        if ($lastItem) {
            $nextReceiptNo = (int) $lastItem->receipt_no + $lastItem->quantity;
        } else {
            $nextReceiptNo = 1;
        }

        return str_pad($nextReceiptNo, 4, '0', STR_PAD_LEFT);
    }

    public function generateInventoryStocks(): void
    {
        $startReceiptNo = (int) $this->receipt_no;
        $year = $this->receipt_date->format('Y');
        $inventoryCodePrefix = $this->inventoryCode->code ?? 'INV';

        $stocks = [];
        for ($i = 0; $i < $this->quantity; $i++) {
            $receiptNumber = str_pad($startReceiptNo + $i, 4, '0', STR_PAD_LEFT);
            $inventoryCode = "{$inventoryCodePrefix}/{$receiptNumber}/{$this->funding}/{$year}";

            $stocks[] = [
                'id' => (string) Str::ulid(),
                'item_id' => $this->id,
                'inventory_code' => $inventoryCode,
                'incoming_stock' => 1,
                'outgoing_stock' => 0,
                'location' => 'Gudang Bu Tias',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        InventoryStock::insert($stocks);
    }
}
