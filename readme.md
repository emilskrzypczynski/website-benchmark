1. Download project

    `git clone git@github.com:emilskrzypczynski/website-benchmark.git`

2. Go to project dir

    `cd website-benchmark`
    
3. Run `composer install`
    
4. Create .env file from .env.dist

    `cp .env.dist .env`

5. In `.env` file set SMTP connection string (default: MAILER_URL=null://localhost)

6. In `config/services.yml` change parameters in `email_notifier_config`

7. Run `docker-compose build` and `docker-compose up -d` 

8. Open browser with url `http://localhost:8080`