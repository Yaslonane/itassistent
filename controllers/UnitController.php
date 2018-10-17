<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UnitController
 *
 * @author adm_azashchepkin
 */
class UnitController {
    //put your code here
    public static $title = " Unit";
    
    public function actionIndex($page = 1){
        
        $title = self::$title . " | Список обращений";
        
        $requests = Unit::getRequests($page);
        $total = Unit::getTotalRequests();
        
        $pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT, 'page-');
        
        /*echo "<pre>";
        var_dump($requests);
        echo "</pre>";*/
        
        require_once (ROOT. TMPL. 'requests.php');
        
        return true;
    }
    
    public function actionCreaterequest(){
        
        $title = self::$title . " | Создание запроса";
        
        $error = false;
        $message = false;
        
        if(user::checkAdmin() == true){

            $printers = Printer::getListPrinters('all');
            $create = filter_input(INPUT_POST,'create');
            if(isset($create)){
                $user_id = filter_input(INPUT_POST,'username');
                $print_id = filter_input(INPUT_POST,'print_id');
                $description = filter_input(INPUT_POST,'text');

                $lnk = Mail::getRequests($print_id, $description);
                
                
            }
            $save = filter_input(INPUT_POST, 'save_request');
            if(isset($save)){
                $user = filter_input(INPUT_POST,'user_id');
                $print = filter_input(INPUT_POST,'print_id');
                $desc = filter_input(INPUT_POST,'description');
                $saving = Unit::setRequest($user, $print, $desc);//добавить в базу заявок
                $create_action = Unit::createNewAction($saving, 0, $user);
                //var_dump($create_action);
                if(!$saving){
                    $message = "error";
                }else {
                    $message = "ok";
                    //header("Location: ".$_SERVER['HTTP_REFERER']."");
                }
            }
        }else{
            $error = "access denied";
        }
        require_once (ROOT. TMPL. 'create_request.php');
        
        /*echo "<pre>";
        var_dump($status);
        echo "</pre>";*/

        return true;
    }
    
    public function actionRequesttobase(){
        //$printers = Printer::getListPrinters('all');
        $save = filter_input(INPUT_POST, 'save_request');
            if(isset($save)){
                $user_id = filter_input(INPUT_POST,'user_id');
                $print_id = filter_input(INPUT_POST,'print_id');
                $description = filter_input(INPUT_POST,'description');
                $saving = Unit::setRequest($user_id, $print_id, $description);//добавить в базу заявок
                if(!$saving){
                    $message = "error";
                }else {
                    $message = "ok";
                    header("Location: ".$_SERVER['HTTP_REFERER']."");
                }
            }
            echo $message;
        return true;
        /*echo "<pre>";
        var_dump($status);
        echo "</pre>";*/

    }
    
    public function actionActionrequest($id = NULL){
        $title = self::$title . " | Действия по обращению";
        $error = "";
         if(user::checkAdmin() == true){
             //action if authorization is successful
             if($id === NULL){
                 header("Location: http://".DOMEN."/unit/requests");
             }else{
                 $list = Unit::getRequestByID($id);
                 $act = Unit::getAllActionByIDRequest($id);
             }
         }else{
            $error = "access denied";
        }
        //require_once (ROOT. TMPL. 'create_request.php');
        require_once (ROOT. TMPL. 'action_request.php');

        return true;
    }
    
    public function actionNewactionrequest(){
        
        $act = Unit::setNewActions();
        
        $docs = filter_input(INPUT_POST, 'docs');
        $request_id = filter_input(INPUT_POST, 'request_id');
        
        $indoc = Unit::setNewDocs($act, $request_id, $docs);
        
        if($indoc == true) header("Location: http://".DOMEN."/unit/actionrequest/".$request_id."");
        
        //return true;
    }
}
