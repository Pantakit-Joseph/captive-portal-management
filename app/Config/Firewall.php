<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Firewall extends BaseConfig
{
    public string $authURL = 'http://192.168.1.1:8090/httpclient.html';
}
