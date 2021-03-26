<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class IdeaSpamController extends Controller
{
    public function index()
    {
        $ideas = Idea::has('spams')->withCount('spams')->latest()->paginate();

        return view('backend.idea_spammed.index',compact('ideas'));
    }

    public function destroy(Idea $idea)
    {
        DB::table('votes')->where('idea_id',$idea->id)->delete();
        DB::table('comments')->where('idea_id',$idea->id)->delete();
        DB::table('idea_spam')->where('idea_id',$idea->id)->delete();
        Storage::disk('public')->delete($idea->files);

        if($idea->delete())
        {
            session()->flash('success', 'Idea deleted successfully.');

            return redirect()->route('spam.ideas');
        }
    }
}
