ng-newsapi
===

**ng-newsapi** is the result of a code challenge presented in 2017. The result is a Laravel-powered API built to consume the [NewsAPI](https://newsapi.org) service, store it locally, and allow querying

**Project Specifications**

> 1. Pick one of these API’s: 
> https://newsapi.org/
> https://skyscanner.github.io/slate/#api-documentation
> 2. Create an API to consume that API using Laravel
> 3. Append each ‘record’ with two fields e.g NG_Description and NG_Review
> 4. Output a list of records (edited)

**Setup**

1. Clone the repository
2. Run `composer install`
3. Copy the `.env-dist` file into `.env`
4. Update `.env` with your database credentials and News API key
5. Run `php artisan migrate` to create the database structure
6. run `php artisan serve` to spin up a localhost instance

From here, you can go to the `/api/sources` endpoint to pull in the news sources. Imported data is created in the local database, with additional `NG_Description` and `NG_Review` fields, and the results are output in JSON format.

Using the `id` attribute, you can then consume individual sources by sending a request to `/api/sources/{id}/articles`. Imported articles are also saved to the local database with additional fields, and results are output in JSON format.

**API Documentation**

Full API documentation is available in the [ENDPOINTS.apib](ENDPOINTS.apib) file, as well as online at [docs.ngnewsapi.apiary.io](http://docs.ngnewsapi.apiary.io/).

**Expansion Considerations**

Given that this is a starter excersize, I didn't want to get carried away with items outside of scope. Were this a production application, however, next steps would include:

1. Adding additional source data, including `urlsToLogo` and `sortBysAvailable` data
2. Defaulting endpoints to look at local database rather than hitting the NewsAPI endpoint on every request
3. Adding a `refresh` attribute to all requests to force NewsAPI data updates
4. Very likely adding integer primary keys to the `Source` model. I don't like using strings as primary keys, but that appears to be how NewsAPI's schema is designed.
5. Possibly extending the Guzzle class so we can include the NewsAPI API key on each request automatically, instead of keeping it in each controller method.
6. Add exception handling for use of a bad API key or if NewsAPI is inaccessible.
