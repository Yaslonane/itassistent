<?php include ROOT . TMPL . 'header.php'; ?>

<?php if($error == "access denied"): ?>
    <div class="panel panel-danger col-xs-offset-4 col-xs-4">
        <div class="panel-heading">
            <h3 class="panel-title">Error!!!</h3>
        </div>
        <div class="panel-body">
            Ошибка доступа
        </div>
    </div> 
<?php else: ?>

<!-- HTML-код модального окна -->
<div class="modal fade" id="newactionrequest" tabindex="-1" role="dialog" aria-labelledby="newactionrequestLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="newactionrequestLabel">Редактирование записи</h4>
        </div>
        <div class="modal-body">
            <form id="newaction" method="POST" action="/unit/newactionrequest">
                <div class="form-group">
                    <input type="hidden" class="form-control" name="request_id" id="id">
                    <label for="user" class="form-control-label">Логин:</label>
                        <input type="text" class="form-control" id="user" name="user">
                    <label for="date" class="form-control-label">Дата:</label>
                        <input type="date" class="form-control" id="date" name="date">
                    <label for="action" class="form-control-label">Действие:</label>
                        <select class="form-control" id="action_id" name="action_id">
                            <datalist id="action_id">
                                <option disabled selected>Действие</option>
                                <option value="1">Создание запроса</option>
                                <option value="2">Подтверждение от юнита</option>
                                <option value="3">Визит инжененра</option>
                                <option value="4">Закрытине запроса</option>
                            </select> 
                    <label for="description" class="form-control-label">Описание:</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                    <label for="docs" class="form-control-label">Документы:</label>
                        <script type="text/javascript">
                            function openKCFinder(textarea) {
                                window.KCFinder = {
                                    callBackMultiple: function(files) {
                                        window.KCFinder = null;
                                        textarea.value = "";
                                        for (var i = 0; i < files.length; i++)
                                            textarea.value += files[i] + "\n";
                                    }
                                };
                                window.open('<?php echo LIB ?>/kcfinder/browse.php?type=files&dir=files/public',
                                    'kcfinder_multiple', 'status=0, toolbar=0, location=0, menubar=0, ' +
                                    'directories=0, resizable=1, scrollbars=0, width=800, height=600'
                                );
                            }
                        </script>

                        <textarea id="docs" name="docs" class="form-control" readonly="readonly" onclick="openKCFinder(this)">Нажмите здесь и выберите несколько файлов с помощью клавиши Ctrl/command. Затем нажмите правой кнопкой мыши на одном из них и выберите " Выбрать"</textarea>
                        
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" name="save">Сохранить</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>


<h4>Основная информация <br><small>Заявка № <?php echo $list['id']; ?></small></h4>
<br />
    <div class="row" id="history">
        <div class="col-xs-3 col-xs-offset-1">
            <label class="control-label " for="date_create">Дата открытия: </label> <?php echo date("d-m-Y", $list['date_create']); ?>
            <br /><label class="control-label " for="user">Логин автора: </label> <?php echo $list['user']; ?>
            <br /><label class="control-label " for="status">Статус заявки: </label> <?php echo $list['status']; ?>
            <br /><label class="control-label " for="date_close">Дата закрытия: </label> <?php echo date("d-m-Y", $list['date_close']); ?>
        </div>
        <div class="col-xs-4">
            <label class="control-label " for="printname">Имя: </label> <?php echo $list['printname']; ?>
            <br /><label class="control-label " for="printmodel">Модель: </label> <?php echo $list['printmodel']; ?>
            <br /><label class="control-label " for="unit">№ юнит: </label> <?php echo $list['unit']; ?>
            <br /><label class="control-label " for="description">Описание: </label> <?php echo $list['description']; ?>
        </div>
        <div class="col-xs-4">
            <img  width="150px" src="<?php echo $list['img']; ?>"/>
        </div>
    </div>


<h4>История движения <br><small>Заявка № <?php echo $list['id']; ?> Текущий статус: <i><?php echo $list['status']; ?></i></small></h4>
    
    
<ul class="timeline">
    <?php foreach($act as $action): ?>
        <li><!---Time Line Element--->
         <div class="timeline-badge up">
            <?php if($action['action_id'] == 1): ?>
                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                <?php elseif($action['action_id'] == 2): ?>
                    <i class="fa fa-envelope-open-o" aria-hidden="true"></i>
                <?php elseif($action['action_id'] == 3): ?>
                    <i class="fa fa-handshake-o" aria-hidden="true"></i>
                <?php elseif($action['action_id'] == 4): ?>
                    <i class="fa fa-floppy-o" aria-hidden="true"></i>
                <?php else: ?>
                    <i class="fa fa-thumbs-up"></i>
                <?php endif; ?>
         </div>
         <div class="timeline-panel">
            <div class="timeline-heading">
                <h4 class="timeline-title"><p><?php echo $action['actname']; ?></p>
                <small><strong>Дата:</strong> <em><?php echo date("d-m-Y", $action['date']) ?></em></small> <small><strong>Пользователь:</strong> <em><?php echo $action['user'] ?></em></small> </h4>
            </div>
            <div class="timeline-body"><!---Time Line Body&Content--->
                <p><?php echo $action['description'] ?></p>
            </div>

            <dl class="row">
            <dt class="col-xs-1 text-right">Документы</dt>
                <?php for($i=0;count($action['docs']) > $i; $i++): ?>
                    <?php if($i==0):?><dd class="col-xs-10"><a href="<?php echo $action['docs'][$i]['link']; ?>" target="_blank"><?php echo $action['docs'][$i]['docname']; ?></a></dd>
                    <?php else:?> <dd class="col-xs-offset-1 col-xs-10"><a href="<?php echo $action['docs'][$i]['link']; ?>" target="_blank"><?php echo $action['docs'][$i]['docname']; ?></a></dd>
                    <?php endif; ?>
                <?php endfor; ?>
             </dl>
         </div>
        </li>
    <?php endforeach; ?>
</ul> 

<button type="button" class="btn btn-link" data-toggle="modal" data-target="#newactionrequest" data-whatever='<?php echo Unit::getStringJSONbyModal($list); ?>'><i class="fa fa-cogs" aria-hidden="true"></i></button>
<?php endif; ?>
<?php include ROOT . TMPL . 'footer.php'; ?>