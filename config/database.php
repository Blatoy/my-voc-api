<?php
	// Database config
	return array(
		'host' 		=> "",			// Host address
		'database' 	=> "",			// Database name
		'username' 	=> "",			// Database username
		'password'  => "",			// Username password
        
        'tables' => array(              // Tables config    
            'word' => array(
                'name' => 'myVocWord',
                'fields' => array(
                    'wordId' => 'WordID',
                    'wordBase' => 'WordBase',
                    'wordTranslation' => 'WordTranslation',
                    'categoryId' => 'CategoryID'
                )
            ),
            'language' => array(
                'name' => 'myVocLanguage',
                'fields' => array(
                    'languageId' => 'LanguageID',
                    'languageName' => 'LanguageName'
                )
            ),
            'category' => array(
                'name' => 'myVocCategory',
                'fields' => array(
                    'categoryId' => 'CategoryID',
                    'categoryName' => 'CategoryName',
                    'languageIdBase' => 'LanguageIDBase',
                    'languageIdTranslation' => 'LanguageIDTranslation',
                )
            )
        )
	);
?>