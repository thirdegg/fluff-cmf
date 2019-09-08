<?php

set_include_path(implode(PATH_SEPARATOR, array(get_include_path(), __DIR__.'/utils', __DIR__.'/models')));
require_once("config.php");

require_once("utils/Random.php");
require_once("utils/DataBase.php");
require_once("utils/Url.php");
require_once("utils/Mail.php");

require_once("models/Template.php");
require_once("models/Page.php");
require_once("models/User.php");
require_once("models/Group.php");
require_once("models/File.php");
require_once("models/FluffObject.php");
require_once("models/ObjectList.php");
require_once("models/Option.php");

require_once("models/templatefields/TemplateField.php");
require_once("models/templatefields/BooleanField.php");
require_once("models/templatefields/IntegerField.php");
require_once("models/templatefields/RealField.php");
require_once("models/templatefields/StringField.php");
require_once("models/templatefields/TextareaField.php");
require_once("models/templatefields/SetField.php");
require_once("models/templatefields/EnumField.php");
require_once("models/templatefields/FileField.php");
require_once("models/templatefields/ObjectField.php");


?>