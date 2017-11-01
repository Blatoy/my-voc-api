<?php
	require "../init-api.php";
	// Include custom class
	require $path["class"] . "category-manager.class.php";
    $CategoryManager = new CategoryManager($Db);
	
	switch($action) {
		case "getAll":
            $result["code"] = 3;
			$result["data"] = $CategoryManager->getAll();
			break;
		case "getMatching":
            if(!isset($data->languageId)) {
                $result["code"] = 1;
                break;
            }
            $result["code"] = 3;
			$result["data"] = $CategoryManager->getMatching($data->languageId);
			break;
		case "add":
            if(!isset($data->name, $data->languageIdBase, $data->languageIdTranslation)) {
                $result["code"] = 1;
                break;
            }
            $result["code"] = 3;
			$result["data"] = $CategoryManager->add($data->name, $data->languageIdBase, $data->languageIdTranslation);
			break;
		case "remove":
            if(!isset($data->id)) {
                $result["code"] = 1;
                break;
            }
            $result["code"] = 3;
			$result["data"] = $CategoryManager->remove($data->id);
			break;
		case "set":
            if(!isset($data->id, $data->newName, $data->languageIdBase, $data->languageIdTranslation)) {
                $result["code"] = 1;
                break;
            }
            $result["code"] = 3;
			$result["data"] = $CategoryManager->set($data->id, $data->newName, $data->languageIdBase, $data->languageIdTranslation);
			break;
	}
	
	require $path["root"] . "terminate-api.php";
?>