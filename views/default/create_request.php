<?php include ROOT . TMPL . 'header.php'; ?>

<?php if(isset($_POST['create'])): ?>
    <!-- Скрипт, вызывающий модальное окно после загрузки страницы -->
    <script>
      $(document).ready(function() {
        $("#myModalBox").modal('show');
      });
    </script>
        
<?php endif; ?>
    
<style type="text/css">
#kcfinder_div {
    display: none;
    position: absolute;
    width: 670px;
    height: 400px;
    background: #e0dfde;
    border: 2px solid #3687e2;
    border-radius: 6px;
    -moz-border-radius: 6px;
    -webkit-border-radius: 6px;
    padding: 1px;
    z-index: 9999;
}
</style>
 
<script type="text/javascript">
function openKCFinder(field) {
    var div = document.getElementById('kcfinder_div');
    if (div.style.display == "block") {
        div.style.display = 'none';
        div.innerHTML = '';
        return;
    }
    window.KCFinder = {
        callBack: function(url) {
            window.KCFinder = null;
            field.value = url;
            div.style.display = 'none';
            div.innerHTML = '';
        }
    };
    div.innerHTML = '<iframe name="kcfinder_iframe" src="<?php echo LIB ?>/kcfinder/browse.php?type=files&dir=files/public" ' +
        'frameborder="0" width="100%" height="100%" marginwidth="0" marginheight="0" scrolling="no" />';
    div.style.display = 'block';
}
</script>
    
    <?php if($message == "ok"): ?>
        <!-- Сообщение об успешном выполнения действия -->
        <div class="alert alert-success">
        <!-- Кнопка для закрытия сообщения, созданная с помощью элемента button -->
            <button type="button" class="close" data-dismiss="alert">×</button>
            Запрос зарегистрирован.
        </div>
    <?php endif; ?>        

    <!-- HTML-код модального окна -->
<div id="myModalBox" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Заголовок модального окна -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Запрос сформирован</h4>
      </div>
      <form action="" method="post">
        <!-- Основное содержимое модального окна -->
        <div class="modal-body">
          Нажмите на ссылку для завершения процедуры оформления запроса <?php echo $lnk;?>
        </div>
        <!-- Футер модального окна -->
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
              <input type="hidden" name="print_id" value="<?php echo $print_id;?>">
              <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
              <input type="hidden" name="description" value="<?php echo $description;?>">
              <button type="submit" class="btn btn-primary" name="save_request">В базу запросов</button>    
        </div>
      </form>
    </div>
  </div>
</div>


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
    <div class="row">
        <form action="" method="post" class="form-horizontal">

                <div class="form-group">
                    <label class="control-label col-xs-2" for="username">Заказчик:</label>
                    <div class="col-xs-9">
                        <input type="text" class="form-control" name="username" value="<?php echo $_SESSION['user_id']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-2" for="print_id">Аппарат:</label>
                    <div class="col-xs-5">
                        <select class="form-control" name="print_id" id="select_prn" >
                                <option selected value="0">Выберите принтер</option>
                                <?php foreach($printers as $print): ?>
                                    <option value="<?php echo $print['id']; ?>"><?php echo $print['name']; ?> <?php echo $print['model']; ?> <?php echo $print['unit']; ?></option>
                                <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-xs-4">
                        <input type="text" class="form-control" id="value_prn">
                    </div>
                    
                    <script type='text/javascript'>
                        var elems = document.getElementById("select_prn").options;
                        var similar = function (A, B) {
                                for (var i = 0; i < B.length; i++)
                                        if (A.charAt(i) != B.charAt(i)) break;
                                return i;
                        };
                        document.getElementById("value_prn").onkeypress = function (event) {
                                var max = 0;
                                for (var i = 0; i < elems.length; i++) {
                                        var A = elems[i].innerHTML.replace(/^\s+|\s+$/g, "").toLowerCase(),
                                        B = (this.value + String.fromCharCode(event.keyCode)).toLowerCase();
                                        if (similar(A, B) > max)
                                                elems[i].selected = "selected", max = similar(A, B);
                                }
                        };
                    </script>
                    
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-2" for="text">Описание:</label>
                    <div class="col-xs-9">
                        <textarea rows="4" class="form-control" name="text"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-offset-2 col-xs-2">
                        <button type="submit" name="create" class="btn btn-primary">Создать запрос</button>
                    </div>
                </div>
            <input class="form-control" name="img" type="text" readonly="readonly" placeholder="Нажмите для выбора\загрузки файла" value="" onclick="openKCFinder(this)" style="cursor:pointer" />
              <div id="kcfinder_div"></div>

        </form>
    </div>
<?php endif; ?>
<?php include ROOT . TMPL . 'footer.php'; ?>