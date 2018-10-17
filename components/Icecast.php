<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Icecast
 *
 * @author adm_azashchepkin
 */
class Icecast {
    
    public static function getConnection(){
        
        $paramsPath = ROOT.'/config/icecast.php';
        $params = include($paramsPath);
        $radio = [];
        $radio['host'] = $params['icecast_host']; // Сервер, на котором висит Icecast
        $radio['ip'] = $params['icecast_ip']; // Сервер, на котором висит Icecast
        $radio['port'] = $params['icecast_port']; // Порт
        
        return $radio;
        
    }
}
