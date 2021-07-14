*Crear instalador
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
