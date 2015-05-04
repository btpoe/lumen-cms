var dragula = require('../bower_components/dragula.js/dragula');

var app = new (function App() {

	this.init = function() {

		dragula($('[data-drag-container]').get(), {
			accepts: function(el, target, source) {
				if (target == source) {
					return true;
				}
				var $target = $(target);
				if ($target.data('dragContainer') == 'master') {
					return true;
				}
				return $(el).data('group') == $target.data('group');
			}
		});

		var settingsWrap = $('#FieldTypeSettings');
		var originalSettings = settingsWrap.data('settings');
		$('#FieldType').on('change', function() {
			var id = this.value;
			$.get('/field-types/'+id+'/config')
				.done(function(results) {
					settingsWrap.html(results);
					$.each(originalSettings, function(name, value) {
						var input = settingsWrap.find('[name="settings['+name+']"]');
						if ($.inArray(input.prop('type'), ['checkbox', 'radio']) > -1) {
							input.each(function() {
								var ip = $(this);
								// Check current state
								if(ip.val() == value) {
									ip.attr('checked', 'checked')
										.parent().addClass('checked');
								}
								else {
									ip.removeAttr('checked')
										.parent().removeClass('checked');
								}
							});
						}
						else {
							input.val(value);
						}
					});
				});
		}).trigger('change');
	};

	return this;
});

$(document).ready(function() { app.init(); });