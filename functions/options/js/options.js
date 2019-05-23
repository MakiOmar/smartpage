var SettingsView = Backbone.View.extend({
	el: "#options-nav",
	events: {
		'click': function(e){
			"use strict";

			if($(e.target).hasClass('nav-toggle')){

				e.preventDefault();

				var targetID = e.target.id.split('-')[0];

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
	$('.smpg-radio-slider').find('input[type="radio"]').change(function(){
		var clicked = $(this);

		$('.slider_show').each(function(){
			$(this).removeClass('slider_show');
		});

		$('.' + clicked.val()).addClass('slider_show');
		
	});
	
	$("#home_slider").change(function() {
		
			$('.rev_slider').each(function(){
				
				if($(this).hasClass('home_slider')){
					
					$(this).removeClass('home_slider');
					
				}else{
					
					$(this).addClass('home_slider');
					
				}	
			});
	});
	
});