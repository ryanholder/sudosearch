(function($) {
        $.widget( "custom.catcomplete", $.ui.autocomplete, {
                _renderMenu: function( ul, items ) {
                        var self = this,
                                currentCategory = "";
                        $.each( items, function( index, item ) {
                                if ( item.category != currentCategory ) {
                                        ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
                                        currentCategory = item.category;
                                }
                                self._renderItem( ul, item );
                        });
                }
        });
	$(function() {
		
		$( "#sudosearch" ).catcomplete({
			source: sudosearch_terms
		});
                $( "#sudosearch-form" ).submit(function(e) {
                    $( "#sudosearch-form" ).attr('action', $( "#sudosearch" ).val());
                });
                $( "#sudosearch-dialog" ).dialog({ autoOpen: false, modal: true });
                Mousetrap.bind(['command+shift+s', 'ctrl+shift+s'], function() { 
                    $( "#wp-admin-bar-sudosearch" ).addClass('hover');
                    $( "#sudosearch" ).focus();
                });
                
	});
})(jQuery);