<?php

namespace App\Http\Controllers;

use Image;
use App\Dev;
use Storage;
use App\Project;
use App\ProjectImg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::orderBy('id', 'DESC')->get();

        return view('projects/index', [
            'projects' => $projects
        ]);
    }

    
    public function create()
    {
        $devs = Dev::select('id', 'name')->get();

        return view('projects/create', [
            'devs' => $devs
        ]);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'desc' => 'required|string',
            'imgs' => 'required',
            'imgs.*' => 'image|mimes:jpg,jpeg,png',
            'dev_ids' => 'required|array',
            'dev_ids.*' => 'integer|exists:devs,id',
        ]);

        $project = Project::create([
            'name' => $request->name,
            'desc' => $request->desc,
        ]);

        $insert_id = $project->id;

        // upload image 
        foreach ($request->imgs as $img) {
            $ext = $img->getClientOriginalExtension();
            
            $name = uniqid() . ".$ext";
            $dest = public_path() . "/uploads/projects/" . $name;
            Image::make($img)->save($dest);

            ProjectImg::create([
                'name' => $name,
                'project_id' => $insert_id,
            ]);
        }

        foreach ($request->dev_ids as $dev_id) {
            DB::insert('insert into dev_project (dev_id, project_id) 
            values (?, ?)', [$dev_id, $insert_id]);
        }

        return redirect( route('projects.index') );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::findOrFail($id);

        return view('projects/show', [
            'project' => $project
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
        $data['project'] = Project::findOrFail($id);
        $dev_ids = DB::select('select dev_id from dev_project where project_id = ?', [$id]);
        $data['devs'] = Dev::select('id', 'name')->get();
        $data['imgs'] = ProjectImg::where('project_id', $id)->get();

        $data['dev_ids'] = [];

        foreach ($dev_ids as $d) {
            array_push($data['dev_ids'], $d->dev_id);
        }
        // dd($data['dev_ids']);

        return view('projects/edit', $data);
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
