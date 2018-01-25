#########################################
# Make sure the backups directory exists
#########################################
mkdir -p /vagrant/localStorage/;
touch /vagrant/localStorage/.gitkeep;
mkdir -p /vagrant/localStorage/dbBackups/;
touch /vagrant/localStorage/dbBackups/.gitkeep;





###################################
# Run PHP Backup Script
###################################

#!/bin/sh
sudo php /vagrant/vagrantConfig/dbBackups.php;
