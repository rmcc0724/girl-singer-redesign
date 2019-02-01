/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 10);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports) {

module.exports = wp;

/***/ }),
/* 1 */
/***/ (function(module, exports) {

module.exports = _;

/***/ }),
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function(global) {/* jshint browserify: true */



var _ = __webpack_require__(1);

function Application() {
	var settings = {};

	_.extend(this, {
		controller: {},
		l10n: {},
		model: {},
		view: {}
	});

	this.settings = function (options) {
		if (options) {
			_.extend(settings, options);
		}

		if (settings.l10n) {
			this.l10n = _.extend(this.l10n, settings.l10n);
			delete settings.l10n;
		}

		return settings || {};
	};
}

global.audiotheme = global.audiotheme || new Application();
module.exports = global.audiotheme;
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(11)))

/***/ }),
/* 3 */
/***/ (function(module, exports) {

module.exports = jQuery;

/***/ }),
/* 4 */
/***/ (function(module, exports) {

module.exports = Backbone;

/***/ }),
/* 5 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* jshint browserify: true */



var Venue,
    _ = __webpack_require__(1),
    Backbone = __webpack_require__(4),
    settings = __webpack_require__(2).settings(),
    wp = __webpack_require__(0);

Venue = Backbone.Model.extend({
	idAttribute: 'ID',

	defaults: {
		ID: null,
		name: '',
		address: '',
		city: '',
		state: '',
		postal_code: '',
		country: '',
		phone: '',
		timezone_string: settings.defaultTimezoneString || '',
		website: ''
	},

	sync: function sync(method, model, options) {
		options = options || {};
		options.context = this;

		if ('create' === method) {
			if (!settings.canPublishVenues || !settings.insertVenueNonce) {
				return Backbone.$.Deferred().rejectWith(this).promise();
			}

			options.data = _.extend(options.data || {}, {
				action: 'audiotheme_ajax_save_venue',
				model: model.toJSON(),
				nonce: settings.insertVenueNonce
			});

			return wp.ajax.send(options);
		}

		// If the attachment does not yet have an `ID`, return an instantly
		// rejected promise. Otherwise, all of our requests will fail.
		if (_.isUndefined(this.id)) {
			return Backbone.$.Deferred().rejectWith(this).promise();
		}

		// Overload the `read` request so Venue.fetch() functions correctly.
		if ('read' === method) {
			options.data = _.extend(options.data || {}, {
				action: 'audiotheme_ajax_get_venue',
				ID: this.id
			});
			return wp.ajax.send(options);
		} else if ('update' === method) {
			// If we do not have the necessary nonce, fail immeditately.
			if (!this.get('nonces') || !this.get('nonces').update) {
				return Backbone.$.Deferred().rejectWith(this).promise();
			}

			// Set the action and ID.
			options.data = _.extend(options.data || {}, {
				action: 'audiotheme_ajax_save_venue',
				nonce: this.get('nonces').update
			});

			// Record the values of the changed attributes.
			if (model.hasChanged()) {
				options.data.model = model.changed;
				options.data.model.ID = this.id;
			}

			return wp.ajax.send(options);
		}
	}
});

module.exports = Venue;

/***/ }),
/* 6 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* jshint browserify: true */



module.exports = {
	isAddressEmpty: function isAddressEmpty() {
		return !(this.address || this.city || this.state || this.postal_code || this.country);
	},

	formatCityStatePostalCode: function formatCityStatePostalCode() {
		var location = '';

		if (this.city) {
			location += this.city;
		}

		if (this.state) {
			location = '' === location ? this.state : location + ', ' + this.state;
		}

		if (this.postal_code) {
			location = '' === location ? this.postal_code : location + ' ' + this.postal_code;
		}

		return location;
	}
};

/***/ }),
/* 7 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* jshint browserify: true */
/* global google */



var settings,
    $ = __webpack_require__(3),
    _ = __webpack_require__(1),
    app = __webpack_require__(2);

settings = app.settings();

function getAddress(components) {
	var map,
	    address = {};

	map = {
		street_number: 'short_name',
		route: 'long_name',
		locality: 'long_name',
		administrative_area_level_1: 'short_name',
		country: 'long_name',
		postal_code: 'short_name'
	};

	_.each(components, function (component) {
		var type = component.types[0];

		if (map[type]) {
			address[type] = component[map[type]];
		}
	});

	return address;
}

function updateTimeZone($field, latitude, longitude) {
	return $.ajax({
		url: 'https://maps.googleapis.com/maps/api/timezone/json',
		data: {
			location: latitude + ',' + longitude,
			key: settings.googleMapsApiKey,
			timestamp: parseInt(Math.floor(Date.now() / 1000), 10)
		}
	}).done(function (response) {
		$field.find('option[value="' + response.timeZoneId + '"]').attr('selected', true).end().trigger('change');
	});
}

/*
 * Currently used in:
 * - views/venue/add-form.js
 * - views/venue/edit-form.js
 */
module.exports = function (options) {
	var autocomplete,
	    fields = options.fields || {};

	autocomplete = new google.maps.places.Autocomplete(options.input, {
		types: [options.type]
	});

	autocomplete.addListener('place_changed', function () {
		var place = autocomplete.getPlace(),
		    address = getAddress(place.address_components),
		    location = place.geometry.location;

		if (fields.name) {
			fields.name.val(place.name).trigger('change');
		}

		if (fields.address) {
			fields.address.val(address.street_number + ' ' + address.route).trigger('change');
		}

		if (fields.city) {
			fields.city.val(address.locality).trigger('change');
		}

		if (fields.state) {
			fields.state.val(address.administrative_area_level_1).trigger('change');
		}

		if (fields.postalCode) {
			fields.postalCode.val(address.postal_code).trigger('change');
		}

		if (fields.country) {
			fields.country.val(address.country).trigger('change');
		}

		if (fields.phone) {
			fields.phone.val(place.formatted_phone_number).trigger('change');
		}

		if (fields.website) {
			fields.website.val(place.website).trigger('change');
		}

		if (fields.timeZone) {
			updateTimeZone(fields.timeZone, location.lat(), location.lng());
		}
	});
};

/***/ }),
/* 8 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* jshint browserify: true */



var Venues,
    Backbone = __webpack_require__(4),
    Venue = __webpack_require__(5);

Venues = Backbone.Collection.extend({
	model: Venue,

	comparator: function comparator(model) {
		return model.get('name').toLowerCase();
	}
});

module.exports = Venues;

/***/ }),
/* 9 */,
/* 10 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* jshint browserify: true */
/* global _audiothemeGigEditSettings, _audiothemeVenueManagerSettings, _pikadayL10n, isRtl, Pikaday */



var datepicker,
    frame,
    settings,
    wpScreen,
    $ = __webpack_require__(3),
    app = __webpack_require__(2),
    Backbone = __webpack_require__(4),
    $time = $('#gig-time'),
    ss = sessionStorage || {},
    lastGigDate = 'lastGigDate' in ss ? new Date(ss.lastGigDate) : null,
    lastGigTime = 'lastGigTime' in ss ? new Date(ss.lastGigTime) : null,
    $venueIdField = $('#gig-venue-id');

var GigVenueMetaBox = __webpack_require__(12),
    Venue = __webpack_require__(5),
    VenueFrame = __webpack_require__(15);

settings = app.settings(_audiothemeGigEditSettings);
settings = app.settings(_audiothemeVenueManagerSettings);

// Add a day to the last saved gig date.
if (lastGigDate) {
	lastGigDate.setDate(lastGigDate.getDate() + 1);
}

// Initialize the time picker.
$time.timepicker({
	'scrollDefaultTime': lastGigTime || '',
	'timeFormat': settings.timeFormat,
	'className': 'ui-autocomplete'
}).on('showTimepicker', function () {
	$(this).addClass('open');
	$('.ui-timepicker-list').width($(this).outerWidth());
}).on('hideTimepicker', function () {
	$(this).removeClass('open');
}).next().on('click', function () {
	$time.focus();
});

// Add the last saved date and time to session storage
// when the gig is saved.
$('#publish').on('click', function () {
	var date = datepicker.getDate(),
	    time = $time.timepicker('getTime');

	if (ss && '' !== date) {
		ss.lastGigDate = date;
	}

	if (ss && '' !== time) {
		ss.lastGigTime = time;
	}
});

// Initialize the date picker.
datepicker = new Pikaday({
	bound: false,
	container: document.getElementById('audiotheme-gig-start-date-picker'),
	field: $('.audiotheme-gig-date-picker-start').find('input').get(0),
	format: 'YYYY/MM/DD',
	i18n: _pikadayL10n || {},
	isRTL: isRtl,
	theme: 'audiotheme-pikaday'
});

// Initialize the venue frame.
frame = new VenueFrame({
	title: app.l10n.venues || 'Venues',
	button: {
		text: app.l10n.selectVenue || 'Select Venue'
	}
});

// Refresh venue in case data was edited in the modal.
frame.on('close', function () {
	wpScreen.get('venue').fetch();
});

frame.on('insert', function (selection) {
	wpScreen.set('venue', selection.first());
	$venueIdField.val(selection.first().get('ID'));
});

wpScreen = new Backbone.Model({
	frame: frame,
	venue: new Venue(settings.venue || {})
});

new GigVenueMetaBox({
	controller: wpScreen
}).render();

$(window).on('keyup', function (e) {
	// Only handle key events when the venue list state is active.
	if (!frame.$el.is(':visible') || 'venues' !== frame.state().id) {
		return;
	}

	// Up arrow.
	if (38 === e.keyCode) {
		frame.state().previous();
	}

	// Down arrow.
	if (40 === e.keyCode) {
		frame.state().next();
	}
});

/***/ }),
/* 11 */
/***/ (function(module, exports) {

var g;

// This works in non-strict mode
g = (function() {
	return this;
})();

try {
	// This works if eval is allowed (see CSP)
	g = g || Function("return this")() || (1,eval)("this");
} catch(e) {
	// This works if the window reference is available
	if(typeof window === "object")
		g = window;
}

// g can still be undefined, but nothing to do about it...
// We return undefined, instead of nothing here, so it's
// easier to handle this case. if(!global) { ...}

module.exports = g;


/***/ }),
/* 12 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* jshint browserify: true */



var GigVenueMetaBox,
    GigVenueDetails = __webpack_require__(13),
    GigVenueSelectButton = __webpack_require__(14),
    wp = __webpack_require__(0);

GigVenueMetaBox = wp.media.View.extend({
	el: '#audiotheme-gig-venue-meta-box',

	initialize: function initialize(options) {
		this.controller = options.controller;

		this.listenTo(this.controller, 'change:venue', this.render);
		this.controller.get('frame').on('open', this.updateSelection, this);
	},

	render: function render() {
		this.views.set('.audiotheme-panel-body', [new GigVenueDetails({
			model: this.controller.get('venue')
		}), new GigVenueSelectButton({
			controller: this.controller
		})]);

		return this;
	},

	updateSelection: function updateSelection() {
		var frame = this.controller.get('frame'),
		    model = this.controller.get('venue'),
		    venues = frame.states.get('venues').get('venues'),
		    selection = frame.states.get('venues').get('selection');

		if (model.get('ID')) {
			venues.add(model, { at: 0 });
			selection.reset(model);
		}
	}
});

module.exports = GigVenueMetaBox;

/***/ }),
/* 13 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* jshint browserify: true */



var GigVenueDetails,
    _ = __webpack_require__(1),
    templateHelpers = __webpack_require__(6),
    wp = __webpack_require__(0);

GigVenueDetails = wp.media.View.extend({
	className: 'audiotheme-gig-venue-details',
	template: wp.template('audiotheme-gig-venue-details'),

	initialize: function initialize(options) {
		this.model = options.model;

		this.listenTo(this.model, 'change', this.render);
	},

	render: function render() {
		var data;

		if (this.model.get('ID')) {
			data = _.extend(this.model.toJSON(), templateHelpers);
			this.$el.html(this.template(data));
		} else {
			this.$el.empty();
		}

		return this;
	}
});

module.exports = GigVenueDetails;

/***/ }),
/* 14 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* jshint browserify: true */



var GigVenueSelectButton,
    l10n = __webpack_require__(2).l10n,
    wp = __webpack_require__(0);

GigVenueSelectButton = wp.media.View.extend({
	className: 'button',
	tagName: 'button',

	events: {
		'click': 'openModal'
	},

	render: function render() {
		this.$el.text(l10n.selectVenue || 'Select Venue');
		return this;
	},

	openModal: function openModal(e) {
		e.preventDefault();
		this.controller.get('frame').open();
	}
});

module.exports = GigVenueSelectButton;

/***/ }),
/* 15 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* jshint browserify: true */



var VenueFrame,
    _ = __webpack_require__(1),
    Frame = __webpack_require__(16),
    settings = __webpack_require__(2).settings(),
    VenueAddContent = __webpack_require__(17),
    VenueAddController = __webpack_require__(19),
    VenueAddToolbar = __webpack_require__(20),
    VenueSelectToolbar = __webpack_require__(21),
    VenuesContent = __webpack_require__(22),
    VenuesController = __webpack_require__(30);

VenueFrame = Frame.extend({
	className: 'media-frame audiotheme-venue-frame',

	initialize: function initialize() {
		Frame.prototype.initialize.apply(this, arguments);

		_.defaults(this.options, {
			title: '',
			modal: true,
			state: 'venues'
		});

		this.createStates();
		this.bindHandlers();
	},

	createStates: function createStates() {
		this.states.add(new VenuesController());

		if (settings.canPublishVenues) {
			this.states.add(new VenueAddController());
		}
	},

	bindHandlers: function bindHandlers() {
		this.on('content:create:venues-manager', this.createContent, this);
		this.on('toolbar:create:venues', this.createSelectToolbar, this);
		this.on('toolbar:create:venue-add', this.createAddToolbar, this);
		this.on('content:render:venue-add', this.renderAddContent, this);
	},

	createContent: function createContent(contentRegion) {
		contentRegion.view = new VenuesContent({
			controller: this,
			collection: this.state().get('venues'),
			searchQuery: this.state().get('search'),
			selection: this.state().get('selection')
		});
	},

	createSelectToolbar: function createSelectToolbar(toolbar) {
		toolbar.view = new VenueSelectToolbar({
			controller: this,
			selection: this.state().get('selection')
		});
	},

	createAddToolbar: function createAddToolbar(toolbar) {
		toolbar.view = new VenueAddToolbar({
			controller: this,
			model: this.state('venue-add').get('model')
		});
	},

	renderAddContent: function renderAddContent() {
		this.content.set(new VenueAddContent({
			model: this.state('venue-add').get('model')
		}));
	}
});

module.exports = VenueFrame;

/***/ }),
/* 16 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* jshint browserify: true */



var Frame,
    _ = __webpack_require__(1),
    wp = __webpack_require__(0);

Frame = wp.media.view.Frame.extend({
	className: 'media-frame',
	template: wp.media.template('media-frame'),
	regions: ['menu', 'title', 'content', 'toolbar'],

	initialize: function initialize() {
		wp.media.view.Frame.prototype.initialize.apply(this, arguments);

		_.defaults(this.options, {
			title: '',
			modal: true
		});

		// Ensure core UI is enabled.
		this.$el.addClass('wp-core-ui');

		// Initialize modal container view.
		if (this.options.modal) {
			this.modal = new wp.media.view.Modal({
				controller: this,
				title: this.options.title
			});

			this.modal.content(this);
		}

		this.on('attach', _.bind(this.views.ready, this.views), this);

		// Bind default title creation.
		this.on('title:create:default', this.createTitle, this);
		this.title.mode('default');

		this.on('menu:create:default', this.createMenu, this);
	},

	render: function render() {
		// Activate the default state if no active state exists.
		if (!this.state() && this.options.state) {
			this.setState(this.options.state);
		}

		// Call 'render' directly on the parent class.
		return wp.media.view.Frame.prototype.render.apply(this, arguments);
	},

	createMenu: function createMenu(menu) {
		menu.view = new wp.media.view.Menu({
			controller: this
		});
	},

	createTitle: function createTitle(title) {
		title.view = new wp.media.View({
			controller: this,
			tagName: 'h1'
		});
	},

	createToolbar: function createToolbar(toolbar) {
		toolbar.view = new wp.media.view.Toolbar({
			controller: this
		});
	}
});

// Map some of the modal's methods to the frame.
_.each(['open', 'close', 'attach', 'detach', 'escape'], function (method) {
	/**
  * @returns {wp.media.view.VenueFrame} Returns itself to allow chaining.
  */
	Frame.prototype[method] = function () {
		if (this.modal) {
			this.modal[method].apply(this.modal, arguments);
		}
		return this;
	};
});

module.exports = Frame;

/***/ }),
/* 17 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* jshint browserify: true */



var VenueAddContent,
    VenueAddForm = __webpack_require__(18),
    wp = __webpack_require__(0);

VenueAddContent = wp.media.View.extend({
	className: 'audiotheme-venue-frame-content audiotheme-venue-frame-content--add',

	initialize: function initialize(options) {
		this.model = options.model;
	},

	render: function render() {
		this.views.add([new VenueAddForm({
			model: this.model
		})]);
		return this;
	}
});

module.exports = VenueAddContent;

/***/ }),
/* 18 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* jshint browserify: true */



var VenueAddForm,
    $ = __webpack_require__(3),
    wp = __webpack_require__(0),
    placeAutocomplete = __webpack_require__(7);

/**
 *
 *
 * @todo Display an error if the timezone isn't set.
 */
VenueAddForm = wp.media.View.extend({
	tagName: 'div',
	className: 'audiotheme-venue-edit-form',
	template: wp.template('audiotheme-venue-edit-form'),

	events: {
		'change [data-setting]': 'updateAttribute'
	},

	initialize: function initialize(options) {
		this.model = options.model;
	},

	render: function render() {
		this.$el.html(this.template(this.model.toJSON()));

		placeAutocomplete({
			input: this.$('[data-setting="name"]')[0],
			fields: {
				name: this.$('[data-setting="name"]'),
				address: this.$('[data-setting="address"]'),
				city: this.$('[data-setting="city"]'),
				state: this.$('[data-setting="state"]'),
				postalCode: this.$('[data-setting="postal_code"]'),
				country: this.$('[data-setting="country"]'),
				timeZone: this.$('[data-setting="timezone_string"]'),
				phone: this.$('[data-setting="phone"]'),
				website: this.$('[data-setting="website"]')
			},
			type: 'establishment'
		});

		placeAutocomplete({
			input: this.$('[data-setting="city"]')[0],
			fields: {
				city: this.$('[data-setting="city"]'),
				state: this.$('[data-setting="state"]'),
				country: this.$('[data-setting="country"]'),
				timeZone: this.$('[data-setting="timezone_string"]')
			},
			type: '(cities)'
		});

		return this;
	},

	/**
  * Update a model attribute when a field is changed.
  *
  * Fields with a 'data-setting="{{key}}"' attribute whose value
  * corresponds to a model attribute will be automatically synced.
  *
  * @param {Object} e Event object.
  */
	updateAttribute: function updateAttribute(e) {
		var attribute = $(e.target).data('setting'),
		    value = e.target.value;

		if (this.model.get(attribute) !== value) {
			this.model.set(attribute, value);
		}
	}
});

module.exports = VenueAddForm;

/***/ }),
/* 19 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* jshint browserify: true */



var VenueAddController,
    l10n = __webpack_require__(2).l10n,
    Venue = __webpack_require__(5),
    wp = __webpack_require__(0);

VenueAddController = wp.media.controller.State.extend({
	defaults: {
		id: 'venue-add',
		title: l10n.addNewVenue || 'Add New Venue',
		button: {
			text: l10n.save || 'Save'
		},
		content: 'venue-add',
		menu: 'default',
		menuItem: {
			text: l10n.addVenue || 'Add a Venue',
			priority: 20
		},
		toolbar: 'venue-add'
	},

	initialize: function initialize() {
		this.set('model', new Venue());
	}
});

module.exports = VenueAddController;

/***/ }),
/* 20 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* jshint browserify: true */



var VenueAddToolbar,
    _ = __webpack_require__(1),
    Venue = __webpack_require__(5),
    wp = __webpack_require__(0);

VenueAddToolbar = wp.media.view.Toolbar.extend({
	initialize: function initialize(options) {
		_.bindAll(this, 'saveVenue');

		// This is a button.
		this.options.items = _.defaults(this.options.items || {}, {
			save: {
				text: this.controller.state().get('button').text,
				style: 'primary',
				priority: 80,
				requires: false,
				click: this.saveVenue
			},
			spinner: new wp.media.view.Spinner({
				priority: 60
			})
		});

		this.options.items.spinner.delay = 0;
		this.listenTo(this.model, 'change:name', this.toggleButtonState);

		wp.media.view.Toolbar.prototype.initialize.apply(this, arguments);
	},

	render: function render() {
		this.$button = this.get('save').$el;
		this.toggleButtonState();
		return this;
	},

	saveVenue: function saveVenue() {
		var controller = this.controller,
		    model = controller.state().get('model'),
		    spinner = this.get('spinner').show();

		model.save().done(function (response) {
			var selectController = controller.state('venues');

			// Insert into the venues collection and update the selection.
			selectController.get('venues').add(model);
			selectController.get('selection').reset(model);
			selectController.set('mode', 'view');
			controller.state().set('model', new Venue());

			// Switch to the select view.
			controller.setState('venues');

			spinner.hide();
		});
	},

	toggleButtonState: function toggleButtonState() {
		this.$button.attr('disabled', '' === this.model.get('name'));
	}
});

module.exports = VenueAddToolbar;

/***/ }),
/* 21 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* jshint browserify: true */



var VenueSelectToolbar,
    _ = __webpack_require__(1),
    wp = __webpack_require__(0);

VenueSelectToolbar = wp.media.view.Toolbar.extend({
	initialize: function initialize(options) {
		var selection = options.selection;

		this.controller = options.controller;

		// This is a button.
		this.options.items = _.defaults(this.options.items || {}, {
			select: {
				text: this.controller.state().get('button').text,
				style: 'primary',
				priority: 80,
				requires: {
					selection: true
				},
				click: function click() {
					this.controller.state().trigger('insert', selection);
					this.controller.close();
				}
			}
		});

		wp.media.view.Toolbar.prototype.initialize.apply(this, arguments);
	}
});

module.exports = VenueSelectToolbar;

/***/ }),
/* 22 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* jshint browserify: true */



var VenuesContent,
    VenuePanel = __webpack_require__(23),
    VenuesList = __webpack_require__(27),
    VenuesSearch = __webpack_require__(29),
    wp = __webpack_require__(0);

VenuesContent = wp.media.View.extend({
	className: 'audiotheme-venue-frame-content',

	initialize: function initialize(options) {
		var view = this,
		    selection = this.controller.state('venues').get('selection');

		if (!this.collection.length) {
			this.collection.fetch().done(function () {
				if (!selection.length) {
					selection.reset(view.collection.first());
				}
			});
		}
	},

	render: function render() {
		this.views.add([new VenuesSearch({
			controller: this.controller
		}), new VenuesList({
			controller: this.controller,
			collection: this.collection
		}), new VenuePanel({
			controller: this.controller
		})]);

		return this;
	}
});

module.exports = VenuesContent;

/***/ }),
/* 23 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* jshint browserify: true */



var VenuePanel,
    VenueDetails = __webpack_require__(24),
    VenueEditForm = __webpack_require__(25),
    VenuePanelTitle = __webpack_require__(26),
    wp = __webpack_require__(0);

VenuePanel = wp.media.View.extend({
	tagName: 'div',
	className: 'audiotheme-venue-panel',

	initialize: function initialize() {
		this.listenTo(this.controller.state().get('selection'), 'reset', this.render);
		this.listenTo(this.controller.state(), 'change:mode', this.render);
	},

	render: function render() {
		var panelContent,
		    model = this.controller.state().get('selection').first();

		if (!this.controller.state('venues').get('selection').length) {
			return this;
		}

		if ('edit' === this.controller.state().get('mode')) {
			panelContent = new VenueEditForm({
				controller: this.controller,
				model: model
			});
		} else {
			panelContent = new VenueDetails({
				controller: this.controller,
				model: model
			});
		}

		this.views.set([new VenuePanelTitle({
			controller: this.controller,
			model: model
		}), panelContent]);

		return this;
	}
});

module.exports = VenuePanel;

/***/ }),
/* 24 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* jshint browserify: true */



var VenueDetails,
    _ = __webpack_require__(1),
    templateHelpers = __webpack_require__(6),
    wp = __webpack_require__(0);

VenueDetails = wp.media.View.extend({
	tagName: 'div',
	className: 'audiotheme-venue-details',
	template: wp.template('audiotheme-venue-details'),

	render: function render() {
		var model = this.controller.state('venues').get('selection').first(),
		    data = _.extend(model.toJSON(), templateHelpers);

		this.$el.html(this.template(data));
		return this;
	}
});

module.exports = VenueDetails;

/***/ }),
/* 25 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* jshint browserify: true */



var VenueEditForm,
    $ = __webpack_require__(3),
    wp = __webpack_require__(0),
    placeAutocomplete = __webpack_require__(7);

VenueEditForm = wp.media.View.extend({
	tagName: 'div',
	className: 'audiotheme-venue-edit-form',
	template: wp.template('audiotheme-venue-edit-form'),

	events: {
		'change [data-setting]': 'updateAttribute'
	},

	initialize: function initialize(options) {
		this.model = options.model;
		this.$spinner = $('<span class="spinner"></span>');
	},

	render: function render() {
		var tzString = this.model.get('timezone_string');

		this.$el.html(this.template(this.model.toJSON()));

		if (tzString) {
			this.$el.find('#venue-timezone-string').find('option[value="' + tzString + '"]').prop('selected', true);
		}

		placeAutocomplete({
			input: this.$('[data-setting="name"]')[0],
			fields: {
				name: this.$('[data-setting="name"]'),
				address: this.$('[data-setting="address"]'),
				city: this.$('[data-setting="city"]'),
				state: this.$('[data-setting="state"]'),
				postalCode: this.$('[data-setting="postal_code"]'),
				country: this.$('[data-setting="country"]'),
				timeZone: this.$('[data-setting="timezone_string"]'),
				phone: this.$('[data-setting="phone"]'),
				website: this.$('[data-setting="website"]')
			},
			type: 'establishment'
		});

		placeAutocomplete({
			input: this.$('[data-setting="city"]')[0],
			fields: {
				city: this.$('[data-setting="city"]'),
				state: this.$('[data-setting="state"]'),
				country: this.$('[data-setting="country"]'),
				timeZone: this.$('[data-setting="timezone_string"]')
			},
			type: '(cities)'
		});

		return this;
	},

	/**
  * Update a model attribute when a field is changed.
  *
  * Fields with a 'data-setting="{{key}}"' attribute whose value
  * corresponds to a model attribute will be automatically synced.
  *
  * @param {Object} e Event object.
  */
	updateAttribute: function updateAttribute(e) {
		var $target = $(e.target),
		    attribute = $target.data('setting'),
		    value = e.target.value,
		    $spinner = this.$spinner;

		if (this.model.get(attribute) !== value) {
			$spinner.insertAfter($target).addClass('is-active');

			this.model.set(attribute, value).save().always(function () {
				$spinner.removeClass('is-active');
			});
		}
	}
});

module.exports = VenueEditForm;

/***/ }),
/* 26 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* jshint browserify: true */



var VenuePanelTitle,
    l10n = __webpack_require__(2).l10n,
    wp = __webpack_require__(0);

/**
 *
 *
 * @todo Don't show the button if the user can't edit venues.
 */
VenuePanelTitle = wp.media.View.extend({
	tagName: 'div',
	className: 'audiotheme-venue-panel-title',
	template: wp.template('audiotheme-venue-panel-title'),

	events: {
		'click button': 'toggleMode'
	},

	initialize: function initialize(options) {
		this.model = options.model;
		this.listenTo(this.model, 'change:name', this.updateTitle);
	},

	render: function render() {
		var state = this.controller.state('venues'),
		    mode = state.get('mode');

		this.$el.html(this.template(this.model.toJSON()));
		this.$el.find('button').text('edit' === mode ? l10n.view || 'View' : l10n.edit || 'Edit');
		return this;
	},

	toggleMode: function toggleMode(e) {
		var mode = this.controller.state().get('mode');
		e.preventDefault();
		this.controller.state().set('mode', 'edit' === mode ? 'view' : 'edit');
	},

	updateTitle: function updateTitle() {
		this.$el.find('h2').text(this.model.get('name'));
	}
});

module.exports = VenuePanelTitle;

/***/ }),
/* 27 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* jshint browserify: true */



var VenuesList,
    _ = __webpack_require__(1),
    VenuesListItem = __webpack_require__(28),
    wp = __webpack_require__(0);

/**
 *
 *
 * @todo Show feedback (spinner) when searching.
 */
VenuesList = wp.media.View.extend({
	tagName: 'div',
	className: 'audiotheme-venues',

	initialize: function initialize(options) {
		var state = this.controller.state();

		this.listenTo(state, 'change:provider', this.switchCollection);
		this.listenTo(this.collection, 'add', this.addVenue);
		this.listenTo(this.collection, 'reset', this.render);
		this.listenTo(state.get('search'), 'reset', this.render);
		this.listenTo(state, 'change:selectedItem', this.maybeMakeItemVisible);
	},

	render: function render() {
		this.$el.off('scroll').on('scroll', _.bind(this.scroll, this)).html('<ul />');

		if (this.collection.length) {
			this.collection.each(this.addVenue, this);
		} else {
			// @todo Show feedback about there not being any matches.
		}

		return this;
	},

	addVenue: function addVenue(venue) {
		var view = new VenuesListItem({
			controller: this.controller,
			model: venue
		}).render();

		this.$el.children('ul').append(view.el);
	},

	maybeMakeItemVisible: function maybeMakeItemVisible() {
		var $item = this.controller.state().get('selectedItem'),
		    itemHeight = $item.outerHeight(),
		    itemTop = $item.position().top;

		if (itemTop > this.el.clientHeight + this.el.scrollTop - itemHeight) {
			this.el.scrollTop = itemTop - this.el.clientHeight + itemHeight;
		} else if (itemTop < this.el.scrollTop) {
			this.el.scrollTop = itemTop;
		}
	},

	scroll: function scroll() {
		if (this.el.scrollHeight < this.el.scrollTop + this.el.clientHeight * 3 && this.collection.hasMore()) {
			this.collection.more({
				remove: false
			});
		}
	},

	switchCollection: function switchCollection() {
		var state = this.controller.state(),
		    provider = state.get('provider');

		this.collection = state.get(provider);
		this.render();
	}
});

module.exports = VenuesList;

/***/ }),
/* 28 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* jshint browserify: true */



var VenuesListItem,
    wp = __webpack_require__(0);

VenuesListItem = wp.media.View.extend({
	tagName: 'li',
	className: 'audiotheme-venues-list-item',

	events: {
		'click': 'setSelection'
	},

	initialize: function initialize() {
		var selection = this.controller.state('venues').get('selection');
		selection.on('reset', this.updateSelected, this);
		this.listenTo(this.model, 'change:name', this.render);
	},

	render: function render() {
		this.$el.html(this.model.get('name'));
		this.updateSelected();
		return this;
	},

	setSelection: function setSelection() {
		this.controller.state().get('selection').reset(this.model);
	},

	updateSelected: function updateSelected() {
		var state = this.controller.state('venues'),
		    isSelected = state.get('selection').first() === this.model;

		this.$el.toggleClass('is-selected', isSelected);

		if (isSelected) {
			state.set('selectedItem', this.$el);
		}
	}
});

module.exports = VenuesListItem;

/***/ }),
/* 29 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* jshint browserify: true */



var VenuesSearch,
    wp = __webpack_require__(0);

VenuesSearch = wp.media.View.extend({
	tagName: 'div',
	className: 'audiotheme-venues-search',
	template: wp.template('audiotheme-venues-search-field'),

	events: {
		'keyup input': 'search',
		'search input': 'search'
	},

	render: function render() {
		this.$field = this.$el.html(this.template()).find('input');
		return this;
	},

	search: function search() {
		var view = this;

		clearTimeout(this.timeout);
		this.timeout = setTimeout(function () {
			view.controller.state().search(view.$field.val());
		}, 300);
	}
});

module.exports = VenuesSearch;

/***/ }),
/* 30 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* jshint browserify: true */



var VenuesController,
    Backbone = __webpack_require__(4),
    l10n = __webpack_require__(2).l10n,
    Venues = __webpack_require__(8),
    VenuesQuery = __webpack_require__(31),
    wp = __webpack_require__(0);

VenuesController = wp.media.controller.State.extend({
	defaults: {
		id: 'venues',
		title: l10n.venues || 'Venues',
		button: {
			text: l10n.select || 'Select'
		},
		content: 'venues-manager',
		menu: 'default',
		menuItem: {
			text: l10n.manageVenues || 'Manage Venues',
			priority: 10
		},
		mode: 'view',
		toolbar: 'venues',
		provider: 'venues'
	},

	initialize: function initialize() {
		var search = new VenuesQuery({}, { props: { s: '' } }),
		    venues = new VenuesQuery();

		this.set('search', search);
		this.set('venues', venues);
		this.set('selection', new Venues());
		this.set('selectedItem', Backbone.$());

		// Synchronize changes to models in each collection.
		search.observe(venues);
		venues.observe(search);
	},

	next: function next() {
		var provider = this.get('provider'),
		    collection = this.get(provider),
		    currentIndex = collection.indexOf(this.get('selection').at(0));

		if (collection.length - 1 !== currentIndex) {
			this.get('selection').reset(collection.at(currentIndex + 1));
		}
	},

	previous: function previous() {
		var provider = this.get('provider'),
		    collection = this.get(provider),
		    currentIndex = collection.indexOf(this.get('selection').at(0));

		if (0 !== currentIndex) {
			this.get('selection').reset(collection.at(currentIndex - 1));
		}
	},

	search: function search(query) {
		// Restore the original state if the text in the search field
		// is less than 3 characters.
		if (query.length < 3) {
			this.get('search').reset();
			this.set('provider', 'venues');
			return;
		}

		this.set('provider', 'search');
		this.get('search').props.set('s', query);
	}
});

module.exports = VenuesController;

/***/ }),
/* 31 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* jshint browserify: true */



var VenuesQuery,
    _ = __webpack_require__(1),
    Backbone = __webpack_require__(4),
    Venues = __webpack_require__(8),
    wp = __webpack_require__(0);

VenuesQuery = Venues.extend({
	initialize: function initialize(models, options) {
		options = options || {};
		Venues.prototype.initialize.apply(this, arguments);

		this.props = new Backbone.Model();
		this.props.set(_.defaults(options.props || {}));
		this.props.on('change', this.requery, this);

		this.args = _.extend({}, {
			posts_per_page: 20
		}, options.args || {});

		this._hasMore = true;
	},

	hasMore: function hasMore() {
		return this._hasMore;
	},

	/**
  * Fetch more venues from the server for the collection.
  *
  * @param   {object}  [options={}]
  * @returns {Promise}
  */
	more: function more(options) {
		var query = this;

		// If there is already a request pending, return early with the Deferred object.
		if (this._more && 'pending' === this._more.state()) {
			return this._more;
		}

		if (!this.hasMore()) {
			return Backbone.$.Deferred().resolveWith(this).promise();
		}

		options = options || {};
		options.remove = false;

		return this._more = this.fetch(options).done(function (response) {
			if (_.isEmpty(response) || -1 === this.args.posts_per_page || response.length < this.args.posts_per_page) {
				query._hasMore = false;
			}
		});
	},

	observe: function observe(collection) {
		var self = this;

		collection.on('change', function (model) {
			self.set(model, { add: false, remove: false });
		});
	},

	requery: function requery() {
		this._hasMore = true;
		this.args.paged = 1;
		this.fetch({ reset: true });
	},

	/**
  * Overrides Backbone.Collection.sync
  *
  * @param {String} method
  * @param {Backbone.Model} model
  * @param {Object} [options={}]
  * @returns {Promise}
  */
	sync: function sync(method, model, options) {
		var args, fallback;

		// Overload the read method so VenuesQuery.fetch() functions correctly.
		if ('read' === method) {
			options = options || {};
			options.context = this;

			options.data = _.extend(options.data || {}, {
				action: 'audiotheme_ajax_get_venues'
			});

			args = _.clone(this.args);

			if (this.props.get('s')) {
				args.s = this.props.get('s');
			}

			// Determine which page to query.
			if (-1 !== args.posts_per_page) {
				args.paged = Math.floor(this.length / args.posts_per_page) + 1;
			}

			options.data.query_args = args;
			return wp.ajax.send(options);
		}

		// Otherwise, fall back to Backbone.sync()
		else {
				fallback = Venues.prototype.sync ? Venues.prototype : Backbone;
				return fallback.sync.apply(this, arguments);
			}
	}
});

module.exports = VenuesQuery;

/***/ })
/******/ ]);