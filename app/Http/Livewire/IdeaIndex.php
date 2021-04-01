<?php

namespace App\Http\Livewire;

use App\Exceptions\DuplicateFavException;
use App\Exceptions\DuplicateVoteException;
use App\Exceptions\FavNotFoundException;
use App\Exceptions\VoteNotFoundException;
use App\Models\Idea;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class IdeaIndex extends Component
{
    public $idea;
    public $votesCount;
    public $commentsCount;
    public $hasVoted;
    public $hasFav;

    public function mount(Idea $idea, $votesCount,$commentsCount)
    {
        $this->idea = $idea;
        $this->votesCount = $votesCount;
        $this->commentsCount = $commentsCount;
        $this->hasVoted = $idea->voted_by_user;
        $this->hasFav = $idea->isFavByUser(auth()->user());
    }

    public function vote()
    {
        if (! auth()->check()) {
            return redirect(route('login'));
        }
        
        if ($this->hasVoted) {
            try {
                $this->idea->removeVote(auth()->user());
            } catch (VoteNotFoundException $e) {
                // do nothing
            }
            $this->votesCount--;
            $this->hasVoted = false;
        } else {
            try {
                $this->idea->vote(auth()->user());
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
                $this->idea->removeFavourite(auth()->user());
            } catch (FavNotFoundException $e) {
                // do nothing
            }

            session()->flash('success', 'Successfully removed from Favourites.');
            $this->hasFav = false;
        } else {
            try {
                $this->idea->Fav(auth()->user());
            } catch (DuplicateFavException $e) {
                // do nothing
            }
            session()->flash('success', 'Successfully added to Favourites.');

            $this->hasFav = true;
        }
    }

    public function render()
    {
        return view('livewire.idea-index');
    }

    public function deleteIdea(Idea $idea)  
    {   
        if (! auth()->check()) {
            return redirect(route('login'));
        }
        
        if ($idea->comments->count() >= 3) {
            session()->flash('error', 'You cannot delete this idea because it got more then 3 Comments.');

            return back();
        }

        if ($idea->isIdeaOwner()) {
            DB::table('votes')->where('idea_id',$idea->id)->delete();
    
            if($idea->delete())
            {
                session()->flash('success', 'Idea deleted successfully.');
    
                return redirect()->route('idea.index');
            }
        }

        session()->flash('error', 'Unauthorized Action.');
    
        return redirect()->route('idea.index');
    }
}
