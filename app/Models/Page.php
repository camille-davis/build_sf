<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

// A page in the website.
class Page extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'weight',
        'homepage',
        'meta_description',
    ];

    // Get all pages in order of the weight set in the nav.
    public static function getAll()
    {
        return Page::orderBy('weight', 'ASC')->get();
    }

    // Create a new page with placeholder content.
    public static function createBlank()
    {
        // Get the existing count of pages.
        $pages = Page::orderBy('weight', 'ASC')->get();
        $count = count($pages);

        // Create a blank page.
        $page = Page::create([
            'title' => 'New Page',
            'slug' => Str::uuid()->toString(),
        ]);

        // Set its weight by incrementing the last page's weight.
        if ($count !== 0) {
            $page->weight = $pages[$count - 1]->weight + 1;
        } else {
            $page->weight = 0;

            // If no last page, set the page to homepage.
            $page->homepage = 1;
        }

        // Save the page, and create a blank section.
        $page->save();
        Section::createBlank($page->id);

        return $page;
    }

    // Reorder pages in the given order.
    public static function updateWeights($stringIDs)
    {
        $ids = explode(' ', $stringIDs);
        foreach ($ids as $index => $id) {
            $page = Page::find($id);
            if (! $page) {
                continue;
            }

            // Set the page's weight to its index in the list of IDs.
            $page->weight = $index;
            $page->save();
        }
    }

    // Delete a page and shift weights of subsequent pages.
    public static function deleteAndShift($id)
    {
        $page = Page::find($id);
        if (! $page) {
            return; // TODO display specific error.
        }

        // Shift weights of subsequent pages.
        $pages = Page::orderBy('weight', 'ASC')->get();
        $i = $page->weight + 1;
        $count = count($pages);
        while ($i < $count) {
            $pages[$i]->weight -= 1;
            $pages[$i]->save();
            $i++;
        }

        // Delete the page's sections.
        $sections = Section::getAll($page->id);
        foreach ($sections as $section) {
            Section::deleteAndShift($section->id);
        }

        // Delete the page.
        $page->delete();
    }
}
