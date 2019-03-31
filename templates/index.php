<main class="content__main">
        <h2 class="content__main-heading">Список задач</h2>
        
        <?php 
                $errors = $template_data['errors'];
                $tasks = $template_data['tasks'];
                $get = $_GET['tasks'];
                
                $d = strtotime("-1 day");
               
        ?>
        
        <form class="search-form" action="index.php" method="get">
            <input class="search-form__input" type="search" name="search" value="<?=$_GET['search'];?>" placeholder="Поиск по задачам">

            <input class="search-form__submit" type="submit" name="find" value="Искать">
        </form>
        

               
        <?php
            if ($get == 'td') { $classname1 = 'tasks-switch__item--active'; }
            if ($get == 'all' || $get == '') { $classname = 'tasks-switch__item--active'; }     // тупой метод, надо js
            if ($get == 'tm') { $classname2 = 'tasks-switch__item--active'; }
            if ($get == 'fin') { $classname3 = 'tasks-switch__item--active'; }
        ?>
        
        <div class="tasks-controls">
            <nav class="tasks-switch">
                <a href="index.php?tasks=all" class="tasks-switch__item <?=$classname;?>">Все задачи</a>
                <a href="index.php?tasks=td" class="tasks-switch__item <?=$classname1;?>">Повестка дня</a>
                <a href="index.php?tasks=tm" class="tasks-switch__item <?=$classname2;?>">Завтра</a>
                <a href="index.php?tasks=fin" class="tasks-switch__item <?=$classname3;?>">Просроченные</a>
            </nav>
            
                <label class="checkbox">
                    <input class="checkbox__input visually-hidden show_completed" type="checkbox" name="check"<?=$show_complete_tasks ? 'checked':''; ?>>
                    <span class="checkbox__text">Показывать выполненные</span>
                </label>
        </div>
        
        
        
        <table class="tasks">
            <?php if (empty($tasks)) { ?>
                <p>Нет задач</p>
            <?php } ?>
            <?php
                foreach ($tasks as $val) : 
                (($val['data_stop'] == date('Y-m-d', $d)) and ($val['status'] == 0)) ? $classname = "task--important" : $classname = "";
                ($val['status'] == 1) ? $classname_st = "task--completed" : $classname_st = ""; ?>
            <tr class="tasks__item task <?=$classname, $classname_st;?>"> <!-- task--completed -->
              <td class="task__select">
                <label class="checkbox task__checkbox">
                  <input class="checkbox__input visually-hidden" type="checkbox" checked>
                  <a href="index.php?id=<?=$val['id'];?>"><span class="checkbox__text"><?= $val['name']; ?></span></a>
                </label>
              </td>
              
              <?php
                if (!empty($val['url'])) { ?>
                  <td class="task__file">
                    <a class="download-link" href="<?=$val['url'];?>"><?= substr($val['url'],6); ?></a>
                  </td>
                <?php } else { ?>
                <td class="task__file">
              </td>
              <?php } ?> 

              <td class="task__date"><?= normalizeDate($val['data_stop']); ?></td>

            </tr>
            
            <?php endforeach; ?>
    
               <!--
            <tr class="tasks__item task task--important">
              <td class="task__select">
                <label class="checkbox task__checkbox">
                  <input class="checkbox__input visually-hidden" type="checkbox">
                  <a href="#"><span class="checkbox__text">Выполнить домашнее задание</span></a>
                </label>
              </td>

              <td class="task__file">
              </td>

              <td class="task__date">21.03.2017</td>
            </tr>
            -->
        </table>
</main>
    
