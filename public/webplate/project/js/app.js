(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

var dragula = require('../bower_components/dragula.js/dragula');
require('./plugins/jquery.populate');
require('./plugins/Table');

var app = new function App() {

	this.init = function () {

		dragula($('[data-drag-container]').get(), {
			accepts: function accepts(el, target, source) {
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

		var form = $('#FieldForm');
		var settingsWrap = $('#FieldTypeSettings');
		var originalSettings = settingsWrap.data('settings');
		$('#FieldType').on('change', function () {
			var id = this.value;
			$.get('/settings/field-types/' + id + '/config').done(function (results) {
				settingsWrap.html(results);
				form.populate(originalSettings);
				form.find('[type="checkbox"],[type="radio"]').each(function () {
					if (this.checked) {
						$(this).parent().addClass('checked');
					}
				});
				registerFieldTypes();
			});
		}).trigger('change');

		registerFieldTypes();
	};

	return this;
}();

function registerFieldTypes() {
	$('.formplate[data-field-type="table"]').ftTable();
}

$(document).ready(function () {
	app.init();
});

},{"../bower_components/dragula.js/dragula":3,"./plugins/Table":7,"./plugins/jquery.populate":8}],2:[function(require,module,exports){
// shim for using process in browser

var process = module.exports = {};
var queue = [];
var draining = false;

function drainQueue() {
    if (draining) {
        return;
    }
    draining = true;
    var currentQueue;
    var len = queue.length;
    while(len) {
        currentQueue = queue;
        queue = [];
        var i = -1;
        while (++i < len) {
            currentQueue[i]();
        }
        len = queue.length;
    }
    draining = false;
}
process.nextTick = function (fun) {
    queue.push(fun);
    if (!draining) {
        setTimeout(drainQueue, 0);
    }
};

process.title = 'browser';
process.browser = true;
process.env = {};
process.argv = [];
process.version = ''; // empty string to avoid regexp issues
process.versions = {};

function noop() {}

process.on = noop;
process.addListener = noop;
process.once = noop;
process.off = noop;
process.removeListener = noop;
process.removeAllListeners = noop;
process.emit = noop;

process.binding = function (name) {
    throw new Error('process.binding is not supported');
};

// TODO(shtylman)
process.cwd = function () { return '/' };
process.chdir = function (dir) {
    throw new Error('process.chdir is not supported');
};
process.umask = function() { return 0; };

},{}],3:[function(require,module,exports){
(function (global){
'use strict';

var emitter = require('contra.emitter');
var crossvent = require('crossvent');

function dragula(initialContainers, options) {
  var body = document.body;
  var documentElement = document.documentElement;
  var _mirror; // mirror image
  var _source; // source container
  var _item; // item being dragged
  var _offsetX; // reference x
  var _offsetY; // reference y
  var _initialSibling; // reference sibling when grabbed
  var _currentSibling; // reference sibling now
  var _copy; // item used for copying
  var _containers = []; // containers managed by the drake

  var o = options || {};
  if (o.moves === void 0) {
    o.moves = always;
  }
  if (o.accepts === void 0) {
    o.accepts = always;
  }
  if (o.copy === void 0) {
    o.copy = false;
  }
  if (o.revertOnSpill === void 0) {
    o.revertOnSpill = false;
  }
  if (o.removeOnSpill === void 0) {
    o.removeOnSpill = false;
  }
  if (o.direction === void 0) {
    o.direction = 'vertical';
  }

  var api = emitter({
    addContainer: manipulateContainers('add'),
    removeContainer: manipulateContainers('remove'),
    start: start,
    end: end,
    cancel: cancel,
    remove: remove,
    destroy: destroy,
    dragging: false
  });

  events();
  api.addContainer(initialContainers);

  return api;

  function manipulateContainers(op) {
    return function addOrRemove(all) {
      var changes = Array.isArray(all) ? all : [all];
      changes.forEach(track);
      if (op === 'add') {
        _containers = _containers.concat(changes);
      } else {
        _containers = _containers.filter(removals);
      }
      function track(container) {
        touchy(container, op, 'mousedown', grab);
      }
      function removals(container) {
        return changes.indexOf(container) === -1;
      }
    };
  }

  function events(remove) {
    var op = remove ? 'remove' : 'add';
    touchy(documentElement, op, 'mouseup', release);
  }

  function destroy() {
    events(true);
    api.removeContainer(_containers);
    release({});
  }

  function grab(e) {
    var item = e.target;

    if (e.which !== 0 && e.which !== 1 || e.metaKey || e.ctrlKey) {
      return; // we only care about honest-to-god left clicks and touch events
    }
    if (start(item) !== true) {
      return;
    }

    var offset = getOffset(_item);
    _offsetX = getCoord('pageX', e) - offset.left;
    _offsetY = getCoord('pageY', e) - offset.top;
    renderMirrorImage();
    drag(e);
    e.preventDefault();
  }

  function start(item) {
    var handle = item;

    if (api.dragging && _mirror) {
      return;
    }

    if (_containers.indexOf(item) !== -1) {
      return; // don't drag container itself
    }
    while (_containers.indexOf(item.parentElement) === -1) {
      if (invalidTarget(item)) {
        return;
      }
      item = item.parentElement; // drag target should be a top element
    }
    if (invalidTarget(item)) {
      return;
    }

    var container = item.parentElement;
    var movable = o.moves(item, container, handle);
    if (!movable) {
      return;
    }

    end();

    if (o.copy) {
      _copy = item.cloneNode(true);
      addClass(_copy, 'gu-transit');
    } else {
      addClass(item, 'gu-transit');
    }

    _source = container;
    _item = item;
    _initialSibling = _currentSibling = nextEl(item);

    api.dragging = true;
    api.emit('drag', _item, _source);

    return true;
  }

  function invalidTarget(el) {
    return el.tagName === 'A' || el.tagName === 'BUTTON';
  }

  function end() {
    if (!api.dragging) {
      return;
    }
    var item = _copy || _item;
    drop(item, item.parentElement);
  }

  function release(e) {
    if (!api.dragging) {
      return;
    }

    var item = _copy || _item;
    var clientX = getCoord('clientX', e);
    var clientY = getCoord('clientY', e);
    var elementBehindCursor = getElementBehindPoint(_mirror, clientX, clientY);
    var dropTarget = findDropTarget(elementBehindCursor, clientX, clientY);
    if (dropTarget && (o.copy === false || dropTarget !== _source)) {
      drop(item, dropTarget);
    } else if (o.removeOnSpill) {
      remove();
    } else {
      cancel();
    }
  }

  function drop(item, target) {
    if (isInitialPlacement(target)) {
      api.emit('cancel', item, _source);
    } else {
      api.emit('drop', item, target, _source);
    }
    cleanup();
  }

  function remove() {
    if (!api.dragging) {
      return;
    }
    var item = _copy || _item;
    var parent = item.parentElement;
    if (parent) {
      parent.removeChild(item);
    }
    api.emit(o.copy ? 'cancel' : 'remove', item, parent);
    cleanup();
  }

  function cancel(revert) {
    if (!api.dragging) {
      return;
    }
    var reverts = arguments.length > 0 ? revert : o.revertOnSpill;
    var item = _copy || _item;
    var parent = item.parentElement;
    if (parent === _source && o.copy) {
      parent.removeChild(_copy);
    }
    var initial = isInitialPlacement(parent);
    if (initial === false && o.copy === false && reverts) {
      _source.insertBefore(item, _initialSibling);
    }
    if (initial || reverts) {
      api.emit('cancel', item, _source);
    } else {
      api.emit('drop', item, parent, _source);
    }
    cleanup();
  }

  function cleanup() {
    var item = _copy || _item;
    removeMirrorImage();
    rmClass(item, 'gu-transit');
    _source = _item = _copy = _initialSibling = _currentSibling = null;
    api.dragging = false;
    api.emit('dragend', item);
  }

  function isInitialPlacement(target, s) {
    var sibling;
    if (s !== void 0) {
      sibling = s;
    } else if (_mirror) {
      sibling = _currentSibling;
    } else {
      sibling = nextEl(_item || _copy);
    }
    return target === _source && sibling === _initialSibling;
  }

  function findDropTarget(elementBehindCursor, clientX, clientY) {
    var target = elementBehindCursor;
    while (target && !accepted()) {
      target = target.parentElement;
    }
    return target;

    function accepted() {
      var droppable = _containers.indexOf(target) !== -1;
      if (droppable === false) {
        return false;
      }

      var immediate = getImmediateChild(target, elementBehindCursor);
      var reference = getReference(target, immediate, clientX, clientY);
      var initial = isInitialPlacement(target, reference);
      if (initial) {
        return true; // should always be able to drop it right back where it was
      }
      return o.accepts(_item, target, _source, reference);
    }
  }

  function drag(e) {
    if (!_mirror) {
      return;
    }

    var clientX = getCoord('clientX', e);
    var clientY = getCoord('clientY', e);
    var x = clientX - _offsetX;
    var y = clientY - _offsetY;

    _mirror.style.left = x + 'px';
    _mirror.style.top = y + 'px';

    var elementBehindCursor = getElementBehindPoint(_mirror, clientX, clientY);
    var dropTarget = findDropTarget(elementBehindCursor, clientX, clientY);
    if (dropTarget === _source && o.copy) {
      return;
    }
    var item = _copy || _item;
    var immediate = getImmediateChild(dropTarget, elementBehindCursor);
    if (immediate === null) {
      return;
    }
    var reference = getReference(dropTarget, immediate, clientX, clientY);
    if (reference === null || reference !== item && reference !== nextEl(item)) {
      _currentSibling = reference;
      dropTarget.insertBefore(item, reference);
      api.emit('shadow', item, dropTarget);
    }
  }

  function renderMirrorImage() {
    if (_mirror) {
      return;
    }
    var rect = _item.getBoundingClientRect();
    _mirror = _item.cloneNode(true);
    _mirror.style.width = rect.width + 'px';
    _mirror.style.height = rect.height + 'px';
    rmClass(_mirror, 'gu-transit');
    addClass(_mirror, ' gu-mirror');
    body.appendChild(_mirror);
    touchy(documentElement, 'add', 'mousemove', drag);
    addClass(body, 'gu-unselectable');
  }

  function removeMirrorImage() {
    if (_mirror) {
      rmClass(body, 'gu-unselectable');
      touchy(documentElement, 'remove', 'mousemove', drag);
      _mirror.parentElement.removeChild(_mirror);
      _mirror = null;
    }
  }

  function getImmediateChild(dropTarget, target) {
    var immediate = target;
    while (immediate !== dropTarget && immediate.parentElement !== dropTarget) {
      immediate = immediate.parentElement;
    }
    if (immediate === documentElement) {
      return null;
    }
    return immediate;
  }

  function getReference(dropTarget, target, x, y) {
    var horizontal = o.direction === 'horizontal';
    var reference = target !== dropTarget ? inside() : outside();
    return reference;

    function outside() {
      // slower, but able to figure out any position
      var len = dropTarget.children.length;
      var i;
      var el;
      var rect;
      for (i = 0; i < len; i++) {
        el = dropTarget.children[i];
        rect = el.getBoundingClientRect();
        if (horizontal && rect.left > x) {
          return el;
        }
        if (!horizontal && rect.top > y) {
          return el;
        }
      }
      return null;
    }

    function inside() {
      // faster, but only available if dropped inside a child element
      var rect = target.getBoundingClientRect();
      if (horizontal) {
        return resolve(x > rect.left + rect.width / 2);
      }
      return resolve(y > rect.top + rect.height / 2);
    }

    function resolve(after) {
      return after ? nextEl(target) : target;
    }
  }
}

function touchy(el, op, type, fn) {
  var touch = {
    mouseup: 'touchend',
    mousedown: 'touchstart',
    mousemove: 'touchmove'
  };
  var microsoft = {
    mouseup: 'MSPointerUp',
    mousedown: 'MSPointerDown',
    mousemove: 'MSPointerMove'
  };
  if (global.navigator.msPointerEnabled) {
    crossvent[op](el, microsoft[type], fn);
  }
  crossvent[op](el, touch[type], fn);
  crossvent[op](el, type, fn);
}

function getOffset(el) {
  var rect = el.getBoundingClientRect();
  return {
    left: rect.left + getScroll('scrollLeft', 'pageXOffset'),
    top: rect.top + getScroll('scrollTop', 'pageYOffset')
  };
}

function getScroll(scrollProp, offsetProp) {
  if (typeof global[offsetProp] !== 'undefined') {
    return global[offsetProp];
  }
  var documentElement = document.documentElement;
  if (documentElement.clientHeight) {
    return documentElement[scrollProp];
  }
  var body = document.body;
  return body[scrollProp];
}

function getElementBehindPoint(point, x, y) {
  if (!x && !y) {
    return null;
  }
  var p = point || {};
  var state = p.className;
  var el;
  p.className += ' gu-hide';
  el = document.elementFromPoint(x, y);
  p.className = state;
  return el;
}

function always() {
  return true;
}

function nextEl(el) {
  return el.nextElementSibling || manually();
  function manually() {
    var sibling = el;
    do {
      sibling = sibling.nextSibling;
    } while (sibling && sibling.nodeType !== 1);
    return sibling;
  }
}

function addClass(el, className) {
  if (el.className.indexOf(' ' + className) === -1) {
    el.className += ' ' + className;
  }
}

function rmClass(el, className) {
  el.className = el.className.replace(new RegExp(' ' + className, 'g'), '');
}

function getCoord(coord, e) {
  if (typeof e.targetTouches === 'undefined') {
    return e[coord];
  }
  // on touchend event, we have to use `e.changedTouches`
  // see http://stackoverflow.com/questions/7192563/touchend-event-properties
  // see https://github.com/bevacqua/dragula/issues/34
  return e.targetTouches && e.targetTouches.length && e.targetTouches[0][coord] || e.changedTouches && e.changedTouches.length && e.changedTouches[0][coord] || 0;
}

module.exports = dragula;

}).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
},{"contra.emitter":4,"crossvent":6}],4:[function(require,module,exports){
module.exports = require('./src/contra.emitter.js');

},{"./src/contra.emitter.js":5}],5:[function(require,module,exports){
(function (process){
(function (root, undefined) {
  'use strict';

  var undef = '' + undefined;
  function atoa (a, n) { return Array.prototype.slice.call(a, n); }
  function debounce (fn, args, ctx) { if (!fn) { return; } tick(function run () { fn.apply(ctx || null, args || []); }); }

  // cross-platform ticker
  var si = typeof setImmediate === 'function', tick;
  if (si) {
    tick = function (fn) { setImmediate(fn); };
  } else if (typeof process !== undef && process.nextTick) {
    tick = process.nextTick;
  } else {
    tick = function (fn) { setTimeout(fn, 0); };
  }

  function _emitter (thing, options) {
    var opts = options || {};
    var evt = {};
    if (thing === undefined) { thing = {}; }
    thing.on = function (type, fn) {
      if (!evt[type]) {
        evt[type] = [fn];
      } else {
        evt[type].push(fn);
      }
      return thing;
    };
    thing.once = function (type, fn) {
      fn._once = true; // thing.off(fn) still works!
      thing.on(type, fn);
      return thing;
    };
    thing.off = function (type, fn) {
      var c = arguments.length;
      if (c === 1) {
        delete evt[type];
      } else if (c === 0) {
        evt = {};
      } else {
        var et = evt[type];
        if (!et) { return thing; }
        et.splice(et.indexOf(fn), 1);
      }
      return thing;
    };
    thing.emit = function () {
      var args = atoa(arguments);
      return thing.emitterSnapshot(args.shift()).apply(this, args);
    };
    thing.emitterSnapshot = function (type) {
      var et = (evt[type] || []).slice(0);
      return function () {
        var args = atoa(arguments);
        var ctx = this || thing;
        if (type === 'error' && opts.throws !== false && !et.length) { throw args.length === 1 ? args[0] : args; }
        evt[type] = et.filter(function emitter (listen) {
          if (opts.async) { debounce(listen, args, ctx); } else { listen.apply(ctx, args); }
          return !listen._once;
        });
        return thing;
      };
    }
    return thing;
  }

  // cross-platform export
  if (typeof module !== undef && module.exports) {
    module.exports = _emitter;
  } else {
    root.contra = root.contra || {};
    root.contra.emitter = _emitter;
  }
})(this);

}).call(this,require('_process'))
},{"_process":2}],6:[function(require,module,exports){
(function (global){
'use strict';

var doc = document;
var addEvent = addEventEasy;
var removeEvent = removeEventEasy;
var hardCache = [];

if (!global.addEventListener) {
  addEvent = addEventHard;
  removeEvent = removeEventHard;
}

function addEventEasy (el, type, fn, capturing) {
  return el.addEventListener(type, fn, capturing);
}

function addEventHard (el, type, fn) {
  return el.attachEvent('on' + type, wrap(el, type, fn));
}

function removeEventEasy (el, type, fn, capturing) {
  return el.removeEventListener(type, fn, capturing);
}

function removeEventHard (el, type, fn) {
  return el.detachEvent('on' + type, unwrap(el, type, fn));
}

function fabricateEvent (el, type) {
  var e;
  if (doc.createEvent) {
    e = doc.createEvent('Event');
    e.initEvent(type, true, true);
    el.dispatchEvent(e);
  } else if (doc.createEventObject) {
    e = doc.createEventObject();
    el.fireEvent('on' + type, e);
  }
}

function wrapperFactory (el, type, fn) {
  return function wrapper (originalEvent) {
    var e = originalEvent || global.event;
    e.target = e.target || e.srcElement;
    e.preventDefault  = e.preventDefault  || function preventDefault () { e.returnValue = false; };
    e.stopPropagation = e.stopPropagation || function stopPropagation () { e.cancelBubble = true; };
    fn.call(el, e);
  };
}

function wrap (el, type, fn) {
  var wrapper = unwrap(el, type, fn) || wrapperFactory(el, type, fn);
  hardCache.push({
    wrapper: wrapper,
    element: el,
    type: type,
    fn: fn
  });
  return wrapper;
}

function unwrap (el, type, fn) {
  var i = find(el, type, fn);
  if (i) {
    var wrapper = hardCache[i].wrapper;
    hardCache.splice(i, 1); // free up a tad of memory
    return wrapper;
  }
}

function find (el, type, fn) {
  var i, item;
  for (i = 0; i < hardCache.length; i++) {
    item = hardCache[i];
    if (item.element === el && item.type === type && item.fn === fn) {
      return i;
    }
  }
}

module.exports = {
  add: addEvent,
  remove: removeEvent,
  fabricate: fabricateEvent
};

}).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
},{}],7:[function(require,module,exports){
'use strict';

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
FtTable.prototype.addRow = function (data) {
	var ft = this;
	var newRow = this.rowTemplate.clone();
	this.tbody.append(newRow);
	newRow.find(':input').each(function (i, elem) {
		i = $(elem);
		elem.name = ft.namespace + '[' + newRow.index() + '][' + i.data('field') + ']';
	});
};

function bindEvents(table) {

	var event_addClick = function event_addClick(e) {
		e.preventDefault();
		table.addRow();
	};

	table.addRowBtn.on('click.ftTable', event_addClick);
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

},{}],8:[function(require,module,exports){
'use strict';

jQuery.fn.populate = function (obj, options) {

	// ------------------------------------------------------------------------------------------
	// JSON conversion function

	// convert
	function parseJSON(obj, path) {
		// prepare
		path = path || '';

		// iteration (objects / arrays)
		if (obj == undefined) {} else if (obj.constructor == Object) {
			for (var prop in obj) {
				var name = path + (path == '' ? prop : '[' + prop + ']');
				parseJSON(obj[prop], name);
			}
		} else if (obj.constructor == Array) {
			for (var i = 0; i < obj.length; i++) {
				var index = options.useIndices ? i : '';
				index = options.phpNaming ? '[' + index + ']' : index;
				var name = path + index;
				parseJSON(obj[i], name);
			}
		}

		// assignment (values)
		else {
			// if the element name hasn't yet been defined, create it as a single value
			if (arr[path] == undefined) {
				arr[path] = obj;
			}

			// if the element name HAS been defined, but it's a single value, convert to an array and add the new value
			else if (arr[path].constructor != Array) {
				arr[path] = [arr[path], obj];
			}

			// if the element name HAS been defined, and is already an array, push the single value on the end of the stack
			else {
				arr[path].push(obj);
			}
		}
	};

	// ------------------------------------------------------------------------------------------
	// population functions

	function debug(str) {
		if (window.console && console.log) {
			console.log(str);
		}
	}

	function getElementName(name) {
		if (!options.phpNaming) {
			name = name.replace(/\[\]$/, '');
		}
		return name;
	}

	function populateElement(parentElement, name, value) {
		var selector = options.identifier == 'id' ? '#' + name : '[' + options.identifier + '="' + name + '"]';
		var element = jQuery(selector, parentElement);
		value = value.toString();
		value = value == 'null' ? '' : value;
		element.val(value);
	}

	function populateFormElement(form, name, value) {

		// check that the named element exists in the form
		var name = getElementName(name); // handle non-php naming
		var element = form[name];

		// debug options				
		if (options.debug) {
			_populate.elements.push(element);
		}

		if (!element) {
			return;
		}

		// now, place any single elements in an array.
		// this is so that the next bit of code (a loop) can treat them the
		// same as any array-elements passed, ie radiobutton or checkox arrays,
		// and the code will just work

		var elements = element.type == undefined && element.length ? element : [element];

		// populate the element correctly

		for (var e = 0; e < elements.length; e++) {

			// grab the element
			element = elements[e];

			// skip undefined elements or function objects (IE only)
			if (!element || typeof element == 'undefined' || typeof element == 'function') {
				continue;
			}

			// anything else, process
			var values, j;

			switch (element.type || element.tagName) {

				case 'radio':
					// use the single value to check the radio button
					element.checked = element.value != '' && value.toString() == element.value;
					if (element.checked) {
						$(element).attr('checked', 'checked');
					}
					break;

				case 'checkbox':
					// depends on the value.
					// if it's an array, perform a sub loop
					// if it's a value, just do the check

					values = value.constructor == Array ? value : [value];
					for (j = 0; j < values.length; j++) {
						element.checked |= element.value == values[j];
						if (element.checked) {
							$(element).attr('checked', 'checked');
						}
					}

					//element.checked = (element.value != '' && value.toString().toLowerCase() == element.value.toLowerCase());
					break;

				case 'select-multiple':
					values = value.constructor == Array ? value : [value];
					for (var i = 0; i < element.options.length; i++) {
						for (j = 0; j < values.length; j++) {
							element.options[i].selected |= element.options[i].value == values[j];
						}
					}
					break;

				case 'select':
				case 'select-one':
					element.value = value.toString() || value;
					break;

				case 'text':
				case 'button':
				case 'textarea':
				case 'submit':
				default:
					value = value == null ? '' : value;
					element.value = value;

			}
		}
	}

	// ------------------------------------------------------------------------------------------
	// options & setup

	// exit if no data object supplied
	if (obj === undefined) {
		return this;
	};

	// options
	var options = jQuery.extend({
		phpNaming: true,
		phpIndices: false,
		resetForm: false,
		identifier: 'name',
		debug: false
	}, options);

	if (options.phpIndices) {
		options.phpNaming = true;
	}

	// ------------------------------------------------------------------------------------------
	// convert hierarchical JSON to flat array

	var arr = [];
	parseJSON(obj);

	if (options.debug) {
		_populate = {
			arr: arr,
			obj: obj,
			elements: []
		};
	}

	// ------------------------------------------------------------------------------------------
	// main process function

	this.each(function () {

		// variables
		var tagName = this.tagName.toLowerCase();
		var method = tagName == 'form' ? populateFormElement : populateElement;

		// reset form?
		if (tagName == 'form' && options.resetForm) {
			this.reset();
		}

		// update elements
		for (var i in arr) {
			method(this, i, arr[i]);
		}
	});

	return this;
};

// do nothing

},{}]},{},[1]);
