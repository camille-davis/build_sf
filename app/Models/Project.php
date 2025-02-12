<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use stdClass;

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

    public static function createBlank()
    {
        $project = new Project;

        $projects = Project::orderBy('weight', 'ASC')->get();
        $count = count($projects);
        if ($count !== 0) {
            $project->weight = $projects[$count - 1]->weight + 1;
        } else {
            $project->weight = 0;
        }

        $project->title = 'New Project';
        $project->body = '<p>Add your content here!</p>';
        $project->slug = Str::uuid()->toString();
        $project->save();

        return $project;
    }

    public static function getAll()
    {
        $projects = [];
        $projectsData = Project::orderBy('weight', 'ASC')->get();
        foreach ($projectsData as $data) {
            $project = new stdClass;
            $project->id = $data->id;
            $project->title = $data->title;
            $project->body = $data->body;
            $project->slug = $data->slug;
            $project->weight = $data->weight;

            if ($data->featured_image_id == '') {
                $projects[] = $project;

                continue;
            }

            $featuredImage = Media::find($data->featured_image_id);
            if ($featuredImage) {
                $project->featured_image_filename = $featuredImage->filename;
            }

            $projects[] = $project;
        }

        return $projects;
    }

    public static function updateWeights($array)
    {

        foreach ($array as $key => $value) {
            $project = Project::find($value);
            if (! $project) {
                continue;
            }
            $project->weight = $key;
            $project->save();
        }
    }

    public static function deleteAndShift($id)
    {
        $project = Project::find($id);
        if (! $project) {
            return; // TODO
        }

        $projects = Project::orderBy('weight', 'ASC')->get();

        $i = $project->weight + 1;
        $count = count($projects);
        while ($i < $count) {
            $projects[$i]->weight -= 1;
            $projects[$i]->save();
            $i++;
        }

        $media = Media::where('project_id', $project->id)->get();

        foreach ($media as $medium) {
            Media::deleteAndShift($medium);
        }

        $project->delete();
    }
}
