@echo off
REM Optional: Start Laravel server (uncomment if needed)
php artisan serve --host=127.0.0.1 --port=8000

REM Start ngrok tunnel
ngrok http 127.0.0.1:8000

pause
