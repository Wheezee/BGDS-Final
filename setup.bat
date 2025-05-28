@echo off
echo Barangay Governance and Development System (BGDS) Setup
echo ===================================================
echo.

REM Check if PHP is installed
php -v >nul 2>&1
if %errorlevel% neq 0 (
    echo Error: PHP is not installed or not in PATH
    echo Please install PHP 8.2 or higher
    pause
    exit /b 1
)

REM Check if Composer is installed
composer -V >nul 2>&1
if %errorlevel% neq 0 (
    echo Error: Composer is not installed or not in PATH
    echo Please install Composer
    pause
    exit /b 1
)

echo Installing PHP dependencies...
composer install
if %errorlevel% neq 0 (
    echo Error: Failed to install PHP dependencies
    pause
    exit /b 1
)

echo.
echo Generating application key...
php artisan key:generate
if %errorlevel% neq 0 (
    echo Error: Failed to generate application key
    pause
    exit /b 1
)

echo.
echo Running database migrations...
php artisan migrate
if %errorlevel% neq 0 (
    echo Error: Failed to run database migrations
    pause
    exit /b 1
)

echo.
echo Seeding database with default super admin...
php artisan db:seed
if %errorlevel% neq 0 (
    echo Error: Failed to seed database
    pause
    exit /b 1
)

echo.
echo Creating storage link...
php artisan storage:link
if %errorlevel% neq 0 (
    echo Error: Failed to create storage link
    pause
    exit /b 1
)

echo.
echo Setup completed successfully!
echo.
echo Default Super Admin Credentials:
echo Email: superadmin@gmail.com
echo Password: superadmin123
echo.
echo Starting development server...
echo The application will be available at http://127.0.0.1:8000
echo Press Ctrl+C to stop the server
echo.
php artisan serve 