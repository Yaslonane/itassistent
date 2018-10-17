<?php

class PhonebookController{
    
    public static $title = " Телефонный справочник";

    public function actionIndex(){
        
        $title = self::$title;
        
        $list = Phonebook::gelAllPhoneList();
        
        /*echo "<pre>";
        var_dump($list);
        echo "</pre>";*/

        require_once (ROOT. TMPL. 'phonebook.php');

        return true;
    }
    
    public function actionSearch(){
        
        $title = self::$title . " | Поиск";
        
        if(!empty($_POST)){
        $searching = $_POST['searching'];
        }
        if(!empty($searching)){
            $value = Phonebook::gerResultSearch($searching);
        }
        /*echo "<pre>";
        var_dump($list);
        echo "</pre>";*/

        require_once (ROOT. TMPL. 'phonebook_search.php');

        return true;
    }
    
    public function actionSave(){
        
        Phonebook::getExcelList();
        
        header("Location: ".$_SERVER['HTTP_REFERER']."");
        
    }
    
    public function actionUpdate(){
        
        $data = $_POST;

        $upd = Phonebook::save($data);
        if(!empty($upd) || isset($upd['save'])){
            
            if($upd){
                header("Location: ".$_SERVER['HTTP_REFERER']."");
            }else return false;
        }
    }
    
    public function actionAdmsearch(){
        
        $title = self::$title . " | Поиск adm";
        
        $error = false;
        if(user::checkAdmin() == true){
            
            if(isset($_POST['submit']) || !empty($_POST['searching'])){
                $searching = $_POST['searching'];
                $list = Phonebook::gerResultSearch($searching, 1);
            }else{
                $list = Phonebook::gelAllPhoneList(0);
            }
        }else{
            $error = "access denied";
        }
        
        $subardination = Phonebook::getSubordination();
        $parents = Phonebook::getParents();
        $departments = Phonebook::getDepatmnents();
        
        require_once (ROOT. TMPL. 'phonebook_admsearch.php');
        
        return true;
    }
    
    public function actionActiv($id){
        
        if(user::checkAdmin() == true){
            $pub = Phonebook::changeIsActiv($id);
                //var_dump($_SESSION);
                //var_dump($_POST);
                //var_dump($_FILES);
                //var_dump($id);
            if($pub){
                header ('Location: http://'.DOMEN .'/phonebook/admsearch'); 
            }
        }else $error = "access denied";
        
        require_once (ROOT. TMPL. 'phonebook_admsearch.php');
        return true;
    }
    
    public function actionAdd(){
        
        if(user::checkAdmin() == true){
            
        }else{
            $error = "access denied";
        }
        
        require_once (ROOT. TMPL. 'phonebook_add.php');
        
        return true;
    }
    
    public function actionEdit($id){
        
        $title = self::$title . " | Редактирование";
        $message = false;
        
        if(user::checkAdmin() == true){
            if(isset($_POST['save'])){
                $update = Phonebook::save($_POST);
                (!$update) ? $message = "Error" : $message = "Good";
            }
            $info = Phonebook::getElementByID($id);
            $subardination = Phonebook::getSubordination();
            $parents = Phonebook::getParents();
            $departments = Phonebook::getDepatmnents();
        }else{
            $error = "access denied";
        }
        
        require_once (ROOT. TMPL. 'phonebook_edit.php');
        
        return true;
    }
    
    public function actionDelete($id){
        
        if(user::checkAdmin() == true){
            
        }else{
            $error = "access denied";
        }
        
        require_once (ROOT. TMPL. 'phonebook_del.php');
        
        return true;
    }
            

}