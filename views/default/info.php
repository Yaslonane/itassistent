<?php include ROOT . TMPL . 'header.php'; ?>
		<div class="row">
			<div class="col-md-offset-2 col-md-4">
                            <?php if($print['img'] != ""): ?>
                                <img class="img-responsive" src="<?php echo $print['img']; ?>" alt="...">
                            <?php else: ?>
                                <img class="img-responsive" src="/img/not_img_print.png" alt="...">
                            <?php endif; ?>
			</div>
			<div class="col-md-6">
                            <p><big>
                                <dl class="dl-horizontal">
                                    <dt>ID</dt>
                                        <dd><?php echo $print['id']; ?></dd>
                                    <dt>Имя</dt>
                                        <dd><?php echo $print['name']; ?></dd>
                                    <dt>Модель</dt>
                                        <dd><?php echo $print['model']; ?></dd>
                                    <dt># UNIT</dt>
                                        <dd><?php echo $print['unit']; ?></dd>
                                    <dt>S/N</dt>
                                        <dd><?php echo $print['sn']; ?></dd>
                                    <dt>Инвентарный</dt>
                                        <dd><?php echo $print['inventar']; ?></dd>
                                    <dt>Расположение</dt>
                                        <dd><?php echo $print['adress']; ?></dd>
                                        <dd><?php echo $print['floor']; ?></dd>
                                    <dt>Отдел</dt>
                                        <dd><?php echo $print['department']; ?></dd>
                                    <dt>Картридж</dt>
                                        <dd><?php echo $print['cartrige']; ?></dd>
                                    <dt>Статус</dt>
                                        <dd><?php echo $print['status']; ?></dd>
                                    <dt>Функционал</dt>
                                        <?php if($print['functions'] == 0): ?>
                                    <dd><b>Не заполнено</b></dd>
                                        <?php else: ?>
                                            <?php for($i=0; $i<count($print['functions']); $i++){
                                                    echo "<dd>".$print['functions'][$i]['name']."</dd>";
                                                }
                                            ?>
                                        <?php endif; ?>
                                </dl>
                            </p></big>
                            <?php if(user::checkAdmin() == true): ?>    
                                <a href="/printer/edit/<?php echo $print['id']; ?>" class="btn btn-default" role="button">Редактировать</a></p>
                            <?php endif; ?>
                        </div>
                </div>
                <br>
                <h2>История изменений</h2>
                <br>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>id action</th>
                                <th>дата изменения</th>
                                <th>id принтера</th>
                                <th>Кто изменял</th>
                                <th>Что изменял</th>
                                <th>Исходные данные</th>
                                <th>Конечные данные</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($history as $hist): ?>
                                <tr onclick="window.location.href='/edit/1'; return false">
                                            <td><?php echo $hist['id']; ?></td>
                                            <td><?php echo $hist['date']; ?></td>
                                            <td><?php echo $hist['id_print']; ?></td>
                                            <td><?php echo $hist['user']; ?></td>
                                            <td><?php echo $hist['object_change']; ?></td>
                                            <td><?php echo $hist['old_data']; ?></td>
                                            <td><?php echo $hist['new_data']; ?></td>
                                </tr> 
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <br>
                <h2>История заявок в UNIT</h2>
                <br>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>id заявки</th>
                                <th>дата заведения</th>
                                <th>id принтера</th>
                                <th>Кто заводил</th>
                                <th>Проблема</th>
                                <th>Текущий статус</th>
                                <th>Дата закрытия</th>
                                <th>Коментарий</th>
                                <th>Файлы</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr onclick="window.location.href='/request/1'; return false">
                                         <td>1</td>
                                         <td>11.09.2000</td>
                                         <td>2</td>
                                         <td>кто-то</td>
                                         <td>что-то сломалось и теперь всё не работает</td>
                                         <td>чё-то делаеют там</td>
                                         <td>не закрыто</td>
                                         <td>блин, как часто он ломается :(</td>
                                         <td>файлы есть</td>
                             </tr>
                            <tr onclick="window.location.href='/request/2'; return false">
                                         <td>2</td>
                                         <td>11.09.2000</td>
                                         <td>2</td>
                                         <td>кто-то</td>
                                         <td>что-то сломалось и теперь всё не работает</td>
                                         <td>чё-то делаеют там</td>
                                         <td>не закрыто</td>
                                         <td>блин, как часто он ломается :(</td>
                                         <td>файлы есть</td>
                             </tr>
                            <tr onclick="window.location.href='/request/3'; return false">
                                         <td>3</td>
                                         <td>11.09.2000</td>
                                         <td>2</td>
                                         <td>кто-то</td>
                                         <td>что-то сломалось и теперь всё не работает</td>
                                         <td>чё-то делаеют там</td>
                                         <td>не закрыто</td>
                                         <td>блин, как часто он ломается :(</td>
                                         <td>файлы есть</td>
                             </tr>
                            <tr onclick="window.location.href='/request/4'; return false">
                                         <td>4</td>
                                         <td>11.09.2000</td>
                                         <td>2</td>
                                         <td>кто-то</td>
                                         <td>что-то сломалось и теперь всё не работает</td>
                                         <td>чё-то делаеют там</td>
                                         <td>не закрыто</td>
                                         <td>блин, как часто он ломается :(</td>
                                         <td>файлы есть</td>
                             </tr>
                            <tr onclick="window.location.href='/request/5'; return false">
                                         <td>5</td>
                                         <td>11.09.2000</td>
                                         <td>2</td>
                                         <td>кто-то</td>
                                         <td>что-то сломалось и теперь всё не работает</td>
                                         <td>чё-то делаеют там</td>
                                         <td>не закрыто</td>
                                         <td>блин, как часто он ломается :(</td>
                                         <td>файлы есть</td>
                             </tr>
                            <tr onclick="window.location.href='/request/6'; return false">
                                         <td>6</td>
                                         <td>11.09.2000</td>
                                         <td>2</td>
                                         <td>кто-то</td>
                                         <td>что-то сломалось и теперь всё не работает</td>
                                         <td>чё-то делаеют там</td>
                                         <td>не закрыто</td>
                                         <td>блин, как часто он ломается :(</td>
                                         <td>файлы есть</td>
                             </tr>
                        </tbody>
                    </table>
<?php include ROOT . TMPL . 'footer.php'; ?>