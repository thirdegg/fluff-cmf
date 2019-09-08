<?php function IndexView() {?>
<h1>Привет <?=User::getCurrent()->getUsername(); ?></h1>
<?php }?>