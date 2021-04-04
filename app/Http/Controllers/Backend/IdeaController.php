<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Paginator::useBootstrap();
        $ideas=Idea::where('user_id', Auth::id())->with(['category'])->latest()->paginate();
        return view('backend.idea.index', get_defined_vars());
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
    public function edit(Idea $idea)
    {
        $category=Category::all();
        return view('backend.idea.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Idea $idea)
    {
        $request->validate([
            'title'=>'required',
            'description'=>'required',
            'category_id'=>'required',
        ]);
        $idea->title=$request->title;
        $idea->description=$request->description;
        $idea->category_id=$request->category_id;

        if ($request->hasFile('file')) {
            if (file_exists(public_path($request->old_file))) {
                File::delete(public_path($request->old_file));
            }
            $file_name = time().rand().'.'.$request->file->extension();
            $request->file->move(public_path('/idea-photos/'), $file_name);
            $idea->files='/idea-photos/'.$file_name;
        }
       $res= $idea->save();
        if ($res) {
            return back()->with('success', 'Idea Updated Successfully');
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
