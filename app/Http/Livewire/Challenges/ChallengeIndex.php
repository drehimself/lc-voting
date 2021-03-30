<?php

namespace App\Http\Livewire\Challenges;

use App\Exceptions\DuplicateFavException;
use App\Exceptions\DuplicateVoteException;
use App\Exceptions\FavNotFoundException;
use App\Exceptions\VoteNotFoundException;
use App\Models\Challenge;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ChallengeIndex extends Component
{
    public $challenge;
    public $votesCount;
    public $commentsCount;
    public $hasVoted;
    public $hasFav;

    public function mount(Challenge $challenge, $votesCount,$commentsCount)
    {
        $this->challenge = $challenge;
        $this->votesCount = $votesCount;
        $this->commentsCount = $commentsCount;
        $this->hasVoted = $challenge->voted_by_user;
        $this->hasFav = $challenge->isFavByUser(auth()->user());
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

    public function render()
    {
        return view('livewire.challenges.challenge-index');
    }

    public function deleteIdea(Challenge $challenge)  
    {   
        if (! auth()->check()) {
            return redirect(route('login'));
        }
        
        if ($challenge->comments->count() >= 3) {
            session()->flash('error', 'You cannot delete this idea because it got more then 3 Comments.');

            return back();
        }

        if ($challenge->isIdeaOwner()) {
            DB::table('challenge_votes')->where('challenge_id',$challenge->id)->delete();
    
            if($challenge->delete())
            {
                session()->flash('success', 'Challenge deleted successfully.');
    
                return redirect()->route('challenges.index');
            }
        }

        session()->flash('error', 'Unauthorized Action.');
    
        return redirect()->route('challenges.index');
    }
}
