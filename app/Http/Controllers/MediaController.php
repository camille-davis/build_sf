<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Project;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MediaController extends Controller
{
    public function __construct()
    {
        $this->mediaByDate = Media::orderBy('created_at', 'desc')->get();
    }

    public function showMediaForm()
    {
        return view('media', [
            'classes' => 'page',
            'media' => $this->mediaByDate,
            'settings' => Settings::find(1),
        ]);
    }

    // Get media from IDs in a given order.
    public function getMedia($stringIDs = null)
    {
        // If no order given, return media by order of upload date.
        if (! $stringIDs) {
            return $this->mediaByDate;
        }

        // Return media in the requested order.
        $ids = explode(' ', $stringIDs);
        $media = Media::findManyInOrder($ids);
        return $media;
    }

    // Get a given project's media.
    public function getProjectMedia($projectID)
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

        /// Loop through the uploaded files.
        if ($request->hasFile('file')) {
            $files = $request->file('file');
            foreach ($files as $file) {

                // Generate filename (without extension).
                $rawFilename = uniqid();

                $mime = $file->getMimeType();

                // Process PNG.
                if ($mime == 'image/png') {

                    // Create PNG image.
                    $filename = $rawFilename . '.png';
                    $img = imagecreatefrompng($file);
                    imagealphablending($img, true);
                    imagesavealpha($img, true);

                    // Create PNG thumbnail.
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

                    // Save PNG files.
                    imagepng($img, storage_path('app/public/media/' . $filename));
                    imagepng($thumb, storage_path('app/public/media/' . $rawFilename . '_thumb.png'));
                } else {

                    // Process JPG. Todo: add additional image compatibility.
                    // Create JPG image.
                    $filename = $rawFilename . '.jpg';
                    $img = imagecreatefromjpeg($file);

                    // Create JPG thumbnail.
                    $width = imagesx($img);
                    if ($width > 767) {
                        $thumb = imagescale($img, 767);
                    } else {
                        $thumb = $img;
                    }

                    // Save JPG files.
                    imagejpeg($img, storage_path('app/public/media/' . $filename), 100);
                    imagejpeg($thumb, storage_path('app/public/media/' . $rawFilename . '_thumb.jpg'), 100);
                }

                // Clear memory.
                if (isset($img)) {
                    imagedestroy($img);
                }
                if (isset($thumb)) {
                    imagedestroy($thumb);
                }

                // If no project ID given, create a Media entry with no project ID.
                if (! $projectID) {
                    Media::create([
                        'filename' => $filename,
                        'alt' => '',
                    ]);

                    continue;
                }

                // Otherwise create a Media entry associated with the project.
                Media::createInProject($projectID, $filename);
            }
        }

        // If no project ID, redirect to media admin page.
        if (! $projectID) {
            return redirect('/admin/media');
        }

        // Otherwise redirect to the project page.
        return redirect('/project/' . Project::find($projectID)->slug);
    }

    public function updateMedia(Request $request, $id)
    {
        $request->validate([
            'alt' => 'max:160|nullable',
            'project_id' => 'max:50|nullable',
        ]);

        $media = Media::find($id);
        if (! $media) {
            abort(404); // TODO: return specific error.
        }

        // Check if media is part of a project.
        $projectID = $request->input('project_id');

        // If project could not be found, show error. TODO: display on frontend.
        if ($projectID && !Project::find($projectID)) {
            return response()->json([
                'errors' => [
                    '0' => 'Error: that project does not exist.'
                ]
            ], 404);
        }

        // Update media.
        $media->update([
            'alt' => $request->input('alt'),
            'project_id' => $projectID,
        ]);

        // Send success message to JS.
        if ($request->header('Content-Type') === 'application/json') {
            return response()->json(['success' => 'Media successfully updated.'], 200);
        }
    }

    public function deleteMedia($id)
    {
        // Delete the image and thumbnail from storage.
        $media = Media::find($id);
        $rawFilename = explode('.', $media->filename);
        File::delete(storage_path('app/public/media/' . $media->filename));
        File::delete(storage_path('app/public/media/' . $rawFilename[0] . '_thumb.' . $rawFilename[1]));

        // If media is part of a project, delete it and shift weight of other media in project.
        if ($media->project_id) {
            Media::deleteAndShift($id);
        } else {

            // Otherwise just delete the media.
            $media->delete();
        }

        return redirect(url()->previous());
    }
}
