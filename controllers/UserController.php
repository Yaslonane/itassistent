<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserController
 *
 * @author andrey
 */
class UserController {
    //put your code here
    
    //public static function actionIndex{
        
        
   // }
    
   /* public function actionRegister(){
        
        $name = '';
        $email = '';
        $password = '';
        $result = false;
            
        if(isset($_POST['submit'])){
            
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $errors = false;
            
            if(!user::checkName($name)){
                $errors[] = 'Warning!!! It\'s name short 2 elements';
            }
            
            if(!User::checkPassword($password)){
                $errors[] = 'Warning!!! It\'s password short 6 elements';
            }
            
            if(!User::checkEmail($email)){
                $errors[] = 'Warning!!! It\'s e-mail dont valid';
            }
            
            if(user::checkEmailExists($email)){
                $errors[] = 'Sorry, this is e-mail is using';
            }
            
            if($errors == false){
                $result = (user::register($name, $password, $email));
            }
            
        }
        
        
        require_once (ROOT. TMPL. 'register.php');
        
        return true;
    }*/
    
    public function actionLogin(){
        if(!isset($_POST['submit'])) $_SESSION['link'] = $_SERVER['HTTP_REFERER'];
        $username = '';
        $password = '';
        
        $errors = false;
        
        if(isset($_POST['submit'])){
            $username = $_POST['login'];
            $password = $_POST['password'];
            
            $errors = false;
            
            $auth = Ldap::LdapAuth($username, $password);
            header("location: ".$_SESSION['link']."");    
        }
        
        require_once (ROOT . TMPL . 'login.php');
        
        return true;
    }
    

    public function actionLogout(){
        
        @session_start();
        unset($_SESSION['user_id']);  
        unset($_SESSION['name']);  
        header("Location: ".$_SERVER['HTTP_REFERER']."");
        session_destroy();
    }
    
}
