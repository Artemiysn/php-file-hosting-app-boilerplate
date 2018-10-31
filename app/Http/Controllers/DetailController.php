<?php

namespace App\Http\Controllers;

use App\uploadedFiles;
use App\userCommentaries;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    private $_uploadedFilesModel;
    private $_commentariesModel;
    public function __construct(uploadedFiles $uploadedFilesModel, userCommentaries $userCommentaries)
    {
        $this->_uploadedFilesModel = $uploadedFilesModel;
        $this->_commentariesModel = $userCommentaries;
    }

    public function index(Request $request, $id)
    {
        $file = $this->_uploadedFilesModel->findOrFail($id);
        if (!$file) {
            \Log::channel('appLog')->critical('File with id: ' . $id . ' not found');
            $request->session()->flash('status', 'Ooops! Error happened! File not found');
            return redirect('/');
        }
        $commentariesArr = $file->userCommentaries->toArray();
        // convert size to Mb's
        $fileArr = $file->toArray();
        return view('detail', ['file' => $fileArr, 'commentaries' => $commentariesArr]);
    }

    public function addComment($id, Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:3|max:255',
            'userCommentaryInput' => 'required|min:3|max:255',
        ]);
        $name = $request->name;
        $content = $request->userCommentaryInput;
        $this->_commentariesModel->uploaded_files_id = $id;
        $this->_commentariesModel->content = $content;
        $this->_commentariesModel->name = $name;
        $this->_commentariesModel->save();
        $this->_uploadedFilesModel->updateSearchColumn($id, $content);
        return redirect('/detail/' . $id);
    }

}
