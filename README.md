<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://digipatrol.id/assets/img/illustrations/opening_digpat.svg" width="400"></a></p>

> ### This is private repository..
## About DigiPatrol

Digipatrol is a system intended to digitize the security patrol process in company patrol areas, the features contained in the digipatrol application are such as:
- Patrol Analytics
- Patrol Abnormality Report
- Patrol Performace Report
- Schedule and Shift Management
- Area Configuration
- Multiple Company Plant and Building Configuration
- etc

## System Requirement
- PHP >= 8.0
- PostgreSQL
- Webserver Nginx or Apache (Production Server)

## How to Install (Local Development)
- Create new PostgreSQL database
- Clone this repository 
>`git clone https://gitlab.com/imamsy/digipatrol-backend.git`
- Run composer install
> `composer i`
- Copy file config
> - Copy [.env.example](.env.example) and rename to .env 
- Update Config
```DB_CONNECTION=pgsql
DB_HOST=your db host, example localhost, 127.0.0.1
DB_PORT=db port, default db port for posgresql 5432
DB_DATABASE=your db name
DB_USERNAME=your db username
DB_PASSWORD=your db password
```
- Run database and seeders 
>```php artisan migrate:fresh --seed```
- Run Application
> ```php artisan serve```

## How to Install (Server Ubuntu, with apache webserver)
- Install all requirement, 
> - Install apachehttps://www.digitalocean.com/community/tutorials/how-to-install-the-apache-web-server-on-ubuntu-20-04
> - Install PHP 8.0 https://medium.com/@laraveltuts/how-to-install-and-run-php-8-x-on-ubuntu-20-04-8f18e7565c41
> - Install PostgreSQL https://www.digitalocean.com/community/tutorials/how-to-install-and-use-postgresql-on-ubuntu-20-04
- Create new PostgreSQL database
- Go to apache site directory
```shell
cd /var/www/
```
```shell
mkdir apps
```
- Clone this repository
```shell
git clone https://gitlab.com/imamsy/digipatrol-backend.git .
```
- Assign ownership of the directiry
```shell
sudo chown -R $USER:$USER /var/www/apps
```
- Run composer install 
```shell
  composer i
```
- Copy file config
Copy [.env.example](.env.example) and rename to .env
- Update Config
``` dotenv
DB_CONNECTION=pgsql
DB_HOST=your db host, example localhost, 127.0.0.1
DB_PORT=db port, default db port for posgresql 5432
DB_DATABASE=your db name
DB_USERNAME=your db username
DB_PASSWORD=your db password
```
- Run database and seeders
```shell
php artisan migrate:fresh --seed
```
- Go to apache config directory
```shell
cd /etc/apache2/site-available/
```
```shell
sudo nano 000-default.conf
```
- update config and set virtualhost
```apacheconf
<VirtualHost *:80>
# The ServerName directive sets the request scheme, hostname and port that
# the server uses to identify itself. This is used when creating
# redirection URLs. In the context of virtual hosts, the ServerName
# specifies what hostname must appear in the request's Host: header to
# match this virtual host. For the default virtual host (this file) this
# value is not decisive as it is used as a last resort host regardless.
# However, you must set it for any further virtual host explicitly.
#ServerName www.example.com

        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/apps/digipatrol-backend/public/
        <Directory  /var/www/apps/digipatrol-backend/public/>
                Options Indexes FollowSymLinks
                AllowOverride All
                Require all granted
        </Directory>
        # Available loglevels: trace8, ..., trace1, debug, info, notice, warn,
        # error, crit, alert, emerg.
        # It is also possible to configure the loglevel for particular
        # modules, e.g.
        #LogLevel info ssl:warn

        LogLevel debug
        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined

        # For most configuration files from conf-available/, which are
        # enabled or disabled at a global level, it is possible to
        # include a line for only one particular virtual host. For example the
        # following line enables the CGI configuration for this host only
        # after it has been globally disabled with "a2disconf".
        #Include conf-available/serve-cgi-bin.conf
</VirtualHost>
```
- restart apache server
```shell
sudo systemctl status apache2
```
# FAQ
- ### Error 419 after login
> Adjust Session configuration 
 ``` dotenv
SESSION_DOMAIN=                 # Domain or ip server
SESSION_SECURE_COOKIE=false     # Set true if using https
SESSION_SAME_SITE=           # Supported: "lax", "strict", "none", null
```
- ### Permission denied `could not be opened: failed to open stream: Permission denied ...`
> Webserver user and group depend on your webserver and your OS. to figure out what's your web server user and group use the following commands. for nginx use:

```bash
ps aux|grep nginx|grep -v grep
```
for apache use:

```shell
ps aux | egrep '(apache|httpd)'
```
> then change directory ownership. set your current user that you are logged in with as owner and the webserver user (www-data, apache, ...) as the group. You can try this:
```shell
sudo chown -R $USER:www-data storage
sudo chown -R $USER:www-data bootstrap/cache
```
then to set directory permission try this:
```shell
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```


# Reference
### Artisan Command
- Clear Application Cache:
`php artisan cache:clear`
- Clear Configuration Cache:
`php artisan config:clear`

for other reference, you can visit this tutorials
- https://www.hostinger.co.id/tutorial/install-laravel-di-ubuntu
- https://www.niagahoster.co.id/blog/cara-install-laravel-di-ubuntu/
