<?php include ROOT . TMPL . 'header.php'; ?>
<!-- HTML-код модального окна -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="exampleModalLabel">Редактирование записи</h4>
        </div>
        <div class="modal-body">
            <form action="update" method="post">
                <div class="form-group">
                    <input type="hidden" class="form-control" name="id" id="id">
                    
                    <label for="name" class="form-control-label">Имя:</label>
                    <input type="text" class="form-control" id="name" name="name">
                    
                    <label for="post" class="form-control-label">Должность:</label>
                    <input type="text" class="form-control" id="post" name="post">
                    
                    <label for="number" class="form-control-label">Телефон:</label>
                    <input type="text" class="form-control" id="number" name="number">
                    
                    <label for="mac" class="form-control-label">Mac-адрес:</label>
                    <input type="text" class="form-control" id="mac" name="mac">
                    
                    <label for="department" class="form-control-label">Отдел:</label>
                    <select class="form-control" name="department" id="department" name="department">
                            <option selected>Отдел</option>
                            <?php foreach($departments as $dep): ?>
                                <option value="<?php echo $dep['id']; ?>"><?php echo $dep['department']; ?></option>
                            <?php endforeach; ?>
                    </select>
                    
                    <label for="parent_id" class="form-control-label">Руководитель:</label>
                    <select class="form-control" name="parent_id" id="parent_id" name="parent_id">
                            <option selected value="0">Руководитель</option>
                            <?php foreach($parents as $parent): ?>
                                <option value="<?php echo $parent['id']; ?>"><?php echo $parent['name']; ?></option>
                            <?php endforeach; ?>
                    </select>
                    
                    <label for="subord" class="form-control-label">Ранг:</label>
                    <select class="form-control" name="subord" id="subord" name="subord">
                            <option selected>Ранг</option>
                            <?php foreach($subardination as $subard): ?>
                                <option value="<?php echo $subard['id']; ?>"><?php echo $subard['subordination']; ?></option>
                            <?php endforeach; ?>
                    </select>
                    
                    <label for="login" class="form-control-label">Логин:</label>
                    <input type="text" class="form-control" id="login" name="login">
                    
                    <div class="checkbox"><label><input type="checkbox" name="activ" id="activ"> Активный </label></div><br>

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

<?php if($error == false): ?>
    <form action="" method="post">
        <div class="row">
            <div class="col-xs-offset-2 col-xs-7">
                <input type="text" class="form-control" name="searching" placeholder="Напишите фамилию или номер телефона, можно часть..." <?php if(isset($_POST['searching'])) echo "value='".$_POST['searching']."'"; ?>>
            </div>
            <div class="col-xs-3">
                <button type="submit" name="submit" class="btn btn-primary">Выбрать</button>
            </div>
        </div>
    </form>
            <br />

    <div class = "search_result table-responsive">	
    <table class="table table-hover text-center" style="vertical-align: middle;">
        <tbody> 
            <?php for($i=0; count($list) > $i; $i++): ?>
            <tr>
                <!--<td><a href="<?php //DOMEN; ?>/phonebook/admedit/<?php //echo $list[$i]['id']; ?>" ><i class="fa fa-edit"></i></a></td>-->
                <td><button type="button" class="btn btn-link" data-toggle="modal" data-target="#exampleModal" data-whatever='<?php echo json_encode(Phonebook::getElementByID($list[$i]['id'])); ?>'><i class="fa fa-cogs" aria-hidden="true"></i></button></td>
                <td style="min-width: 200px; vertical-align: middle;"><?php echo $list[$i]['name']; ?></td>
                <td style="vertical-align: middle;"><?php echo $list[$i]['number']; ?></td>
                <td style="vertical-align: middle;"><?php echo $list[$i]['mac']; ?></td>
                <td><?php echo $list[$i]['post']; ?></td>
                <td><a href="<?php DOMEN; ?>/phonebook/admactiv/<?php echo $list[$i]['id']; ?>" > <i <?php echo ($list[$i]['activ'] == 0) ? 'class="fa fa-times"  style="font-size:20px; color:#cc0000 "' : "class='fa fa-check'"; ?>></i></a></td>
            </tr>
            <?php endfor; ?>
        </tbody>
    </table>
    </div>

        

<?php else: ?>
    <div class="panel panel-danger col-xs-offset-4 col-xs-4">
        <div class="panel-heading">
            <h3 class="panel-title">Error!!!</h3>
        </div>
        <div class="panel-body">
            Ошибка доступа
        </div>
    </div> 
<?php endif; ?>
<?php include ROOT . TMPL . 'footer.php'; ?>

