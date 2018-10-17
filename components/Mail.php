<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mail
 *
 * @author adm_azashchepkin
 */
class Mail {
    //put your code here
    public static function getOrderCartriges($list_print, $from){
        //
        $message = '<html>
                    <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                        <title>Заказ картриджей</title>
                    </head>
                    <body>
                    <p>Добрый день.<br />
                    КБ «Ренессанс Кредит» (ООО)<br /> 
                    Адрес: г. Курск, ул. Радищева 5.<br /> 
                    Необходимы картриджи для: </p>
                    <p>';
        for($i=0; $i < count($list_print); $i++){
            if($list_print[$i]['is_color'] == 1){
                $message .= "".$list_print[$i]['model']."  ".$list_print[$i]['unit']." (black)  (2 шт.)<br />";
                $message .= "".$list_print[$i]['model']."  ".$list_print[$i]['unit']." (blue)  (2 шт.)<br />";
                $message .= "".$list_print[$i]['model']."  ".$list_print[$i]['unit']." (yellow)  (2 шт.)<br />";
                $message .= "".$list_print[$i]['model']."  ".$list_print[$i]['unit']." (magenta)  (2 шт.)<br />";
            }else $message .= "".$list_print[$i]['model']."  ".$list_print[$i]['unit']." (2 шт.)<br />";
        }
        
        $message .= '</p><p>График работы:  Пн-Пт. 9:00 - 18:00. <br /> 
                    Контактные номера: <br /> 
                    Захаренко Евгений    <br />  
                    +7 (495) 783-46-00 доб. 15015 <br /> 
                    Защепкин Андрей     <br /> 
                    +7 (495) 783-46-00 доб. 15000 <br /> 
                    Галин Владислав <br /> 
                    +7 (495) 783-46-00 доб. 15025 </p>
                    ';
        $ord = self::getMail('Заказ картриджей', $message, $from);
        (!$ord) ? $mess = "don't geting" : $mess = "OK";
        return $mess;
    }
    
    
    
    
    private static function getMail($subject, $message, $from){
        
        $paramsPath = ROOT.'/config/unit_information.php';
        $params = include($paramsPath);

        // отправка нескольким адресатам
        $to  = $params['email_support'] . ', '; // кому отправляем
        //$to .= 'friend2@yourmail.ru' . ', '; // Внимание! Так пишем второй и тд адреса
        // не забываем запятую. Даже в последнем контакте лишней не будет
        // Для начинающих! $to .= точка в этом случае для Дописывания в переменную 

        // содержание письма
        /*$subject = "Тема сообщения";
        $message = '
        <html>
            <head>
           <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Тема страницы</title>
            </head>
            <body>
                <p>А здесь ваше сообщение</p>
            </body>
        </html>';*/

        // устанавливаем тип сообщения Content-type, если хотим
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= "Content-type: text/html; charset=utf-8 \r\n";

        // дополнительные данные
        $headers .= "From: ".$from['name']." <".$from['email'].">\r\n"; // от кого
        $headers .= "Cc: #ITKursk@rencredit.ru" . "\r\n"; // копия сообщения на этот адрес
        //$headers .= "Bcc: yournick-archive@yourmail.ru\r\n"; // скрытая копия сообщения на этот
        mail($to, $subject, $message, $headers);
        
    }
    
    public static function getLinkOrd($list_print){
        
        $paramsPath = ROOT.'/config/unit_information.php';
        $params = include($paramsPath);

        // отправка нескольким адресатам
        $to  = $params['email_support']; // кому отправляем
        $message = "КБ «Ренессанс Кредит» (ООО)%0aАдрес: г. Курск, ул. Радищева 5.%0aНеобходимы картриджи для:%0a%0a";
        for($i=0; $i < count($list_print); $i++){
            if($list_print[$i]['is_color'] == 1){
                $message .= "".$list_print[$i]['model']."  ".$list_print[$i]['unit']." (black)  (2 шт.)%0a";
                $message .= "".$list_print[$i]['model']."  ".$list_print[$i]['unit']." (blue)  (2 шт.)%0a";
                $message .= "".$list_print[$i]['model']."  ".$list_print[$i]['unit']." (yellow)  (2 шт.)%0a";
                $message .= "".$list_print[$i]['model']."  ".$list_print[$i]['unit']." (magenta)  (2 шт.)%0a";
            }else $message .= "".$list_print[$i]['model']." ".$list_print[$i]['unit']." (2 шт.)%0a";
        }
        $message .= "%0aГрафик работы:  Пн-Пт. 9:00 - 18:00.%0aКонтактные номера:%0aЗахаренко Евгений%0a+7 (495) 783-46-00 доб. 15015%0aЗащепкин Андрей%0a+7 (495) 783-46-00 доб. 15000%0aГалин Владислав%0a+7 (495) 783-46-00 доб. 15025";
        
        $ord = self::getLinkMail("Заказ картриджей", $message, $to);
        //(!$ord) ? $mess = "don't geting" : $mess = "OK";
        return $ord;
        
    }
    
    public static function getRequests($print_id, $description){
        
        $paramsPath = ROOT.'/config/unit_information.php';
        $params = include($paramsPath);
        $print = Printer::getPrintByID($print_id);
        // отправка нескольким адресатам
        $to  = $params['email_support']; // кому отправляем
        $message = "КБ «Ренессанс Кредит» (ООО)%0aАдрес: г. Курск, ул. Радищева 5.%0a%0a";
        $message .= "Проблемы с принтером ".$print['model']."  ".$print['unit'].". ".$description."%0a";
        $message .= "%0aГрафик работы:  Пн-Пт. 9:00 - 18:00.%0aКонтактные номера:%0aЗахаренко Евгений%0a+7 (495) 783-46-00 доб. 15015%0aЗащепкин Андрей%0a+7 (495) 783-46-00 доб. 15000%0aГалин Владислав%0a+7 (495) 783-46-00 доб. 15025";
        
        $request = self::getLinkMail("Проблемы с принтером ".$print['model']."  ".$print['unit'], $message, $to);
        //(!$ord) ? $mess = "don't geting" : $mess = "OK";
        return $request;
    }
    
    
    private static function getLinkMail($subject, $body, $to){
        
        $subject = "?subject=".$subject;
        $body = "&body=".$body;
        $cc = "&cc=%23ITKursk%40rencredit.ru";
        
        $link = "<a href='mailto:".$to.$subject.$body.$cc."'>Link</a>";
        
        return $link;
    }
}
/*array(13) {
  ["link"]=>
  string(30) "http://prints.local/cartriges/"
  ["user_id"]=>
  string(12) "azashchepkin"
  ["name_en"]=>
  string(19) "Zashchepkin, Andrey"
  ["name"]=>
  string(16) "Защепкин"
  ["surname"]=>
  string(12) "Андрей"
  ["middle_name"]=>
  string(26) "Александрович"
  ["full_name"]=>
  string(56) "Защепкин Андрей Александрович"
  ["city"]=>
  string(10) "Курск"
  ["position"]=>
  string(62) "Специалист технической поддержки"
  ["department"]=>
  string(60) "Отдел информационных технологий"
  ["mail"]=>
  string(25) "azashchepkin@rencredit.ru"
  ["phone"]=>
  string(5) "15000"
  ["georol"]=>
  string(16) "GR.RC.Курск"
}*/