<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Stevebauman\Purify\Facades\Purify;

class SectionController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'page_id' => 'numeric',
        ]);

        // Create an empty section in the given page.
        Section::createBlank($request->page_id);

        // Send success response to JS.
        if ($request->header('Content-Type') === 'application/json') {
            // TODO
        }

        // If no JS, refresh the page to display the new section.
        return redirect(url()->previous());
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

        // Update the section.
        $section = Section::find($id);
        if (!$section) {
            return response()->json([
                'errors' => [
                    '0' => 'Error: the section you are trying to edit does not exist. Please refresh the page and try again.'
                ]
            ], 404);
        }
        $section->update([
            'title' => $request->input('title'),
            'slug' => Purify::clean($request->input('slug')),
            'type' => Purify::clean($request->input('type')),
            'body' => Purify::clean($request->input('body')),
            'image_ids' => Purify::clean($request->input('image_ids')),
        ]);

        // Send success response to JS.
        if ($request->header('Content-Type') === 'application/json') {
            return response()->json([
                'redirect' => url()->previous(),
            ], 301);
        }

        // If no JS, refresh the page to show the section content was updated.
        return redirect(url()->previous());
    }

    public function moveDown(Request $request, $id)
    {
        Section::moveDown($id);

        // Send success response to JS.
        if ($request->header('Content-Type') === 'application/json') {
            return response()->json(['success' => 'Section was successfully moved down.'], 200);
        }

        // If no JS, refresh the page to show section order was updated.
        return redirect(url()->previous());
    }

    public function moveUp(Request $request, $id)
    {
        Section::moveUp($id);

        // Send success response to JS.
        if ($request->header('Content-Type') === 'application/json') {
            return response()->json(['success' => 'Section was successfully moved up.'], 200);
        }

        // If no JS, refresh the page to show section order was updated.
        return redirect(url()->previous());
    }

    public function discard(Request $request, $id)
    {
        // Delete the section.
        Section::deleteAndShift($id);

        // Send success response to JS.
        if ($request->header('Content-Type') === 'application/json') {
            return response()->json(['success' => 'Section was successfully deleted.'], 200);
        }

        // If no JS, refresh the page to show the section was deleted.
        return redirect(url()->previous());
    }
}
