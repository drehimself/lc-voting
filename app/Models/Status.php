<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    public function ideas()
    {
        return $this->hasMany(Idea::class);
    }

    public static function getCount()
    {
        return Idea::query()
            ->selectRaw("count(*) as all_statuses")
            ->selectRaw("count(case when status_id = 1 then 1 end) as open")
            ->selectRaw("count(case when status_id = 2 then 1 end) as considering")
            ->selectRaw("count(case when status_id = 3 then 1 end) as in_progress")
            ->selectRaw("count(case when status_id = 4 then 1 end) as implemented")
            ->selectRaw("count(case when status_id = 5 then 1 end) as closed")
            ->first()
            ->toArray();
    }
}
