newsapi-app
===

**newsapi-app** is the result of a code challenge. The result is a Laravel-powered API built to consume the Newsapi services, store it locally, and allow querying

**Project Specifications**

> 1. Picks one of these API’s: 
> https://newsapi.org/
> https://content.guardianapis.com
> https://api.nytimes.com
> 2. Allow authenticated users to set news preferences based on Authors, categories and sources where the news come from. 
> 3. Allow filtering of news items by category, author, date and source

NB: This app uses a command `php artisan grab:fresh` to import data from all sources into the database. This approach allows us do all querying for data locally, and the data can be refreshed by a cron service every `15 minutes`.

Authentication was done using **SANCTUM**

**Setup**

1. Clone the repository
2. Run `composer install`
3. Copy the `.env-dist` file into `.env`
4. Update `.env` with your database credentials and News API key
5. Run `php artisan migrate` to create the database structure
6. run `php artisan serve` to spin up a localhost instance

You can also spin up an instance using Docker.

Data returned are all in JSON format.

**API Documentation**

Full API Postman documentation is available here - `https://documenter.getpostman.com/view/5785856/2s93sc4CQF`

**Testing**

Application is running and can be tested at `http://66.228.61.106:7444`

**Expansion Considerations**

Given that this is a starter excersize, I didn't want to get carried away with items outside of scope. Were this a production application, however, next steps would include:

1. Adding additional source data, including `urlsToLogo` and `sortByAvailable` data
2. Adding a `refresh` attribute to all requests to force NewsAPI data updates
3. Very likely adding integer primary keys to the `Source` model. I don't like using strings as primary keys, but that appears to be how NewsAPI's schema is designed.
4. Possibly extending the Guzzle class so we can include the NewsAPI API key on each request automatically, instead of keeping it in each controller method.
5. Add a more extensive exception handling for use of a bad API key or if NewsAPI is inaccessible.
