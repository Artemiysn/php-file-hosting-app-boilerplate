<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class uploadedFiles extends Model
{
    //

    protected $table = 'uploadedFiles';
    protected $fillable = ['nameUser', 'type', 'size', 'path', 'preview', 'downloads'];
    protected $guarded = ['id'];

    public function userCommentaries()
    {
        return $this->hasMany('\App\userCommentaries');
    }

    /**
     * adds a normalised name to a special tsvector column in uplaodedFiles table
     * @param $uploadedFile - user name for uploaded file
     * @param $id - uploaded file id in column id
     */
    public function normaliseName($uploadedFile, $id)
    {
        // replace ALL special symbols in file name including dots and underscores with spaces
        $normalisedName = preg_replace('/[-_,!=<>@#`%&;:\'\"\[\\\\^\$\.\|\?\*\+\(\)\{\}\]]/', ' ', $uploadedFile);
        // we add user name for uploaded file in the special column in our table with tsvector format for better search
        $sql = \DB::raw('UPDATE "uploadedFiles" SET searchtext = setweight(to_tsvector(coalesce(:normalisedName, \'\' )), \'A\') WHERE  "uploadedFiles".id = :id');

        $variables = [
            'normalisedName' => $normalisedName,
            'id' => $id
        ];
        \DB::select($sql, $variables);
    }

    /**
     * updates search cell value with normalised user comment
     * @param $id - file id
     * @param $content - user commentary
     */
    public function updateSearchColumn($id, $content)
    {
        // add normalised commentary to a search column for a file, with lower priority compared to file title
        $sql = \DB::raw('UPDATE "uploadedFiles" SET searchtext = coalesce(searchtext, \'\') ||  setweight(to_tsvector(coalesce(:content, \'\' )), \'B\') WHERE "uploadedFiles".id = :id ');
        $variables = [
            'content' => $content,
            'id' => $id
        ];
        \DB::select($sql, $variables);
    }

    /**
     * @param $pages - number of file per page
     * @param $normalisedInput - normalised search input
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator - returns
     * object with found file and pagination pagination
     */
    public function search($pages, $normalisedInput)
    {
         $search = DB::table('uploadedFiles')
            ->whereRaw('searchtext @@ plainto_tsquery(?)', [$normalisedInput])
            ->orderByRaw('ts_rank(searchtext, plainto_tsquery(?)) DESC', [$normalisedInput])
            ->paginate($pages);
         return $search;
    }
}
