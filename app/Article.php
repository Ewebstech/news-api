<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [ 'source_id', 'author', 'title', 'description', 'url', 'urlToImage', 'publishedAt', 'NG_Description', 'NG_Review' ];
}
