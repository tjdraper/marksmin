###################################
# Prepare things
###################################

# Remove all virtual hosts
sudo rm -rf /etc/nginx/sites-available/*;
sudo rm -rf /etc/nginx/sites-enabled/*;

# Add known hosts file
cp /vagrant/vagrantConfig/knownHosts /home/vagrant/.ssh/known_hosts;
chown vagrant:vagrant /home/vagrant/.ssh/known_hosts;
chmod 0644 /home/vagrant/.ssh/known_hosts;





###################################
# Install tools
###################################

sudo apt-get install jq zip unzip





###################################
# Run PHP Provisioning Script
###################################

sudo php /vagrant/vagrantConfig/provision.php;





###################################
# Cron setups
###################################

# Only set up cron if not already set up
if [ ! -f /var/log/cronSetup ]; then
    # Make sure script is executable
    chmod +x /vagrant/vagrantConfig/dbBackups.sh;

    # Set up DB Backups cron for every 30 minutes if it has not been setup
    echo "*/30 * * * * /vagrant/vagrantConfig/dbBackups.sh >/dev/null 2>&1" >> cron;

    # Make sure nginx log file stay writable
    echo "*/5 * * * * chmod -R 0777 /var/log/nginx/ >/dev/null 2>&1" >> cron;

    # Set the cron file as a cron job
    crontab cron;

    # remove the cron file
    rm cron;

    # Write the file cronSetup so we know it's already been setup
    echo 'cron setup' > /var/log/cronSetup;
fi





######################################
# CD into the project on vagrant ssh
######################################
echo '' >> /home/vagrant/.profile;
echo 'cd /home/vagrant/development' >> /home/vagrant/.profile;





###################################
# Restart services
###################################

# Restart apache
sudo service php-5.3.29-fpm restart
sudo service php-5.6.30-fpm restart
sudo service php-7.0.18-fpm restart
sudo service php-7.1.3-fpm restart
sudo service nginx restart;
