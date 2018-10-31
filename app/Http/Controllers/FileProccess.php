<?php

namespace App\Http\Controllers;

use App\uploadedFiles;
use Illuminate\Http\Request;
use Intervention\Image\Image;

class FileProccess extends Controller
{

    private $_uploadedFilesModel;

    public function __construct(uploadedFiles $uploadedFilesModel)
    {
        $this->_uploadedFilesModel = $uploadedFilesModel;
    }
    /**
     * proccess Uploaded file and return view file with results
     * @return bool
     */
    public function proccess(Request $request)
    {
        if (!is_uploaded_file($_FILES['file-input']['tmp_name'])) {
            \Log::channel('appLog')->critical('is_uploaded_file returned false!');
            $request->session()->flash('status', 'Ooops! Error happened!');
            return redirect('/');
        }
        $validatedData = $request->validate([
            'file-input' => 'required|max:8192',
        ]);
        // global app settings
        $baseUploadDir = \Config::get('_filehost.uploadDirectory');
        $filesInFolder = \Config::get('_filehost.files.filesInFolder');

        $lastInsertedFile = uploadedFiles::orderBy('id', 'desc')->first();
        $lastId = ($lastInsertedFile == null) ? 0 : $lastInsertedFile->id;
        // actual upload dir
        $uploadDir = $this->_createFolder($lastId, $filesInFolder, $baseUploadDir);
        // file name to save on server
        $filename = $this->_resolveFileName($lastId);
        $fullFileName = $uploadDir . '/' . $filename;
        // attempt to save file
        $moveFile = move_uploaded_file($_FILES['file-input']['tmp_name'], $fullFileName);
        if ($moveFile) {
            $populateDb = $this->_populateDB($fullFileName);
            if ($populateDb) {
                $request->session()->flash('status', 'Success!');
                return redirect('/');
            } else {
                \Log::channel('appLog')->critical('file was not saved in Database');
                $request->session()->flash('status', 'Ooops! Error happened!');
                return redirect('/');
            }
        } else {
            \Log::channel('appLog')->critical('move_uploaded_file returned false!');
            $request->session()->flash('status', 'Ooops! Error happened!');
            return redirect('/');
        }
    }

    /**
     * return or create and return folder for uplaoded file
     * @param $lastId - id of the last uploaded file
     * @param $filesInFolder - amount of files in folder as set up in config file
     * @param $baseUploadDir - uplaod dir as setup in config file
     * @return string
     */
    private function _createFolder($lastId, $filesInFolder, $baseUploadDir)
    {
        if ($lastId == 0)
            $lastId = 1;
        $folderName = $baseUploadDir . '/' . ceil($lastId / $filesInFolder) . '-' . date('Y-m-d');
        if (!file_exists($folderName) && !is_dir($folderName))
            mkdir($folderName);
        return $folderName;
    }

    /**
     * with this name the file will be saved on server
     * @param $id - uplaoded file id
     * @return string
     */
    private function _resolveFileName($id)
    {
        $id = $id + 1;
        return $id . '-' . date('Y-m-d');
    }


    /**
     * populate db if user uploaded file saved
     * @param $fullFileName - full name of the saved uploaded file
     * @return bool - returns true if successful
     */
    private function _populateDB($fullFileName)
    {

        $maxLengthName = \Config::get('_filehost.files.maxLengthName');
        $maxFileNameLength = \Config::get('_filehost.files.maxLengthName');

        $uploadedFile = $_FILES['file-input']['name'];
        $uploadedFileType = pathinfo($uploadedFile)['extension'];
        // file name length should not contain more chars then _filehost.files.maxLengthName
        $uploadedFile = (strlen($uploadedFile) > $maxLengthName)
            ? substr($uploadedFile, 0, $maxFileNameLength)
            : $uploadedFile;
        $previewPath = $this->_getPreviewPath($fullFileName, $uploadedFileType);
        $file = $this->_uploadedFilesModel->create([
            'nameUser' => $uploadedFile,
            'type' => $_FILES['file-input']['type'],
            'size' => $_FILES['file-input']['size'],
            'path' => $fullFileName,
            'preview' => $previewPath,
            'downloads' => 0
        ]);
        $fileId = $file->id;
        if ($fileId) {
            $this->_uploadedFilesModel->normaliseName($uploadedFile, $fileId);
            return true;
        } else {
            return false;
        }

    }

    //

    /**
     * @param $fullFileName - full path of uploaded file
     * @param $type - uploaded file extension
     * @return mixed|string - full path to uploaded image thumb or file type icon for preview
     */
    private function _getPreviewPath($fullFileName, $uploadedFileType)
    {
        $iconsList = $this->_getIconslist();
        $pathToIcons = \Config::get('_filehost.files.relPathToIcons');
        $defaultIcon = \Config::get('_filehost.files.defaultIcon');
        $iconsList['default'] = $pathToIcons . '/' . $defaultIcon;
        $pathToIcon = $iconsList['default'];
        foreach ($iconsList as $storedType => $path) {
            if ($storedType == $uploadedFileType) {
                if ($uploadedFileType == 'gif' || $uploadedFileType == 'jpg' || $uploadedFileType == 'jpeg' || $uploadedFileType == 'png') {
                    $pathToIcon = $this->_getThumb($fullFileName, $uploadedFileType);
                    break;
                }
                $pathToIcon = $path;
                break;
            }
        }
        return $pathToIcon;
    }

    /**
     * returns list of icons in particular folder in format like this:
     * "wav" => "/icons/wav.png"
     * @return array
     */
    private function _getIconslist()
    {
        $relPathToicons = \Config::get('_filehost.files.relPathToIcons');
        $absPathToicons = \Config::get('_filehost.files.pathToIcons');
        $iconsFiles = array_diff(scandir($absPathToicons), ['..', ',']);
        $iconsList = [];
        foreach ($iconsFiles as $file) {
            $fileArr = explode('.', $file);
            $iconsList[$fileArr[0]] = $relPathToicons . '/' . $file;
        }
        return $iconsList;
    }


    /**
     * @param $fullFileName - full path of uploaded image file
     * @param $type - uploaded file extension
     * @return array with absolute and relative path to a thumb of an image
     */
    private function _createThumbName($fullFileName, $type)
    {
        $relThumbsBaseDir = \Config::get('_filehost.files.relPathToThumbs');
        $absThumbsBaseDir = \Config::get('_filehost.files.pathToThumbs');
        $imgPathArr = pathinfo($fullFileName);
        $thumbName = $imgPathArr['filename'] . '.thumb';
        $explodedImgPathArr = explode('/', $imgPathArr['dirname']);
        $absDir = $absThumbsBaseDir . '/' . end($explodedImgPathArr);
        $relDir = $relThumbsBaseDir . '/' . end($explodedImgPathArr);
        if (!is_dir($absDir) || !file_exists($absDir)) {
            mkdir($absDir);
        }
        $fullThumbName = $absDir . '/' . $thumbName . '.' . $type;
        $relThumbName = $relDir . '/' . $thumbName . '.' . $type;
        return [
            'absThumbPath' => $fullThumbName,
            'relThumbPath' => $relThumbName
        ];
    }

    /**
     * Saves and returns path to thumb of an uploaded image
     * @param $fullFileName - full path of uploaded image file
     * @param $type - uploaded file extension
     * @return string - returns full path to uploaded image thumb
     */
    public function _getThumb($fullFileName, $type)
    {
        $thumbArr = $this->_createThumbName($fullFileName, $type);
        $thumbName = $thumbArr['absThumbPath'];
        $relThumbName = $thumbArr['relThumbPath'];
        $image = \InterventionImage::make($fullFileName);
        $thumbSizeH = \Config::get('_filehost.files.thumbsHsize');
        $thumbSizeV = \Config::get('_filehost.files.thumbsVsize');
        $image->fit($thumbSizeH, $thumbSizeV)->save($thumbName);
        return $relThumbName;
    }
}
