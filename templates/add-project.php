<main class="content__main">
  <h2 class="content__main-heading">Добавление проекта</h2>

  <?php
  $errors = $template_data['errors'];
  $classname = (isset($errors['name']) ? "form__input--error" : "");
  $error = (isset($errors) ? $errors['name'] : "");
  ?>

  <form class="form" action="add-project.php" method="post">
    <div class="form__row">
      <label class="form__label" for="project_name">Название <sup>*</sup></label>

      <input class="form__input <?= $classname; ?>" type="text" name="name" id="project_name" value="" placeholder="Введите название проекта">

      <p class="form__message"><?= $error; ?></p>
    </div>

    <div class="form__row form__row--controls">
      <input class="button" type="submit" name="" value="Добавить">
    </div>
  </form>
</main>