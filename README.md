# Welcome to simple queue app

Aplikasi antrian sederhana, yang menerapkan multi _counter_ dan juga multi _service_
dimana setiap _counter_ bisa menangani antrian lebih dari 1 _service_. dan memiliki banyak _counter_.

aplikasi dibuat dengan menggunakan :

-   Laravel

akun untuk login :

-   Officer :
    -   Email : officer@example.com
    -   Password : password
-   Admin :
    -   Email :admin@example.com
    -   Password : password

note :

-   pada route **_/audio_** akan berusaha menjalankan audio secara otomatis jika ada. maka perhatikan juga akses autoplay di browser kalian.
-   pada kolom **/code** di table **/service** menggunakan titik(.) di akhir yang nantinya digunakan untuk pemisah antara code dan nomor

## Instalasi

-   composer install
-   setup env database dan generate key
-   buat symbolic link
-   buat folder **queue** dan **audio** di folder **storage/app/public/**
-   download dan copy audio file dari https://drive.google.com/file/d/1CMIFnM3pvltX1Nmi_vAlfpNMaWZsY5d5/view?usp=sharing ke folder **audio**
-   migrasi database dan seeder

## Demo

video penjelasan penggunaan : https://youtu.be/QqDOnenfd9w
