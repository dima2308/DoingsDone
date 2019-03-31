<main class="content__main">
        <h2 class="content__main-heading">Добавление задачи</h2>
        
        <?php 
                $errors = $template_data['errors'];
        ?>
        
        
        <form class="form" action="add-task.php" method="post" enctype="multipart/form-data">
          <div class="form__row">
          
          <?php
                $classname = (isset($errors['name']) ? "form__input--error" : "");
                $error = (isset($errors) ? $errors['name'] : "");
          ?>
          
            <label class="form__label" for="name">Название <sup>*</sup></label>

            <input class="form__input <?=$classname?>" type="text" name="name" id="name" value="" placeholder="Введите название">
            
            <p class="form__message"><?=$error;?></p>
          </div>

          <div class="form__row">
          
           <?php
                $classname = (isset($errors['project']) ? "form__input--error" : "");
                $error = (isset($errors) ? $errors['project'] : "");
          ?>
          
            <label class="form__label" for="project">Проект <sup>*</sup></label>
            
            <?php
                $projects = $template_data['projects'];
                if (empty($projects)) { ?> <p><a href="add-project.php">Добавьте проект</a></p> <?php } else {?>
           
            
            <select class="form__input form__input--select" name="project" id="project">
                <?php foreach ($projects as $val) : ?>
                    <option value="<?=$val['name'];?>"><?=$val['name'];?></option>
               <?php endforeach; ?>
            </select>
                <?php } ?>
                 
            <p class="form__message"><?=$error;?></p>
          </div>

          <div class="form__row">
          
          <?php
                $classname = (isset($errors['date']) ? "form__input--error" : "");
                $error = (isset($errors) ? $errors['date'] : "");
          ?>
          
            <label class="form__label" for="date">Дата выполнения <sup>*</sup></label>

            <input class="form__input form__input--date <?=$classname;?>" type="date" name="date" id="date" value="" placeholder="Введите дату в формате ДД.ММ.ГГГГ">
            
            <p class="form__message"><?=$error;?></p>
          </div>

          <div class="form__row">
          
          <?php
                $error = (isset($errors) ? $errors['file'] : "");
          ?>
          
            <label class="form__label" for="preview">Файл</label>

            <div class="form__input-file">
              <input class="visually-hidden" type="file" name="filename" id="preview" value="">

              <label class="button button--transparent" for="preview">
                <span>Выберите файл</span>
              </label>
            </div>
            <p class="form__message"><?=$error;?></p>
          </div>

          <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
          </div>
        </form>
      </main>
