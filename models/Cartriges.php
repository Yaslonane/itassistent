<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Catriges
 *
 * @author andrey
 */
class Cartriges {
    //put your code here
    
    public static function getSumAllCarteiges(){ //получаем сумму всех картриджей(доставленных и замененных) по запросу ниже
        
        /*SELECT c.name as Имя, sum(aC.value) as Сумма FROM actionsCartriges aC
        INNER JOIN cartriges c ON aC.id_cartriges = c.id
        GROUP BY c.name;*/
        $db = Db::getConnection();
        
        $sql = "SELECT c.name as name, sum(aC.action) as value FROM cartridges aC "
                . "RIGHT JOIN cartriges c ON aC.id_cartrige = c.id "
                . "WHERE c.action = 1 "
                . "GROUP BY c.name";
        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $i = 0;
            while($row = $result->fetch()){
                $summ_cart[$i]['name'] = $row['name'];
                $summ_cart[$i]['value'] = $row['value'];
                    if($summ_cart[$i]['value'] == NULL) $summ_cart[$i]['value'] = 0;
                $i++;
            }
            
        return $summ_cart;
//return arr();
    }
    
    public static function getActivCartriges(){
        
        $db = Db::getConnection();
        
        $result = $db->query('SELECT id, name FROM cartriges WHERE action = 1');
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $i = 0;
            while($row = $result->fetch()){
                $cart[$i]['id'] = $row['id'];  
                $cart[$i]['name'] = $row['name']; 
                $i++;
            }
    return $cart; 
    }
    
    public static function getAllCartriges(){
        
        $db = Db::getConnection();
        
        $result = $db->query('SELECT id, name, action FROM cartriges');
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $i = 0;
            while($row = $result->fetch()){
                $cart[$i]['id'] = $row['id'];  
                $cart[$i]['name'] = $row['name']; 
                $cart[$i]['action'] = $row['action']; 
                if(!Printer::getAllPrintersByCartrige($row['id']))  $cart[$i]['print_list'] = "Нет принтеров использующих данный картридж";
                else $cart[$i]['print_list'] = Printer::getAllPrintersByCartrige($row['id']); 
                $i++;
            }
    return $cart; 
    }
    
    public static function getHistoryCartridges($limit = 5){
        $db = Db::getConnection();
        $result = $db->query('SELECT hc.id, hc.user, hc.date, c.name, hc.action
                              FROM history_cartridges hc 
                              LEFT JOIN cartriges c ON hc.id_cartridge = c.id
                              ORDER BY hc.id DESC
                              LIMIT '.$limit.';');
          
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $i = 0;
        while($row = $result->fetch()){
            foreach($row as $key=>$value){
                        $cartridges[$i][$key] = $value;
                    }
                    $i++;
        }
        
        return $cartridges;
    }
    
    
    
    private static function setActionCartriges($user_name, $id_cartrige, $quatity, $act){
        
        $db = Db::getConnection();
        $date = date("Y-m-d H:i:s");
        if($act == "out"){
            $action = $quatity * -1;
        }elseif ($act == "in" || "zaro") {
            $action = $quatity;
        }
                                                            /* история действий по картриджам */
                                                            if($act == "out"){
                                                                $actions = "Замена ".$quatity." шт";
                                                            }elseif ($act == "in") {
                                                                $actions = "Доставка ".$quatity." шт";
                                                            }elseif ($act == "zero") {
                                                                $actions = "!!!Обнуление: ".$quatity." шт";
                                                            }
                                                            Unit::setToHistoryCartridges($user_name, $id_cartrige, $actions);
                                                            /*end*/
          //внесение денных об изменениях принтера в бд
        $stmt = $db->prepare("INSERT INTO cartridges (date, id_cartrige, action, user) VALUES (:date, :id_cartrige, :action, :user)");
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':id_cartrige', $id_cartrige);
        $stmt->bindParam(':action', $action);
        $stmt->bindParam(':user', $user_name);
        
        return $stmt->execute();
        
        
    }
    
    public static function ActionCartriges($post_data, $session_data){
        
        for($i = 0; $i < count($post_data)-2; $i++){
           self::setActionCartriges($session_data['user_id'], $post_data[$i]['cartrige'], $post_data[$i]['quatity'], $post_data['action']);
        }
        
        return "all right";
        
    }
    
    public static function colorRow($a){
        if($a < 3 && $a >= 2) return "class='warning'";
        elseif($a < 2) return "class='danger'";
        else return "";
    }
    
    public static function resetToZero(){
        $db = Db::getConnection();
        
        $sql = "SELECT id_cartrige as id, sum(action) as value FROM cartridges GROUP BY id_cartrige";
        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $i = 0;
            while($row = $result->fetch()){
                $summ_cart[$i]['id'] = $row['id'];
                $summ_cart[$i]['value'] = $row['value'];
                    if($summ_cart[$i]['value'] == NULL) $summ_cart[$i]['value'] = 0;
                $i++;
            }
            
        for($i = 0; $i < count($summ_cart); $i++){
           self::setActionCartriges($_SESSION["user_id"]."/resetToZero", $summ_cart[$i]['id'], $summ_cart[$i]['value']*-1, "zero");
        }
        
        /*return $stmt->execute();
        echo "<pre>";    
        print_r($summ_cart);
        echo "</pre>"; */
        
    }


    
    public static function addCartriges($cart){ //добавление действия с картриджеми
        
        $db = Db::getConnection();
        
        $name = $cart['name'];
        (!$cart['action']) ? $action = 0 : $action = $cart['action'];
          //добавление картриджа в бд
        $stmt = $db->prepare("INSERT INTO cartriges (name, action) VALUES (:name, :action)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':action', $action);
        
        return $stmt->execute();
        
    }
    
    //public static function RemoveCartriges()
 
    public static function reactivCartriges($id){ // изменение статуза задействования принтера
        
        $db = Db::getConnection();
        $act_val = 0;
        $cart = Printer::getCartrigeByID($id);
        var_dump($cart);
        ($cart[0]['action'] == 1) ? $act_val = 0 : $act_val = 1;
          //добавление картриджа в бд
        $stmt = $db->prepare("UPDATE cartriges SET action = :action WHERE id=:id");
        $stmt->bindParam(':action', $act_val);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
        
    } 
    
    public static function orderCartriges($data){ //формирования массива принтеров для заказа картриджей
        
        /*приходящие данные

         * array(3) {
            [0]=>
            array(2) {
              ["cartrige"]=>
              string(1) "1"
              ["quatity"]=>
              string(1) "3"
            }
            [1]=>
            array(2) {
              ["cartrige"]=>
              string(1) "2"
              ["quatity"]=>
              string(0) ""
            }
            ["submit"]=>
            string(0) ""
          *}
         */
        
        //запрос к базе - забираем список всех id принтеров по первому массиву заказа
        //вставляем в массив $arr
        $list = "";//список для IN
        //случайные числа
        for($j = 0; $j < count($data) - 1; $j++){
            $arr = self::setListPrintByID($data[$j]['cartrige']); //id принетров
            $quantity = ceil($data[$j]['quantity']/2);
            
            //получаем нужные поля из таблицы  с помощью случайного id из списка
            if(count($arr)> 1){
                if(count($arr) < $quantity) $quantity = count($arr);
                $rand_key = array_rand($arr, $quantity);// подставляем в цикл случайное число из массива

                for($i = 0; $i < $quantity; $i++){
                    $list .= $arr[$rand_key[$i]].",";
                }

            }elseif(count($arr)== 1){
                $list .= $arr[0].",";
            }
        }
        
        $list = substr($list, 0, -1);
        //print_r ($list);
        $data_ord = array();
        
        $db = Db::getConnection();
        
        $result = $db->query("SELECT model, name, unit, is_color FROM print WHERE id IN (".$list.")");
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $i = 0;
            while($row = $result->fetch()){
                $data_ord[$i]['model'] = $row['model'];
                $data_ord[$i]['name'] = $row['name'];
                $data_ord[$i]['unit'] = $row['unit'];
                $data_ord[$i]['is_color'] = $row['is_color'];
                //if($row['is_color'] == 1) $data_ord[$i]['unit'] .= "  (black, yellow, magenta, blue)";
                $i++;
            }
        
        //print_r($data_ord);
        return $data_ord;
        //формируем нужный массив с данными для отправки письма
        /*
         * 
         * Array ( [0] => Array ( [model] => HP LJM1212 [name] => PRN0175 [unit] => 0055-7357 ) [1] => Array ( [model] => HP LJ 3030 [name] => DSK0173 [unit] => 0000-0297 ) [2] => Array ( [model] => HP LJ 3030 [name] => DKUR0151 [unit] => 0000-5280 ) [3] => Array ( [model] => HP LJ 3020 [name] => DSK4719 [unit] => 0000-5428 ) [4] => Array ( [model] => HP LJM1212 [name] => PRN0173 [unit] => 0053-3585 ) [5] => Array ( [model] => HP LJ 3030 [name] => dsk0651 [unit] => 0045-5575 ) [6] => Array ( [model] => HP LJM1212 [name] => prn0180 [unit] => 0043-8493 ) [7] => Array ( [model] => Ricoh Aficio SP 3510SF [name] => PRN0185 [unit] => 0045-1758 ) )
         * 
         */
    }
    
    private static function setListPrintByID($id){
        
        $db = Db::getConnection();
        
        $result = $db->query("SELECT id FROM print WHERE id_cartriges=".$id." AND id_status IN (1, 6, 8)");
        //$result->setFetchMode(PDO::FETCH_ASSOC);
        $i = 0;
            while($row = $result->fetch()){
                $ids[$i] = $row['id'];
                $i++;
            }
        return $ids;
    }
    
    public static function changeIsPublic($id){
        
        $db = Db::getConnection();
        $result = $db->query('SELECT * FROM cartriges WHERE id='.$id);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();
        
        $is_publication = $row['action'];
        
        if($is_publication == 0) $is_publication_new = 1;
        else $is_publication_new = 0;
        
        $stmt = $db->prepare("UPDATE cartriges SET action = :action WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':action', $is_publication_new);
        $stmt->execute();
        
        return true;
    }

    
}
