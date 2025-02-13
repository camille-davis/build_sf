<?php

namespace App\Http\Controllers;

use App\Models\Block;
use Illuminate\Http\Request;
use Stevebauman\Purify\Facades\Purify;

class BlockController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'location' => 'max:120|nullable',
        ]);

        // Create an empty block in the given location.
        Block::createBlank($request->input('location'));

        // Send success response to JS.
        if ($request->header('Content-Type') === 'application/json') {
            // TODO
        }

        // If no JS, refresh the page to display the new block.
        return redirect(url()->previous() . '#footer');
    }

    public function updateMultiple(Request $request)
    {
        // Get block ids.
        $block_ids = explode(',', $request->input('block_ids'));

        // Create validation rules, and validate request.
        $rules = [];
        foreach($block_ids as $id) {
            $rules['block_' . $id . '_type'] = 'max:120|nullable';
            $rules['block_' . $id . '_body'] = 'max:10000|nullable';
        }
        $request->validate($rules);

        // Update each block.
        foreach ($block_ids as $id) {
            $block = Block::find($id);
            if (!$block) {
                return response()->json([
                    'errors' => [
                        '0' => 'Error: the content you are trying to edit does not exist. Please refresh the page and try again.'
                    ]
                ], 404);
            }

            $block->update([
                'type' => Purify::clean($request->input('block_' . $id . '_type')),
                'body' => Purify::clean($request->input('block_' . $id . '_body')),
            ]);
        }

        // Send success response to JS.
        if ($request->header('Content-Type') === 'application/json') {
            return response()->json(['success' => 'Block was successfully updated.'], 200);
        }

        // If no JS, refresh the page to show the blocks were updated.
        return redirect(url()->previous());
    }

    public function discard(Request $request, $id)
    {
        // Delete the block.
        Block::deleteAndShift($id);

        // Send success response to JS.
        if ($request->header('Content-Type') === 'application/json') {
            // TODO
        }

        // If no JS, refresh the page to show the block was deleted.
        return redirect(url()->previous() . '#footer');
    }
}
