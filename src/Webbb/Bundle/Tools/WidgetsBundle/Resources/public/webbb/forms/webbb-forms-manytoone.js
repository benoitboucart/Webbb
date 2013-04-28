$(function(){
	// Get the ul that holds the collection of tags
	var $manytoone_collectionHolder = $('.webbb-mto-container');
	var mto_single_item_class = $manytoone_collectionHolder.data('mto-itemclass'); // class of the LI items (direct children of the container!)
	var mto_itemremoveclass = $manytoone_collectionHolder.data('mto-itemremoveclass');
	var mto_index = parseInt($manytoone_collectionHolder.data('mto-index'));

	// Setup an "add a tag" link
	var $addTagLink = $('<a href="#" class="webbb_mto_add_item_link">Add item</a>');
	// "Add new item" - link
	var $newLinkLi = $('<li></li>').addClass(mto_single_item_class).addClass(mto_itemremoveclass).append($addTagLink);

	jQuery(document).ready(function() {
	    // add a delete link to all of the existing tag form li elements
	    $manytoone_collectionHolder.find('.'+mto_single_item_class).each(function() {
	        addMtoItemFormDeleteLink($(this));
	    });

	    // add the "add a tag" anchor and li to the tags ul
	    $manytoone_collectionHolder.append($newLinkLi);

	    // count the current form inputs we have (e.g. 2), use that as the new
	    // index when inserting a new item (e.g. 2)
	    mto_index++;
	    $manytoone_collectionHolder.data('index', mto_index); // $manytoone_collectionHolder.find(':input').length

	    $addTagLink.on('click', function(e) {
	        // prevent the link from creating a "#" on the URL
	        e.preventDefault();

	        // add a new tag form (see next code block)
	        addMtoItemForm($manytoone_collectionHolder, $newLinkLi);

	        // Trigger event: called when form (fields) are added dynamically with JS
	        // $('body').trigger('webbb_formfields_generated');
	        $.event.trigger('webbb_formfields_generated', [$manytoone_collectionHolder]);  
	    });
	});

	function addMtoItemForm($collectionHolder, $newLinkLi) {
	    // Get the data-prototype explained earlier
	    var prototype = $collectionHolder.data('prototype');

	    // get the new index
	    var index = $collectionHolder.data('index');

	    // Replace '__name__' in the prototype's HTML to
	    // instead be a number based on how many items we have
	    var newForm = prototype.replace(/__name__/g, index);

	    // increase the index with one for the next item
	    $collectionHolder.data('index', index + 1);

	    // Display the form in the page in an li, before the "Add a tag" link li
	    var $newFormLi = $('<li></li>').addClass(mto_single_item_class).append(newForm);
	    $newLinkLi.before($newFormLi);

	    // add a delete link to the new form
	    addMtoItemFormDeleteLink($newFormLi);
	}
	function addMtoItemFormDeleteLink($itemFormLi) {
	    var $removeFormA = $('<a href="#">delete this tag</a>');
	    $itemFormLi.append($removeFormA);

	    $removeFormA.on('click', function(e) {
	        // prevent the link from creating a "#" on the URL
	        e.preventDefault();

	        // remove the li for the tag form
	        $itemFormLi.remove();
	    });
	}
});