<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userCommentaries extends Model
{
    protected $table = 'userCommentaries';

    protected $fillable = ['content', 'uploadedFiles_id', 'name'];

    protected $guarded = ['id' ];

    public function file()
    {
        return $this->belongsTo('uploadedFiles');
    }
}
