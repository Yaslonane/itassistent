<?php include ROOT . TMPL . 'header.php'; ?>

<?php if(isset($_POST['submit'])): ?>
    <!-- Скрипт, вызывающий модальное окно после загрузки страницы -->
    <script>
      $(document).ready(function() {
        $("#myModalBox").modal('show');
      });
    </script>
        
<?php endif; ?>
    
    <!-- HTML-код модального окна -->
<div id="myModalBox" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Заголовок модального окна -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Заказ сформирован</h4>
      </div>
      <!-- Основное содержимое модального окна -->
      <form action="" method="post">
      <div class="modal-body">
        Нажмите на ссылку для завершения процедуры заказа <?php echo $a;?>
      </div>
      <!-- Футер модального окна -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            <input type="hidden" name="data" value='<?php echo $data_ord;?>'>
            <button type="submit" class="btn btn-primary" name="save_order">В базу запросов</button>
      </div>
      </form>
    </div>
  </div>
</div>

    <table class="table table-bordered">
			<caption><h2>Количество картриджей</h2> </caption>
			<thead>
				<tr>
                                    <?php for($i = 0; $i < count($summ_cart); $i++):?>
                                        <th><?php echo $summ_cart[$i]['name']; ?></th>
                                    <?php endfor;?>
				</tr>
			</thead>
			<tbody>
				<tr align="center">
                                    <?php for($i = 0; $i < count($summ_cart); $i++):?>
                                    <th <?php echo Cartriges::colorRow($summ_cart[$i]['value']); ?>><?php echo $summ_cart[$i]['value']; ?></th>
                                    <?php endfor;?>
				</tr>
			</tbody>
		</table>
<br />
<p class="text-center"><h2>Заказ картриджей</h2></p>

    <form action="" method="post"> 
            <table class="table">
            <thead>
                <tr>
                    <th scope="col">Наименование</th>
                    <th scope="col">Количество</th>
                    <th scope="col">&nbsp;</th>
                </tr>
            </thead>
            <tbody id="dynamic">
                     <!-- ЭТА СТРОКА БУДЕТ ШАБЛОНОМ ДЛЯ ВНОВЬ СОЗДАВАЕМЫХ //-->
                <tr>
                    <td class="col-xs-3">
                        <select class="form-control input-lg" name="cartrige">
                            <option selected value="">Выбирете картридж</option>
                            <?php foreach($cartriges as $cart): ?>
                                <option value="<?php echo $cart['id']; ?>"><?php echo $cart['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td class="col-xs-3">
                        <input class="form-control input-lg" type='number' name='quantity' value='' min='0' max='10' step='1' placeholder="Укажите кол-во"/>
                    </td>
                    <td class="col-xs-2">
                        <button type="button" class="btn btn-primary add">+</button>
                        <button type="button" class="btn btn-primary del">-</button>
                    </td>
                </tr>
                    </tbody>
            </table>
    <!-- конец СТРОКи БУДЕТ ШАБЛОНОМ ДЛЯ ВНОВЬ СОЗДАВАЕМЫХ //-->
                <button type="submit" name="submit" class="btn btn-primary">Заказать</button>
        </form>    
    </p>

<?php include ROOT . TMPL . 'footer.php'; ?>