<?php
	// 
	class LanguageManager {
		private $Db;
		function __construct($Db) {
			$this->Db = $Db;
		}

		// Languages
		public function getAll() {
			$fields = $this->Db->tables["language"]["fields"];
            return $this->Db->getResults(
				"SELECT " . $fields["languageId"] . " as 'languageId' " .
					", " . $fields["languageName"] . " as 'languageName' " . 
				"FROM " . $this->Db->tables["language"]["name"] . " " .
                "ORDER BY " . $fields["languageName"]
			);
        }
        
		// Return a list with language that may be asked
		public function getAvailable($languageId) {
			$langsAvailable = array();
			$fields = $this->Db->tables["category"]["fields"];
			
			// Get every available language
            $results = $this->Db->getResults(
				"SELECT " . $fields["languageIdBase"] . " as baseLanguageId " . 
					", " . $fields["languageIdTranslation"] . " as translationLanguageId " .
				"FROM " . $this->Db->tables["category"]["name"] . " " .
				"WHERE " . $fields["languageIdBase"] . " = ? " . 
				"OR " . $fields["languageIdTranslation"] . " = ? " .
				"GROUP BY " . $fields["languageIdBase"] . ", " . $fields["languageIdTranslation"]
				, array($languageId, $languageId)
			);
			
			// Group results
			foreach($results as $result) {
				//	echo $result["baseLanguageId"];
				if(!in_array($result["baseLanguageId"], $langsAvailable))
					$langsAvailable[] = $result["baseLanguageId"];

				if(!in_array($result["translationLanguageId"], $langsAvailable))
					$langsAvailable[] = $result["translationLanguageId"];
			}
			
			// Remove the base language
			unset($langsAvailable[array_search($languageId, $langsAvailable)]);
			$langsAvailable = array_values($langsAvailable);
			
			return array("availableLanguages" => $langsAvailable);
		}
		
		// Add a language
		public function add($name) {
			$result = $this->Db->execute(
				"INSERT INTO " . $this->Db->tables["language"]["name"] . " " .
					"(" . $this->Db->tables["language"]["fields"]["languageName"] . ") " . 
				"VALUES (?)"
				, array($name));

			return array("success" => $result);
		}

		// Remove a language
		public function remove($id) {
			$result = $this->Db->execute(
				"DELETE FROM " . $this->Db->tables["language"]["name"] . " " .
				"WHERE " . $this->Db->tables["language"]["fields"]["languageId"] . " = ?"
				, array($id));

			// Return the number of row delete (max is 1)
			return array("success" => $this->Db->getLastRowCount());
		}
		
		// Rename a language
		public function set($id, $newName) {
			$result = $this->Db->execute(
				"UPDATE " . $this->Db->tables["language"]["name"] . " " .
				"SET " . $this->Db->tables["language"]["fields"]["languageName"] . " = ? " . 
				"WHERE " . $this->Db->tables["language"]["fields"]["languageId"] . " = ?"
				, array($newName, $id));

			return array("success" => $this->Db->getLastRowCount());
		}
	}
?>