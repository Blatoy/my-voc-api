<?php
	// Useful functions to manage the database
	// See http://php.net/manual/en/class.pdo.php for more information about PDO

    class DatabaseManager
    {
        private $Pdo;
		private $lastRowCount;
        public $tables;

        // Connect to the database
        function __construct($dbConfig) {
            try {
                $this->Pdo = new PDO('mysql:host='.$dbConfig['host'].';dbname='.$dbConfig['database'], $dbConfig['username'], $dbConfig['password']);
                // Force UTF8 use
				$this->Pdo->exec('SET CHARACTER SET utf8');
                $this->tables = $dbConfig["tables"];
            } catch (PDOException $e) {
                die('[DB Error] Cannot connect to the database ('.$e->getCode().')');
            }
        }


        // Get one row (prepared or not)
        public function getResult($sql, $values = false) {
            try {
				if($values !== false) {
					if($reqPrep = $this->Pdo->prepare($sql)) {
						if($reqPrep->execute($values)) {
							return $reqPrep->fetch();
						}
					}
				}
				else {
					if($req = $this->Pdo->query($sql)) {
						return $req->fetch();
					}
				}
            } catch (PDOException $e) {
                die('[DB Error] ('.$e->getCode().')');
            }
        }
        
         // Get an array of row (prepared or not)
         public function getResults($sql, $values = false) {
            try {
				if($values !== false) {
					if($reqPrep = $this->Pdo->prepare($sql)) {
						if($reqPrep->execute($values)) {
							return $reqPrep->fetchAll(PDO::FETCH_ASSOC);
						}
					}
				}
				else {
					if($req = $this->Pdo->query($sql)) {
						return $req->fetchAll(PDO::FETCH_ASSOC);
					}
				}
            } catch(PDOException $e) {
                die('[DB Error] ('.$e->getCode().')');
            }
        }
		

        // Execute any query (prepared or not)
        public function execute($sql, $values = false) {
			if($values !== false) {
				if($req = $this->Pdo->prepare($sql)) {
					$res = $req->execute($values);
					$this->lastRowCount = $req->rowCount();
					return $res;
				}
				else {
					return false;
				}
			}
			else {
				$this->lastRowCount = $req->rowCount($values);
				return $this->Pdo->exec($sql);
			}
        }

        // Return the last inserted id
        public function getLastId() {
            return $this->Pdo->lastInsertId();
        }
		
		public function getLastRowCount() {
			return $this->lastRowCount;
		}
    }
?>