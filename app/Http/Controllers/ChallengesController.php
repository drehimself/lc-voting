<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Challenge;
use Illuminate\Http\Request;
use App\Models\ChallengeVote;

class ChallengesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('challenges.index', [
            'challenges' => Challenge::with('user', 'category', 'comments', 'favourites')
                ->addSelect(['voted_by_user' => ChallengeVote::select('id')
                    ->where('user_id', auth()->id())
                    ->whereColumn('challenge_id', 'challenges.id'),
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

                    return $query->whereHas('user', function ($query) use ($role) {
                        return $query->where('role_id', $role);
                    });
                })
                ->when(request()->other_filters, function ($query) {
                    if (request()->other_filters == 'popular') {
                        return $query->orderBy('votes_count', 'desc');
                    }
                })
                ->orderBy('id', 'desc')
                ->simplePaginate(Challenge::PAGINATION_COUNT),
            'challengesCount' => Challenge::count(),
            'categories'      => Category::all(),
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($challenge)
    {
        $challenge = Challenge::with('user', 'category','favourites','spams')
        ->withCount('votes','comments')
        ->where('slug',$challenge)->firstOrFail();

        return view('challenges.show', [
            'challenge' => $challenge,
            'votesCount' => $challenge->votes_count,
            'commentsCount' => $challenge->comments_count,
            'challengesCount' => Challenge::count(),
            'categories' => Category::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
