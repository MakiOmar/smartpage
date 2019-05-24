var SettingsView = Backbone.View.extend({
	el: "#options-nav",
	events: {
		'click': function(e){
			"use strict";

			if($(e.target).hasClass('nav-toggle')){

				e.preventDefault();

				var targetID = e.target.id.split('-')[0];
				
				$('.smpg-dropdown').hide();
				
				$('#' + targetID).toggle();	

			}

		}
	},
});

 var settingsView = new SettingsView();

SettingsRouter = Backbone.Router.extend({
        routes: {
            'section/:section': function(section) {
				"use strict";
				var target = $('a[href="#section/' + section + '"]'),
					content = $('#smpg-' + section + '-section-group');
				$('.smpg-nav-link').parent().removeClass('active');
				$('.smpg-section-group').removeClass('smpg-show-section');
				target.parent().addClass('active');
				content.addClass('smpg-show-section');
			}
        },
        
    });

var settingsRouter = new SettingsRouter();

Backbone.history.start();

jQuery(document).ready(function($){
	"use strict";

	$( "input[type=checkbox]" ).change(function(){
		$('.' + this.id + '_').toggle();
	});
	$( "input[type=radio]" ).change(function(){
		$('.'+ this.className +'_').hide();
		$('.' + this.value ).toggle();
	});
	
});