<?php

namespace App\Models\BizTools;

use Illuminate\Database\Eloquent\Model;

class LedgerCategory extends Model
{
    public function ledgers()
    {
        return $this->hasMany(Ledger::class);
    }
}
