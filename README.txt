
Instalacion de paquetes y librerias

BoomBang-Launcher-Game > Terminal
npm install 

BoomBang-Launcher-Game->www > Terminal 
npm install 
npm run dev
composer install
php artisan cache:clear
php artisan config:cache
***********************************************************************************
Dentro de la carpeta BoomBang-Launcher-Game creamos carpeta 'php'
Dentro de la carpeta php pegamos todo lo que contiene la carpeta de php descargable
https://www.php.net/downloads.php

***********************************************************************************
Crear instalador
npm run make
npm install electron-builder --only=dev
npm run build-installer

Una vez creado el instalador vamos a a la carpeta dist
Dentro de la carpeta dist localizamos carpeta win-unpacked

Dentro de la carpeta win-unpakced nos dirigimos a resources
Dentro de resources crearemos nueva carpeta llamada app

Dentro de la carpeta app pegaremos todo nuestro projecto de electron 

Instalamos programa para crear instalador apartir de los archivos
El programa se encuentra dentro de la carpeta installProgram

Una vez instalado lo ejecutamos
En el apartado de importar el .exe de nuestra aplicacion 
En la parte inferior nos saldran 2 opciones subir carpetas o archivos
Le damos click carpetas y esocojemos la carpera dist 
Le damos aceptar cuando nos pida si quieremos incluir los subdirectorios de 
la carpeta dist.

PD: el instalador que se encuentra en la carpeta dist no nos funcionara 
todabia no encontre solucion.
Por lo tanto debemos usar el programa que crea un instalador a partir de archivos
mencionado anteriormente.
