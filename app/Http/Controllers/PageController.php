<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Project;
use App\Models\Review;
use App\Models\Section;
use App\Traits\SitewideDataTrait;
use Illuminate\Http\Request;
use Stevebauman\Purify\Facades\Purify;

class PageController extends Controller
{
    use SitewideDataTrait;

    public function create()
    {
        $page = Page::createBlank();
        return redirect('/' . $page->slug);
    }

    public function show($slug = null)
    {
        // Get the page, defaulting to homepage.
        if (!$slug) {
            $page = Page::where('homepage', 1)->first();
        } else {
            $page = Page::where('slug', $slug)->first();
        }

        // If the page couldn't be found, return 404.
        if (!$page) {
            abort(404);
        }

        // Get page sections.
        $sections = Section::getAll($page->id);

        // Get sitewide data.
        $sitewideData = $this->getSitewideData();

        // Display page.
        return view('page', array_merge([
            'page' => $page,
            'sections' => $sections,
            'reviews' => Review::getApproved(),
            'projects' => Project::getAll(),
        ], $sitewideData));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'max:120|nullable',
            'meta_description' => 'max:160|nullable',
            'slug' => 'max:50|nullable',
        ]);

        $page = Page::find($id);
        if (! $page) {
            abort(404); // TODO return specific error.
        }

        // Update page data.
        $page->update([
            'meta_description' => $request->input('meta_description'),
            'title' => $request->input('title'),
            'slug' => Purify::clean($request->input('slug')),
        ]);
        if ($request->input('weight') != '') {
            $page->update([
                'weight' => $request->input('weight'),
            ]);
        }

        // Send success response to JS.
        if ($request->header('Content-Type') === 'application/json') {
            return response()->json(['success' => 'Page successfully updated.'], 200);
        }

        // If no JS, refresh the page to show the page content was updated.
        return redirect(url()->previous());
    }

    public function updateWeights(Request $request)
    {
        Page::updateWeights($request->item_ids);

        // Send success response to JS.
        if ($request->header('Content-Type') === 'application/json') {
            return response()->json(['success' => 'success'], 200);
        }

        // If no JS, refresh the page to show the page order was updated.
        return redirect(url()->previous());
    }

    public function discard($id)
    {
        Page::deleteAndShift($id);

        // Redirect to home page.
        return redirect('/')->with('success', 'The page was successfully deleted.');
    }
}
