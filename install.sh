#!/bin/bash
cd /usr/local/cpanel/whostmgr/docroot/cgi
mkdir /usr/local/cpanel/whostmgr/docroot/cgi/downloads
cd /usr/local/cpanel/whostmgr/docroot/cgi/downloads
wget https://github.com/Crazy-Coderz/CronManager/archive/master.zip
unzip master
cd /usr/local/cpanel/whostmgr/docroot/cgi/downloads/CronManager-master
cp /usr/local/cpanel/whostmgr/docroot/cgi/downloads/CronManager-master/* /usr/local/cpanel/whostmgr/docroot/cgi/
cd /usr/local/cpanel/whostmgr/docroot/cgi/downloads/CronManager-master/cronmgr/
mkdir /usr/local/cpanel/whostmgr/docroot/cgi/cronmgr/
cp /usr/local/cpanel/whostmgr/docroot/cgi/downloads/CronManager-master/cronmgr/* /usr/local/cpanel/whostmgr/docroot/cgi/cronmgr/
chmod 777 /usr/local/cpanel/whostmgr/docroot/cgi/addon_cronmanager.cgi
rm -rf /usr/local/cpanel/whostmgr/docroot/cgi/downloads
