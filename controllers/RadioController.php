<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RadioController
 *
 * @author adm_azashchepkin
 */
class RadioController {
    //put your code here
    public static $title = " Радио";
    
    public function actionIndex(){ //главная страница раздела картриджей
        
        $title = self::$title;
        
        $radioList = Radio::radioList();
        $statistic = Radio::getStatistic();
        
        
        /*echo "<pre>";
        var_dump($statistic);
        echo "</pre>";*/
        //echo $this->host_ice .":". $this->port_ice;
        
        require_once (ROOT . TMPL . 'radio.php');
        return true;
    }
    
    public function actionStatistics(){
        
        $statistic = Radio::getStatistic();
        $string = "<table class='table'>
            <tr>
                <th>Название</th>
                <th> Слушать </td>
                <th>Слушателей<br>сейчас</th>
                <th>Композиция</th>
            </tr>";
        for($i=0; count($statistic)>$i; $i++){
            $string .= "<tr>";
            $string .= "<td>".$statistic[$i]['stream']."</td>";
            $string .="<td><a target=_blanc href='http://dsk7681:8000".$statistic[$i]['stream'].".m3u'><img border='0' width='24' src='http://dsk7681/frame/images/radio1.gif'></a></td>";
            $string .="<td>".$statistic[$i]['quantity_listens']."</td>";
            $string .="<td>".$statistic[$i]['title']."</td>";
            $string .="</tr>";
        }
        
        $string .="</table>";
        echo $string;
        return true;
    }

}
