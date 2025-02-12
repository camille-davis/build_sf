<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Media;
use App\Models\Page;
use App\Models\Project;
use App\Models\Section;
use App\Models\Settings;
use Illuminate\Http\Request;
use Stevebauman\Purify\Facades\Purify;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->settings = Settings::find(1);
        $this->pages = Page::orderBy('weight', 'ASC')->get();
        $this->projects = Project::orderBy('weight', 'ASC')->get();
        $this->sections = Section::orderBy('weight', 'ASC')->get();
        $url = config('app.url');
        $this->domain = preg_replace('/https?:\/\//i', '', $url);
    }

    public function create()
    {
        $project = Project::createBlank();

        return redirect('/project/' . $project->slug);
    }

    public function show($slug)
    {

        $project = Project::where('slug', $slug)->first();
        if (! $project) {
            abort(404);
        }

        $media = Media::where('project_id', $project->id)->orderBy('weight', 'ASC')->get();

        $featuredImage = null;
        if (isset($project->featured_image_id) && $project->featured_image_id != '') {
            $featuredImage = Media::find($project->featured_image_id);
        }

        if ($this->settings->nav_type == 'pages') {
            $navLinks = $this->pages;
        } else {
            $homepage = Page::where('homepage', 1)->first();
            $navLinks = Section::where('page_id', $homepage->id)->orderBy('weight', 'ASC')->get();
        }

        $footerBlocks = Block::where('location', 'footer')->orderBy('weight', 'ASC')->get();

        $data = [
            'settings' => $this->settings,
            'navLinks' => $navLinks,
            'footerBlocks' => $footerBlocks,
            'project' => $project,
            'media' => $media,
            'featuredImage' => $featuredImage,
        ];

        return view('project', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'max:120|nullable',
            'meta_description' => 'max:160|nullable',
            'body' => 'max:10000|nullable',
            'slug' => 'max:50|nullable',
            'featured_image_id' => 'max:120|nullable',
        ]);

        $project = Project::find($id);
        if (! $project) {
            abort(404); // TODO
        }

        $project->update([
            'title' => $request->input('title'),
            'meta_description' => $request->input('meta_description'),
            'body' => Purify::clean($request->input('body')),
            'slug' => Purify::clean($request->input('slug')),
        ]);

        if ($request->input('featured_image_id') != '') {
            $project->update([
                'featured_image_id' => Purify::clean($request->input('featured_image_id')),
            ]);
        }

        if ($request->header('Content-Type') !== 'application/json') {
            return; // TODO
        }

        return response()->json(['success' => 'success'], 200);
    }

    public function showPrev($slug)
    {
        $project = Project::where('slug', $slug)->first();
        if (! $project) {
            abort(404);
        }

        $count = count($this->projects);
        if ($project->weight == 0) {
            $nextProject = $this->projects[$count - 1];
        } else {
            $nextProject = $this->projects[$project->weight - 1];
        }

        return redirect('/project/' . $nextProject->slug);
    }

    public function showNext($slug)
    {
        $project = Project::where('slug', $slug)->first();
        if (! $project) {
            abort(404);
        }

        $count = count($this->projects);
        if ($project->weight == $count - 1) {
            $nextProject = $this->projects[0];
        } else {
            $nextProject = $this->projects[$project->weight + 1];
        }

        return redirect('/project/' . $nextProject->slug);
    }

    public function updateWeights(Request $request)
    {

        $data = json_decode($request->getContent(), true);
        Project::updateWeights($data);
        if ($request->header('Content-Type') !== 'application/json') {
            return; // TODO
        }

        return response()->json(['success' => 'success'], 200);
    }

    public function discard(Request $request, $id)
    {
        Project::deleteAndShift($id);

        return redirect('/')->with('success', 'The project was successfully deleted.');
    }
}
