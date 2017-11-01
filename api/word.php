<?php
	require "../init-api.php";
	// Include custom class
	require $path["class"] . "word-manager.class.php";
    $WordManager = new WordManager($Db);
	
	switch($action) {
		case "getFromCategory":
            if(!isset($data->categoryId)) {
                $result["code"] = 1;
                break;
            }
            $result["code"] = 3;
			$result["data"] = $WordManager->getFromCategory($data->categoryId);
			break;
		case "add":
            if(!isset($data->baseWord, $data->translationWord, $data->categoryId)) {
                $result["code"] = 1;
                break;
            }
            $result["code"] = 3;
			$result["data"] = $WordManager->add($data->baseWord, $data->translationWord, $data->categoryId);
			break;
		case "remove":
            if(!isset($data->id)) {
                $result["code"] = 1;
                break;
            }
            $result["code"] = 3;
			$result["data"] = $WordManager->remove($data->id);
			break;
		case "set":
            if(!isset($data->id, $data->baseWord, $data->translationWord)) {
                $result["code"] = 1;
                break;
            }
            $result["code"] = 3;
			$result["data"] = $WordManager->set($data->id, $data->baseWord, $data->translationWord);
			break;
	}
	
	require $path["root"] . "terminate-api.php";
?>