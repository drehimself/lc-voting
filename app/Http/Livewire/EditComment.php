<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Illuminate\Http\Response;
use Livewire\Component;

class EditComment extends Component
{
    public Comment $comment;
    public $body;

    protected $rules = [
        'body' => 'required|min:4',
    ];

    protected $listeners = ['setEditComment'];

    public function setEditComment($commentId)
    {
        $this->comment = Comment::findOrFail($commentId);
        $this->body = $this->comment->body;

        $this->emit('editCommentWasSet');
    }

    public function updateComment()
    {
        if (auth()->guest() || auth()->user()->cannot('update', $this->comment)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->validate();

        $this->comment->body = $this->body;
        $this->comment->save();

        $this->emit('commentWasUpdated', 'Comment was updated!');
    }

    public function render()
    {
        return view('livewire.edit-comment');
    }
}
