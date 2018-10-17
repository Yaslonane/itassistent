<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return array(
    'ldap_host' => 'LDAP_B7.LOCAL.RU', //, LDAP_M1.LOCAL.RU',
    'ldap_port' => '389',
    'ldap_base' => 'OU=Accounts, DC=local, DC=ru',
    'ldap_filter' => 'sAMAccountName=',
    'ldap_domain' => '@local.ru',
);
