<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $fillable = ['location', 'type', 'weight', 'body'];

    public static function getAllInLocation($location = null)
    {
        if (! $location) {
            return Block::all();
        }

        return Block::where('location', $location)->orderBy('weight', 'ASC')->get();
    }

    public static function createBlank($location)
    {
        $blocks = Block::where('location', $location)->orderBy('weight', 'ASC')->get();

        $block = Block::create([
            'body' => '<p>Add your content here!</p>',
            'type' => 'basic',
            'location' => $location,
        ]);

        $count = count($blocks);
        if ($count !== 0) {
            $lastBlock = $blocks[$count - 1];
            $block->weight = $lastBlock->weight + 1;
        } else {
            $block->weight = 0;
        }

        $block->save();

        return $block;
    }

    public static function moveUp($id)
    {
        $section = Section::find($id);
        if (! $section) {
            return; // TODO
        }

        $sections = Section::getAllInPage($section->page_id);

        $previousSection = null;
        if (isset($sections[$section->weight - 1])) {
            $previousSection = $sections[$section->weight - 1];
        }
        if (! $previousSection) {
            return;
        }

        $section->weight -= 1;
        $section->save();

        $previousSection->weight += 1;
        $previousSection->save();
    }

    public static function moveDown($id)
    {
        $section = Section::find($id);
        if (! $section) {
            return; // TODO
        }

        $sections = Section::getAllInPage($section->page_id);

        $nextSection = null;
        if (isset($sections[$section->weight + 1])) {
            $nextSection = $sections[$section->weight + 1];
        }
        if (! $nextSection) {
            return;
        }

        $section->weight += 1;
        $section->save();

        $nextSection->weight -= 1;
        $nextSection->save();
    }

    public static function deleteAndShift($id)
    {
        $block = Block::find($id);
        if (! $block) {
            return; // TODO
        }

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
