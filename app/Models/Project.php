<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

// An alternative to pages, with more data, and a media gallery.
// Projects are also displayed in any 'projects'-type section.
class Project extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'weight',
        'body',
        'featured_image_id',
        'meta_description',
    ];

    // Create a new project with placeholder content.
    public static function createBlank()
    {
        // Get the existing count of projects.
        $projects = Project::orderBy('weight', 'ASC')->get();
        $count = count($projects);

        // Create a blank project.
        $project = Project::create([
            'title' => 'New Project',
            'slug' => Str::uuid()->toString(),
            'body' => '<p>Add your content here!</p>',
        ]);

        // Set its weight by incrementing the last project's weight.
        if ($count !== 0) {
            $project->weight = $projects[$count - 1]->weight + 1;
        } else {
            $project->weight = 0;
        }

        $project->save();
        return $project;
    }

    // Get all projects.
    public static function getAll()
    {
        // Loop over projects in order of weight.
        $projects = Project::orderBy('weight', 'ASC')->get();
        foreach ($projects as $project) {

            // If the project has a featured image, add it.
            if ($project->featured_image_id !== '') {
                $featuredImage = Media::find($project->featured_image_id);
                if ($featuredImage) {
                    $project->featured_image_filename = $featuredImage->filename;
                }
            }
        }

        return $projects;
    }

    // Reorder projects in order of the array given.
    public static function updateWeights($array)
    {
        foreach ($array as $index => $id) {
            $project = Project::find($id);
            if (! $project) {
                continue;
            }
            $project->weight = $index;
            $project->save();
        }
    }

    // Delete a project and shift weights of subsequent projects.
    public static function deleteAndShift($id)
    {
        $project = Project::find($id);
        if (! $project) {
            return; // TODO return specific error.
        }

        // Shift weights of subsequent projects.
        $projects = Project::orderBy('weight', 'ASC')->get();
        $i = $project->weight + 1;
        $count = count($projects);
        while ($i < $count) {
            $projects[$i]->weight -= 1;
            $projects[$i]->save();
            $i++;
        }

        // Delete all media associated with the project.
        $media = Media::where('project_id', $project->id)->get();
        foreach ($media as $medium) {
            Media::deleteAndShift($medium);
        }

        // Delete the project.
        $project->delete();
    }
}
