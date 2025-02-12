<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Project;
use App\Models\Review;
use App\Models\Section;
use App\Models\Settings;
use Illuminate\Http\Request;
use Stevebauman\Purify\Facades\Purify;

class SectionController extends Controller
{
    public function __construct()
    {
        $this->settings = Settings::find(1);
        $this->reviews = Review::where('approved', true)->orderBy('created_at', 'desc')->get();

        $this->projects = Project::getAll();

        $url = config('app.url');
        $this->domain = preg_replace('/https?:\/\//i', '', $url);
    }

    public function create(Request $request)
    {
        $request->validate([
            'page_id' => 'numeric',
        ]);

        $section = Section::createBlank($request->page_id);

        $page = Page::find($request->page_id);
        $redirect = '/' . $page->slug;

        if ($request->header('Content-Type') !== 'application/json') {
            return redirect($redirect);
        }
        // TODO if json
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'max:120|nullable',
            'slug' => 'max:50|nullable',
            'type' => 'max:50|nullable',
            'body' => 'max:50000|nullable',
            'image_ids' => 'max:120|nullable',
        ]);

        $section = Section::find($id);
        if (! $section) {
            abort(404); // TODO
        }

        $section->update([
            'title' => $request->input('title'),
            'slug' => Purify::clean($request->input('slug')),
            'type' => Purify::clean($request->input('type')),
            'body' => Purify::clean($request->input('body')),
            'image_ids' => Purify::clean($request->input('image_ids')),
        ]);

        if ($request->header('Content-Type') !== 'application/json') {
            // TODO
        }

        return response()->json(['success' => 'success'], 200);
    }

    public function moveDown(Request $request, $id)
    {
        Section::moveDown($id);

        if ($request->header('Content-Type') !== 'application/json') {
            // TODO
        }

        return response()->json(['success' => 'success'], 200);
    }

    public function moveUp(Request $request, $id)
    {
        Section::moveUp($id);

        if ($request->header('Content-Type') !== 'application/json') {
            // TODO
        }

        return response()->json(['success' => 'success'], 200);
    }

    public function discard(Request $request, $id)
    {
        Section::deleteAndShift($id);

        if ($request->header('Content-Type') === 'application/json') {
            return response()->json(['success' => 'success'], 200);
        }

        return redirect('/');
    }
}
