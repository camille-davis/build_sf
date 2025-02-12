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
        $this->pages = Page::orderBy('weight', 'ASC')->get();
        $this->reviews = Review::where('approved', true)->orderBy('created_at', 'desc')->get();
        $this->projects = Project::getAll();
    }

    public function create()
    {
        $page = Page::createBlank();

        return redirect('/' . $page->slug);
    }

    public function show($slug = null)
    {
        if (! $slug) {
            $page = Page::where('homepage', 1)->first();
        } else {
            $page = Page::where('slug', $slug)->first();
        }

        if ($page) {
            $sections = Section::getAll($page->id);
        } else {
            $sections = null;
        }

        if ($this->settings->nav_type == 'pages') {
            $navLinks = $this->pages;
        } else {
            $homepage = Page::where('homepage', 1)->first();
            $navLinks = Section::where('page_id', $homepage->id)->orderBy('weight', 'ASC')->get();
        }

        $footerBlocks = Block::where('location', 'footer')->orderBy('weight', 'ASC')->get();

        $data = [
            'navLinks' => $navLinks,
            'page' => $page,
            'sections' => $sections,
            'footerBlocks' => $footerBlocks,
            'settings' => $this->settings,
            'reviews' => $this->reviews,
            'projects' => $this->projects,
        ];

        return view('page', $data);
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
            abort(404); // TODO
        }

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

        if ($request->header('Content-Type') !== 'application/json') {
            return; // TODO
        }

        return response()->json(['success' => 'success'], 200);
    }

    public function updateWeights(Request $request)
    {

        Page::updateWeights($request->item_ids);
        if ($request->header('Content-Type') !== 'application/json') {
            return; // TODO
        }

        return response()->json(['success' => 'success'], 200);
    }

    public function discard(Request $request, $id)
    {
        Page::deleteAndShift($id);

        return redirect('/')->with('success', 'The page was successfully deleted.');
    }
}
