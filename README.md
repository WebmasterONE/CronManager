Cron Admin
==========
Crontab Admin is a WHM addon that allows System Administrators to edit the Crontab file on their RHEL based server without needing ssh.

Features
==========
Edit Crontab File

Changelog
==========
V1

*Added ability to edit & save crontab

V1.1

*Fixed issue where crontab would not import without blank line at end of temp file

*Added check for blank lines


Requirements
==========
Cpanel/WHM for VPS or Dedicated Servers

CentOS or any RHEL Based Linux OS

Installation
==========
From your cpanel-based server type the following commands into ssh as root:

wget https://raw.github.com/Crazy-Coderz/CronManager/master/Install.sh

chmod 777 install.sh

./install.sh

Removal
==========
From your cpanel-based server type the following commands into ssh as root:

wget https://raw.github.com/Crazy-Coderz/CronManager/master/uninstall.sh

chmod 777 uninstall.sh

./uninstall.sh