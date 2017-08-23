#!/bin/sh 
port=${1:-8000}
php7 -S "0.0.0.0:$port" -file webServer.php &



