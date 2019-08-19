# install packets
sudo apt-get update && sudo apt-get install apache2
sudo apt-get install apache2-utils

# add moduls
sudo a2enmod dav
sudo a2enmod dav_fs
sudo a2enmod auth_digest

# prepare and config
sudo htdigest -c /etc/apache2/users.password webdav fredy
sudo chown www-data:www-data /etc/apache2/users.password
sudo chown -R www-data:www-data /var/www/cloud

echo "

# webdav configuration:

DavLockDB /var/www/DavLock
Alias /cloud /var/www/cloud

<Directory /var/www/cloud>
    	DAV On
	AuthType Digest
	AuthName \"webdav\"
	AuthUserFile /etc/apache2/users.password
	Require valid-user
</Directory>" | sudo tee --append /etc/apache2/apache2.conf

sudo service apache2 restart

