<?php

/**
 * Created on 04.10.2016
 * By NetBeans IDE 8.1
 * Author: Andrey Zashchepkin 
 *
 * 
 * ******** Contacts:*********
 * my e-mails - yaslonane@yandex.ru
 *            - andrey@zashchepkin.ru
 *            - info@zashchepkin.ru
 *  my site     zashchepkin.ru 
 * ********  end contacts *********
 * 
 *
 * Copyright zashchepkin.ru © 2016. All Rights Reserved.
 * License https://opensource.org/licenses/mit-license.php MIT License (MIT)
 *
 *
 * Description of Printer
 *
 * @author andrey
 * */
class Printer {
    
    public static function getListPrinters($id_status_print = 1){
        
        $db = Db::getConnection();
        
        /*$name = "";
        $unit = "";
        $floor = "";
        $department = "";
        $cartrige = "";
        $status = "";*/
        
        if(isset($_POST['submit']) && (isset($_POST['name']) || isset($_POST['unit']) || isset($_POST['floor']) || isset($_POST['department']) || isset($_POST['cartrige']) || isset($_POST['status']))){
            
            $sql = "SELECT * FROM print";
            /*echo "<pre>";
            var_dump($_POST) ;
            echo "</pre>";*/
            if(!empty($_POST['name']) || !empty($_POST['unit']) || !empty($_POST['floor']) || !empty($_POST['department']) || !empty($_POST['cartrige']) || !empty($_POST['status'])) {
                
                $sql .= " WHERE ";
            
                if(!empty($_POST['name'])) {
                    $name = $_POST['name'];
                    $sql .= "name LIKE '%$name%', ";
                }

                if(!empty($_POST['unit'])) {
                    $unit = $_POST['unit'];
                    $sql .= "unit = '$unit', ";
                }

                if(!empty($_POST['floor'])) {
                    $floor = $_POST['floor'];
                    $sql .= "id_floor = $floor, ";
                }

                if(!empty($_POST['department'])) {
                    $department = $_POST['department'];
                    $sql .= "id_department = $department, ";
                }

                if(!empty($_POST['cartrige'])) {
                    $cartrige = $_POST['cartrige'];
                    $sql .= "id_cartrige = $cartrige, ";
                }

                if(!empty($_POST['status'])) {
                    $status = $_POST['status'];
                $sql .= "id_status = $status, ";
                }


                $sql = substr($sql, 0, -2);
                $sql .= ";";
            
            }else $sql .= ";";
                                                                                //echo $sql;
            $result = $db->query($sql);
            if($result == false) return 0;
            $result->setFetchMode(PDO::FETCH_ASSOC);
            //$row = $result->fetch();
            
            //if($result->fetch() == false) $print = 0;

            $i = 0;
            while($row = $result->fetch()){
                $print[$i]['id'] = $row['id'];  
                $print[$i]['name'] = $row['name'];  
                $print[$i]['model'] = $row['model'];  
                $print[$i]['unit'] = $row['unit']; 
                    $fl = self::getAllValuesInTable('name', 'floor', $where = 'id', $where_value = $row['id_floor']);
                $print[$i]['id_floor'] = $fl[0]['name'];
                    $dp = self::getAllValuesInTable('name', 'departments', $where = 'id', $where_value = $row['id_department']);
                $print[$i]['id_department'] = $dp[0]['name'];; 
                $print[$i]['img'] = $row['img']; 
                $i++;
            }
            
           return $print;
            
            
        }else {
            $sql = 'SELECT 
                        print.id as id, 
                        print.name as name, 
                        print.model as model, 
                        print.unit as unit, 
                        print.inventar as indentar, 
                        print.sn as sn, 
                        cartriges.name as cartrige, 
                        departments.name as department, 
                        floor.name as floor, 
                        status.name as status, 
                        print.img as img 
                    FROM print 
                    LEFT JOIN `cartriges` ON cartriges.id = print.id_cartriges 
                    LEFT JOIN `departments` ON departments.id = print.id_department 
                    LEFT JOIN `floor` ON floor.id =  print.id_floor 
                    LEFT JOIN `status` ON status.id =  print.id_status ';
            
            if($id_status_print == 'all'){
                $sql .= ';';
            }else
                $sql .= 'WHERE print.id_status = '.$id_status_print.';';
                        

           // $result = $db->query('SELECT * FROM print WHERE id_status = 1');
            $result = $db->query($sql);
            
            /*
             * SELECT id
             * FROM actionsCartriges aC            
             * INNER JOIN cartriges c ON aC.id_cartriges = c.id
             */
            
            $result->setFetchMode(PDO::FETCH_ASSOC);
            //$row = $result->fetch();
            
            //if($result->fetch() == false) $print = 0;

            $i = 0;
            while($row = $result->fetch()){
                $print[$i]['id'] = $row['id'];  
                $print[$i]['name'] = $row['name'];  
                $print[$i]['model'] = $row['model'];  
                $print[$i]['unit'] = $row['unit']; 
                $print[$i]['id_floor'] = $row['floor']; 
                $print[$i]['id_department'] = $row['department']; 
                $print[$i]['img'] = $row['img']; 
                $i++;
            }
            
           return $print;
        }
        
        
    }
    
    private static function getListFunction($id_functions){
        $error = "Отсутствует";
        if($id_functions){
            $db = Db::getConnection();
            $sql = 'SELECT id, name, description FROM functions ';
            $sql .= 'WHERE id IN ('.$id_functions.')';
            $result = $db->query($sql);
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $i = 0;
                while($row = $result->fetch()){
                    $arr[$i]['id'] = $row['id'];
                    $arr[$i]['name'] = $row['name'];
                    $arr[$i]['description'] = $row['description'];
                    $i++;
                }
            return $arr;
        }else return $error;
    }
    
    public static function getPrintByID($id){
        $db = Db::getConnection();
        $result = $db->query('
                    SELECT 
                        print.id as id, 
                        print.name as name, 
                        print.model as model, 
                        print.unit as unit, 
                        print.inventar as inventar, 
                        print.id_functions as functions, 
                        print.sn as sn, 
                        cartriges.name as cartrige, 
                        departments.name as department, 
                        adress.city as city, 
                        adress.street as street, 
                        adress.house as house, 
                        floor.name as floor, 
                        status.name as status, 
                        print.img as img 
                    FROM print 
                    LEFT JOIN `cartriges` ON cartriges.id = print.id_cartriges 
                    LEFT JOIN `departments` ON departments.id = print.id_department 
                    LEFT JOIN `adress` ON adress.id =  print.id_adress 
                    LEFT JOIN `floor` ON floor.id =  print.id_floor 
                    LEFT JOIN `status` ON status.id =  print.id_status
                    WHERE print.id = '.$id.'
                    ');
            
            /*
             * SELECT id
             * FROM actionsCartriges aC            
             * INNER JOIN cartriges c ON aC.id_cartriges = c.id
             */
            
            $result->setFetchMode(PDO::FETCH_ASSOC);
            //$row = $result->fetch();
            
            //if($result->fetch() == false) $print = 0;

            $row = $result->fetch();
                $print['id'] = $row['id'];  
                $print['name'] = $row['name'];  
                $print['model'] = $row['model'];  
                $print['unit'] = $row['unit']; 
                $print['inventar'] = $row['inventar']; 
                $print['sn'] = $row['sn']; 
                $print['adress'] = $row['city'] .", ". $row['street'].", ". $row['house']; 
                $print['floor'] = $row['floor']; 
                $print['department'] = $row['department']; 
                $print['status'] = $row['status']; 
                $print['cartrige'] = $row['cartrige']; 
                $print['img'] = $row['img']; 
                $print['functions'] = self::getListFunction($row['functions']);
                
           return $print;
    }
    
    public static function getPrintByIDFullData($id){
        $db = Db::getConnection();
        $result = $db->query('
                    SELECT 
                        print.id as id, 
                        print.name as name, 
                        print.model as model, 
                        print.unit as unit, 
                        print.inventar as inventar, 
                        print.id_functions as functions, 
                        print.sn as sn, 
                        cartriges.name as cartrige, 
                            print.id_cartriges as id_cart, 
                        departments.name as department,
                            print.id_department as id_dep, 
                        floor.name as floor,
                            print.id_floor as id_fl,
                        status.name as status, 
                            print.id_status as id_st,
                        print.img as img 
                    FROM print 
                    LEFT JOIN `cartriges` ON cartriges.id = print.id_cartriges 
                    LEFT JOIN `departments` ON departments.id = print.id_department 
                    LEFT JOIN `floor` ON floor.id =  print.id_floor 
                    LEFT JOIN `status` ON status.id =  print.id_status
                    WHERE print.id = '.$id.'
                    ');
            
            /*
             * SELECT id
             * FROM actionsCartriges aC            
             * INNER JOIN cartriges c ON aC.id_cartriges = c.id
             */
            
            $result->setFetchMode(PDO::FETCH_ASSOC);
            //$row = $result->fetch();
            
            //if($result->fetch() == false) $print = 0;

            $row = $result->fetch();
                $print['id'] = $row['id'];  
                $print['name'] = $row['name'];  
                $print['model'] = $row['model'];  
                $print['unit'] = $row['unit']; 
                $print['inventar'] = $row['inventar']; 
                $print['sn'] = $row['sn']; 
                $print['floor'] = $row['floor'];
                    $print['id_fl'] = $row['id_fl'];
                $print['department'] = $row['department'];
                    $print['id_dep'] = $row['id_dep'];
                $print['status'] = $row['status'];
                    $print['id_st'] = $row['id_st'];
                $print['cartrige'] = $row['cartrige']; 
                    $print['id_cart'] = $row['id_cart'];
                $print['img'] = $row['img']; 
                $print['functions'] = self::getListFunction($row['functions']);
                
           return $print;
    }
    
    public static function checkDataUpdatePrint($old_data, $new_data){
        
        $message = "";
        $update = array();
        $i = 0;
        
        if($old_data['name'] != $new_data['name']){
            $i++;
            $update[$i]['object'] = "Имя принтера";
            $update[$i]['old_data'] = $old_data['name'];
            $update[$i]['new_data'] = $new_data['name'];
        }
        if($old_data['model'] != $new_data['model']){
            $i++;
            $update[$i]['object'] = "Модель принтера";
            $update[$i]['old_data'] = $old_data['model'];
            $update[$i]['new_data'] = $new_data['model'];
        }
        if($old_data['unit'] != $new_data['unit']){
            $i++;
            $update[$i]['object'] = "Номер UNIT принтера";
            $update[$i]['old_data'] = $old_data['unit'];
            $update[$i]['new_data'] = $new_data['unit'];
        }
        if($old_data['inventar'] != $new_data['inventar']){
            $i++;
            $update[$i]['object'] = "Инвентарный номер принтера";
            $update[$i]['old_data'] = $old_data['inventar'];
            $update[$i]['new_data'] = $new_data['inventar'];
        }
        if($old_data['sn'] != $new_data['sn']){
            $i++;
            $update[$i]['object'] = "Серийный номер принтера";
            $update[$i]['old_data'] = $old_data['sn'];
            $update[$i]['new_data'] = $new_data['sn'];
        }
        
        if($old_data['id_fl'] != $new_data['id_floor']){
            $i++;
            $update[$i]['object'] = "Этаж";
            $update[$i]['old_data'] = $old_data['id_fl'];
            $update[$i]['new_data'] = $new_data['id_floor'];
        }
        if($old_data['id_dep'] != $new_data['id_department']){
            $i++;
            $update[$i]['object'] = "Отдел";
            $update[$i]['old_data'] = $old_data['id_dep'];
            $update[$i]['new_data'] = $new_data['id_department'];
        }
        if($old_data['id_cart'] != $new_data['id_cartrige']){
            $i++;
            $update[$i]['object'] = "Картридж";
            $update[$i]['old_data'] = $old_data['id_cart'];
            $update[$i]['new_data'] = $new_data['id_cartrige'];
        }
        if($old_data['id_st'] != $new_data['id_status']){
            $i++;
            $update[$i]['object'] = "Статус";
            $update[$i]['old_data'] = $old_data['id_st'];
            $update[$i]['new_data'] = $new_data['id_status'];
        }
        
        if(self::identical_values(self::modAndCheckFunctions($old_data['functions']), $new_data['id_functions']) == false){
            if($old_data['functions'] != "Отсутствует"){
                $del = array_diff(self::modAndCheckFunctions($old_data['functions']), $new_data['id_functions']);
                $add = array_diff( $new_data['id_functions'], self::modAndCheckFunctions($old_data['functions']));
            }else {
                $del = false;
                $add = $new_data['id_functions'];
            }
            
            if($del){
                $i++;
                $update[$i]['object'] = "Функции удалили";
                $update[$i]['old_data'] = implode(",", $del);
                $update[$i]['new_data'] = "";
            }
            if($add){
                $i++;
                $update[$i]['object'] = "Функции добавили";
                $update[$i]['old_data'] = "";
                $update[$i]['new_data'] = implode(",", $add);
            }
            
        }
        
        return $update;
        
    }
    
    public static function setHistoryChange($data_change, $id_print, $id_user){
        //формирования запроса
        for($i=1; $i <= count($data_change); $i++){
            self::InsertHistoryChange($id_print, $id_user, $data_change[$i]['object'], $data_change[$i]['old_data'], $data_change[$i]['new_data']);
        }
        return true;
    }
    
    public static function getHistoryChangeByID($id_print){
        //формирования запроса
        $db = Db::getConnection();
        
        $history = $db->query('SELECT * FROM history_change WHERE id_print ='.$id_print.';');

        $history->setFetchMode(PDO::FETCH_ASSOC);

        $i = 0;
        while($row = $history->fetch()){
            foreach($row as $key => $value){
                $arr[$i][$key] = $value;
            }
            $i++;
        }
        return $arr;
    }
    
    public static function message(){
        if(isset($_SESSION['message'])){
            return true;
        }
       return false;
    }
    
    private static function InsertHistoryChange($id_print, $user, $object_change, $old_data, $new_data){
        $db = Db::getConnection();
        $date = date("Y-m-d H:i:s");
        //внесение денных об изменениях принтера в бд
        $stmt = $db->prepare("INSERT INTO history_change (date, id_print, user, object_change, old_data, new_data) VALUES (:date, :id_print, :user, :object_change, :old_data, :new_data)");
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':id_print', $id_print);
        $stmt->bindParam(':user', $user);
        $stmt->bindParam(':object_change', $object_change);
        $stmt->bindParam(':old_data', $old_data);
        $stmt->bindParam(':new_data', $new_data);
        
        return $stmt->execute();
    }
    
    public static function insertPrint($data, $return_id = false){
        //формирование запроса и обновление данных в базе
        $db = Db::getConnection();
        $functions = "";
        if(isset($data['id_functions'])) $functions = implode(",", $data['id_functions']);
        //внесение денных об изменениях принтера в бд
        $stmt = $db->prepare("INSERT INTO print 
            (name, unit, model, sn, inventar, id_floor, id_department, id_cartriges, id_status, id_functions) 
            VALUES 
            (:name, :unit, :model, :sn, :inventar, :id_floor, :id_department, :id_cartrige, :id_status, :id_functions)");
        //$stmt->bindParam(':id', $id_print, PDO::PARAM_INT);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':unit', $data['unit']);
        $stmt->bindParam(':model', $data['model']);
        $stmt->bindParam(':sn', $data['sn']);
        $stmt->bindParam(':inventar', $data['inventar']);
        $stmt->bindParam(':id_floor', $data['id_floor']);
        $stmt->bindParam(':id_department', $data['id_department']);
        $stmt->bindParam(':id_cartrige', $data['id_cartrige']);
        $stmt->bindParam(':id_status', $data['id_status']);
        $stmt->bindParam(':id_functions', $functions);
        
        $stmt->execute();
        
        if($return_id = false) return true;
        else return $db->lastInsertId();
        
    }
    
    public static function updatePrint($id_print, $data){
        //формирование запроса и обновление данных в базе
        $db = Db::getConnection();
        $functions = implode(",", $data['id_functions']);
        //внесение денных об изменениях принтера в бд
        $stmt = $db->prepare("UPDATE print set name=:name, unit=:unit, model=:model, sn=:sn, inventar=:inventar, id_floor=:id_floor, id_department=:id_department, id_cartriges=:id_cartrige, id_status=:id_status, id_functions=:id_functions WHERE id = :id");
        $stmt->bindParam(':id', $id_print, PDO::PARAM_INT);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':unit', $data['unit']);
        $stmt->bindParam(':model', $data['model']);
        $stmt->bindParam(':sn', $data['sn']);
        $stmt->bindParam(':inventar', $data['inventar']);
        $stmt->bindParam(':id_floor', $data['id_floor']);
        $stmt->bindParam(':id_department', $data['id_department']);
        $stmt->bindParam(':id_cartrige', $data['id_cartrige']);
        $stmt->bindParam(':id_status', $data['id_status']);
        $stmt->bindParam(':id_functions', $functions);
        
        return $stmt->execute();
    }
    
    private static function identical_values($arrayA, $arrayB) { 
        if(!is_array($arrayA) || !is_array($arrayA)) return false;
        else{
            sort( $arrayA ); 
            sort( $arrayB ); 

            return $arrayA == $arrayB;
        }
    } 

    
    private static function modAndCheckFunctions($old_functions){
        if($old_functions != "Отсутствует"){
            $old_mod_functions = array();
        
            for($i=0; $i < count($old_functions); $i++){
                $old_mod_functions[] = $old_functions[$i]['id'];
            }

            return $old_mod_functions;
        } else return false;
    }


    public static function getAllFloors(){
        
        return self::getAllValuesInTable('*', 'floor');
        
    }
    
    public static function getAllDepartments(){
        
        return self::getAllValuesInTable(array('id', 'name'), 'departments', $where = 'action', $where_value = '1');
        
    }
    
    public static function getAllCartriges(){
        
        return self::getAllValuesInTable(array('id', 'name'), 'cartriges', $where = 'action', $where_value = '1');
        
    }
    
    public static function getAllPrintersByCartrige($id_cartriges){
        
        return self::getAllValuesInTable(array('id', 'name', 'id_status'), 'print', $where = 'id_cartriges', $where_value = $id_cartriges);
        
    }
    
    public static function getCartrigeByID($id){
        
        return self::getAllValuesInTable("*", 'cartriges', $where = 'id', $where_value = $id);
        
    }
    
    public static function getAllStatuses(){
        
         return self::getAllValuesInTable('*', 'status');
    }
    
    public static function getAllFunctions(){
        
         return self::getAllValuesInTable('*', 'functions');
    }
    
    private static function getAllValuesInTable($columns, $table, $where = false, $where_value = false){
        
        $db = Db::getConnection();
        $arr = null;
        $sql = "SELECT ";
        
        if(is_array($columns)) $columns = implode(",", $columns);
        
        $sql .= "$columns FROM $table";
        
        if($where != false) {
            
            $sql .= " WHERE $where=$where_value";
        }
        
        $sql .= ";";
        
        $result = $db->query($sql);
            $result->setFetchMode(PDO::FETCH_ASSOC);
           //$result->fetch();
             //var_dump($row = $result->fetch());
            //if($result->fetch() == false) return false;    СДЕЛАТЬ ИМЕНА КЛЮЧЕЙ МАССИВА ИЗ ВЫГРУЖАЕМЫХ ДАННЫХ!!!!!!!!! НИЖЕ

            $i = 0;
            while($row = $result->fetch()){
                
                foreach($row as $key => $value){
                    $arr[$i][$key] = $value;
                }
                /*$arr[$i]['id'] = $row['id'];
                $arr[$i]['name'] = $row['name'];
                if(isset($row['id_status'])) $arr[$i]['id_status'] = $row['id_status'];*/
                $i++;
            }
            
            return $arr;
    }
    
    public static function getRandPrint($quantity){
        $db = Db::getConnection();
        $list = "";//список для IN
        $arr = array();
        $print = [];
        
        $id_list = $db->query('SELECT id FROM print WHERE id_status = 1');

        $id_list->setFetchMode(PDO::FETCH_ASSOC);

        $i = 0;
        while($row = $id_list->fetch()){
            $arr[$i] = $row['id'];
            $i++;
        }

        $rand_key = array_rand($arr, $quantity);// подставляем в цикл случайное число из массива

            for($j = 0; $j < $quantity; $j++){
                $list .= $arr[$rand_key[$j]].",";
            }
            
        $list = substr($list, 0, -1);
        
        echo $list;

        $result = $db->query('
                    SELECT 
                        print.id as id, 
                        print.name as name, 
                        print.model as model, 
                        print.unit as unit, 
                        print.inventar as indentar, 
                        print.sn as sn, 
                        cartriges.name as cartrige, 
                        departments.name as department, 
                        floor.name as floor, 
                        status.name as status, 
                        print.img as img,
                        print.is_color as color
                    FROM print 
                    LEFT JOIN `cartriges` ON cartriges.id = print.id_cartriges 
                    LEFT JOIN `departments` ON departments.id = print.id_department 
                    LEFT JOIN `floor` ON floor.id =  print.id_floor 
                    LEFT JOIN `status` ON status.id =  print.id_status
                    WHERE print.id IN ('.$list.')'); 
  
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $k = 0;
            while($row = $result->fetch()){
                $print[$k]['id'] = $row['id'];  
                $print[$k]['name'] = $row['name'];  
                $print[$k]['model'] = $row['model'];  
                $print[$k]['unit'] = $row['unit']; 
                $print[$k]['id_floor'] = $row['floor']; 
                $print[$k]['id_department'] = $row['department']; 
                $print[$k]['img'] = $row['img']; 
                $print[$k]['color'] = $row['color']; 
                $k++;
            }
        return $print;
    }
}
