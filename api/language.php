<?php
	require "../init-api.php";
	// Include custom class
	require $path["class"] . "language-manager.class.php";
    $LanguageManager = new LanguageManager($Db);

	switch($action) {
		case "getAll":
            $result["code"] = 3;
            $result["data"] = $LanguageManager->getAll();
            break;
        case "getAvailable":
            if(!isset($data->languageId)) {
                $result["code"] = 1;
                break;
            }
            $result["code"] = 3;
            $result["data"] = $LanguageManager->getAvailable($data->languageId);
            break;
        case "add":
            if(!isset($data->name)) {
                $result["code"] = 1;
                break;
            }
			$result["code"] = 3;
            $result["data"] = $LanguageManager->add($data->name);
            break;
        case "remove":
            if(!isset($data->id)) {
                $result["code"] = 1;
                break;
            }
			$result["code"] = 3;
            $result["data"] = $LanguageManager->remove($data->id);
            break;
        case "set":
            if(!isset($data->id, $data->newName)) {
                $result["code"] = 1;
                break;
            }
            $result["data"] = $LanguageManager->set($data->id, $data->newName);
            break;

	}
	require $path["root"] . "terminate-api.php";
?>