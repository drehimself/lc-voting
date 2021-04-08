<?php

namespace App\Models\BizTools;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['subject','board_id','status','due_date','sort_order'];

    protected $casts = [
        'due_date' => 'datetime:Y-m-d',
    ];

    public function board()
    {
        return $this->belongsTo(TaskBoard::class)->withDefault([
            'name' => 'Not Assigned',
        ]);
    }
}
