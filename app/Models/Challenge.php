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

class Challenge extends Model
{
    use HasFactory;

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
        return $this->belongsToMany(User::class, 'challenge_votes');
    }

    public function favourites()
    {
        return $this->belongsToMany(User::class, 'challenge_favourites','challenge_id');
    }

    public function spams()
    {
        return $this->belongsToMany(User::class, 'challenge_spam','challenge_id');
    }

    public function comments()
    {
        return $this->hasMany(ChallengeComment::class, 'challenge_id');
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

        ChallengeVote::create([
            'challenge_id' => $this->id,
            'user_id' => $user->id,
        ]);
    }

    public function removeVote(User $user)
    {
        $voteToDelete = ChallengeVote::where('challenge_id', $this->id)
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

        ChallengeFavourite::create([
            'challenge_id' => $this->id,
            'user_id' => $user->id,
        ]);
    }

    public function removeFavourite(User $user)
    {
        $favToRemove = ChallengeFavourite::where('challenge_id', $this->id)
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

        ChallengeSpam::create([
            'challenge_id' => $this->id,
            'user_id' => $user->id,
        ]);
    }

    public function removeSpam(User $user)
    {
        $spamToRemove = ChallengeSpam::where('challenge_id', $this->id)
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
