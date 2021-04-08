<?php

namespace App\Models\BizTools;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SalesLeadsAndCustomer extends Model
{
    protected $table = 'sales_leads';

    protected $fillable = [ 'title', 'position', 'is_customer', 'name', 'last_name',
        'board_id', 'category', 'telephone', 'email', 'source', 'notes', 'class',
        'last_contacted', 'sort_order'
    ];

    public function board()
    {
        return $this->belongsTo(Board::class, 'board_id');
    }

    public function scopeLeads($query)
    {
        return $query->where('is_customer', false);
    }

    public function scopeCustomers($query)
    {
        return $query->where('is_customer', true);
    }

    /**
    * Get the user's first name.
    *
    * @param  string  $value
    * @return string
    */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }
}
