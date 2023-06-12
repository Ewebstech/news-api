<?php
namespace App\Services;

use App\Models\Feed;
use App\Models\Item;
use App\Services\NewsApiOrg;
use App\Services\TheGuardian;
use Illuminate\Support\Facades\DB;

class InitFeeds
{

    public static function getFeedData(): void
    {
        self::NewsApiOrg();

        self::TheGuardian();
    }

    private static function NewsApiOrg(): void
    {
        $newsApiOrg = new NewsApiOrg;
        $sources = $newsApiOrg->fetchSources();
        $newsApiOrg->fetchArticles($sources);
    }

    private static function TheGuardian(): void
    {
        $guardian = new TheGuardian;
        $sources = $guardian->fetchSources();
        $guardian->fetchArticles($sources);
    }

    /// Get other news api data


}
