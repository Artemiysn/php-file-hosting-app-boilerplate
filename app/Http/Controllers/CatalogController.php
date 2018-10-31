<?php

namespace App\Http\Controllers;

use App\uploadedFiles;
use Illuminate\Http\Request;

class CatalogController extends Controller
{

    private $_uploadedFilesModel;

    public function __construct(uploadedFiles $uploadedFilesModel)
    {
        $this->_uploadedFilesModel = $uploadedFilesModel;
    }

    public function index()
    {
        // пагинацию
        $pages = \Config::get('_filehost.pagination');
        $files = $this->_uploadedFilesModel->paginate($pages);
        return view('catalog', ['files' => $files]);
    }

    public function search(Request $request)
    {
        $pages = \Config::get('_filehost.pagination');
        $getSearchRequest = $request->input('search-input');
        // replace everything except letters to spaces. Note! regex like [^a-z]
        // is not precise with languages other the english
        $normalisedInput = preg_replace('/[-_,!=<>@#`%&;:"\[\\\^\$\.\|\?\*\+\(\)\{\}\]]/', ' ', $getSearchRequest);
        $files = $this->_uploadedFilesModel->search($pages, $normalisedInput);
        if ($files->total() == 0) {
            $request->session()->flash('status', 'Nothing was found!');
            return redirect('/');
        }
        return view('catalog', ['files' => $files]);
    }
}
