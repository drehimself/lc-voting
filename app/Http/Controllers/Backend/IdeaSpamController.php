<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class IdeaSpamController extends Controller
{
    public function index()
    {
        if (!request()->has('filter')  || (request()->filter == '') || (request()->filter == 'idea')) {
            $ideas = Idea::has('spams')->withCount('spams')->latest()->paginate();
        }
        else
        {
            $ideas = Challenge::has('spams')->withCount('spams')->latest()->paginate();
        }

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

    public function destroyChallenge($challenge)
    {
        $challenge = Challenge::findOrFail($challenge);
        DB::table('challenge_votes')->where('challenge_id',$challenge->id)->delete();
        DB::table('challenge_comments')->where('challenge_id',$challenge->id)->delete();
        DB::table('challenge_spam')->where('challenge_id',$challenge->id)->delete();
        Storage::disk('public')->delete($challenge->files);

        if($challenge->delete())
        {
            session()->flash('success', 'Challenge deleted successfully.');

            return redirect()->route('spam.ideas');
        }
    }
}
