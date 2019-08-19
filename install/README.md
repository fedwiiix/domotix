
# install 

## Basic

```
sudo chmod 100 install.sh
sudo sh install.sh
```

####  copy 
* domotix in /var/www/html
* copy domotixServer and cloud file in /var/www
* cloud file need two files
    * initial dir 
    * trash dir

#### server.ini
init file in domotix/parametre/server.ini.example
* config cloud
  * cloud dir
  * initial dir 
  * trash dir
  * music dir

* backendDir

* passwords
  * MusicPlayer
  * Camera stream
  * Digest connection for database api

## increase php upload size:

```
sudo nano /etc/php/7.0/apache2/php.ini
# sudo nano /etc/php5/apache2/php.ini
```
```
# get line: 
	upload_max_filesize = 2M
	post_max_size = 8M

# change by:
	upload_max_filesize = 100M
	post_max_size = 100M

sudo /etc/init.d/apache2 restart
```

create mysql user with right to save databases:
* SHOW DATABASES
* LOCK TABLES 
  
## error when you want save in database

```
MySQL response : #1366 - Incorrect integer value: '' for column 'auteur_note' at row 1
```

```
set global sql_mode=""

# or execute

remplace  ( remove STRICT_TRANS_TABLES in ) sql-mode=ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION by sql-mode=ONLY_FULL_GROUP_BY,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION
```
