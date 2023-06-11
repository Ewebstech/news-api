<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [ 'source_id', 'author', 'title', 'description', 'url', 'urlToImage', 'publishedAt', 'last_updated' ];
}
