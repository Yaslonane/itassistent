<?php include ROOT . TMPL . 'header.php'; ?>
<section>
    <div class="container">
        <div class="row">
            <?php if(user::checkAuth() == false): ?>
            <div class="col-sm-4 col-sm-offset-4 padding-right">
                <div class="signup-form"><!--sign up form-->
                    <h2>Вход на сайт</h2>
                    <form action="#" method="post">
                        <input type="text" name="login" placeholder="login" value=""/>
                        <input type="password" name="password" placeholder="Пароль" value=""/>
                        <input type="submit" name="submit" class="btn btn-default" value="Вход" />
                    </form>
                </div><!--/sign up form-->
                <br/>
                <br/>
            </div>
            <?php else: ?>
            <div class="col-sm-6 col-sm-offset-3 padding-right">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                      <h3 class="panel-title">Warning!!!</h3>
                    </div>
                    <div class="panel-body text-center">
                        <h3>Привет <?php echo $_SESSION['surname']; ?>. Вы уже авторизованы</h3>
                        <p>Хотите выйти?<a href="./logout">Да, хочу</a></p>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php include ROOT . TMPL . 'footer.php'; ?>