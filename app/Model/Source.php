<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{

    protected $fillable = [ 'id', 'category', 'description', 'url', 'language', 'country', 'news_source', 'last_updated'];
    protected $casts = ['id' => 'string'];

    public function sorts() {
        return $this->hasMany(SourceSort::class);
    }

}
