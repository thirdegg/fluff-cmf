```php
include "core/includes.php";

$group = new Group();
$group->setName("admins");    
$group->setPrivileges(127);
$group->save();

$user = new User();
$user->setLogin("admin");
$user->setUsername("admin");
$user->setEmail("admin@admin.ru");
$user->setGroup($group->getId()); 
$user->save("admin");
```
