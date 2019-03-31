<?php
    $errors = $template_data['errors'];
?>

        <section class="content__side">
          <p class="content__side-info">Если у вас уже есть аккаунт, авторизуйтесь на сайте</p>

          <a class="button button--transparent content__side-button" href="login.php">Войти</a>
        </section>

        <main class="content__main">
          <h2 class="content__main-heading">Регистрация аккаунта</h2>

          <form class="form" action="registration.php" method="post" enctype="multipart/form-data">
            <div class="form__row">
               
              <?php 
                $classname = (isset($errors['email']) ? "form__input--error" : "");
                $error = (isset($errors) ? $errors['email'] : "");
                $value = (isset($_POST['email']) ? $_POST['email'] : "");
               ?>
                
              <label class="form__label" for="email">E-mail <sup>*</sup></label>

              <input class="form__input <?= $classname; ?>" type="text" name="email" id="email" value="<?= $value; ?>" placeholder="Введите e-mail">

              <p class="form__message"><?= $error; ?></p>
            </div>

            <div class="form__row">
            
              <?php 
                $classname = (isset($errors['password']) ? "form__input--error" : "");
                $error = (isset($errors) ? $errors['password'] : "");
               ?>  
            
              <label class="form__label" for="password">Пароль <sup>*</sup></label>

              <input class="form__input <?= $classname; ?>" type="password" name="password" id="password" value="" placeholder="Введите пароль">
              
              <p class="form__message"><?= $error; ?></p>
            </div>

            <div class="form__row">
            
            <?php 
                $classname = (isset($errors['name']) ? "form__input--error" : "");
                $error = (isset($errors) ? $errors['name'] : "");
                $value = (isset($_POST['name']) ? $_POST['name'] : "");
               ?>  
            
              <label class="form__label" for="name">Имя <sup>*</sup></label>

              <input class="form__input <?= $classname; ?>" type="text" name="name" id="name" value="<?= $value; ?>" placeholder="Введите имя">
              
              <p class="form__message"><?= $error; ?></p>
            </div>
            
            <div class="form__row">
            <label class="form__label" for="preview">Аватар</label>

            <div class="form__input-file">
              <input class="visually-hidden" type="file" name="filename" id="preview" value="">

              <label class="button button--transparent" for="preview">
                <span>Выберите файл</span>
              </label>
            </div>
            </div>
            
            <?php 
                if (isset($errors)) { ?>
            <div class="form__row form__row--controls">
              <p class="error-message">Пожалуйста, исправьте ошибки в форме.</p>
                <?php } ?>
                
              <input class="button" type="submit" action="registration.php"value="Зарегистрироваться">
            </div>
          </form>
        </main>

