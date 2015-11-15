#!/bin/bash

service mysql status|grep 'mysql start/running' &> /dev/null
if [ $? != 0 ]; then
sudo service mysql restart
else
echo 'mysql is runnning'
fi
