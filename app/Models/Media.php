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

    // Create media for a given project.
    public static function createInProject($projectID, $filename)
    {
        // Get the existing count of media in the project.
        $mediaInProject = Media::where('project_id', $projectID)->orderBy('weight', 'ASC')->get();
        $count = count($mediaInProject);

        // Create new media from the file details.
        $media = Media::create([
            'filename' => $filename,
            'project_id' => Purify::clean($projectID),
            'alt' => '',
        ]);

        // Set its weight by incrementing the last media's weight.
        if ($count !== 0) {
            $lastMedia = $mediaInProject[$count - 1];
            $media->weight = $lastMedia->weight + 1;
        } else {
            $media->weight = 0;
        }

        $media->save();
        return $media;
    }

    // Get media in a given order.
    public static function findManyInOrder($ids)
    {
        $collection = [];
        foreach ($ids as $id) {
            $collection[] = Media::find($id);
        }

        return $collection;
    }

    // Delete a media and shift weights of subsequent media.
    public static function deleteAndShift($id)
    {
        $media = Media::find($id);
        if (! $media) {
            return; // TODO display specific error.
        }

        // Shift weights of subsequent media in project.
        $mediaInProject = Media::where('project_id', $media->project_id)->orderBy('weight', 'ASC')->get();
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
