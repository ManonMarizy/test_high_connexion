Project installation:

Create your `.en.local` make the necessary changes on these variables:
- `DATABASE_URL`
- `APP_DB_USER`
- `APP_DB_PWD`
- `APP_DB_HOST`
- `APP_DB_NAME`

Then run:
- `composer install`
- `yarn install`
- `yarn encore dev`
- `php bin/console app:migrate:donations` with your path to your file
- `symfony server:start`
