Options -MultiViews

<IfModule mod_rewrite.c>
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME}.php -f
RewriteRule ^(.*)$ $1.php



</IfModule>
 	
ErrorDocument 404 https://www.mycherreelaundry.com/404
Options -Indexes
php_value max_input_vars 5000