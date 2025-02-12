<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Project;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function __construct()
    {
        $this->media = Media::orderBy('created_at', 'desc')->get();
        $this->settings = Settings::find(1);
    }

    public function showMediaForm()
    {
        return view('media', [
            'classes' => 'page',
            'media' => $this->media,
            'settings' => $this->settings,
        ]);
    }

    public function getMediaData($stringIDs = null)
    {
        if (! $stringIDs) {
            return $this->media;
        }

        $ids = explode(' ', $stringIDs);
        $media = Media::findManyInOrder($ids);

        return $media;
    }

    public function getProjectMediaData($projectID)
    {
        $media = Media::where('project_id', $projectID)->get();

        return $media;
    }

    public function uploadMedia(Request $request)
    {

        $request->validate([
            'file.*' => 'required|image|mimes:jpeg,png|max:2000',
            'project_id' => 'nullable',
        ]);

        $projectID = $request->input('project_id');
        $project = Project::find($projectID);

        $files = $request->file('file');

        if ($request->hasFile('file')) {
            foreach ($files as $file) {
                $rawFilename = uniqid();

                $mime = $file->getMimeType();
                if ($mime == 'image/png') {
                    $filename = $rawFilename . '.png';
                    $img = imagecreatefrompng($file);

                    imagealphablending($img, true);
                    imagesavealpha($img, true);

                    imagepng($img, storage_path('app/public/media/' . $filename));

                    $width = imagesx($img);
                    $height = imagesy($img);

                    if ($width > 767) {
                        $newWidth = 767;
                        $newHeight = intval(767 * $height / $width);

                        $newImage = imagecreatetruecolor($newWidth, $newHeight);
                        imagealphablending($newImage, false);
                        imagesavealpha($newImage, true);
                        imagecopyresampled($newImage, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                        $thumb = $newImage;
                    } else {
                        $thumb = $img;
                    }
                    imagepng($thumb, storage_path('app/public/media/' . $rawFilename . '_thumb.png'));
                } else {
                    $filename = $rawFilename . '.jpg';
                    $img = imagecreatefromjpeg($file);
                    imagejpeg($img, storage_path('app/public/media/' . $filename), 100);
                    $width = imagesx($img);
                    if ($width > 767) {
                        $thumb = imagescale($img, 767);
                    } else {
                        $thumb = $img;
                    }

                    imagejpeg($thumb, storage_path('app/public/media/' . $rawFilename . '_thumb.jpg'), 100);
                }
                if (isset($img)) {
                    imagedestroy($img);
                }
                if (isset($thumb)) {
                    imagedestroy($thumb);
                }

                if (! $project) {
                    Media::create([
                        'filename' => $filename,
                        'alt' => '',
                    ]);

                    continue;
                }

                Media::createInProject($projectID, $filename);
            }
        }

        if (! $project) {
            return redirect('/admin/media');
        }

        return redirect('/project/' . $project->slug);
    }

    public function updateMedia(Request $request, $id)
    {
        $request->validate([
            'alt' => 'max:160|nullable',
            'project_id' => 'max:50|nullable',
        ]);

        $media = Media::find($id);
        if (! $media) {
            abort(404); // TODO
        }

        $media->update([
            'alt' => $request->input('alt'),
        ]);

        $projectID = $request->input('project_id');
        if ($projectID) {
            $project = Project::find($projectID);
            if ($project) {
                $media->update([
                    'project_id' => $projectID,
                ]);
            }
        } else {
            $media->update([
                'project_id' => null,
            ]);
        }

        if ($request->header('Content-Type') !== 'application/json') {
            // TODO
        }

        return response()->json(['success' => 'success'], 200);
    }

    public function deleteMedia(Request $request, $id)
    {

        if ($request->input('current_page')) {
            $currentPage = $request->input('current_page');
        }

        $media = Media::find($id);

        Storage::delete('public/media/' . $media->filename);

        $rawFilename = explode('.', $media->filename);
        Storage::delete('public/media/' . $rawFilename[0] . '_thumb.' . $rawFilename[1]);

        if ($media->project_id == '') {
            $media->delete();

            return redirect('/admin/media');
        }

        Media::deleteAndShift($media);

        if (isset($currentPage) && $currentPage == 'media') {
            return redirect('/admin/media');
        }

        $project = Project::find($media->project_id);
        if (! $project) {
            return redirect('/admin/media');
        }

        return redirect('/project/' . $project->slug);
    }
}
