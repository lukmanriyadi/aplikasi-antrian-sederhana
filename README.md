## aplikasi antrian sederhana

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
-   pada kolom **code** di table **_services_** harus memiliki **.** (titik) pada akhirnya. ini diperlukan untuk memisahkan antara huruf dan angka pada queue number nantinya.

### Demo

video penjelasan : https://youtu.be/QqDOnenfd9w

list route
