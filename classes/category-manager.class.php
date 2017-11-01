<?php
	// 
	class CategoryManager {
		private $Db;
		function __construct($Db) {
			$this->Db = $Db;
		}

		// Get every category
		public function getAll() {
			$fields = $this->Db->tables["category"]["fields"];
            return $this->Db->getResults(
				"SELECT " . $fields["categoryId"] . " as 'categoryId' " .
					", " . $fields["categoryName"] . " as 'categoryName' " . 
					", " . $fields["languageIdBase"] . " as 'languageIdBase' " . 
					", " . $fields["languageIdTranslation"] . " as 'languageIdTranslation' " . 
				"FROM " . $this->Db->tables["category"]["name"] . " " . 
                "ORDER BY " . $fields["categoryName"]
			);
		}
		
		// Return every category containing one of the specified language
		public function getMatching($languageId) {
			$categoriesAvailable = array();
			$fields = $this->Db->tables["category"]["fields"];
			
			// Get every available language
            $results = $this->Db->getResults(
				"SELECT " . $fields["categoryId"] . " as categoryId " . 
					", " . $fields["categoryName"] . " as categoryName " .
					", " . $fields["languageIdBase"] . " as languageIdBase " .
					", " . $fields["languageIdTranslation"] . " as languageIdTranslation " .
				"FROM " . $this->Db->tables["category"]["name"] . " " .
				"WHERE " . $fields["languageIdBase"] . " = ? " . 
				"OR " . $fields["languageIdTranslation"] . " = ? "
				, array($languageId, $languageId)
			);
			
			return array("availableLanguages" => $results);
		}
		
		// Add a category
		public function add($name, $languageIdBase, $languageIdTranslation) {
			$fields = $this->Db->tables["category"]["fields"];
			$result = $this->Db->execute(
				"INSERT INTO " . $this->Db->tables["category"]["name"] . " " .
					"(" . $fields["categoryName"] . ", " . $fields["languageIdBase"] . ", " . $fields["languageIdTranslation"] .
					") VALUES (?, ?, ?)"
				, array($name, $languageIdBase, $languageIdTranslation));

			return array("success" => $result, "categoryId" => $this->Db->getLastId());
		}
		
		// Remove a category
		public function remove($id) {
			$result = $this->Db->execute(
				"DELETE FROM " . $this->Db->tables["category"]["name"] . " " .
				"WHERE " . $this->Db->tables["category"]["fields"]["categoryId"] . " = ?"
				, array($id));

			// Return the number of row delete (max is 1)
			return array("success" => $this->Db->getLastRowCount());
		}
		
		// Rename a category
		public function set($id, $newName, $languageIdBase, $languageIdTranslation) {
			$fields = $this->Db->tables["category"]["fields"];
			$result = $this->Db->execute(
				"UPDATE " . $this->Db->tables["category"]["name"] . " " .
				"SET " . $fields["categoryName"] . " = ? " . 
				", " . $fields["languageIdBase"] . " = ? " . 
				", " . $fields["languageIdTranslation"] . " = ? " . 
				"WHERE " . $fields["categoryId"] . " = ?"
				, array($newName, $languageIdBase, $languageIdTranslation, $id));

			return array("success" => $this->Db->getLastRowCount());
		}
	}
?>