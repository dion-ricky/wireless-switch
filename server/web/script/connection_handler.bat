@echo off
for /f "usebackq tokens=1" %%a in ("script\ip") do @set ip=%%a
for /f "tokens=5 delims==, " %%a in ('ping -n 1 %ip% ^| findstr /c:Packets') do @set result=%%a
exit /b %result%