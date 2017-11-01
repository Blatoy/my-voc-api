<?php
	// 
	class WordManager {
		private $Db;
		function __construct($Db) {
			$this->Db = $Db;
		}
		
		// Words
		public function getFromCategory($categoryId) {
			$fields = $this->Db->tables["word"]["fields"];
            return $this->Db->getResults(
				"SELECT " . $fields["wordBase"] . " as 'wordBase' " .
					", " . $fields["wordTranslation"] . " as 'wordTranslation' " . 
					", " . $fields["wordId"] . " as 'wordId' " . 
				"FROM " . $this->Db->tables["word"]["name"] . " " .
				"WHERE " . $fields["categoryId"] . " = ? " . 
                "ORDER BY " . $fields["wordId"]
				, array($categoryId)
			);
		}
		
		// Add a word
		public function add($baseWord, $translation, $categoryId) {
			$fields = $this->Db->tables["word"]["fields"];
			$result = $this->Db->execute(
				"INSERT INTO " . $this->Db->tables["word"]["name"] . " " .
					"(" . $fields["wordBase"] . ", " . $fields["wordTranslation"] . ", " . $fields["categoryId"] . ") " . 
				"VALUES (?, ?, ?)"
				, array($baseWord, $translation, $categoryId));

			return array("success" => $result);
		}
		
		// Remove a word
		public function remove($id) {
			$result = $this->Db->execute(
				"DELETE FROM " . $this->Db->tables["word"]["name"] . " " .
				"WHERE " . $this->Db->tables["word"]["fields"]["wordId"] . " = ?"
				, array($id));

			// Return the number of row delete (max is 1)
			return array("success" => $this->Db->getLastRowCount());
		}
		
		// Change a word
		public function set($id, $baseWord, $translationWord) {
			$fields = $this->Db->tables["word"]["fields"];
			$result = $this->Db->execute(
				"UPDATE " . $this->Db->tables["word"]["name"] . " " .
				"SET " . $fields["wordBase"] . " = ? " . 
					", " . $fields["wordTranslation"] . " = ? " . 
				"WHERE " . $fields["wordId"] . " = ?"
				, array($baseWord, $translationWord, $id));

			return array("success" => $result);
		}
	}
?>