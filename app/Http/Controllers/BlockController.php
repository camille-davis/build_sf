<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Page;
use App\Models\Settings;
use Illuminate\Http\Request;
use Stevebauman\Purify\Facades\Purify;

class BlockController extends Controller
{
    public function __construct()
    {
        $this->settings = Settings::find(1);
    }

    public function create(Request $request)
    {

        $request->validate([
            'location' => 'max:120|nullable',
            'current_page' => 'numeric|nullable',
        ]);

        $block = Block::createBlank($request->input('location'));

        $page = null;
        if ($request->current_page != '') {
            $page = Page::find($request->current_page);
        }
        if (! $page) {
            $redirect = '/#footer';
        } else {
            $redirect = '/' . $page->slug . '#footer';
        }

        if ($request->header('Content-Type') !== 'application/json') {
            return redirect($redirect);
        }
        // TODO if json
    }

    public function updateMultiple(Request $request)
    {

        $request->validate([
            'type[*]' => 'max:120|nullable',
            'body[*]' => 'max:10000|nullable',
        ]);

        $keys = explode(' ', $request->input('keys'));

        foreach ($keys as $id) {
            $block = Block::find($id);
            if (! $block) {
                abort(404); // TODO
            }

            $body_key = 'body[' . $id . ']';
            $type_key = 'type[' . $id . ']';

            $block->update([
                'type' => Purify::clean($request->input($type_key)),
                'body' => Purify::clean($request->input($body_key)),
            ]);
        }

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

        $request->validate([
            'current_page' => 'numeric|nullable',
        ]);

        Block::deleteAndShift($id);

        if ($request->current_page != '') {
            $page = Page::find($request->current_page);
        }
        if (! isset($page) || ! $page) {
            $redirect = '/#footer';
        } else {
            $redirect = '/' . $page->slug . '#footer';
        }

        if ($request->header('Content-Type') !== 'application/json') {
            return redirect($redirect);
        }

        return response()->json(['success' => 'success'], 200);
    }
}
