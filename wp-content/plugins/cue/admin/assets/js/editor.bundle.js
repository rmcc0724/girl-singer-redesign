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
/******/ 	return __webpack_require__(__webpack_require__.s = 14);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports) {

module.exports = wp;

/***/ }),
/* 1 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function(global) {/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return l10n; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "c", function() { return settings; });
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var Application = function () {
	function Application() {
		_classCallCheck(this, Application);

		this.l10n = {};
		this.settings = {};
	}

	_createClass(Application, [{
		key: "config",
		value: function config(settings) {
			if (settings.l10n) {
				this.l10n = Object.assign(this.l10n, settings.l10n);
				delete settings.l10n;
			}

			this.settings = Object.assign(this.settings, settings);
		}
	}]);

	return Application;
}();

global.cue = global.cue || new Application();

/* harmony default export */ __webpack_exports__["a"] = (global.cue);
var l10n = global.cue.l10n;
var settings = global.cue.settings;
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(5)))

/***/ }),
/* 2 */
/***/ (function(module, exports) {

module.exports = jQuery;

/***/ }),
/* 3 */
/***/ (function(module, exports) {

module.exports = _;

/***/ }),
/* 4 */
/***/ (function(module, exports) {

module.exports = Backbone;

/***/ }),
/* 5 */
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
/* 6 */,
/* 7 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return PlaylistBrowser; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_wp__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_wp___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_wp__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__browser_no_items__ = __webpack_require__(8);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__browser_playlists__ = __webpack_require__(9);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__browser_sidebar__ = __webpack_require__(11);






var PlaylistBrowser = __WEBPACK_IMPORTED_MODULE_0_wp___default.a.Backbone.View.extend({
	className: 'cue-playlist-browser',

	initialize: function initialize(options) {
		this.collection = options.controller.state().get('collection');
		this.controller = options.controller;

		this._paged = 1;
		this._pending = false;

		this.scroll = this.scroll.bind(this);
		this.listenTo(this.collection, 'reset', this.render);

		if (!this.collection.length) {
			this.getPlaylists();
		}
	},

	render: function render() {
		this.$el.off('scroll').on('scroll', this.scroll);

		this.views.add([new __WEBPACK_IMPORTED_MODULE_2__browser_playlists__["a" /* Playlists */]({
			collection: this.collection,
			controller: this.controller
		}), new __WEBPACK_IMPORTED_MODULE_3__browser_sidebar__["a" /* Sidebar */]({
			controller: this.controller
		}), new __WEBPACK_IMPORTED_MODULE_1__browser_no_items__["a" /* NoItems */]({
			collection: this.collection
		})]);

		return this;
	},

	scroll: function scroll() {
		if (!this._pending && this.el.scrollHeight < this.el.scrollTop + this.el.clientHeight * 3) {
			this._pending = true;
			this.getPlaylists();
		}
	},

	getPlaylists: function getPlaylists() {
		var _this = this;

		__WEBPACK_IMPORTED_MODULE_0_wp___default.a.ajax.post('cue_get_playlists', {
			paged: this._paged
		}).done(function (response) {
			_this.collection.add(response.playlists);

			_this._paged++;

			if (_this._paged <= response.maxNumPages) {
				_this._pending = false;
				_this.scroll();
			}
		});
	}
});

/***/ }),
/* 8 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return NoItems; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_wp__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_wp___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_wp__);


var NoItems = __WEBPACK_IMPORTED_MODULE_0_wp___default.a.Backbone.View.extend({
	className: 'cue-playlist-browser-empty',
	tagName: 'div',
	template: __WEBPACK_IMPORTED_MODULE_0_wp___default.a.template('cue-playlist-browser-empty'),

	initialize: function initialize(options) {
		this.collection = this.collection;

		this.listenTo(this.collection, 'add remove reset', this.toggleVisibility);
	},

	render: function render() {
		this.$el.html(this.template());
		return this;
	},

	toggleVisibility: function toggleVisibility() {
		this.$el.toggleClass('is-visible', this.collection.length < 1);
	}
});

/***/ }),
/* 9 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return Playlists; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_wp__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_wp___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_wp__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__playlist__ = __webpack_require__(10);




var Playlists = __WEBPACK_IMPORTED_MODULE_0_wp___default.a.Backbone.View.extend({
	className: 'cue-playlist-browser-list',
	tagName: 'ul',

	initialize: function initialize(options) {
		this.collection = options.controller.state().get('collection');
		this.controller = options.controller;

		this.listenTo(this.collection, 'add', this.addItem);
		this.listenTo(this.collection, 'reset', this.render);
	},

	render: function render() {
		this.collection.each(this.addItem, this);
		return this;
	},

	addItem: function addItem(model) {
		var view = new __WEBPACK_IMPORTED_MODULE_1__playlist__["a" /* Playlist */]({
			controller: this.controller,
			model: model
		}).render();

		this.$el.append(view.el);
	}
});

/***/ }),
/* 10 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return Playlist; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_wp__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_wp___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_wp__);


var Playlist = __WEBPACK_IMPORTED_MODULE_0_wp___default.a.Backbone.View.extend({
	tagName: 'li',
	className: 'cue-playlist-browser-list-item',
	template: __WEBPACK_IMPORTED_MODULE_0_wp___default.a.template('cue-playlist-browser-list-item'),

	events: {
		'click': 'resetSelection'
	},

	initialize: function initialize(options) {
		this.controller = options.controller;
		this.model = options.model;
		this.selection = this.controller.state().get('selection');

		this.listenTo(this.selection, 'add remove reset', this.updateSelectedClass);
	},

	render: function render() {
		this.$el.html(this.template(this.model.toJSON()));
		return this;
	},

	resetSelection: function resetSelection() {
		if (this.selection.contains(this.model)) {
			this.selection.remove(this.model);
		} else {
			this.selection.reset(this.model);
		}
	},

	updateSelectedClass: function updateSelectedClass() {
		if (this.selection.contains(this.model)) {
			this.$el.addClass('is-selected');
		} else {
			this.$el.removeClass('is-selected');
		}
	}
});

/***/ }),
/* 11 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return Sidebar; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_jquery__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_jquery___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_jquery__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_wp__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_wp___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_wp__);



var Sidebar = __WEBPACK_IMPORTED_MODULE_1_wp___default.a.Backbone.View.extend({
	className: 'cue-playlist-browser-sidebar media-sidebar',
	template: __WEBPACK_IMPORTED_MODULE_1_wp___default.a.template('cue-playlist-browser-sidebar'),

	events: {
		'change [data-setting]': 'updateAttribute'
	},

	initialize: function initialize(options) {
		this.attributes = options.controller.state().get('attributes');
	},

	render: function render() {
		this.$el.html(this.template());
	},

	updateAttribute: function updateAttribute(e) {
		var $target = __WEBPACK_IMPORTED_MODULE_0_jquery___default()(e.target);
		var attribute = $target.data('setting');
		var value = e.target.value;

		if ('checkbox' === e.target.type) {
			value = !!$target.prop('checked');
		}

		this.attributes.set(attribute, value);
	}
});

/***/ }),
/* 12 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return PlaylistsController; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_backbone__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_backbone___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_backbone__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_wp__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_wp___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_wp__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_cue__ = __webpack_require__(1);





var PlaylistsController = __WEBPACK_IMPORTED_MODULE_1_wp___default.a.media.controller.State.extend({
	defaults: {
		id: 'cue-playlists',
		title: __WEBPACK_IMPORTED_MODULE_2_cue__["b" /* l10n */].insertPlaylist || 'Insert Playlist',
		collection: null,
		content: 'cue-playlist-browser',
		menu: 'default',
		menuItem: {
			text: __WEBPACK_IMPORTED_MODULE_2_cue__["b" /* l10n */].insertFromCue || 'Insert from Cue',
			priority: 130
		},
		selection: null,
		toolbar: 'cue-insert-playlist'
	},

	initialize: function initialize(options) {
		var collection = options.collection || new __WEBPACK_IMPORTED_MODULE_0_backbone___default.a.Collection();
		var selection = options.selection || new __WEBPACK_IMPORTED_MODULE_0_backbone___default.a.Collection();

		this.set('attributes', new __WEBPACK_IMPORTED_MODULE_0_backbone___default.a.Model({
			id: null,
			show_playlist: true
		}));

		this.set('collection', collection);
		this.set('selection', selection);

		this.listenTo(selection, 'remove', this.updateSelection);
	}
});

/***/ }),
/* 13 */,
/* 14 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__blocks_playlist__ = __webpack_require__(15);


/***/ }),
/* 15 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_wp__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_wp___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_wp__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_cue__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__sandbox__ = __webpack_require__(16);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__views_frame_select_playlist__ = __webpack_require__(17);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }







var Component = __WEBPACK_IMPORTED_MODULE_0_wp__["element"].Component;
var __ = __WEBPACK_IMPORTED_MODULE_0_wp__["i18n"].__;
var registerBlockType = __WEBPACK_IMPORTED_MODULE_0_wp__["blocks"].registerBlockType;
var BlockControls = __WEBPACK_IMPORTED_MODULE_0_wp__["blocks"].BlockControls,
    BlockDescription = __WEBPACK_IMPORTED_MODULE_0_wp__["blocks"].BlockDescription,
    InspectorControls = __WEBPACK_IMPORTED_MODULE_0_wp__["blocks"].InspectorControls;
var SelectControl = InspectorControls.SelectControl,
    ToggleControl = InspectorControls.ToggleControl;
var Placeholder = __WEBPACK_IMPORTED_MODULE_0_wp__["components"].Placeholder,
    Toolbar = __WEBPACK_IMPORTED_MODULE_0_wp__["components"].Toolbar;


__WEBPACK_IMPORTED_MODULE_1_cue__["a" /* default */].config(_cueEditorSettings);
var l10n = __WEBPACK_IMPORTED_MODULE_1_cue__["a" /* default */].l10n,
    settings = __WEBPACK_IMPORTED_MODULE_1_cue__["a" /* default */].settings;
var parseNonce = settings.parseNonce,
    themes = settings.themes;

var themeOptions = Object.keys(themes).map(function (key) {
	return { label: themes[key], value: key };
});

var ICON = wp.element.createElement(
	'svg',
	{ x: '0px', y: '0px', viewBox: '0 0 20 20' },
	wp.element.createElement('path', { d: 'M11,8h7v2h-7V8z M7,3v7.3C6.5,10.1,6,10,5.5,10C3.6,10,2,11.6,2,13.5S3.6,17,5.5,17S9,15.4,9,13.5V6h9V3H7z M11,13h7v-2h-7 V13z M11,16h7v-2h-7V16z' })
);

function getPreview(attributes) {
	return wp.ajax.post('cue_parse_shortcode', {
		_ajax_nonce: parseNonce,
		shortcode: wp.shortcode.string({
			tag: 'cue',
			type: 'single',
			attrs: {
				id: attributes.playlistId,
				show_playlist: attributes.showPlaylist,
				theme: attributes.theme
			}
		})
	});
}

registerBlockType('cue/playlist', {
	icon: ICON,

	edit: function (_Component) {
		_inherits(edit, _Component);

		function edit() {
			_classCallCheck(this, edit);

			var _this = _possibleConstructorReturn(this, (edit.__proto__ || Object.getPrototypeOf(edit)).apply(this, arguments));

			_this.onOpen = _this.onOpen.bind(_this);
			_this.onSelect = _this.onSelect.bind(_this);
			_this.openModal = _this.openModal.bind(_this);
			_this.togglePlaylist = _this.togglePlaylist.bind(_this);

			_this.state = {
				head: '',
				body: ''
			};

			if (_this.props.attributes.playlistId) {
				_this.request = getPreview(_this.props.attributes);

				_this.request.done(function (response) {
					_this.setState({
						head: response.head,
						body: response.body
					});
				});
			}

			// Initialize the playlist frame.
			var frame = new __WEBPACK_IMPORTED_MODULE_3__views_frame_select_playlist__["a" /* default */]();
			frame.setState('cue-playlists');
			frame.on('open', _this.onOpen);
			frame.on('select', _this.onSelect);
			_this.frame = frame;
			return _this;
		}

		_createClass(edit, [{
			key: 'componentWillReceiveProps',
			value: function componentWillReceiveProps(nextProps) {
				var _this2 = this;

				if (!nextProps.attributes.playlistId) {
					return;
				}

				var shouldRefresh = ['playlistId', 'showPlaylist', 'theme'].reduce(function (shouldRefresh, attribute) {
					return shouldRefresh || _this2.props.attributes[attribute] !== nextProps.attributes[attribute];
				}, false);

				if (!shouldRefresh) {
					return;
				}

				this.request = getPreview(nextProps.attributes);

				this.request.done(function (response) {
					_this2.setState({
						head: response.head,
						body: response.body
					});
				});
			}
		}, {
			key: 'onOpen',
			value: function onOpen() {
				var playlistId = this.props.attributes.playlistId;

				var selection = this.frame.state().get('selection');

				// @todo Update the selection.
			}
		}, {
			key: 'onSelect',
			value: function onSelect(selection) {
				this.props.setAttributes({
					playlistId: selection.first().get('id')
				});
			}
		}, {
			key: 'openModal',
			value: function openModal() {
				this.frame.open();
			}
		}, {
			key: 'togglePlaylist',
			value: function togglePlaylist() {
				var showPlaylist = this.props.attributes.showPlaylist;

				this.props.setAttributes({ showPlaylist: !showPlaylist });
			}
		}, {
			key: 'render',
			value: function render() {
				var _props = this.props,
				    attributes = _props.attributes,
				    className = _props.className,
				    focus = _props.focus,
				    setAttributes = _props.setAttributes,
				    setFocus = _props.setFocus;
				var playlistId = attributes.playlistId,
				    showPlaylist = attributes.showPlaylist,
				    theme = attributes.theme;
				var _state = this.state,
				    head = _state.head,
				    body = _state.body;


				if (!body) {
					return wp.element.createElement(
						Placeholder,
						{
							key: 'placeholder',
							icon: 'playlist-audio',
							label: l10n.cuePlaylist || __('Cue Playlist'),
							instructions: l10n.clickToChoose || __('Click to choose a playlist.') },
						wp.element.createElement(
							'button',
							{ onClick: this.openModal, className: 'button' },
							l10n.choosePlaylist || __('Choose Playlist')
						)
					);
				}

				var toolbarControls = [{
					icon: 'edit',
					title: l10n.choosePlaylist || __('Choose Playlist'),
					onClick: this.openModal
				}];

				return [focus && wp.element.createElement(
					BlockControls,
					{ key: 'controls' },
					wp.element.createElement(Toolbar, { controls: toolbarControls })
				), focus && wp.element.createElement(
					InspectorControls,
					{ key: 'inspector' },
					wp.element.createElement(
						BlockDescription,
						null,
						wp.element.createElement(
							'p',
							null,
							l10n.blockDescription || __('The Cue block allows you to display an audio playlist in your content.')
						)
					),
					wp.element.createElement(ToggleControl, {
						label: l10n.showPlaylist || __('Show the playlist'),
						checked: showPlaylist,
						onChange: this.togglePlaylist
					}),
					wp.element.createElement(SelectControl, {
						label: __('Theme'),
						value: theme,
						options: themeOptions,
						onChange: function onChange(value) {
							return setAttributes({ theme: value });
						}
					})
				), wp.element.createElement(__WEBPACK_IMPORTED_MODULE_2__sandbox__["a" /* default */], {
					key: 'preview',
					head: head,
					body: body,
					title: l10n.cuePlaylist || __('Cue Playlist')
				})];
			}
		}, {
			key: 'componentWillUnmount',
			value: function componentWillUnmount() {
				if (this.request && 'pending' === this.request.state()) {
					this.request.abort();
				}
			}
		}]);

		return edit;
	}(Component),

	save: function save(_ref) {
		var attributes = _ref.attributes,
		    className = _ref.className;

		return null;
	}
});

/***/ }),
/* 16 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_wp__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_wp___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_wp__);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }



var Component = __WEBPACK_IMPORTED_MODULE_0_wp__["element"].Component,
    renderToString = __WEBPACK_IMPORTED_MODULE_0_wp__["element"].renderToString;

var Sandbox = function (_Component) {
	_inherits(Sandbox, _Component);

	_createClass(Sandbox, null, [{
		key: 'defaultProps',
		get: function get() {
			return {
				body: '',
				head: '',
				title: ''
			};
		}
	}]);

	function Sandbox() {
		_classCallCheck(this, Sandbox);

		var _this = _possibleConstructorReturn(this, (Sandbox.__proto__ || Object.getPrototypeOf(Sandbox)).apply(this, arguments));

		_this.state = {
			height: 0,
			width: 0
		};

		_this.isFrameAccessible = _this.isFrameAccessible.bind(_this);
		_this.isFrameEmpty = _this.isFrameEmpty.bind(_this);
		_this.setContent = _this.setContent.bind(_this);
		_this.receiveMessage = _this.receiveMessage.bind(_this);
		return _this;
	}

	_createClass(Sandbox, [{
		key: 'componentDidMount',
		value: function componentDidMount() {
			window.addEventListener('message', this.receiveMessage, false);
			this.setContent();
		}
	}, {
		key: 'componentDidUpdate',
		value: function componentDidUpdate(prevProps) {
			if (this.props.body !== prevProps.body || this.isFrameEmpty()) {
				this.setContent();
			}
		}
	}, {
		key: 'componentWillUnmount',
		value: function componentWillUnmount() {
			window.removeEventListener('message', this.receiveMessage);
		}
	}, {
		key: 'isFrameAccessible',
		value: function isFrameAccessible() {
			try {
				return !!this.iframe.contentDocument.body;
			} catch (e) {
				return false;
			}
		}
	}, {
		key: 'isFrameEmpty',
		value: function isFrameEmpty() {
			return this.isFrameAccessible() && '' === this.iframe.contentDocument.body.innerHTML;
		}
	}, {
		key: 'receiveMessage',
		value: function receiveMessage(event) {
			var iframe = this.iframe;
			var data = event.data || {};

			// Verify that the mounted element is the source of the message.
			if (!iframe || iframe.contentWindow !== event.source) {
				return;
			}

			// Update the state only if the message is formatted as we expect, i.e.
			// as an object with a 'resize' action, width, and height.
			var action = data.action,
			    width = data.width,
			    height = data.height;
			var _state = this.state,
			    oldWidth = _state.width,
			    oldHeight = _state.height;


			if ('resize' === action && (oldWidth !== width || oldHeight !== height)) {
				this.setState({ width: width, height: height });
			}
		}
	}, {
		key: 'setContent',
		value: function setContent() {
			var observeAndResizeJS = '\n\t\t\t(function() {\n\t\t\t\tif ( ! window.MutationObserver || ! document.body || ! window.parent ) {\n\t\t\t\t\treturn;\n\t\t\t\t}\n\n\t\t\t\tfunction sendResize() {\n\t\t\t\t\tconst clientBoundingRect = document.body.getBoundingClientRect();\n\t\t\t\t\twindow.parent.postMessage({\n\t\t\t\t\t\taction: \'resize\',\n\t\t\t\t\t\twidth: clientBoundingRect.width,\n\t\t\t\t\t\theight: clientBoundingRect.height\n\t\t\t\t\t}, \'*\' );\n\t\t\t\t}\n\n\t\t\t\tconst observer = new MutationObserver( sendResize );\n\t\t\t\tobserver.observe( document.body, {\n\t\t\t\t\tattributes: true,\n\t\t\t\t\tattributeOldValue: false,\n\t\t\t\t\tcharacterData: true,\n\t\t\t\t\tcharacterDataOldValue: false,\n\t\t\t\t\tchildList: true,\n\t\t\t\t\tsubtree: true\n\t\t\t\t});\n\n\t\t\t\twindow.addEventListener( \'load\', sendResize, true );\n\t\t\t\tsendResize();\n\t\t})();';

			var head = '\n\t\t\t<title>' + this.props.title + '</title>\n\t\t\t' + this.props.head + '\n\t\t\t<style>\n\t\t\tbody {\n\t\t\t\tmargin: 0 !important;\n\t\t\t\tpadding: 0 !important;\n\t\t\t}\n\n\t\t\tbody > div > * {\n\t\t\t\tmargin-top: 0 !important;\n\t\t\t\tmargin-bottom: 0 !important;\n\t\t\t}\n\t\t\t</style>\n\t\t';

			var html = wp.element.createElement(
				'html',
				{ lang: document.documentElement.lang },
				wp.element.createElement('head', { dangerouslySetInnerHTML: { __html: head } }),
				wp.element.createElement(
					'body',
					{ className: this.props.type },
					wp.element.createElement('div', { dangerouslySetInnerHTML: { __html: this.props.body } }),
					wp.element.createElement('script', { type: 'text/javascript', dangerouslySetInnerHTML: { __html: observeAndResizeJS } })
				)
			);

			this.iframe.contentWindow.document.open();
			this.iframe.contentWindow.document.write('<!DOCTYPE html>' + renderToString(html));
			this.iframe.contentWindow.document.close();
		}
	}, {
		key: 'render',
		value: function render() {
			var _this2 = this;

			return wp.element.createElement('iframe', {
				ref: function ref(node) {
					return _this2.iframe = node;
				},
				title: this.props.title,
				scrolling: 'no',
				sandbox: 'allow-scripts allow-same-origin allow-presentation',
				width: Math.ceil(this.state.width),
				height: Math.ceil(this.state.height)
			});
		}
	}]);

	return Sandbox;
}(Component);

/* harmony default export */ __webpack_exports__["a"] = (Sandbox);

/***/ }),
/* 17 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_wp__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_wp___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_wp__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_cue__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__content_playlist_browser__ = __webpack_require__(7);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__toolbar_select_playlist__ = __webpack_require__(18);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__controllers_playlists__ = __webpack_require__(12);







var SelectFrame = __WEBPACK_IMPORTED_MODULE_0_wp___default.a.media.view.MediaFrame.Select;


/* harmony default export */ __webpack_exports__["a"] = (SelectFrame.extend({
	className: 'media-frame cue-playlists-frame cue-playlists-frame--select',

	createStates: function createStates() {
		this.states.add(new __WEBPACK_IMPORTED_MODULE_4__controllers_playlists__["a" /* PlaylistsController */]({
			title: __WEBPACK_IMPORTED_MODULE_1_cue__["b" /* l10n */].selectPlaylist || 'Select Playlist'
		}));
	},

	bindHandlers: function bindHandlers() {
		SelectFrame.prototype.bindHandlers.apply(this, arguments);

		this.on('content:create:cue-playlist-browser', this.createCueContent, this);
		this.on('toolbar:create:cue-insert-playlist', this.createCueToolbar, this);
	},

	createCueContent: function createCueContent(content) {
		content.view = new __WEBPACK_IMPORTED_MODULE_2__content_playlist_browser__["a" /* PlaylistBrowser */]({
			controller: this
		});
	},

	createCueToolbar: function createCueToolbar(toolbar) {
		toolbar.view = new __WEBPACK_IMPORTED_MODULE_3__toolbar_select_playlist__["a" /* default */]({
			controller: this
		});
	}
}));

/***/ }),
/* 18 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_underscore__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_underscore___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_underscore__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_wp__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_wp___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_wp__);



var _wp$media$view = __WEBPACK_IMPORTED_MODULE_1_wp___default.a.media.view,
    l10n = _wp$media$view.l10n,
    Toolbar = _wp$media$view.Toolbar;


/* harmony default export */ __webpack_exports__["a"] = (Toolbar.extend({
	initialize: function initialize(options) {
		this.controller = options.controller;

		this.select = this.select.bind(this);

		// This is a button.
		this.options.items = __WEBPACK_IMPORTED_MODULE_0_underscore___default.a.defaults(this.options.items || {}, {
			select: {
				text: l10n.insertIntoPost || 'Insert into post',
				style: 'primary',
				priority: 80,
				requires: {
					selection: true
				},
				click: this.select
			}
		});

		Toolbar.prototype.initialize.apply(this, arguments);
	},

	select: function select() {
		var state = this.controller.state();
		var selection = state.get('selection');

		this.controller.close();
		state.trigger('select', selection);
	}
}));

/***/ })
/******/ ]);
//# sourceMappingURL=editor.bundle.js.map
