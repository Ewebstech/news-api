<?php

namespace App\Model;

use App\Model\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Source extends Model
{

    protected $fillable = [ 'id', 'category', 'description', 'url', 'language', 'country', 'news_source', 'last_updated'];
    protected $casts = ['id' => 'string'];

     /**
     * Get the articles from a source.
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'source_id');
    }

}
