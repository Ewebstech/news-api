<?php

namespace App\Contracts;

use Closure;
use Exception;
use App\Source;
use GuzzleHttp\Exception\RequestException;

abstract class NewsApiServices
{
    public const OK = "Process Successful";
    public const BAD = "Process Failed";
    public const RATE_LIMIT = 30;
    /**
     * Fetch news sources
     *
     * @return array
     */
    abstract public function fetchSources(): array;

     /**
     * Fetch articles
     * 
     * @return array
     */
    abstract public function fetchArticles(array $source): string;

    /**
     * Handle generic exception.
     */
    protected function handleException(Exception $exception, ?string $message = null)
    {

        if ($exception instanceof RequestException && $exception->response->status() === 503) {
            $message = 'News Api Service not available';
        }

        throw new $exception;
    }
}