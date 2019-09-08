<?php function LogoutView() {

    User::getCurrent()->logout();
    header('Refresh: 0; url=/');
    
} ?>
