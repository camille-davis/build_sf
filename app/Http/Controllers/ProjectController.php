<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Project;
use App\Traits\SitewideDataTrait;
use Illuminate\Http\Request;
use Stevebauman\Purify\Facades\Purify;

class ProjectController extends Controller
{
    use SitewideDataTrait;

    public function __construct()
    {
        $this->projects = Project::getAll();
    }

    public function create()
    {
        $project = Project::createBlank();
        return redirect('/project/' . $project->slug);
    }

    public function show($slug)
    {
        // Get the project.
        $project = Project::where('slug', $slug)->first();
        if (! $project) {
            abort(404);
        }

        // Get the project's media and featured image. TODO: move to model.
        $media = Media::where('project_id', $project->id)->orderBy('weight', 'ASC')->get();
        $featuredImage = Media::find($project->featured_image_id);

        // Get sitewide data.
        $sitewideData = $this->getSitewideData();

        return view('project', array_merge([
            'project' => $project,
            'media' => $media,
            'featuredImage' => $featuredImage,
        ], $sitewideData));
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
            abort(404); // TODO: return specific error.
        }

        // Update project data.
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

        // Send success response to JS.
        if ($request->header('Content-Type') === 'application/json') {
            return response()->json(['success' => 'Project successfully updated.'], 200);
        }

        // If no JS, refresh the page to show the project content was updated.
        return redirect(url()->previous());
    }

    public function showPrev($slug)
    {
        $project = Project::where('slug', $slug)->first();
        if (! $project) {
            abort(404); // Todo: return specific error.
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
            abort(404); // Todo: return specific error.
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
        // Get the ordered array of project ids from the request.
        $data = json_decode($request->getContent(), true);

        // Update the project order.
        Project::updateWeights($data);

        // Send success response to JS.
        if ($request->header('Content-Type') === 'application/json') {
            return response()->json(['success' => 'Project successfully updated.'], 200);
        }

        // If no JS, refresh the page to show the project order was updated.
        return redirect(url()->previous());
    }

    public function discard($id)
    {
        Project::deleteAndShift($id);

        // Redirect to home page.
        return redirect('/')->with('success', 'The project was successfully deleted.');
    }
}
