var DEFAULTS = {};

function FtTable(dom, options) {

	var ft = $.data(dom, '_ftTable');
	if (ft instanceof FtTable) {
		return ft.setOptions(options);
	}

	this.o = $.extend({}, DEFAULTS, options);

	// get DOM elements
	this.wrap = $(dom);
	this.table = this.wrap.find('table');
	this.tbody = this.table.find('tbody');
	this.rowTemplate = this.tbody.children('tr').eq(0).clone();
	this.addRowBtn = this.wrap.find('.add-row');
	this.namespace = this.rowTemplate.find(':input').eq(0).data('namespace');

	bindEvents(this);

	$.data(dom, '_ftTable', this);
	return this;
}

FtTable.prototype.setOptions = function (options) {
	$.extend(this.o, options);
	return this;
};

// attach public methods here
FtTable.prototype.addRow = function () {
	var ft = this;
	var newRow = ft.rowTemplate.clone();
	ft.tbody.append(newRow);
	newRow.find(':input').each(function(i, elem) {
		i = $(elem);
		elem.name = ft.namespace + '[' + newRow.index() + '][' + i.data('field') + ']';
	});
};

FtTable.prototype.addCol = function(opts) {
	var ft = this;

	ft.table.find('thead tr').append('<th>'+opts.heading+'</th>');

	var newCol = ft.rowTemplate.find('td').eq(0).clone();
	ft.tbody.find('tr').each(function($row, row) {
		$row = $(row);
		var td = newCol.clone();
		var input = td.find(':input');
		input.attr('data-field', opts.field)
			.get(0).name = ft.namespace + '[' + $row.index() + '][' + input.data('field') + ']';
		$row.append(td);
	});
};

function bindEvents(table) {

	var event_addClick = function (e) {
		e.preventDefault();
		table.addRow();
	};

	var event_addCol = function(e, data) {
		table.addCol(data);
	};

	table.addRowBtn.on('click.ftTable', event_addClick);
	table.wrap.on('addCol.ftTable', event_addCol);
}

$.fn.ftTable = function (options) {
	return this.each(function () {
		var opts = $(this).data('ftTable');
		if (typeof opts === 'string') {
			opts = new Function('return {' + opts + '};')();
		}
		opts = $.extend({}, options, opts);
		return new FtTable(this, opts);
	});
};