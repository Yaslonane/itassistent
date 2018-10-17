<?php include ROOT . TMPL . 'header.php'; ?>
<?php if($act_error == 1): ?>
    <script>
        $(document).ready(function() {
            $("#error_action").modal('show');
        });
    </script>
<?php endif; ?>
   
    <!-- HTML-код модального окна -->
<div id="error_action" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Заголовок модального окна -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Не выбрано действие</h4>
      </div>
      <!-- Основное содержимое модального окна -->
      <div class="modal-body">
          <h3>Вы производили замену картриджей или была доставка?</h3>
          <div class="btn-group btn-group-justified">
            <a href="?act=out" class="btn btn-primary btn-lg" target="_blank">Замена</a>
            <a href="?act=in" class="btn btn-primary btn-lg" target="_blank">Доставка</a>
          </div>
      </div>
      <!-- Футер модального окна -->
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>-->
      </div>
    </div>
  </div>
</div>




    <p class="text-center">
        <?php if($action == "in"):?>
            <h2>Доставка картриджей</h2>
        <?php elseif($action == "out"): ?>
            <h2>Замена картриджей</h2>
        <?php endif; ?>
    <form action="/cartriges" method="post"> 
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
                        <input class="form-control input-lg" type='number' name='quatity' value='' min='0' max='10' step='1' placeholder="Укажите кол-во"/>
                    </td>
                    <td class="col-xs-2">
                        <button type="button" class="btn btn-primary add">+</button>
                        <button type="button" class="btn btn-primary del">-</button>
                    </td>
                </tr>
                    </tbody>
            </table>
    <!-- конец СТРОКи БУДЕТ ШАБЛОНОМ ДЛЯ ВНОВЬ СОЗДАВАЕМЫХ //-->
                <input type="hidden" name='action' value="<?php echo $action; ?>" />.
                <button type="submit" name="submit" class="btn btn-primary">Внести</button>
        </form>    
    </p>

<?php include ROOT . TMPL . 'footer.php'; ?>
