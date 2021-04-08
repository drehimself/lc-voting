<?php

namespace App\Models\BizTools;

use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    protected $fillable = [
        'id',
        'amount',
        'date',
        'type',
        'ledger_category_id',
        'description',
        'is_taxable'
    ];
    public function ledgerCategory()
    {
        return $this->belongsTo(LedgerCategory::class);
    }
}
