<?php

namespace App\Models\BizTools;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = ['name','website_link','monthly_cost'];
}
