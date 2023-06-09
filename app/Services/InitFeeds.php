<?php
namespace App\Services;

use NewsApiOrg;
use App\Models\Feed;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class InitFeeds
{
    public function __construct(NewsApiOrg $newsApiOrg)
    {
        $this->newsApiOrg = $newsApiOrg;
    }
    public function getFeedDataFromNewsApiOrg(): void
    {
        $sources = $this->newsApiOrg->fetchSources();
        $this->newsApiOrg->fetchArticles();
    }


    /// Get other news api data


}
