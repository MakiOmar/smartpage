(function() {
	"use strict";

	tinymce.PluginManager.add('cbtnmce', function(editor, url) {
		editor.addButton('cbtnmce', {
			text : false,
			type : 'menubutton',
			icon : 'smpg-shortcode',
			classes: 'widget btn smpg-shortcode',
			menu : [ 
				{
				text : 'Content',
				menu : [ {
					text : 'Inline English',
					onclick : function() {
						editor.insertContent('[ltrtext][/ltrtext]');
					}
				}, {
					text : 'Neat quote',
					onclick : function() {
						editor.insertContent('[quoteit][/quoteit]');
					}
				},
			   ]
			}]

		});

		
	});
	
})();