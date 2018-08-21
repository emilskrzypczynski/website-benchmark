1. Download project

    `git clone https://github.com/emilskrzypczynski/website-benchmark.git`

2. Go to project dir

    `cd website-benchmark`
    
3. Run `composer install`

4. In `.env` file set SMTP connection string (default: MAILER_URL=null://localhost)

5. Check parameters in `config/services.yml`

6. Go to `docker` directory - `cd docker`

7. Run `docker-compose build` and `docker-compose up -d` 

8. Open browser with url `http://localhost:8080`