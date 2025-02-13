<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Page;
use App\Models\Project;
use App\Models\Review;
use App\Models\Section;
use App\Models\Settings;
use Illuminate\Http\Request;
use Stevebauman\Purify\Facades\Purify;

class PageController extends Controller
{
    public function __construct()
    {
        $this->settings = Settings::find(1);
        $this->pages = Page::getAll();
        $this->projects = Project::getAll();
        $this->reviews = Review::getApproved();
    }

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

        // TODO get sections, nav, footer in model instead.

        // Get page sections.
        $sections = Section::getAll($page->id);

        // If nav is set to 'pages', get all pages for nav links.
        if ($this->settings && $this->settings->nav_type == 'pages') {
            $navLinks = $this->pages;

        // Otherwise, if on homepage, default to homepage section links.
        } else if ($page->homepage) {
            $navLinks = Section::getAllRaw($page->id);
        }

        // Get footer blocks.
        $footerBlocks = Block::getAllInLocation('footer');

        // Display page.
        return view('page', [
            'page' => $page,
            'sections' => $sections,
            'footerBlocks' => $footerBlocks,
            'navLinks' => $navLinks,
            'settings' => $this->settings,
            'reviews' => $this->reviews,
            'projects' => $this->projects,
        ]);
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
