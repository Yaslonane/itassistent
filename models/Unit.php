<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Unit
 *
 * @author adm_azashchepkin
 */
class Unit {
    //put your code here
    private static $db;
    
    const SHOW_BY_DEFAULT = 10;
    
    public function __construct() {
        self::$db = Db::getConnection();
    }
    
    public static function setRequest($user_id, $id_print, $description){
        
        $db = Db::getConnection();
        $date = strval(time());
        $status = 1;
        //$username = $user_id;
        //$id_prn = intval($id_print);
        //$description = htmlspecialchars($description);

          //внесение денных об изменениях принтера в бд
        $stmt = $db->prepare("INSERT INTO requests (date_create, user, id_print, description, status) VALUES (:date_create, :user, :id_print, :description, :status)");
        $stmt->bindParam(':date_create', $date);
        $stmt->bindParam(':user', $user_id);
        $stmt->bindParam(':id_print', $id_print);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':status', $status);
        
        $stmt->execute();
        return $db->lastInsertId();
    }
    
    public static function createNewAction($id_request, $act, $user){
        $db = Db::getConnection();
        $date = strval(time());
        if($act === 0) {$action = 1;}
        
        $stmt = $db->prepare("INSERT INTO actions_request (request_id, action_id, date, user) VALUES (:request_id, :action, :date, :user)");
        $stmt->bindParam(':request_id', $id_request);
        $stmt->bindParam(':action', $action);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':user', $user);
        
        return $stmt->execute();
    }
    
    public static function getAllActionByIDRequest($id_request){
        $db = Db::getConnection();
        $sql = "SELECT 
                    actions_request.id AS id,
                    actions_request.request_id AS request_id,
                    actions_request.action_id AS action_id,
                    actions_request.description AS description,
                    actions_request.date AS date,
                    actions_request.user AS user,
                    actions.name AS actname
                FROM actions_request 
                LEFT JOIN actions ON  actions.id = actions_request.action_id
                WHERE actions_request.request_id=".$id_request.";";
        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        
        $actions = NULL;
        
        $i = 0;
        while($row = $result->fetch()){
            //if($row == NULL) return NULL;
            foreach($row as $key=>$value){
                $actions[$i][$key] = $value;
                //$actions[$i]['docs'] = self::getAllLinkByActionID($actions[$i]['id']);
            }
            $i++;
        }
        
        for($i=0; count($actions)>$i; $i++){
            $actions[$i]['docs'] = self::getAllLinkByActionID($actions[$i]['id']);
        }
        
        return $actions;
    }
    
    public static function getAllLinkByActionID($id){
        $docs = false;
        $db = Db::getConnection();
        $sql = "SELECT docname, link, id_request, id_actions FROM doc_for_requests WHERE id_actions=".$id.";";
        $result = $db->query($sql);

        $result->setFetchMode(PDO::FETCH_ASSOC);
            $i = 0;
            while($row = $result->fetch()){
                //if($row == NULL) return NULL;
                foreach($row as $key=>$value){
                    $docs[$i][$key] = $value;
                }
                $i++;
            }

        return $docs;
    }

        public static function getRequests($page){
        
        $db = Db::getConnection();
        
        $page = intval($page);
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;
        $sql ="";
        //$sql = "SELECT * FROM requests ORDER BY id DESC LIMIT ".self::SHOW_BY_DEFAULT." OFFSET ".$offset;
        $sql .= "SELECT 
                    requests.id AS id, 
                    requests.date_create AS date_create,
                    requests.user AS user, 
                    requests.id_print AS id_print,
                    print.name AS printname,
                    print.unit AS unit,
                    print.model AS printmodel,
                    requests.description,
                    requests.status AS id_status,
                    request_status.name AS status,
                    requests.date_close
                FROM requests
                LEFT JOIN print ON requests.id_print = print.id
                LEFT JOIN request_status ON requests.status = request_status.id";
        $sql .= " ORDER BY id DESC LIMIT ".self::SHOW_BY_DEFAULT." OFFSET ".$offset;
        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        
        $list = NULL;

        $i = 0;
        while($row = $result->fetch()){
            if($row == NULL) break;
            foreach($row as $key=>$value){
                $list[$i][$key] = $value;
                $list[$i]['actions'] = self::getAllActionByIDRequest($list[$i]['id']);
            }
            $i++;
        }
        
        return $list;
    }
    
    public static function getTotalRequests(){
        $db = Db::getConnection();
        
        $result = $db->query('SELECT count(id) AS count FROM requests');
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();
        
        return $row['count'];
    }
    
    public static function getRequestByID($id){
        $db = Db::getConnection();
        $sql = "SELECT 
                    requests.id AS id, 
                    requests.date_create AS date_create,
                    requests.user AS user, 
                    requests.id_print AS id_print,
                    print.name AS printname,
                    print.unit AS unit,
                    print.model AS printmodel,
                    print.img AS img,
                    requests.description,
                    requests.status AS id_status,
                    request_status.name AS status,
                    requests.date_close
                FROM requests
                LEFT JOIN print ON requests.id_print = print.id
                LEFT JOIN request_status ON requests.status = request_status.id
                WHERE requests.id =".$id.";";
        
        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();
        
        return $row;
    }
    
    public static function getStringJSONbyModal($data){
        $data['user'] = $_SESSION['user_id'];
        return json_encode($data);
    }
    
    public static function setNewActions(){
        
        $request_id = filter_input(INPUT_POST, 'request_id');
        $user = filter_input(INPUT_POST, 'user');
        $date = filter_input(INPUT_POST, 'date'); //2017-10-27
        $action_id = filter_input(INPUT_POST, 'action_id');
        $description = filter_input(INPUT_POST, 'description');
        //$docs = filter_input(INPUT_POST, 'docs');
        $arr_date = explode("-", $date);
        $U_date = mktime(0,0,0,$arr_date[1],$arr_date[2],$arr_date[0]); //"2017-10-27"
        
        $db = Db::getConnection();
        
        if($action_id == 2){
            $stmt = $db->prepare("UPDATE requests SET status=2 WHERE id=:id");
            $stmt->bindParam(':id', $request_id, PDO::PARAM_INT);
            $stmt->execute();
        }elseif($action_id == 4){
            $stmt = $db->prepare("UPDATE requests SET status=3, date_close=:date WHERE id=:id");
            $stmt->bindParam(':id', $request_id, PDO::PARAM_INT);
            $stmt->bindParam(':date', $U_date);
            $stmt->execute();
        }
          //внесение денных об изменениях принтера в бд
        $stmt = $db->prepare("INSERT INTO actions_request (request_id, action_id, description, date, user) VALUES (:request_id, :action_id, :description, :date, :user)");
        $stmt->bindParam(':date', $U_date);
        $stmt->bindParam(':request_id', $request_id);
        $stmt->bindParam(':user', $user);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':action_id', $action_id);
        
        $stmt->execute();
        return $db->lastInsertId();
    }
    
    public static function setNewDocs($id_action, $id_request, $docs){
        
        $links = explode("\n", $docs);
        
        $link = array_slice($links, 0, (count($links)-1));

        $docs = [];
        for($i=0; count($link)>$i;$i++){
            $docs[$i]['name'] = substr(strrchr($link[$i], "/"), 1);  //обрезаем ссылку и получаем имя файла
            $docs[$i]['link'] = $link[$i];  //обрезаем ссылку и получаем имя файла
        }
       
        $db = Db::getConnection();
        
        for($j=0;count($docs)>$j;$j++){
            $docname = $docs[$j]['name'];
            $doclink = $docs[$j]['link'];
                   
            $stmt = $db->prepare("INSERT INTO doc_for_requests (link, docname, id_request, id_actions) VALUES (:link, :docname, :id_request, :id_actions)");
            $stmt->bindParam(':link', $doclink);
            $stmt->bindParam(':docname', $docname);
            $stmt->bindParam(':id_request', $id_request);
            $stmt->bindParam(':id_actions', $id_action);

            $stmt->execute();
        }
        
        return true;
    }
    
    public static function saveOrder($user, $data){

        /*array(3) {
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
            }*/

        for($i=0; $i < count($data)-1; $i++){
            $a = "Заказ ".$data[$i]['quantity']." шт";
            self::setToHistoryCartridges($user, $data[$i]['cartrige'], $a);
            /*$a = "Заказ ".$data[$i]['quantity']." штук";
            self::setToHistoryCartridges($user, $data[$i]['cartrige'], $a);*/
        }

        return true;
    }
    
    public static function setToHistoryCartridges($user, $id_catridge, $action){
        $db = Db::getConnection();
        $stmt = $db->prepare("INSERT INTO history_cartridges (user, date, id_cartridge, action) VALUES (:user,  UNIX_TIMESTAMP(), :id_cartridge, :action)");
        $stmt->bindParam(':user', $user);
        $stmt->bindParam(':id_cartridge', $id_catridge);
        $stmt->bindParam(':action', $action);
        $stmt->execute();
        
        return true;
    }
}
