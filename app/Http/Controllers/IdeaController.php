<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Vote;
use App\Models\Category;
use App\Models\Favourite;
use Illuminate\Http\Request;
use App\Exceptions\FavNotFoundException;
use App\Models\Challenge;
use App\Models\ChallengeVote;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('idea.index', [
            'ideas' => Idea::with('user', 'category', 'comments', 'favourites')
                ->addSelect(['voted_by_user' => Vote::select('id')
                    ->where('user_id', auth()->id())
                    ->whereColumn('idea_id', 'ideas.id'),
                ])
                ->withCount('votes', 'comments')
                ->when(request()->search, function ($query) {
                    return $query->where('title', 'LIKE', '%' . request()->search . '%');
                })
                ->when(request()->category, function ($query) {
                    return $query->where('category_id', request()->category);
                })
                ->when(request()->source, function ($query) {
                    $role = '1';
                    switch (request()->source) {
                        case 'user':
                            $role = 1;
                            break;
                        case 'admin':
                            $role = 0;
                            break;
                        case 'brand':
                            $role = 2;
                            break;
                    }
                    if (request()->source == 'self' && auth()->check()) {
                        return $query->where('user_id', auth()->user()->id);
                    } else {
                        return $query->whereHas('user', function ($query) use ($role) {
                            return $query->where('role_id', $role);
                        });
                    }
                })
                ->when(request()->other_filters, function ($query) {
                    if (request()->other_filters == 'popular') {
                        return $query->orderBy('votes_count', 'desc');
                    }
                })
                ->orderBy('id', 'desc')
                ->simplePaginate(Idea::PAGINATION_COUNT),
            'ideasCount' => Idea::count(),
            'categories' => Category::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Response
     */
    public function show($idea)
    {
        $idea = Idea::with('user', 'category', 'favourites', 'spams')
        ->withCount('votes', 'comments')
        ->where('slug', $idea)->firstOrFail();

        return view('idea.show', [
            'idea'          => $idea,
            'votesCount'    => $idea->votes_count,
            'commentsCount' => $idea->comments_count,
            'ideasCount'    => Idea::count(),
            'categories'    => Category::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Response
     */
    public function edit(Idea $idea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Idea $idea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Response
     */
    public function destroy(Idea $idea)
    {
        //
    }

    /**
     * Show Fav Idea's
     *
     */
    public function showFavourites()
    {
        if (!request()->has('filter') || (request()->filter == '') || (request()->filter == 'idea')) {
            $favs = Idea::with('user', 'category', 'favourites')
                        ->addSelect(['voted_by_user' => Vote::select('id')
                            ->where('user_id', auth()->id())
                            ->whereColumn('idea_id', 'ideas.id'),
                        ])
                        ->whereHas('favourites', function ($query) {
                            return $query->where('user_id', auth()->user()->id);
                        })
                        ->withCount('votes', 'comments')
                        ->orderBy('id', 'desc')
                        ->simplePaginate(Idea::PAGINATION_COUNT);
        } else {
            $favs = Challenge::with('user', 'category', 'favourites')
                    ->addSelect(['voted_by_user' => ChallengeVote::select('id')
                        ->where('user_id', auth()->id())
                        ->whereColumn('challenge_id', 'challenges.id'),
                    ])
                    ->whereHas('favourites', function ($query) {
                        return $query->where('user_id', auth()->user()->id);
                    })
                    ->withCount('votes', 'comments')
                    ->orderBy('id', 'desc')
                    ->simplePaginate(Idea::PAGINATION_COUNT);
        }

        return view('idea.favourites', [
            'favs'       => $favs,
            'ideasCount' => null,
            'categories' => Category::all(), ]);
    }

    /**
     * Remove Fav Idea's
     *
     */
    public function removeFav($idea)
    {
        $favToRemove = Favourite::where('idea_id', $idea)
            ->where('user_id', auth()->user()->id)
            ->first();

        if ($favToRemove) {
            $favToRemove->delete();

            return back()->with('success', 'Removed From Favourites Successfully');
        } else {
            throw new FavNotFoundException();
            return back()->with('error', 'Whoops Something Went Wrong.');
        }
    }
}
