<?php

/* 
 *
 */

class SiteController{
        /*
         * 
         * вывод главной страницы
         * 
         */
    public static $title = " Главная";
    
    public function actionIndex(){ 
        
        //$categories = array(); //инициализируем переменную для вывода списка категорий
        //$categories = Category::getCategoriesList(); // вызываем метод получения массива категорий из модели категории
        /* выводим дерево категорий
        $x = new Category(); // вызываем класс
        $a = $x->treeCategory(); // выбираем из базы список категорий и подкатегорий
        $categories2 = category::create_tree($a, 0); // вызываем функцию и строим дерево
         * 
         */
        
        //$latestProduct = array();
        //$latestProduct = Product::getLatestProducts();
        $title = self::$title;
        
        $summ_cart =  Cartriges::getSumAllCarteiges();
        
        $printList = Printer::getRandPrint(3);
        
        require_once(ROOT . TMPL .'index.php');
        /*echo "Home<br>";
        
        if(user::checkAuth() == false){
            echo "Авторизуйтесь!!!";
        }else{
            echo "<img src='https://intranet.rencredit.ru/my/User%20Photos/Profile%20Pictures/".$_SESSION['user_id']."_LThumb.jpg' class='img-circle'/>";
                
                
            echo "<pre>";
            var_dump($_SESSION);
            echo "</pre>";
            echo "<a href='/user/logout'>Exit</a>";
        }*/
        
        return true;
    }
    
    public function actionContact(){
        
        $userEmail = '';
        $userText = '';
        $result = false;
       
        if(isset($_POST['submit'])){
            
            $userEmail = $_POST['userEmail'];
            $userText = $_POST['userText'];
            
            $errors = false;
            
            if(!user::checkEmail($userEmail)){
                $errors[] = 'Not valid E-mail';
            }
            
            if($errors == false){
                $adminEmail = 'yaslonane@yandex.ru';
                $message = "Текст: {$userText}. От {$userEmail}";
                $subject = 'subject mail TEST';
                $result = mail($adminEmail, $subject, $message, "From: System message from zaa46.xyz <info@zaa46.xyz>"); /* {$userEmail} */
                $result = true;
            }
        }
        
        require (ROOT . TMPL . 'contact.php');
        
        return true;
    }
        /* 
         * конец вывода главной страницы 
         */
}
