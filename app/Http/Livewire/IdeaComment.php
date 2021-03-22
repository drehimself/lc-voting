<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Livewire\Component;
use Livewire\WithPagination;

class IdeaComment extends Component
{
    use WithPagination;

    public $idea;
    public $comment;
    public $perPage = 8;

    protected $listeners = ['comment-saved' => 'reRender'];

    public function mount($idea)
    {
        $this->idea = $idea;
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

        $comment = Comment::findOrFail($data['comment_id']);

        if ($comment->user_id == auth()->user()->id) {
            $comment->body = $data['body'];
            $comment->update();

            session()->flash('success', 'Comment Updated Successfully');
        } else {
            session()->flash('error', 'Whoops Something Went Wrong');
        }
    }

    public function deleteComment(Comment $comment)
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
        return view('livewire.idea-comment', [
            'idea'     => $this->idea,
            'comments' => Comment::with('user')->where('idea_id', $this->idea->id)->orderBy('id', 'desc')->paginate($this->perPage),
        ]);
    }
}
