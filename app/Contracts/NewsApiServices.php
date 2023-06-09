<?php

namespace App\Contracts;

use Closure;
use Exception;
use GuzzleHttp\Exception\RequestException;

abstract class NewsApiServices
{
    public const OK = "Process Successful";
    public const BAD = "Process Failed";
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
    abstract public function fetchArticles(): string;

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