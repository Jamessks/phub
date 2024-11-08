# phub

A website that fetches data from JSON and lists profiles of certain ... stars

## Basic Requirements

Docker

## Deployment Instructions

Follow these steps to set up the project locally:

1. **Clone the Repository**:

   ```bash
   git clone git@github.com:Jamessks/phub.git
   ```

   or just download it as a zip file and place it in the directory of your choice.

2. **Project root**: CD to the root directory of the project with a terminal of your choice (I used WSL2 terminal)

3. **Composer installation**: `composer install`

4. **Open docker**: Open your docker desktop application

5. **Initialize containers**: `docker-compose up --build -d` from your terminal at project root

6. **Access application**: Access the project at http://localhost:8081

PS: From within your docker application -> 'tests-1' image -> EXEC tab

and run

```
vendor/bin/pest
```

to run available tests

# **Available actions for the project**

From within the PHP image -> EXEC run

`php /var/www/phub/cron/scripts/update_pornstars.php`

normally this script runs through a cron that has been setup to run at 00:00 midnight everyday but in case you do not want to wait, run the script manually! (access cron log file from /var/log/cron.log)

The script hits the given JSON endpoint (or if it fails due to a 404 error for example, a fallback has been set to fetch data from a local JSON file instead. It is a copy of the online JSON file).

The script will fetch the data in chunks, cache the thumbnails (if they are valid images eg. no 404 etc.), store the rest of the data inside the `phub` database and its respective tables.

On first run of the script, expect around 7-10 minutes for all the data to be processed. Every other subsequent call of the script will take a lot less time to execute (less than a minute) as data is upserted and depending on how much data needs to be invalidated.

Profile pages are cached for 1-hour until expiration.

# **Important**

To effectively reset the project to its initial state:

1. Delete all records found in 'pornstars' table (the action will cascade to the rest of the tables through foreign key constraint).

2. From the `redis-1` docker image -> EXEC -> type: `redis-cli` -> type: `FLUSHDB`

3. Delete all the images from the project-root /public/images directory. To do this I switched to my WSL2 terminal cd /public/images and ran:
4. `sudo find . ! -name '000-image_not_found.png' -type f -exec rm -f {} +`
5. Be careful not to delete the default image found in `/public/images/000-image_not_found.png`
6. And the project has been reset to its initial state.
