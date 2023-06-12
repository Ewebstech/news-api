<?php

namespace App\Model;

use App\Model\Source;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    protected $fillable = [ 'source_id', 'author', 'title', 'description', 'url', 'urlToImage', 'publishedAt', 'last_updated' ];

    /**
     * Get the source of an article.
     */
    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class, 'source_id');
    }

}
