<?php

namespace App\Models\BizTools;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $fillable = ['title','short_id','class'];

    public function leads()
    {
        return $this->hasMany(SalesLeadsAndCustomer::class,'board_id')->where('is_customer',false);
    }
}
