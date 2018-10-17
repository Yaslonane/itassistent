<?php

/**
 * Created on 03.10.2016
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
 * Description of PrintersController
 *
 * @author andrey
 * */
class PrintersController {
    //put your code here
    
    public static $title = " Принтеры";
    
    public function actionIndex(){
        
        $title = self::$title;
        
        $printList = Printer::getListPrinters();
        
        if($printList == 0) $error = 1;
        
        $floor = Printer::getAllFloors();
        $department = Printer::getAllDepartments();
        $cartrige = Printer::getAllCartriges();
        $status = Printer::getAllStatuses();
       
        require_once (ROOT. TMPL. 'printers.php');
        
        /*echo "<pre>";
        var_dump($status);
        echo "</pre>";*/

        return true;
    }
    
    
    public function actionAdd(){
        
        $title = self::$title;
        
        if(isset($_POST['submit'])){
            
            //echo "save!!!";
            
            //insert in base new printer and geting her id
            //forvard in page edit/[id]
            $id = Printer::insertPrint($_POST, true);
            //echo $id;
            header("Location: /printer/edit/".$id);
            /*$upbd = printer::updatePrint($print['id'], $_POST);

            $save = Printer::setHistoryChange($up, $print['id'], $_SESSION['user_id']);
            if(!$upbd) $_SESSION['message'] = "Error";
            else $_SESSION['message'] = "good";*/
        }else{
            $title = self::$title." | Добавление";

            //$printList = Printer::getListPrinters();

            //if($printList == 0) $error = 1;

            $floor = Printer::getAllFloors();
            $department = Printer::getAllDepartments();
            $cartrige = Printer::getAllCartriges();
            $status = Printer::getAllStatuses();
            $functions = Printer::getAllFunctions();

            require_once (ROOT. TMPL. 'add_prn.php');


            /*echo "<pre>";
            var_dump($status);
            echo "</pre>";*/

            return true;
        }
    }
    
    public static function actionView($id){
        
        $print = Printer::getPrintByID($id);
        
        $title = self::$title." | ".$print['name'];
        
        $history = Printer::getHistoryChangeByID($id);
        
        require_once (ROOT. TMPL. 'info.php');
        /*echo "<pre>";
        var_dump($histiry);
        echo "</pre>";*/
        return true;
    }
    
    public static function actionEdit($id){
        
        if(user::checkAdmin() == true){
            $floor = Printer::getAllFloors();
            $department = Printer::getAllDepartments();
            $cartrige = Printer::getAllCartriges();
            $status = Printer::getAllStatuses();
            $functions = Printer::getAllFunctions();
            $print = Printer::getPrintByIDFullData($id);

            $title = self::$title." | Редактирование | ".$print['name'];

                if(isset($_POST['submit'])){

                    /*echo "<pre>";
                    var_dump($print);
                    echo "</pre>";
                    echo "kek";
                    echo "<pre>";
                    var_dump($_POST);
                    echo "</pre>";*/

                    $up = printer::checkDataUpdatePrint($print, $_POST);

                    $upbd = printer::updatePrint($print['id'], $_POST);

                    $save = Printer::setHistoryChange($up, $print['id'], $_SESSION['user_id']);
                    if(!$upbd) $_SESSION['message'] = "Error";
                    else $_SESSION['message'] = "good";
                }

                /*if(isset($_POST['submitimg'])){
                    echo "<pre>";
                    var_dump($_SESSION);
                    echo "<br />----------------------<br />";
                    var_dump($_POST);
                    echo "</pre>";
                }*/
            $print = Printer::getPrintByIDFullData($id);
        }else{
            $access = "Ошибка доступа";
        }
        require_once (ROOT. TMPL. 'edit_print.php');

        unset($_SESSION['message']);
            
        return true;
    }
    
}
