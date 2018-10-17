<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of radio
 *
 * @author adm_azashchepkin
 */
class Radio {
    //put your code here

    public static function radioList(){
        
        $radio = Icecast::getConnection();

        //$scfp = fsockopen($scip, $scport, $errno, $errstr, 10);
        $scfp = fopen("http://".$radio['ip'].":".$radio['port']."/status3.xsl", "r");

        if($scfp) {
            //fwrite($scfp,"GET /status3.xsl HTTP/1.0\r\n User-Agent: Icecast Song Status (Mozilla Compatible)\r\n\r\n");
            $info = '';
            while(!feof($scfp)) {
              $listeners = fgets($scfp, 1000); // Вот то, что нам надо
              //вывод количества слушателей
              $info .= trim($listeners);
            }

            fclose($scfp);

            $info = explode('!!', $info);
            unset($info[0]);

            foreach ($info as $value) {
              $exploded = explode('%%', $value);
              $new_info[$exploded[0]] = $exploded;
            }

            return $new_info;
        } 
    }

    public static function radioImg($a){
        $a = substr($a,1);
        $img = "http://dsk7681/player/img/".$a.".jpg";
        if (@fopen($img, "r")) {
            return $a;
        } else {
            return 'none';
        }
    }
    
    public static function getStatistic(){
        $radio = Icecast::getConnection();
        
        $scfp = fopen("http://".$radio['ip'].":".$radio['port']."/status3.xsl", "r");
        $list = fread($scfp, 10000);
        
        $statistics = [];
        
        $info = explode('!!', $list);
        for($i=0; count($info)>$i; $i++){
            $elements = explode('%%', $info[$i]);
            $statistics[$i]['stream'] = $elements[0];
            $statistics[$i]['quantity_listens'] = @$elements[1];
            $statistics[$i]['artist'] = @$elements[2];
            $statistics[$i]['title'] = @$elements[3];
        }
        /*array(3) {
            ["host"]=>
            string(7) "dsk7681"
            ["ip"]=>
            string(11) "10.20.4.219"
            ["port"]=>
            string(4) "8000"
        }

         * 
         * 
         * 0 name stream
         * 1 quantity listens
         * 2 artist
         * 3 name composiition
         * 
                  */
        array_shift($statistics);
        
        return $statistics;
    }
}
