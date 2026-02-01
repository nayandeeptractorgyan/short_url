@echo off
echo === URL Shortener Setup ===
echo.

mkdir bootstrap\cache 2>nul
mkdir storage\framework\cache\data 2>nul
mkdir storage\framework\sessions 2>nul
mkdir storage\framework\views 2>nul
mkdir storage\logs 2>nul
mkdir storage\app\public 2>nul

echo Installing dependencies...
composer install
if %ERRORLEVEL% NEQ 0 (
    echo Composer install failed.
    pause
    exit /b 1
)

if not exist .env (
    copy .env.example .env
    php artisan key:generate
)

echo.
echo Before continuing, make sure you have:
echo   1. MySQL running
echo   2. Created a database called: url_shortener
echo   3. Set your DB_USERNAME and DB_PASSWORD in .env
echo.
pause

echo Running migrations...
php artisan migrate
if %ERRORLEVEL% NEQ 0 (
    echo Migration failed. Check your .env MySQL settings.
    pause
    exit /b 1
)

echo Seeding database...
php artisan db:seed

echo.
echo === Setup Complete ===
echo Login: superadmin@example.com / password
echo.
echo Run:  php artisan serve
echo.
pause
