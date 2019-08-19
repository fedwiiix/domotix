# --------------------------- root exec
if [ $USER != "root" -o $UID != 0 ]
then
  echo "need sudo !"
  exit 1
fi

# --------------------------- update

sudo apt-get update
sudo apt-get upgrade -y

# --------------------------- LAMP

sudo apt-get install apache2 php mysql-server phpmyadmin -y
sudo chmod -R 777 /var/www 

# --------------------------- dependace

sudo apt-get install zip -y
sudo apt-get install php-imagick

# add www-data root acces for reboot: 
#echo "www-data ALL=NOPASSWD: /sbin/reboot" | sudo tee --append /etc/sudoers       #www-data reboot = NOPASSWD: /sbin/reboot

# --------------------------- cloud

mkdir /var/www/cloud /var/www/cloud/Accueil /var/www/cloud/Corbeille /var/www/cloud/Musique /var/www/cloud/Perso /var/www/cloud/Projets /var/www/cloud/Linux /var/www/cloud/Images 
sudo chmod -R 777 /var/www 

# --------------------------- htaccess

echo "

# allow htaccess

<Directory /var/www/html>
AllowOverride all
</Directory>" | sudo tee --append /etc/apache2/apache2.conf

## or sudo nano /etc/apache2/sites-available/000-default.conf 

sudo service apache2 restart

cp ./example.htaccess /var/www/html/.htaccess





