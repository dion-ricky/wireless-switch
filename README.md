# wireless-switch
[![Travis](https://img.shields.io/travis/rust-lang/rust.svg)](https://github.com/dion-ricky/wireless-switch)  
A wireless switch based on NodeMCU ESP8266 12E WiFi Development Board with a simple user interface programmed in PHP and using MySql for database storage.

## Table of Contents
1. [How it works?](#how-it-works)  
1.1 [Server side](#1-server-side)  
1.2 [NodeMCU ESP12e WiFi Development Board](#2-nodemcu-esp12e-wifi-development-board)  

## How it works?
### 1. Server side
The server runs a local Apache system and MySql on 192.168.173.1 port 80 contains all the files inside the [server](https://github.com/dion-ricky/wireless-switch/tree/master/server) folder.
The files are:
1. [__servip.php__:](https://github.com/dion-ricky/wireless-switch/blob/master/server/servip.php) It can save the IP of the device because we will need it later to turn on/off the LED. This php file works by saving the given value from the device HTTP Request. The device request is a GET request, for example -> __GET 192.168.173.1/servip.php?locip=192.168.173.20 HTTP/1.1__ so the servip.php will save the value of __locip__ to database server in which i'm using MySql.
2. [__onoff.php__:](https://github.com/dion-ricky/wireless-switch/blob/master/server/onoff.php) This file will be included in [main.php](https://github.com/dion-ricky/wireless-switch/blob/master/server/main.php) and [main.php](https://github.com/dion-ricky/wireless-switch/blob/master/server/main.php) will be included in [index.php](https://github.com/dion-ricky/wireless-switch/blob/master/server/index.php). This php file contains 6 buttons for 3 different pins. The first pin is pin 16 with two button, __ON__ and __OFF__, then pin 4 also with the same button, and the last is pin 12. If you click one of this button, it will call function called `led` with 2 parameters, first parameters is the pin number in integer then the second parameter is LED mode request `"ON"` or `"OFF"`.
3. [__main.php__:](https://github.com/dion-ricky/wireless-switch/blob/master/server/main.php) This file will check if the user has enough permission to control the device.
4. [__login.php__:](https://github.com/dion-ricky/wireless-switch/blob/master/server/login.php) This file is used by the user to gain permission to control the device. This `login.php` contains a form with submit button that give all of the user input to another php file called [login_validasi.php](https://github.com/dion-ricky/wireless-switch/blob/master/server/login_validasi.php).
5. [__login_validasi.php__:](https://github.com/dion-ricky/wireless-switch/blob/master/server/login_validasi.php) This file will check if the user input is registered in the database `w_switch` under a table called `user`. If it's confirmed then this file will redirect you to `?page` (by this time we don't have another page to redirect to, so this is main page).
6. [__index.php__:](https://github.com/dion-ricky/wireless-switch/blob/master/server/index.php) This file is called by the user for the first time when the user send a HTTP request to the server. It contains the layout of the user interface, JavaScript funtion named `led` which accept 2 parameters and it will include [buka_file.php](https://github.com/dion-ricky/wireless-switch/blob/master/server/buka_file.php).
7. [__buka_file.php__:](https://github.com/dion-ricky/wireless-switch/blob/master/server/buka_file.php) This file will include php file according to the `?page` request, if empty [main.php](https://github.com/dion-ricky/wireless-switch/blob/master/server/main.php) will be included.
8. [__logout.php__:](https://github.com/dion-ricky/wireless-switch/blob/master/server/logout.php) This is also called session destroyer, whis file when icluded will destroy the session started by `index.php`.
9. [__404.php__:](https://github.com/dion-ricky/wireless-switch/blob/master/server/404.php) This file will be included if `?page` contains unknown request.
10. [__script\connection_handler.bat__:](https://github.com/dion-ricky/wireless-switch/blob/master/server/script/connection_handler.bat) This file will send 1 packet to the IP of the device and will return `errorlevel` according to the ping response. If 1 packet is received back, it will return `errorlevel = 1`, if no packet is received, then it will return `errorlevel = 0`.

### 2. NodeMCU ESP12e WiFi Development Board
1. [__relay.ino__:](https://github.com/dion-ricky/wireless-switch/blob/master/sketch/relay.ino) This file is a sketch for the NodeMCU ESP12e Board. This sketch configure WiFi SSID to connect to with the given password. The led on pin 16 will blink if NodeMCU ESP12e is not connected to the WiFi yet.
