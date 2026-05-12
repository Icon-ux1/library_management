@echo off
setlocal enabledelayedexpansion

:: ======================================================
:: Library Management System - Desktop Launcher
:: ======================================================

:: 1. Configuration
set "APP_DIR=%~dp0.."
set "BACKEND_DIR=%APP_DIR%\backend"
set "JAR_NAME=library-management-system-1.0.0.jar"
set "FRONTEND_URL=http://localhost/libraryms"

echo Starting Library Management System...

:: 2. Start Java Backend (Minimized)
echo Starting Backend...
cd /d "%BACKEND_DIR%"
if exist "target\%JAR_NAME%" (
    start /min "LibraryMS Backend" java -jar "target\%JAR_NAME%"
) else (
    echo ERROR: Backend JAR not found. Please run 'mvn clean install' in the backend folder first.
    pause
    exit /b 1
)

:: 3. Wait for Backend to initialize (approx 10 seconds)
echo Waiting for services to start...
timeout /t 10 /nobreak > nul

:: 4. Launch Frontend in Chrome App Mode (Dedicated Window)
echo Launching UI...
start chrome --app="%FRONTEND_URL%"

:: If Chrome isn't found, try default browser
if %errorlevel% neq 0 (
    start "" "%FRONTEND_URL%"
)

echo Application is running!
exit
