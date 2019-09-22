Panagiotis Kourtzellis

#1 if used with xampp
edit C:\Windows\System32\drivers\etc\hosts
127.0.0.1 localhost
127.0.0.1 laravelapp.test

#2 if used with xampp
edit C:\xampp\apache\conf\extra\httpd-vhosts.conf
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs"
    ServerName localhost
</VirtualHost>

<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/laravelapp/public"
    ServerName laravelapp.test
</VirtualHost>

#3
edit .env file with your database details
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

#4
Database
The sql dump is in SQL/laravelapp.sql

#5
optional for showing images in posts
create symlink between '/laravelapp/storage/app/public' and '/public/storage'
file symlinkcreate.php run from browser