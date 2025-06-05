(function($){
	
	
	function initialize_field( $el ) {
		
		console.log( 'Hello!' );
		$el.find( 'select' ).select2();
		
	}
	
	
	if( typeof acf.add_action !== 'undefined' ) {
	
		/*
		*  These are 2 events which are fired during the page load
		*  ready = on page load similar to $(document).ready()
		*  append = on new DOM elements appended via repeater field
		*/
		
		acf.add_action('ready append', function( $el ){
			
			// search $el for fields of type 'navmenu'
			acf.get_fields({ type : 'navmenu'}, $el).each(function(){
				
				initialize_field( $(this) );
				
			});
			
		});
		
		
	} else {
		
		
		/*
		*  This event is triggered when ACF adds any new elements to the DOM.
		*/
		
		$(document).on('acf/setup_fields', function(e, postbox){
			
			$(postbox).find('.field[data-field_type="navmenu"]').each(function(){
				
				initialize_field( $(this) );
				
			});
		
		});
	
	
	}


})(jQuery);
