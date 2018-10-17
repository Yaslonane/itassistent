</main>

<hr>	<!--Футер-->
    <div class="row">
      <!--Футер-->
        <footer class="col-sm-12">
          <p >info by IT Kursk</p>
        </footer>
    </div>
</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo TMPL; ?>js/bootstrap.js"></script>
    <script type="text/javascript" src="/js/multiselect.js"></script>
    <script type="text/javascript">
        MultiSelect(document.getElementById("src_countries"),
                    document.getElementById("dst_countries"),
                    document.getElementById("take"),
                    document.getElementById("drop"));
    </script>
    <script src="<?php echo TMPL; ?>js/dynamicTable.js"></script>
    <script src="<?php echo TMPL; ?>js/bootstrap-switch.js"></script>
    <script>
        new DynamicTable( document.getElementById("dynamic") );
    </script>
    <script>
        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Кнопка, что спровоцировало модальное окно  

            var recipient = button.data('whatever')// Извлечение информации из данных-* атрибутов  

            // Если необходимо, вы могли бы начать здесь AJAX-запрос (и выполните обновление в обратного вызова).  

            // Обновление модальное окно Контента. Мы будем использовать jQuery здесь, но вместо него можно использовать привязки данных библиотеки или других методов.  

            var modal = $(this)
            modal.find('.modal-title').text('Редактирование записи № ' + recipient.id)
            modal.find('.modal-body #id').val(recipient.id)
            modal.find('.modal-body #name').val(recipient.name)
            modal.find('.modal-body #post').val(recipient.post)
            modal.find('.modal-body #department').val(recipient.department)
            modal.find('.modal-body #parent_id').val(recipient.parent_id)
            modal.find('.modal-body #mac').val(recipient.mac)
            modal.find('.modal-body #number').val(recipient.number)
            modal.find('.modal-body #subord').val(recipient.subordination)
            modal.find('.modal-body #login').val(recipient.login)
            if(recipient.activ == 1){$('#activ').prop('checked', true);}

          })
    </script>
    <script>
        $('#newactionrequest').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Кнопка, что спровоцировало модальное окно  

            var recipient = button.data('whatever')// Извлечение информации из данных-* атрибутов  

            // Если необходимо, вы могли бы начать здесь AJAX-запрос (и выполните обновление в обратного вызова).  

            // Обновление модальное окно Контента. Мы будем использовать jQuery здесь, но вместо него можно использовать привязки данных библиотеки или других методов.  

            var modal = $(this)
            modal.find('.modal-title').text('Новое событие для заявки № ' + recipient.id)
            modal.find('.modal-body #id').val(recipient.id)
            modal.find('.modal-body #user').val(recipient.user);

          })
    </script>

  </body>
</html>
