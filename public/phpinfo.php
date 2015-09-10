<?php
$mem = new Memcached;
$mem->addServer('127.0.0.1', 11211);
$mem->set('role_1', '100111111111', 3600);
echo $mem->get('role_1');
phpinfo();
