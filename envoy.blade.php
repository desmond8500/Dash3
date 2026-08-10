@servers(['localhost' => '127.0.0.1'])

@task('install', ['on' => 'localhost'])
    composer install
    npm install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate
@endtask
