--------------------
Extra: Cybershop
--------------------
Version: 1.1 beta
Since: September 2013
Author: Andrey Zagorets <AndreyZagorets@gmail.com>

Простой и удобный интернет магазин

Для работы с ЧПУ обязательно добавить в .htaccess

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^catalog/element/(.*)$ index.php?q=catalog/element&elementid=$1 [L,QSA]
RewriteRule ^catalog/get/(.*)$ index.php?q=catalog/get&categorysgroup=$1 [L,QSA]
