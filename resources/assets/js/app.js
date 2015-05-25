var dragula = require('../bower_components/dragula.js/dragula');
require('./plugins/jquery.populate');
require('./plugins/Table');

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

		var form = $('#EntryForm');
		var settingsWrap = $('#EntrySettings');
		var originalSettings = settingsWrap.data('settings');
		$('#EntryType').on('change', function() {
			var id = this.value;
			$.get('/settings/'+settingsWrap.data('type')+'/'+id+'/config')
				.done(function(results) {
					settingsWrap.html(results);
					form.populate(originalSettings);
					form.find('[type="checkbox"],[type="radio"]').each(function() {
						if (this.checked) {
							$(this).parent().addClass('checked')
						}
					});
					registerFieldTypes();
				});
		}).trigger('change');

		registerFieldTypes();
	};

	return this;
});

function registerFieldTypes() {
	$('.formplate[data-field-type="table"]').ftTable();
}

$(document).ready(app.init);

