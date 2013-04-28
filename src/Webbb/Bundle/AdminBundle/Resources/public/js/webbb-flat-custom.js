/**
 * This function is called when form (fields) are added dynamically with JS
 * $added_form_container: generated form container, that contains the field added with JS
 */
function webbbInitGeneratedFormFields(){
	$('body').on('webbb_formfields_generated', function(event, $added_form_container){
	    // Custom selects
	    $added_form_container.find("select").dropkick();
	});
}
webbbInitGeneratedFormFields();