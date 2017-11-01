// Hide the importData tab, wait for api init
$("#importData").hide();

function importWords() {
	// Parse the linse
    var words = [];
	var wordsList = $('#ta').val().split("\n");

	// Check if there's at least one line
	if(wordsList.length < 1) {
		$('#ta').val("Invalid format");
		return;
	}

	// Parse the words
	for(var i = 0; i < wordsList.length; i++) {
		var wordDef = wordsList[i].split("\t");
		words.push([wordDef[0], wordDef[1]]);
	}
	
	// Remove the last element (empty line)
	words.pop();
	
	// Add a category
	$.post($("#apiUrl").val() + "category.php", {action:"add", 
		// JSON encode the word list
		data:JSON.stringify({
			name:$("#catName").val(),
			languageIdBase:$("#baseLanguage").val(),
			languageIdTranslation:$("#targetLanguage").val()
		})
	}, function(data){
		// Get the ID of the category
		var catId = data.data.categoryId;
        if(catId == "0") {
            $('#ta').val("Error! This list may already exist.");
            return;
        }
		// Send each words into the API
		for(var i = 0; i < words.length; i++) {
			(function(word, catId, connected, progress){
				$.post($("#apiUrl").val() + "word.php", {action:"add", 
					data:JSON.stringify({
						baseWord:word[0],
						translationWord:word[1],
						categoryId:catId
					})
				}, function(data){
					$("#progress").val(progress / words.length * 100 + "%");
				}, "json");
			})(words[i], catId, connected, progress);
			
		}
		$('#ta').val("Done!");
	}, "json");
}

// Chec if the api is reachable
function checkApi() {
	// Get the language list
	$.post($("#apiUrl").val() + "language.php", {action:"getAll"}, function(data){
		// Display the elements and hide the "connect to API"
		$("#checkApi").hide();
		$("#importData").show();
	//	$("#currentScreen").show();
		
		$.each(data.data, function(key, value) {   
								connected = true;
			 $('#baseLanguage, #targetLanguage')
				 .append($("<option></option>")
							.attr("value", value.languageId)
							.text(value.languageName)); 
		});
	}, "json")
	.fail(function(){
		$("#apiUrl").val("Cannot reach the API");
	});
	// Get the category list
	$.post($("#apiUrl").val() + "category.php", {action:"getAll"}, function(data){
		$("#checkApi").hide();
		$("#importData").show();
		
		$.each(data.data, function(key, value) {   
								connected = true;
			 $('#categoryList')
				 .append($("<option></option>")
							.attr("value", value.categoryId)
							.text(value.categoryName)); 
		});
	}, "json");
}