<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

// Sections display user-editable content in a given page.
class Section extends Model
{
    protected $fillable = ['slug', 'type', 'title', 'body', 'image_ids', 'page_id'];

    // Get all sections associated with the page.
    public static function getAllRaw($pageID = null)
    {
        // If no page, display all sections.
        if (! $pageID) {
            return Section::all();
        }

        return Section::where('page_id', $pageID)->orderBy('weight', 'ASC')->get();
    }

    // Get all sections associated with the page, plus associated data.
    public static function getAll($pageID = null)
    {
        $sections = [];

        // Get all the sections.
        $sectionData = Section::getAllRaw($pageID);
        foreach ($sectionData as $section) {

            // If it doesn't have images, just add it.
            if ($section->type !== 'slideshow') {
                $sections[] = $section;
                continue;
            }

            // Otherwise get the images and attach them to the section.
            $image_ids = explode(' ', $section->image_ids);
            $featuredImages = Media::findManyInOrder($image_ids);
            $sectionWithImages = $section->toArray();
            $sectionWithImages['featured_images'] = $featuredImages;
            $sections[] = (object) $sectionWithImages;
        }

        return $sections;
    }

    // Create a new section with placeholder content.
    public static function createBlank($pageID)
    {
        // Get the existing count of sections for that page.
        $sections = Section::where('page_id', $pageID)->orderBy('weight', 'ASC')->get();
        $count = count($sections);

        // Create a blank section.
        $section = Section::create([
            'title' => 'New Section',
            'body' => '<p>Add your content here!</p>',
            'slug' => Str::uuid()->toString(),
            'type' => 'basic',
            'weight' => null,
            'page_id' => $pageID,
        ]);

        // Set its weight by incrementing the last section's weight.
        if ($count !== 0) {
            $lastSection = $sections[$count - 1];
            $section->weight = $lastSection->weight + 1;
        } else {
            $section->weight = 0;
        }

        $section->save();
        return $section;
    }

    // Move section up by one.
    public static function moveUp($id)
    {
        $section = Section::find($id);
        if (!$section) {
            return; // TODO return specific error.
        }

        $sections = Section::getAllRaw($section->page_id);

        // Get the previous section in the page.
        $previousSection = null;
        if (isset($sections[$section->weight - 1])) {
            $previousSection = $sections[$section->weight - 1];
        }

        // If there isn't one, do nothing.
        if (!$previousSection) {
            return;
        }

        // Switch the sections' weights.
        $section->weight -= 1;
        $previousSection->weight += 1;
        $section->save();
        $previousSection->save();
    }

    // Move section down by one.
    public static function moveDown($id)
    {
        $section = Section::find($id);
        if (!$section) {
            return; // TODO return specific error.
        }

        $sections = Section::getAllRaw($section->page_id);

        // Get the next section in the page.
        $nextSection = null;
        if (isset($sections[$section->weight + 1])) {
            $nextSection = $sections[$section->weight + 1];
        }

        // If there isn't one, do nothing.
        if (! $nextSection) {
            return;
        }

        // Switch the sections' weights.
        $section->weight += 1;
        $nextSection->weight -= 1;
        $section->save();
        $nextSection->save();
    }

    // Delete a section and shift the other blocks' weights.
    public static function deleteAndShift($id)
    {
        $section = Section::find($id);
        if (! $section) {
            return; // TODO display specific error.
        }

        $sections = Section::getAllRaw($section->page_id);

        $i = $section->weight + 1;
        $count = count($sections);
        while ($i < $count) {
            $sections[$i]->weight -= 1;
            $sections[$i]->save();
            $i++;
        }

        $section->delete();
    }
}
