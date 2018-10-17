<?php include ROOT . TMPL . 'header.php'; ?>
<div class="panel-group" id="accordion">
<table class="table">
  <thead>
    <tr>
      <th>id</th>
      <th>дата создания</th>
      <th>Имя пользователя</th>
      <th>Имя принтера</th>
      <th>номер UNIT</th>
      <th>Статус</th>
      <th>Дата закрытия</th>
      <th>История...</th>
      <th>Добавить</th>
    </tr>
  </thead>
  <tbody>


  <!-- 1 панель -->

<?php foreach($requests as $request): ?>

<tr>
    <th scope="row"><?php echo $request['id']; ?></th>
    <td><?php echo Date::changeLocaleDate(date("d F Y", $request['date_create'])); ?></td>
    <td><?php echo $request['user']; ?></td>
    <td><?php echo $request['printname']; ?></td>
    <td><?php echo $request['unit']; ?></td>
    <td><?php echo $request['status']; ?></td>
    <td><?php echo Date::changeLocaleDate(date("d F Y", $request['date_close'])); ?></td>

  <td>   
  
      <!-- Заголовок 1 панели -->
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $request['id']; ?>">Посмотреть</a>
        </h4>
      </div>
  </td>
      <td> <a href="/unit/actionrequest/<?php echo $request['id']; ?>">+</a></td>
</tr>
    <tr> 
        <td colspan="8">
            <div id="collapse<?php echo $request['id']; ?>" class="panel-collapse collapse">
            <!-- Содержимое 1 панели -->
            <div class="panel-body">

            <?php if($request['actions'] === NULL): ?>
                <h5> Для заявки № <?php echo $request['id']; ?> истории нет</h5>
            <?php else: ?>
                <ul class="timeline">


            <!---["actions"]=>
            array(1) {
            [0]=>
            array(7) {
            ["id"]=>
            string(1) "1"
            ["request_id"]=>
            string(2) "15"
            ["action"]=>
            string(31) "Создание запроса"
            ["description"]=>
            string(165) "fdsgs  agsfdgsf gfg sfdgfdsgsfdgfds gfsjgfmgmfdsg gffgfg gmfmgfmg ,gffgfllfg. jgfdfjgjfdgj fgfg sfgfg/dsfgsdfgfsg fdsg/fsgsfd dsfg/fgsfdgl flkgflkgfgf.gfflgkfgdslfg "
            ["date"]=>
            string(10) "1508340265"
            ["user"]=>
            string(12) "azashchepkin"
            ["doc_link"]=>
            NULL
            } --->              
                <?php foreach($request['actions'] as $actions): ?>
                    <li><!---Time Line Element--->

                        <!---<i class="fa fa-envelope-o" aria-hidden="true"> создание запроса
                        <i class="fa fa-envelope-open-o" aria-hidden="true"></i> подтверждение от юнита
                        <i class="fa fa-handshake-o" aria-hidden="true"></i> визит инжененра
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> закрытине запроса
                        <i class="fa fa-thumbs-up"></i>
                        --->     
                     <div class="timeline-badge up">
                        <?php if($actions['action_id'] == 1): ?>
                            <i class="fa fa-envelope-o" aria-hidden="true"></i>
                        <?php elseif($actions['action_id'] == 2): ?>
                            <i class="fa fa-envelope-open-o" aria-hidden="true"></i>
                        <?php elseif($actions['action_id'] == 3): ?>
                            <i class="fa fa-handshake-o" aria-hidden="true"></i>
                        <?php elseif($actions['action_id'] == 4): ?>
                            <i class="fa fa-floppy-o" aria-hidden="true"></i>
                        <?php else: ?>
                            <i class="fa fa-thumbs-up"></i>
                        <?php endif; ?>
                     </div>
                     <div class="timeline-panel">
                       <div class="timeline-heading">
                           <h4 class="timeline-title"><p><?php echo $actions['actname'] ?></p>
                         <small><strong>Дата:</strong> <em><?php echo date("d-m-Y", $actions['date']) ?></em></small> <small><strong>Пользователь:</strong> <em><?php echo $actions['user'] ?></em></small> </h4>
                       </div>
                       <div class="timeline-body"><!---Time Line Body&Content--->
                         <p><?php echo $actions['description'] ?></p>
                       </div>
                     </div>
                    </li>
                <?php endforeach; ?> 
            </ul> 
            <?php endif; ?>
            </div>
            </div> 
            
        </td>
        
    </tr>
 
    
    


<?php endforeach; ?>  
</tbody>
</table>
  </div>
 

<?php echo $pagination->get(); ?> 

<?php include ROOT . TMPL . 'footer.php'; ?>