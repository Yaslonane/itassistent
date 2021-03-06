<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 01.04.2016
 * Time: 18:04
 */

return array(
    'imgupload' => 'images/upload',
    'user/login' => 'user/login',
    'user/logout' => 'user/logout',
    'printers' => 'printers/index',
    'printer/add' => 'printers/add',
    'printer/([0-9]+)' => 'printers/view/$1',
    'printer/edit/([0-9]+)' => 'printers/edit/$1',
    'cartriges/action' => 'cartriges/actions',
    'cartriges/orders' => 'cartriges/orders',
    'cartriges/reaction/([0-9]+)' => 'cartriges/reaction/$1',
    'cartriges/add/public/([0-9]+)' => 'cartriges/public/$1',
    'cartriges/add' => 'cartriges/add',
    'cartriges/Zeroning' => 'cartriges/Zeroning',
    'cartriges' => 'cartriges/index',
    'phonebook/admactiv/([0-9]+)' => 'phonebook/activ/$1',
    'phonebook/admsearch' => 'phonebook/admsearch',
    'phonebook/admedit' => 'phonebook/edit',
    'phonebook/admedit/([0-9]+)' => 'phonebook/edit/$1',
    'phonebook/admdelete/([0-9]+)' => 'phonebook/delete/$1',
    'phonebook/save' => 'phonebook/save',
    'phonebook/update' => 'phonebook/update',
    'phonebook/search' => 'phonebook/search',
    'phonebook' => 'phonebook/index',
    'unit/newactionrequest' => 'unit/newactionrequest',
    'unit/actionrequest/([0-9]+)' => 'unit/actionrequest/$1',
    'unit/actionrequest' => 'unit/actionrequest',
    'unit/createrequest' => 'unit/createrequest',
    'unit/requesttobase' => 'unit/requesttobase',
    'unit/requests/page-([0-9]+)' => 'unit/index/$1',
    'unit/requests' => 'unit/index',
    'unit' => 'unit/index',
    
    
    //'radio/statistics/([=0-9]+)' => 'radio/statistics',
    //'radio/statistics/?_=([0-9]+)' => 'radio/statistics',
    'radio/statistics' => 'radio/statistics',
    'radio' => 'radio/index',

    '' => 'site/index',
    
);
