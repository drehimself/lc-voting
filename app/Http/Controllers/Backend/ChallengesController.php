<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ChallengesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Paginator::useBootstrap();
        $challenges=Challenge::where('user_id', Auth::id())->with(['category'])->latest()->paginate();
        return view('backend.challenges.index', get_defined_vars());
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Challenge $challenge)
    {
        $category=Category::all();
        return view('backend.challenges.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Challenge $challenge)
    {
        $request->validate([
            'title'=>'required',
            'description'=>'required',
            'category_id'=>'required',
        ]);
        $challenge->title=$request->title;
        $challenge->description=$request->description;
        $challenge->category_id=$request->category_id;

        if ($request->hasFile('file')) {
            if (file_exists(public_path($request->old_file))) {
                File::delete(public_path($request->old_file));
            }
            $file_name = time().rand().'.'.$request->file->extension();
            $request->file->move(public_path('/challenge-photos/'), $file_name);
            $challenge->files='/challenge-photos/'.$file_name;
        }
       $res= $challenge->save();
        if ($res) {
            return back()->with('success', 'Challenge Updated Successfully');
        } else {
            return back()->with('error', 'Whoops Something Went Wrong.');
        }
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
