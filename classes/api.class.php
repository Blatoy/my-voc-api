<?php
	// Helpful methods to handle data
    
	class Api {
		private $Db;
		function __construct($Db) {
			$this->Db = $Db;
		}
        
        // Encode every string from any array
        private function encodeUtf8Array($array) {
            // Walk trough every entries
			foreach($array as $element) {
				// Check if it's an array and call recursively
				if(is_array($element)) {
					$this->encodeUtf8Array($element);
				}
				else {
					// Otherwise, encode to utf8
					$element = utf8_encode($element);
				}
			}
        }
        
        // Get data from $_POST
		public function getData($post) {
			if(isset($post['data'])) {
				if(is_array($post['data']))
					return $post['data'];
				else
					return json_decode($post['data']);
			}
            return array();
        }
        
        // Get action from $_POST
		public function getAction($post) {
            return isset($post['action']) ? ($post['action']) : "";
        }
        
        // Display the results
		public function displayJSON($array) {
            $this->encodeUtf8Array($array);
            echo json_encode($array);
        }
		
		// Not in use => throw error if argument is empty
		/*public function issetArguments() {
			$args = func_get_args();
			foreach($args as $argument) {
				if(!isset($argument)) {
					$result["code"] = 1;
					return false;
				}
			}
			
			return true;
		}*/
	}
?>