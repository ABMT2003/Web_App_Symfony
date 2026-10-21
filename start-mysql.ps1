# Starts the local MySQL server (data in C:\mysql-data, localhost only) if it is not already running.
# Usage, from the symfony_app folder:  .\start-mysql.ps1

$bin = "C:\Program Files\MySQL\MySQL Server 8.4\bin"

& "$bin\mysqladmin.exe" -u root --password= ping 2>$null | Out-Null
$alive = ($LASTEXITCODE -eq 0)
if (-not $alive) {
    # root has a password now, so a "denied" reply also means the server is up
    $out = & "$bin\mysqladmin.exe" -u root ping 2>&1 | Out-String
    if ($out -match 'alive|Access denied') { $alive = $true }
}

if ($alive) {
    Write-Host "MySQL is already running."
    return
}

Start-Process -WindowStyle Hidden "$bin\mysqld.exe" -ArgumentList "--datadir=C:\mysql-data", "--bind-address=127.0.0.1", "--port=3306"

for ($i = 0; $i -lt 20; $i++) {
    Start-Sleep -Seconds 1
    $out = & "$bin\mysqladmin.exe" -u root ping 2>&1 | Out-String
    if ($out -match 'alive|Access denied') {
        Write-Host "MySQL started on 127.0.0.1:3306."
        return
    }
}

Write-Host "MySQL did not respond after 20 seconds. Check C:\mysql-data for a *.err file."
