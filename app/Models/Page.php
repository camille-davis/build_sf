<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'weight',
        'homepage',
        'meta_description',
    ];

    public static function createBlank()
    {
        $page = new Page;

        $pages = Page::orderBy('weight', 'ASC')->get();
        $count = count($pages);
        if ($count !== 0) {
            $page->weight = $pages[$count - 1]->weight + 1;
        } else {
            $page->homepage = 1;
            $page->weight = 0;
        }

        $page->title = 'New Page';
        $page->slug = Str::uuid()->toString();
        $page->save();

        $section = Section::createBlank($page->id);

        return $page;
    }

    public static function updateWeights($stringIDs)
    {
        $ids = explode(' ', $stringIDs);
        foreach ($ids as $key => $id) {
            $page = Page::find($id);
            if (! $page) {
                continue;
            }
            $page->weight = $key;
            $page->save();
        }
    }

    public static function deleteAndShift($id)
    {
        $page = Page::find($id);
        if (! $page) {
            return; // TODO
        }

        $pages = Page::orderBy('weight', 'ASC')->get();

        $i = $page->weight + 1;
        $count = count($pages);
        while ($i < $count) {
            $pages[$i]->weight -= 1;
            $pages[$i]->save();
            $i++;
        }

        $page->delete();
    }
}
