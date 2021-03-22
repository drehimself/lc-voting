<?php

namespace App\Http\Livewire;

use App\Exceptions\DuplicateVoteException;
use App\Exceptions\VoteNotFoundException;
use App\Models\Comment;
use App\Models\Idea;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class IdeaShow extends Component
{
    public $idea;
    public $votesCount;
    public $commentsCount;
    public $hasVoted;
    public $commentBody;

    protected $listeners = ['comment-deleted' => 'decrementTheCommentCount'];

    public function mount(Idea $idea, $votesCount,$commentsCount)
    {
        $this->idea = $idea;
        $this->votesCount = $votesCount;
        $this->commentsCount = $commentsCount;
        $this->hasVoted = $idea->isVotedByUser(auth()->user());
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

        if($idea->delete())
        {
            session()->flash('success', 'Idea deleted successfully.');

            return redirect()->route('idea.index');
        }
    }
}
