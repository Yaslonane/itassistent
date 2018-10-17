<?php include ROOT . TMPL . 'header.php'; ?>

    <div class="row">

            <?php if($message != false): ?>
                <?php if($message == "Good"): ?>
                    <!-- Сообщение об успешном выполнения действия -->
                    <div class="alert alert-success">
                    <!-- Кнопка для закрытия сообщения, созданная с помощью элемента button -->
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        Изменения сохранены.
                    </div>
            
                <?php else: ?>
                    <!-- Сообщение об ошибке -->
                    <div class="alert alert-danger">
                    <!-- Кнопка для закрытия сообщения, созданная с помощью элемента a -->
                    <a href="#" class="close" data-dismiss="alert">×</a>
                    Неизвестная ошибка при передаче данных.
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <form action="" method="post">
                <div class="row">
                <div class="col-md-4">
                    <input type="hidden" name="id" value="<?php echo $info['id']; ?>">
                    <input type="text" class="form-control" name="id" placeholder="id" value="<?php echo $info['id']; ?>" disabled=""><br>
                    <input type="text" class="form-control" name="name" placeholder="Name" value="<?php echo $info['name']; ?>"><br>
                    <input type="text" class="form-control" name="number" placeholder="#Unit" value="<?php echo $info['number']; ?>"><br>
                    <input type="text" class="form-control" name="mac" placeholder="Model" value="<?php echo $info['mac']; ?>"><br>
                    
                </div>
                <div class="col-md-4">
                    <select class="form-control" name="parent_id" >
                            <option selected value="0">Руководитель</option>
                            <?php foreach($parents as $parent): ?>
                                <option value="<?php echo $parent['id']; ?>" <?php if($info['parent_id'] == $parent['id']) echo "selected"; ?>><?php echo $parent['name']; ?></option>
                            <?php endforeach; ?>
                    </select><br>
                    <select class="form-control" name="subord" >
                            <option selected>Ранг</option>
                            <?php foreach($subardination as $subard): ?>
                                <option value="<?php echo $subard['id']; ?>" <?php if($info['subordination'] == $subard['id']) echo "selected"; ?>><?php echo $subard['subordination']; ?></option>
                            <?php endforeach; ?>
                    </select><br>
                    <select class="form-control" name="department" >
                            <option selected>Отдел</option>
                            <?php foreach($departments as $dep): ?>
                                <option value="<?php echo $dep['id']; ?>" <?php if($info['department'] == $dep['id']) echo "selected"; ?>><?php echo $dep['department']; ?></option>
                            <?php endforeach; ?>
                    </select><br>
                    <input type="text" class="form-control" name="login" placeholder="login" value="<?php echo $info['login']; ?>"><br>
                </div>
                <div class="col-md-4">
                    <textarea type="text" rows="5" class="form-control" name="post" placeholder="Должность"><?php echo $info['post']; ?></textarea><br>
                    <div class="checkbox"><label><input type="checkbox"name="activ" <?php if($info['activ'] == 1) echo "checked"; ?>> Активный </label></div><br>
                </div>
                </div>
                    <br>
                    <button type="submit" name="save" class="btn btn-primary">Сохранить</button>
            </form>
    </div>

                       
                        <hr>
                        <br>
<?php include ROOT . TMPL . 'footer.php'; ?>