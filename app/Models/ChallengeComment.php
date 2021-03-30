<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallengeComment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','challenge_id','body'];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function isCommentOwner()
    {
        if (auth()->check()) {
            return $this->user_id == auth()->user()->id;
        }

        return false;
    }
}
