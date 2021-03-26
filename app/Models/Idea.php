<?php

namespace App\Models;

use App\Exceptions\DuplicateFavException;
use App\Exceptions\DuplicateSpamException;
use App\Exceptions\DuplicateVoteException;
use App\Exceptions\FavNotFoundException;
use App\Exceptions\SpamNotFoundException;
use App\Exceptions\VoteNotFoundException;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    use HasFactory, Sluggable;

    const PAGINATION_COUNT = 10;

    protected $guarded = [];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function votes()
    {
        return $this->belongsToMany(User::class, 'votes');
    }

    public function favourites()
    {
        return $this->belongsToMany(User::class, 'favourites','idea_id');
    }

    public function spams()
    {
        return $this->belongsToMany(User::class, 'idea_spam','idea_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'idea_id');
    }

    public function isVotedByUser(?User $user)
    {
        if (!$user) {
            return false;
        }

        return $this->votes->pluck('id')->contains($user->id);
    }

    public function vote(User $user)
    {
        if ($this->isVotedByUser($user)) {
            throw new DuplicateVoteException;
        }

        Vote::create([
            'idea_id' => $this->id,
            'user_id' => $user->id,
        ]);
    }

    public function removeVote(User $user)
    {
        $voteToDelete = Vote::where('idea_id', $this->id)
            ->where('user_id', $user->id)
            ->first();

        if ($voteToDelete) {
            $voteToDelete->delete();
        } else {
            throw new VoteNotFoundException();
        }
    }

    public function isFavByUser(?User $user)
    {
        if (!$user) {
            return false;
        }

        return $this->favourites->pluck('id')->contains($user->id);
    }

    public function Fav(User $user)
    {
        if ($this->isFavByUser($user)) {
            throw new DuplicateFavException();
        }

        Favourite::create([
            'idea_id' => $this->id,
            'user_id' => $user->id,
        ]);
    }

    public function removeFavourite(User $user)
    {
        $favToRemove = Favourite::where('idea_id', $this->id)
            ->where('user_id', $user->id)
            ->first();

        if ($favToRemove) {
            $favToRemove->delete();
        } else {
            throw new FavNotFoundException();
        }
    }

    public function isSpammedByUser(?User $user)
    {
        if (!$user) {
            return false;
        }

        return $this->spams->pluck('id')->contains($user->id);
    }

    public function Spammed(User $user)
    {
        if ($this->isSpammedByUser($user)) {
            throw new DuplicateSpamException();
        }

        IdeaSpam::create([
            'idea_id' => $this->id,
            'user_id' => $user->id,
        ]);
    }

    public function removeSpam(User $user)
    {
        $spamToRemove = IdeaSpam::where('idea_id', $this->id)
            ->where('user_id', $user->id)
            ->first();

        if ($spamToRemove) {
            $spamToRemove->delete();
        } else {
            throw new SpamNotFoundException();
        }
    }

    public function isIdeaOwner()
    {
        if (auth()->check()) {    
            return $this->user_id == auth()->user()->id;
        }

        return false;
    }
}
