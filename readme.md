1. Download project

    `git clone https://github.com/emilskrzypczynski/website-benchmark.git`

2. Go to project dir

    `cd website-benchmark`
    
3. Create `.env` file from `.env.dist`. Change parameters in created file.

4. In `symfony/.env` file set SMTP connection string (default: MAILER_URL=null://localhost)

5. Check parameters in `symfony/config/services.yml`

7. Run `docker-compose build` and `docker-compose up -d` 

8. Run `docker-compose exec php composer install`

9. Open browser with url `http://symfony.localhost`