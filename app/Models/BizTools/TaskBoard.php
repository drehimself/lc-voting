<?php

namespace App\Models\BizTools;

use Illuminate\Database\Eloquent\Model;

class TaskBoard extends Model
{
    protected $fillable = ['name','user_id','class'];

    public function tasks()
    {
        return $this->hasMany(Task::class,'board_id');
    }
}
