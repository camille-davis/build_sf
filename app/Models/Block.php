<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Blocks display site-wide, user-editable content in a given location (e.g. 'footer').
class Block extends Model
{
    protected $fillable = ['location', 'type', 'weight', 'body'];

    // Get all blocks associated with the location, in the order that they were created.
    public static function getAllInLocation($location = null)
    {
        // If no location, get all blocks.
        if (!$location) {
            return Block::all();
        }

        return Block::where('location', $location)->orderBy('weight', 'ASC')->get();
    }

    // Create a new block with placeholder content.
    public static function createBlank($location)
    {

        // Get the existing count of blocks for that location.
        $blocks = Block::where('location', $location)->orderBy('weight', 'ASC')->get();
        $count = count($blocks);

        // Create a blank block.
        $block = Block::create([
            'body' => '<p>Add your content here!</p>',
            'type' => 'basic',
            'location' => $location,
        ]);

        // Set its weight by incrementing the last block's weight.
        if ($count !== 0) {
            $lastBlock = $blocks[$count - 1];
            $block->weight = $lastBlock->weight + 1;
        } else {
            $block->weight = 0;
        }

        $block->save();
        return $block;
    }

    // Delete a block and shift the other blocks' weights.
    public static function deleteAndShift($id)
    {
        $block = Block::find($id);
        $blocks = Block::getAllInLocation($block->location);

        $i = $block->weight + 1;
        $count = count($blocks);
        while ($i < $count) {
            $blocks[$i]->weight -= 1;
            $blocks[$i]->save();
            $i++;
        }

        $block->delete();
    }
}
