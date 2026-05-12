@echo off
echo Stopping Library Management System...

:: Kill Java processes running the library system
:: We use taskkill with a filter for the window title or just kill java if it's the only one
taskkill /FI "WINDOWTITLE eq LibraryMS Backend*" /T /F >nul 2>&1

:: Alternative: kill by image name (caution: kills all java apps)
:: taskkill /IM java.exe /F

echo Application stopped.
pause
