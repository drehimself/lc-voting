<?php

namespace App\Http\Livewire;

use App\Exceptions\DuplicateFavException;
use App\Exceptions\DuplicateSpamException;
use App\Exceptions\DuplicateVoteException;
use App\Exceptions\FavNotFoundException;
use App\Exceptions\SpamNotFoundException;
use App\Exceptions\VoteNotFoundException;
use App\Models\Comment;
use App\Models\Idea;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class IdeaShow extends Component
{
    public $idea;
    public $votesCount;
    public $commentsCount;
    public $hasVoted;
    public $hasFav;
    public $hasMarkedSpam;
    public $commentBody;

    protected $listeners = ['comment-deleted' => 'decrementTheCommentCount'];

    public function mount(Idea $idea, $votesCount,$commentsCount)
    {
        $this->idea = $idea;
        $this->votesCount = $votesCount;
        $this->commentsCount = $commentsCount;
        $this->hasVoted = $idea->isVotedByUser(auth()->user());
        $this->hasFav = $idea->isFavByUser(auth()->user());
        $this->hasMarkedSpam = $idea->isSpammedByUser(auth()->user());
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

    public function markAsSpam()
    {
        if (! auth()->check()) {
            return redirect(route('login'));
        }

        if ($this->hasMarkedSpam) {
            try {
                $this->idea->removeSpam(auth()->user());
            } catch (SpamNotFoundException $e) {
                // do nothing
            }

            session()->flash('success', 'Successfully un-marked from    Spam.');
            $this->hasMarkedSpam = false;
        } else {
            try {
                $this->idea->Spammed(auth()->user());
            } catch (DuplicateSpamException $e) {
                // do nothing
            }
            session()->flash('success', 'Successfully marked as Spam.');

            $this->hasMarkedSpam = true;
        }
    }

    public function render()
    {
        return view('livewire.idea-show');
    }

    public function postComment()
    {
        if (! auth()->check()) {
            return redirect(route('login'));
        }

        $this->validate([
            'commentBody' => 'required',
        ]);

        Comment::create([
            'user_id' => auth()->user()->id,
            'idea_id' => $this->idea->id,
            'body' => $this->commentBody,
        ]);
        
        $this->commentBody = '';
        $this->commentsCount++;
        $this->emit('comment-saved');
    }

    public function deleteIdea(Idea $idea)
    {
        if (! auth()->check()) {
            return redirect(route('login'));
        }

        if ($idea->comments->count() > 3) {
            session()->flash('error', 'You cannot delete this idea because it got more then 3 Comments.');

            return back();
        }

        DB::table('votes')->where('idea_id',$idea->id)->delete();
        DB::table('comments')->where('idea_id',$idea->id)->delete();
        Storage::disk('public')->delete($idea->files);

        if($idea->delete())
        {
            session()->flash('success', 'Idea deleted successfully.');

            return redirect()->route('idea.index');
        }
    }
}
