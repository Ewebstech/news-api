<?php
namespace App\Services;

use App\Models\Feed;
use App\Models\Item;
use App\Services\NewsApiOrg;
use Illuminate\Support\Facades\DB;

class InitFeeds
{

    public static function getFeedData(): void
    {
        self::NewsApiOrg();
    }

    private static function NewsApiOrg(): void
    {
        $newsApiOrg = new NewsApiOrg;
        $sources = $newsApiOrg->fetchSources();
        $newsApiOrg->fetchArticles($sources);
    }


    /// Get other news api data


}
