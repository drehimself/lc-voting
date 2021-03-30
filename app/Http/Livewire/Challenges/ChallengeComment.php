<?php

namespace App\Http\Livewire\Challenges;

use App\Models\ChallengeComment as ModelsChallengeComment;
use Livewire\Component;
use Livewire\WithPagination;

class ChallengeComment extends Component
{
    use WithPagination;

    public $challenge;
    public $comment;
    public $perPage = 8;

    protected $listeners = ['comment-saved' => 'reRender'];

    public function mount($challenge)
    {
        $this->challenge = $challenge;
    }

    public function loadMore()
    {
        $this->perPage += 2;
    }

    public function reRender()
    {
        //
    }

    public function updateComment($data)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $comment = ModelsChallengeComment::findOrFail($data['comment_id']);

        if ($comment->user_id == auth()->user()->id) {
            $comment->body = $data['body'];
            $comment->update();

            session()->flash('success', 'Comment Updated Successfully');
        } else {
            session()->flash('error', 'Whoops Something Went Wrong');
        }
    }

    public function deleteComment(ModelsChallengeComment $comment)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        if ($comment->user_id == auth()->user()->id) {
            $comment->delete();

            $this->emit('comment-deleted');
            session()->flash('success', 'Comment Deleted Successfully');
        } else {
            session()->flash('error', 'Un-authorized Action');
        }
    }

    public function render()
    {
        return view('livewire.challenges.challenge-comment', [
            'challenge'     => $this->challenge,
            'comments' => ModelsChallengeComment::with('user')->where('challenge_id', $this->challenge->id)->orderBy('id', 'desc')->paginate($this->perPage),
        ]);
    }
}
