<?php

namespace App\Http\Livewire\Challenges;

use App\Exceptions\DuplicateFavException;
use App\Exceptions\DuplicateSpamException;
use App\Exceptions\DuplicateVoteException;
use App\Exceptions\FavNotFoundException;
use App\Exceptions\SpamNotFoundException;
use App\Exceptions\VoteNotFoundException;
use App\Models\Challenge;
use App\Models\ChallengeComment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ChallengeShow extends Component
{   
    public $challenge;
    public $votesCount;
    public $commentsCount;
    public $hasVoted;
    public $hasFav;
    public $hasMarkedSpam;
    public $commentBody;

    protected $listeners = ['comment-deleted' => 'decrementTheCommentCount'];

    public function mount(Challenge $challenge, $votesCount,$commentsCount)
    {
        $this->challenge = $challenge;
        $this->votesCount = $votesCount;
        $this->commentsCount = $commentsCount;
        $this->hasVoted = $challenge->isVotedByUser(auth()->user());
        $this->hasFav = $challenge->isFavByUser(auth()->user());
        $this->hasMarkedSpam = $challenge->isSpammedByUser(auth()->user());
    }

    public function decrementTheCommentCount()
    {
        $this->commentsCount--;
    }

    public function vote()
    {
        if (! auth()->check()) {
            return redirect(route('login'));
        }

        if ($this->hasVoted) {
            try {
                $this->challenge->removeVote(auth()->user());
            } catch (VoteNotFoundException $e) {
                // do nothing
            }
            $this->votesCount--;
            $this->hasVoted = false;
        } else {
            try {
                $this->challenge->vote(auth()->user());
            } catch (DuplicateVoteException $e) {
                // do nothing
            }
            $this->votesCount++;
            $this->hasVoted = true;
        }
    }

    public function fav()
    {
        if (! auth()->check()) {
            return redirect(route('login'));
        }

        if ($this->hasFav) {
            try {
                $this->challenge->removeFavourite(auth()->user());
            } catch (FavNotFoundException $e) {
                // do nothing
            }

            session()->flash('success', 'Successfully removed from Favourites.');
            $this->hasFav = false;
        } else {
            try {
                $this->challenge->Fav(auth()->user());
            } catch (DuplicateFavException $e) {
                // do nothing
            }
            session()->flash('success', 'Successfully added to Favourites.');

            $this->hasFav = true;
        }
    }

    public function markAsSpam()
    {
        if (! auth()->check()) {
            return redirect(route('login'));
        }

        if ($this->hasMarkedSpam) {
            try {
                $this->challenge->removeSpam(auth()->user());
            } catch (SpamNotFoundException $e) {
                // do nothing
            }

            session()->flash('success', 'Successfully un-marked from    Spam.');
            $this->hasMarkedSpam = false;
        } else {
            try {
                $this->challenge->Spammed(auth()->user());
            } catch (DuplicateSpamException $e) {
                // do nothing
            }
            session()->flash('success', 'Successfully marked as Spam.');

            $this->hasMarkedSpam = true;
        }
    }

    public function render()
    {
        return view('livewire.challenges.challenge-show');
    }

    public function postComment()
    {
        if (! auth()->check()) {
            return redirect(route('login'));
        }

        $this->validate([
            'commentBody' => 'required',
        ]);

        ChallengeComment::create([
            'user_id' => auth()->user()->id,
            'challenge_id' => $this->challenge->id,
            'body' => $this->commentBody,
        ]);
        
        $this->commentBody = '';
        $this->commentsCount++;
        $this->emit('comment-saved');
    }

    public function deleteIdea(Challenge $challenge)
    {
        if (! auth()->check()) {
            return redirect(route('login'));
        }

        if ($challenge->comments->count() > 3) {
            session()->flash('error', 'You cannot delete this idea because it got more then 3 Comments.');

            return back();
        }

        DB::table('challenge_votes')->where('challenge_id',$challenge->id)->delete();
        DB::table('challenge_comments')->where('challenge_id',$challenge->id)->delete();
        Storage::disk('public')->delete($challenge->files);

        if($challenge->delete())
        {
            session()->flash('success', 'Challenge deleted successfully.');
            
            return redirect()->route('challenges.index');
        }
    }
}
