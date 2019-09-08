<?php

if (!isset($_GET["method"])) return;

if ($_GET["method"]=="getObjectById" && isset($_GET["template"]) && isset($_GET["object"])) {
    $template = Template::getById(intval($_GET["template"]));
    $object = FluffObject::getById($template->getId(),intval($_GET["object"]));
    if ($object!=null) {
        $data = $object->toArray();
        echo json_encode(array("result"=>"ok","data"=>$data));
    } else {
        echo json_encode(array("result"=>"not found"));
    }
}

?>
