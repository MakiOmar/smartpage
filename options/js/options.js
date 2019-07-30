jQuery(document).ready(function($){
	var SettingsView = Backbone.View.extend({
		el: "#anony-options-nav",
		events: {
			'click .nav-toggle': function(e){
				"use strict";
					e.preventDefault();

					var targetID = e.target.id.split('-')[0];

					$('.anony-dropdown').hide();
					if($('#' + targetID + '-dropdown')){
						$('#' + targetID + '-dropdown').toggle();
					}


			}
		},
	});

	var settingsView = new SettingsView();

	var SettingsRouter = Backbone.Router.extend({
			routes: {
				'anony-section/:section': function(section) {
					"use strict";
					var target = $('a[href="#anony-section/' + section + '"]'),
						content = $('#anony-' + section + '-section-group');
					$('.anony-nav-link').parent().removeClass('active');
					$('.anony-section-group').removeClass('anony-show-section');
					target.parent().addClass('active');
					content.addClass('anony-show-section');
				}
			},

		});

	var settingsRouter = new SettingsRouter();

	Backbone.history.start();
	
	$( "input[type=checkbox]" ).change(function(){
		$('.' + this.id + '_').toggle();
	});
	
	
	$( "input[type=radio]" ).change(function(){
		$('.'+ this.className +'_').hide();
		$('.' + this.value ).toggle();
	});
});