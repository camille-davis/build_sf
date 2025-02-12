<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stevebauman\Purify\Facades\Purify;

class Media extends Model
{
    protected $fillable = [
        'filename',
        'alt',
        'project_id',
        'weight',
    ];

    public static function createInProject($projectID, $filename)
    {

        $mediaInProject = Media::where('project_id', $projectID)
            ->orderBy('weight', 'ASC')->get();

        $media = Media::create([
            'filename' => $filename,
            'project_id' => Purify::clean($projectID),
            'alt' => '',
        ]);

        $count = count($mediaInProject);

        if ($count !== 0) {
            $lastMedia = $mediaInProject[$count - 1];
            $media->weight = $lastMedia->weight + 1;
        } else {
            $media->weight = 0;
        }

        $media->save();

        return $media;
    }

    public static function findManyInOrder($ids)
    {
        $collection = [];
        foreach ($ids as $id) {
            $collection[] = Media::find($id);
        }

        return $collection;
    }

    public static function deleteAndShift($media)
    {
        $mediaInProject = Media::where('project_id', $media->project_id)
            ->orderBy('weight', 'ASC')->get();

        $i = $media->weight + 1;
        $count = count($mediaInProject);
        while ($i < $count) {
            $mediaInProject[$i]->weight -= 1;
            $mediaInProject[$i]->save();
            $i++;
        }

        $media->delete();
    }
}
