<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Section extends Model
{
    protected $fillable = ['slug', 'type', 'title', 'body', 'image_ids'];

    public static function getAllRaw($pageID = null)
    {
        if (! $pageID) {
            return Section::all();
        }

        return Section::where('page_id', $pageID)->orderBy('weight', 'ASC')->get();
    }

    public static function getAll($pageID = null)
    {

        $sections = [];
        $sectionData = Section::getAllRaw($pageID);

        foreach ($sectionData as $section) {
            if ($section->type !== 'slideshow') {
                $sections[] = $section;

                continue;
            }

            $ids = explode(' ', $section->image_ids);
            $featuredImages = Media::findManyInOrder($ids);
            $sectionWithImages = $section->toArray();
            $sectionWithImages['featured_images'] = $featuredImages;
            $obj = (object) $sectionWithImages;
            $sections[] = $obj;
        }

        return $sections;
    }

    public static function createBlank($pageID)
    {
        $section = Section::create([
            'title' => 'New Section',
            'body' => '<p>Add your content here!</p>',
            'slug' => Str::uuid()->toString(),
            'type' => 'basic',
            'weight' => null,
        ]);

        $sections = Section::where('page_id', $pageID)->orderBy('weight', 'ASC')->get();
        $section->page_id = $pageID;

        $count = count($sections);
        if ($count !== 0) {
            $lastSection = $sections[$count - 1];
            $section->weight = $lastSection->weight + 1;
        } else {
            $section->weight = 0;
        }

        $section->save();

        return $section;
    }

    public static function moveUp($id)
    {
        $section = Section::find($id);
        if (! $section) {
            return; // TODO
        }

        $sections = Section::getAllRaw($section->page_id);

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

        $sections = Section::getAllRaw($section->page_id);

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
        $section = Section::find($id);
        if (! $section) {
            return; // TODO
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
