<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cartriges
 *
 * @author adm_azashchepkin
 */
class CartrigesController {
    //put your code here
    public static $title = " Картриджи";
    
    public function actionIndex(){ //главная страница раздела картриджей
        
        $title = self::$title;
        
        $summ_cart =  Cartriges::getSumAllCarteiges();
        
        if(isset($_POST['submit'])){
            
            $messages = Cartriges::ActionCartriges($_POST, $_SESSION);
            /*echo "<pre>";
            print_r ($_POST);
            print_r ($_SESSION['user_id']);
           echo "</pre>";*/
            
        }
        
        require_once (ROOT . TMPL . 'cartriges.php');
        return true;
    }
    
    public function actionActions(){ //действия с картриджами (доставка\замена)
        
        if(!isset($_POST['submit'])) @$_SESSION['link'] = $_SERVER['HTTP_REFERER'];
        
        $act_error = 0;
        
        $action = $_GET['act'];
        
        if(empty($action)) $act_error = 1;
        
        $title = self::$title."| Действия";
        
        //echo "hello user ".$action."-action";
        
        $cartriges = Cartriges::getActivCartriges();        
        require_once (ROOT . TMPL . 'action_cartriges.php');
        return true;
    }
    
    public static function actionAdd(){ //добавление картриджа
        
        $title = self::$title."| Добавление";
        
        
        if(isset($_POST['addcartrige'])){
            
            echo "get add new cartrige in base";
            (!Cartriges::addCartriges($_POST)) ? $messages = "Картридж добавлен" : $messages = "error";
            $cartriges = Cartriges::getAllCartriges();
        }
        else{
            $cartriges = Cartriges::getAllCartriges();
        }
        $cartrridges_history = Cartriges::getHistoryCartridges(9);
        require_once (ROOT . TMPL . 'addcartrige.php');
        return true;
    }
    
    public function actionPublic($id){
        
        //self::checkAdmin();

        $pub = Cartriges::changeIsPublic($id);
            //var_dump($_SESSION);
            //var_dump($_POST);
            //var_dump($_FILES);
            //var_dump($id);
        if($pub){
            header ('Location: '.DOMEN .'/cartriges/add'); 
        }
    }

    
    public static function actionReaction($id){ //активация\деактивация картриджа

        Cartriges::reactivCartriges($id);
        
        return true;

    }
    
    public static function actionOrders(){ //заказ картриджей 
        
        $title = self::$title."| Заказ";
        if(user::checkAdmin() == true){
            $summ_cart =  Cartriges::getSumAllCarteiges();
            $cartriges = Cartriges::getActivCartriges();

            if(isset($_POST['submit'])){
                //show and running code for order
                $list = Cartriges::orderCartriges($_POST);
                $data_ord = json_encode($_POST);
                /*$from = array(
                    'name'=>''.$_SESSION["full_name"].'',
                    'email'=>''.$_SESSION["mail"].'',
                );*/
                $a = Mail::getLinkOrd($list);
                //echo $a;
                /*echo "<pre>";
                var_dump($_SESSION);
                echo "</pre>";*/
            }
            $save = filter_input(INPUT_POST, 'save_order');
                if(isset($save)){
                    $data = json_decode(filter_input(INPUT_POST, 'data'), true);
                    
                    $saving = Unit::saveOrder($_SESSION["user_id"], $data);//добавить в базу заявок
                    //var_dump($create_action);
                    if(!$saving){
                        $message = "error";
                    }else {
                        $message = "ok";
                        //header("Location: ".$_SERVER['HTTP_REFERER']."");
                    }
                }
        }else{
            $access = "Ошибка доступа";
        }
        require_once (ROOT . TMPL . 'cartriges_order.php');
        return true;
    }
    
    public static function actionZeroning(){
        Cartriges::resetToZero();
    }

}
