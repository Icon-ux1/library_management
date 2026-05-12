Set WshShell = CreateObject("WScript.Shell")
' Run the batch file hidden (0)
WshShell.Run chr(34) & "start_app.bat" & chr(34), 0
Set WshShell = Nothing
