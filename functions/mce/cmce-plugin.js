(function () {
	"use strict";
	if (tinymce !== undefined) {
		tinymce.PluginManager.add(
			'cbtnmce',
			function (editor, url) {
				editor.addButton(
					'cbtnmce',
					{
						text : false,
						type : 'menubutton',
						icon : 'anony-shortcode',
						classes: 'widget btn anony-shortcode',
						menu : [
						{
							text : 'Content',
							menu : [ {
								text : 'Inline English',
								onclick : function () {
									editor.insertContent( '[ltrtext][/ltrtext]' );
								}
							}, {
								text : 'Neat quote',
								onclick : function () {
									editor.insertContent( '[quoteit][/quoteit]' );
								}
							},
							]
						}]

					}
				);

			}
		);
	}

})();
