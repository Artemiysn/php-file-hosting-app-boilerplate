<?php

namespace App\Http\Controllers;

use App\uploadedFiles;
use App\userCommentaries;
use Illuminate\Http\Request;

class DownloadProccess extends Controller
{
    private $_uploadedFilesModel;

    public function __construct(uploadedFiles $uploadedFilesModel, userCommentaries $userCommentaries)
    {
        $this->_uploadedFilesModel = $uploadedFilesModel;
    }

    public function redirect(Request $request, \Response $response, $id)
    {
        $file = $this->_uploadedFilesModel->findOrFail($id);
        if (!$file) {
            \Log::channel('appLog')->critical('File with id: ' . $id . ' not found');
            $request->session()->flash('status', 'Ooops! Error happened! File not found');
            return redirect('/');
        }
        $path = $file->path;
        $relativePath = (function () use ($path) {
            $relpath = explode('/', $path);
            $relpath = array_slice($relpath, -2, 2, false);
            $relpath = $relpath[0] . '/' . $relpath[1];
            return $relpath;
        })();
        $updatedDownloads = $file->downloads + 1;
        $file->update(['downloads' => $updatedDownloads]);

        return response('',200)
            ->header('Content-Disposition', 'attachment; filename=' . $file->nameUser)
            ->header('Content-Type', $file->type)
            ->header('Content-Length:', $file->size)
            ->header('X-Accel-Redirect', '/uploads/' . $relativePath);
    }
}
