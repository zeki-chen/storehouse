(function($) {
	function Scroller(elem, settings) {
		var m, hi, v, dw, ww, wh, rwh, mw, mh, anim, debounce, that = this,
			ms = $.mobiscroll,
			e = elem,
			elm = $(e),
			theme, lang, s = extend({}, defaults),
			pres = {},
			warr = [],
			iv = {},
			pixels = {},
			input = elm.is('input'),
			visible = false;

		function isReadOnly(wh) {
			if ($.isArray(s.readonly)) {
				var i = $('.dwwl', dw).index(wh);
				return s.readonly[i];
			}
			return s.readonly;
		}

		function generateWheelItems(i) {
			var html = '<div class="dw-bf">',
				l = 1,
				j;
			for (j in warr[i]) {
				if (l % 20 == 0) {
					html += '</div><div class="dw-bf">';
				}
				html += '<div class="dw-li dw-v" data-val="' + j + '" style="height:' + hi + 'px;line-height:' + hi + 'px;"><div class="dw-i">' + warr[i][j] + '</div></div>';
				l++;
			}
			html += '</div>';
			return html;
		}

		function setGlobals(t) {
			min = $('.dw-li', t).index($('.dw-v', t).eq(0));
			max = $('.dw-li', t).index($('.dw-v', t).eq(-1));
			index = $('.dw-ul', dw).index(t);
			h = hi;
			inst = that;
		}

		function formatHeader(v) {
			var t = s.headerText;
			return t ? (typeof t === 'function' ? t.call(e, v) : t.replace(/\{value\}/i, v)) : '';
		}

		function read() {
			that.temp = ((input && that.val !== null && that.val != elm.val()) || that.values === null) ? s.parseValue(elm.val() || '', that) : that.values.slice(0);
			that.setValue(true);
		}

		function scrollToPos(time, index, manual, dir, orig) {
			if (event('validate', [dw, index, time]) !== false) {
				$('.dw-ul', dw).each(function(i) {
					var t = $(this),
						cell = $('.dw-li[data-val="' + that.temp[i] + '"]', t),
						cells = $('.dw-li', t),
						v = cells.index(cell),
						l = cells.length,
						sc = i == index || index === undefined;
					if (!cell.hasClass('dw-v')) {
						var cell1 = cell,
							cell2 = cell,
							dist1 = 0,
							dist2 = 0;
						while (v - dist1 >= 0 && !cell1.hasClass('dw-v')) {
							dist1++;
							cell1 = cells.eq(v - dist1);
						}
						while (v + dist2 < l && !cell2.hasClass('dw-v')) {
							dist2++;
							cell2 = cells.eq(v + dist2);
						}
						if (((dist2 < dist1 && dist2 && dir !== 2) || !dist1 || (v - dist1 < 0) || dir == 1) && cell2.hasClass('dw-v')) {
							cell = cell2;
							v = v + dist2;
						} else {
							cell = cell1;
							v = v - dist1;
						}
					}
					if (!(cell.hasClass('dw-sel')) || sc) {
						that.temp[i] = cell.attr('data-val');
						$('.dw-sel', t).removeClass('dw-sel');
						cell.addClass('dw-sel');
						that.scroll(t, i, v, sc ? time : 0.1, sc ? orig : undefined);
					}
				});
				that.change(manual);
			}
		}

		function position(check) {
			if (s.display == 'inline' || (ww === $(window).width() && rwh === $(window).height() && check)) {
				return;
			}
			var w, l, t, aw, ah, ap, at, al, arr, arrw, arrl, scroll, totalw = 0,
				minw = 0,
				st = $(window).scrollTop(),
				wr = $('.dwwr', dw),
				d = $('.dw', dw),
				css = {},
				anchor = s.anchor === undefined ? elm : s.anchor;
			ww = $(window).width();
			rwh = $(window).height();
			wh = window.innerHeight;
			wh = wh || rwh;
			if (/modal|bubble/.test(s.display)) {
				$('.dwc', dw).each(function() {
					w = $(this).outerWidth(true);
					totalw += w;
					minw = (w > minw) ? w : minw;
				});
				w = totalw > ww ? minw : totalw;
				wr.width(w);
			}
			mw = d.outerWidth();
			mh = d.outerHeight(true);
			if (s.display == 'modal') {
				l = (ww - mw) / 2;
				t = st + (wh - mh) / 2;
			} else if (s.display == 'bubble') {
				scroll = true;
				arr = $('.dw-arrw-i', dw);
				ap = anchor.offset();
				at = ap.top;
				al = ap.left;
				aw = anchor.outerWidth();
				ah = anchor.outerHeight();
				l = al - (d.outerWidth(true) - aw) / 2;
				l = l > (ww - mw) ? (ww - (mw + 20)) : l;
				l = l >= 0 ? l : 20;
				t = at - mh;
				if ((t < st) || (at > st + wh)) {
					d.removeClass('dw-bubble-top').addClass('dw-bubble-bottom');
					t = at + ah;
				} else {
					d.removeClass('dw-bubble-bottom').addClass('dw-bubble-top');
				}
				arrw = arr.outerWidth();
				arrl = al + aw / 2 - (l + (mw - arrw) / 2);
				$('.dw-arr', dw).css({
					left: arrl > arrw ? arrw : arrl
				});
			} else {
				css.width = '100%';
				if (s.display == 'top') {
					t = st;
				} else if (s.display == 'bottom') {
					t = st + wh - mh;
				}
			}
			css.top = t < 0 ? 0 : t;
			css.left = l;
			d.css(css);
			$('.dw-persp', dw).height(0).height(t + mh > $(document).height() ? t + mh : $(document).height());
			if (scroll && ((t + mh > st + wh) || (at > st + wh))) {
				$(window).scrollTop(t + mh - wh);
			}
		}

		function testTouch(e) {
			if (e.type === 'touchstart') {
				touch = true;
				setTimeout(function() {
					touch = false;
				}, 500);
			} else if (touch) {
				touch = false;
				return false;
			}
			return true;
		}

		function event(name, args) {
			var ret;
			args.push(that);
			$.each([theme.defaults, pres, settings], function(i, v) {
				if (v[name]) {
					ret = v[name].apply(e, args);
				}
			});
			return ret;
		}

		function plus(t) {
			var p = +t.data('pos'),
				val = p + 1;
			calc(t, val > max ? min : val, 1, true);
		}

		function minus(t) {
			var p = +t.data('pos'),
				val = p - 1;
			calc(t, val < min ? max : val, 2, true);
		}
		that.enable = function() {
			s.disabled = false;
			if (input) {
				elm.prop('disabled', false);
			}
		};
		that.disable = function() {
			s.disabled = true;
			if (input) {
				elm.prop('disabled', true);
			}
		};
		that.scroll = function(t, index, val, time, orig) {
			function getVal(t, b, c, d) {
				return c * Math.sin(t / d * (Math.PI / 2)) + b;
			}

			function ready() {
				clearInterval(iv[index]);
				delete iv[index];
				t.data('pos', val).closest('.dwwl').removeClass('dwa');
			}
			var px = (m - val) * hi,
				i;
			if (px == pixels[index] && iv[index]) {
				return;
			}
			if (time && px != pixels[index]) {
				event('onAnimStart', [dw, index, time]);
			}
			pixels[index] = px;
			t.attr('style', (prefix + '-transition:all ' + (time ? time.toFixed(3) : 0) + 's ease-out;') + (has3d ? (prefix + '-transform:translate3d(0,' + px + 'px,0);') : ('top:' + px + 'px;')));
			if (iv[index]) {
				ready();
			}
			if (time && orig !== undefined) {
				i = 0;
				t.closest('.dwwl').addClass('dwa');
				iv[index] = setInterval(function() {
					i += 0.1;
					t.data('pos', Math.round(getVal(i, orig, val - orig, time)));
					if (i >= time) {
						ready();
					}
				}, 100);
			} else {
				t.data('pos', val);
			}
		};
		that.setValue = function(sc, fill, time, temp) {
			if (!$.isArray(that.temp)) {
				that.temp = s.parseValue(that.temp + '', that);
			}
			if (visible && sc) {
				scrollToPos(time);
			}
			v = s.formatResult(that.temp);
			if (!temp) {
				that.values = that.temp.slice(0);
				that.val = v;
			}
			if (fill) {
				if (input) {
					elm.val(v).trigger('change');
				}
			}
		};
		that.getValues = function() {
			var ret = [],
				i;
			for (i in that._selectedValues) {
				ret.push(that._selectedValues[i]);
			}
			return ret;
		};
		that.validate = function(i, dir, time, orig) {
			scrollToPos(time, i, true, dir, orig);
		};
		that.change = function(manual) {
			v = s.formatResult(that.temp);
			if (s.display == 'inline') {
				that.setValue(false, manual);
			} else {
				$('.dwv', dw).html(formatHeader(v));
			}
			if (manual) {
				event('onChange', [v]);
			}
		};
		that.changeWheel = function(idx, time) {
			if (dw) {
				var i = 0,
					j, k, nr = idx.length;
				for (j in s.wheels) {
					for (k in s.wheels[j]) {
						if ($.inArray(i, idx) > -1) {
							warr[i] = s.wheels[j][k];
							$('.dw-ul', dw).eq(i).html(generateWheelItems(i));
							nr--;
							if (!nr) {
								position();
								scrollToPos(time, undefined, true);
								return;
							}
						}
						i++;
					}
				}
			}
		};
		that.isVisible = function() {
			return visible;
		};
		that.tap = function(el, handler) {
			var startX, startY;
			if (s.tap) {
				el.bind('touchstart', function(e) {
					e.preventDefault();
					startX = getCoord(e, 'X');
					startY = getCoord(e, 'Y');
				}).bind('touchend', function(e) {
					if (Math.abs(getCoord(e, 'X') - startX) < 20 && Math.abs(getCoord(e, 'Y') - startY) < 20) {
						handler.call(this, e);
					}
					tap = true;
					setTimeout(function() {
						tap = false;
					}, 300);
				});
			}
			el.bind('click', function(e) {
				if (!tap) {
					handler.call(this, e);
				}
			});
		};
		that.show = function(prevAnim) {
			if (s.disabled || visible) {
				return false;
			}
			if (s.display == 'top') {
				anim = 'slidedown';
			}
			if (s.display == 'bottom') {
				anim = 'slideup';
			}
			read();
			event('onBeforeShow', [dw]);
			var l = 0,
				i, label, mAnim = '';
			if (anim && !prevAnim) {
				mAnim = 'dw-' + anim + ' dw-in';
			}
			var html = '<div class="dw-trans ' + s.theme + ' dw-' + s.display + '">' + (s.display == 'inline' ? '<div class="dw dwbg dwi"><div class="dwwr">' : '<div class="dw-persp">' + '<div class="dwo"></div><div class="dw dwbg ' + mAnim + '"><div class="dw-arrw"><div class="dw-arrw-i"><div class="dw-arr"></div></div></div><div class="dwwr">' + (s.headerText ? '<div class="dwv"></div>' : ''));
			for (i = 0; i < s.wheels.length; i++) {
				html += '<div class="dwc' + (s.mode != 'scroller' ? ' dwpm' : ' dwsc') + (s.showLabel ? '' : ' dwhl') + '"><div class="dwwc dwrc"><table cellpadding="0" cellspacing="0"><tr>';
				for (label in s.wheels[i]) {
					warr[l] = s.wheels[i][label];
					html += '<td><div class="dwwl dwrc dwwl' + l + '">' + (s.mode != 'scroller' ? '<div class="dwwb dwwbp" style="height:' + hi + 'px;line-height:' + hi + 'px;"><span>+</span></div><div class="dwwb dwwbm" style="height:' + hi + 'px;line-height:' + hi + 'px;"><span>&ndash;</span></div>' : '') + '<div class="dwl">' + label + '</div><div class="dww" style="height:' + (s.rows * hi) + 'px;min-width:' + s.width + 'px;"><div class="dw-ul">';
					html += generateWheelItems(l);
					html += '</div><div class="dwwo"></div></div><div class="dwwol"></div></div></td>';
					l++;
				}
				html += '</tr></table></div></div>';
			}
			html += (s.display != 'inline' ? '<div class="dwbc' + (s.button3 ? ' dwbc-p' : '') + '"><span class="dwbw dwb-s"><span class="dwb">' + s.setText + '</span></span>' + (s.button3 ? '<span class="dwbw dwb-n"><span class="dwb">' + s.button3Text + '</span></span>' : '') + '<span class="dwbw dwb-c"><span class="dwb">' + s.cancelText + '</span></span></div></div>' : '<div class="dwcc"></div>') + '</div></div></div>';
			dw = $(html);
			scrollToPos();
			event('onMarkupReady', [dw]);
			if (s.display != 'inline') {
				dw.appendTo('body');
				setTimeout(function() {
					dw.removeClass('dw-trans').find('.dw').removeClass(mAnim);
				}, 350);
			} else if (elm.is('div')) {
				elm.html(dw);
			} else {
				dw.insertAfter(elm);
			}
			event('onMarkupInserted', [dw]);
			visible = true;
			theme.init(dw, that);
			if (s.display != 'inline') {
				that.tap($('.dwb-s span', dw), function() {
					if (that.hide(false, 'set') !== false) {
						that.setValue(false, true);
						event('onSelect', [that.val]);
					}
				});
				that.tap($('.dwb-c span', dw), function() {
					that.cancel();
				});
				if (s.button3) {
					that.tap($('.dwb-n span', dw), s.button3);
				}
				if (s.scrollLock) {
					dw.bind('touchmove', function(e) {
						if (mh <= wh && mw <= ww) {
							e.preventDefault();
						}
					});
				}
				$('input,select,button').each(function() {
					if (!$(this).prop('disabled')) {
						$(this).addClass('dwtd').prop('disabled', true);
					}
				});
				position();
				$(window).bind('resize.dw', function() {
					clearTimeout(debounce);
					debounce = setTimeout(function() {
						position(true);
					}, 100);
				});
			}
			dw.delegate('.dwwl', 'DOMMouseScroll mousewheel', function(e) {
				if (!isReadOnly(this)) {
					e.preventDefault();
					e = e.originalEvent;
					var delta = e.wheelDelta ? (e.wheelDelta / 120) : (e.detail ? (-e.detail / 3) : 0),
						t = $('.dw-ul', this),
						p = +t.data('pos'),
						val = Math.round(p - delta);
					setGlobals(t);
					calc(t, val, delta < 0 ? 1 : 2);
				}
			}).delegate('.dwb, .dwwb', START_EVENT, function(e) {
				$(this).addClass('dwb-a');
			}).delegate('.dwwb', START_EVENT, function(e) {
				e.stopPropagation();
				e.preventDefault();
				var w = $(this).closest('.dwwl');
				if (testTouch(e) && !isReadOnly(w) && !w.hasClass('dwa')) {
					click = true;
					var t = w.find('.dw-ul'),
						func = $(this).hasClass('dwwbp') ? plus : minus;
					setGlobals(t);
					clearInterval(timer);
					timer = setInterval(function() {
						func(t);
					}, s.delay);
					func(t);
				}
			}).delegate('.dwwl', START_EVENT, function(e) {
				e.preventDefault();
				if (testTouch(e) && !move && !isReadOnly(this) && !click) {
					move = true;
					$(document).bind(MOVE_EVENT, onMove);
					target = $('.dw-ul', this);
					scrollable = s.mode != 'clickpick';
					pos = +target.data('pos');
					setGlobals(target);
					moved = iv[index] !== undefined;
					start = getCoord(e, 'Y');
					startTime = new Date();
					stop = start;
					that.scroll(target, index, pos, 0.001);
					if (scrollable) {
						target.closest('.dwwl').addClass('dwa');
					}
				}
			});
			event('onShow', [dw, v]);
		};
		that.hide = function(prevAnim, btn) {
			if (!visible || event('onClose', [v, btn]) === false) {
				return false;
			}
			$('.dwtd').prop('disabled', false).removeClass('dwtd');
			elm.blur();
			if (dw) {
				if (s.display != 'inline' && anim && !prevAnim) {
					dw.addClass('dw-trans').find('.dw').addClass('dw-' + anim + ' dw-out');
					setTimeout(function() {
						dw.remove();
						dw = null;
					}, 350);
				} else {
					dw.remove();
					dw = null;
				}
				visible = false;
				pixels = {};
				$(window).unbind('.dw');
			}
		};
		that.cancel = function() {
			if (that.hide(false, 'cancel') !== false) {
				event('onCancel', [that.val]);
			}
		};
		that.init = function(ss) {
			theme = extend({
				defaults: {},
				init: empty
			}, ms.themes[ss.theme || s.theme]);
			lang = ms.i18n[ss.lang || s.lang];
			extend(settings, ss);
			extend(s, theme.defaults, lang, settings);
			that.settings = s;
			elm.unbind('.dw');
			var preset = ms.presets[s.preset];
			if (preset) {
				pres = preset.call(e, that);
				extend(s, pres, settings);
				extend(methods, pres.methods);
			}
			m = Math.floor(s.rows / 2);
			hi = s.height;
			anim = s.animate;
			if (elm.data('dwro') !== undefined) {
				e.readOnly = bool(elm.data('dwro'));
			}
			if (visible) {
				that.hide();
			}
			if (s.display == 'inline') {
				that.show();
			} else {
				read();
				if (input && s.showOnFocus) {
					elm.data('dwro', e.readOnly);
					e.readOnly = true;
					elm.bind('focus.dw', function() {
						that.show();
					});
				}
			}
		};
		that.trigger = function(name, params) {
			return event(name, params);
		};
		that.values = null;
		that.val = null;
		that.temp = null;
		that._selectedValues = {};
		that.init(settings);
	}

	function testProps(props) {
		var i;
		for (i in props) {
			if (mod[props[i]] !== undefined) {
				return true;
			}
		}
		return false;
	}

	function testPrefix() {
		var prefixes = ['Webkit', 'Moz', 'O', 'ms'],
			p;
		for (p in prefixes) {
			if (testProps([prefixes[p] + 'Transform'])) {
				return '-' + prefixes[p].toLowerCase();
			}
		}
		return '';
	}

	function getInst(e) {
		return scrollers[e.id];
	}

	function getCoord(e, c) {
		var org = e.originalEvent,
			ct = e.changedTouches;
		return ct || (org && org.changedTouches) ? (org ? org.changedTouches[0]['page' + c] : ct[0]['page' + c]) : e['page' + c];
	}

	function bool(v) {
		return (v === true || v == 'true');
	}

	function constrain(val, min, max) {
		val = val > max ? max : val;
		val = val < min ? min : val;
		return val;
	}

	function calc(t, val, dir, anim, orig) {
		val = constrain(val, min, max);
		var cell = $('.dw-li', t).eq(val),
			o = orig === undefined ? val : orig,
			idx = index,
			time = anim ? (val == o ? 0.1 : Math.abs((val - o) * 0.1)) : 0;
		inst.temp[idx] = cell.attr('data-val');
		inst.scroll(t, idx, val, time, orig);
		setTimeout(function() {
			inst.validate(idx, dir, time, orig);
		}, 10);
	}

	function init(that, method, args) {
		if (methods[method]) {
			return methods[method].apply(that, Array.prototype.slice.call(args, 1));
		}
		if (typeof method === 'object') {
			return methods.init.call(that, method);
		}
		return that;
	}
	var scrollers = {},
		timer, empty = function() {},
		h, min, max, inst, date = new Date(),
		uuid = date.getTime(),
		move, click, target, index, start, stop, startTime, pos, moved, scrollable, mod = document.createElement('modernizr').style,
		has3d = testProps(['perspectiveProperty', 'WebkitPerspective', 'MozPerspective', 'OPerspective', 'msPerspective']),
		prefix = testPrefix(),
		extend = $.extend,
		tap, touch, START_EVENT = 'touchstart mousedown',
		MOVE_EVENT = 'touchmove mousemove',
		END_EVENT = 'touchend mouseup',
		onMove = function(e) {
			if (scrollable) {
				e.preventDefault();
				stop = getCoord(e, 'Y');
				inst.scroll(target, index, constrain(pos + (start - stop) / h, min - 1, max + 1));
			}
			moved = true;
		},
		defaults = {
			width: 70,
			height: 40,
			rows: 3,
			delay: 300,
			disabled: false,
			readonly: false,
			showOnFocus: true,
			showLabel: true,
			wheels: [],
			theme: '',
			headerText: '{value}',
			display: 'modal',
			mode: 'scroller',
			preset: '',
			lang: 'en-US',
			setText: 'Set',
			cancelText: 'Cancel',
			scrollLock: true,
			tap: true,
			formatResult: function(d) {
				return d.join(' ');
			},
			parseValue: function(value, inst) {
				var w = inst.settings.wheels,
					val = value.split(' '),
					ret = [],
					j = 0,
					i, l, v;
				for (i = 0; i < w.length; i++) {
					for (l in w[i]) {
						if (w[i][l][val[j]] !== undefined) {
							ret.push(val[j]);
						} else {
							for (v in w[i][l]) {
								ret.push(v);
								break;
							}
						}
						j++;
					}
				}
				return ret;
			}
		},
		methods = {
			init: function(options) {
				if (options === undefined) {
					options = {};
				}
				return this.each(function() {
					if (!this.id) {
						uuid += 1;
						this.id = 'scoller' + uuid;
					}
					scrollers[this.id] = new Scroller(this, options);
				});
			},
			enable: function() {
				return this.each(function() {
					var inst = getInst(this);
					if (inst) {
						inst.enable();
					}
				});
			},
			disable: function() {
				return this.each(function() {
					var inst = getInst(this);
					if (inst) {
						inst.disable();
					}
				});
			},
			isDisabled: function() {
				var inst = getInst(this[0]);
				if (inst) {
					return inst.settings.disabled;
				}
			},
			isVisible: function() {
				var inst = getInst(this[0]);
				if (inst) {
					return inst.isVisible();
				}
			},
			option: function(option, value) {
				return this.each(function() {
					var inst = getInst(this);
					if (inst) {
						var obj = {};
						if (typeof option === 'object') {
							obj = option;
						} else {
							obj[option] = value;
						}
						inst.init(obj);
					}
				});
			},
			setValue: function(d, fill, time, temp) {
				return this.each(function() {
					var inst = getInst(this);
					if (inst) {
						inst.temp = d;
						inst.setValue(true, fill, time, temp);
					}
				});
			},
			getInst: function() {
				return getInst(this[0]);
			},
			getValue: function() {
				var inst = getInst(this[0]);
				if (inst) {
					return inst.values;
				}
			},
			getValues: function() {
				var inst = getInst(this[0]);
				if (inst) {
					return inst.getValues();
				}
			},
			show: function() {
				var inst = getInst(this[0]);
				if (inst) {
					return inst.show();
				}
			},
			hide: function() {
				return this.each(function() {
					var inst = getInst(this);
					if (inst) {
						inst.hide();
					}
				});
			},
			destroy: function() {
				return this.each(function() {
					var inst = getInst(this);
					if (inst) {
						inst.hide();
						$(this).unbind('.dw');
						delete scrollers[this.id];
						if ($(this).is('input')) {
							this.readOnly = bool($(this).data('dwro'));
						}
					}
				});
			}
		};
	$(document).bind(END_EVENT, function(e) {
		if (move) {
			var time = new Date() - startTime,
				val = constrain(pos + (start - stop) / h, min - 1, max + 1),
				speed, dist, tindex, ttop = target.offset().top;
			if (time < 300) {
				speed = (stop - start) / time;
				dist = (speed * speed) / (2 * 0.0006);
				if (stop - start < 0) {
					dist = -dist;
				}
			} else {
				dist = stop - start;
			}
			tindex = Math.round(pos - dist / h);
			if (!dist && !moved) {
				var idx = Math.floor((stop - ttop) / h),
					li = $('.dw-li', target).eq(idx),
					hl = scrollable;
				if (inst.trigger('onValueTap', [li]) !== false) {
					tindex = idx;
				} else {
					hl = true;
				}
				if (hl) {
					li.addClass('dw-hl');
					setTimeout(function() {
						li.removeClass('dw-hl');
					}, 200);
				}
			}
			if (scrollable) {
				calc(target, tindex, 0, true, Math.round(val));
			}
			move = false;
			target = null;
			$(document).unbind(MOVE_EVENT, onMove);
		}
		if (click) {
			clearInterval(timer);
			click = false;
		}
		$('.dwb-a').removeClass('dwb-a');
	}).bind('mouseover mouseup mousedown click', function(e) {
		if (tap) {
			e.stopPropagation();
			e.preventDefault();
			return false;
		}
	});
	$.fn.mobiscroll = function(method) {
		extend(this, $.mobiscroll.shorts);
		return init(this, method, arguments);
	};
	$.mobiscroll = $.mobiscroll || {
		setDefaults: function(o) {
			extend(defaults, o);
		},
		presetShort: function(name) {
			this.shorts[name] = function(method) {
				return init(this, extend(method, {
					preset: name
				}), arguments);
			};
		},
		shorts: {},
		presets: {},
		themes: {},
		i18n: {}
	};
	$.scroller = $.scroller || $.mobiscroll;
	$.fn.scroller = $.fn.scroller || $.fn.mobiscroll;
	$.mobiscroll.i18n.zh = $.extend($.mobiscroll.i18n.zh, {
		dateFormat: 'yyyy-mm-dd',
		dateOrder: 'yymmdd',
		dayNames: ['周日', '周一;', '周二;', '周三', '周四', '周五', '周六'],
		dayNamesShort: ['日', '一', '二', '三', '四', '五', '六'],
		dayText: '日',
		hourText: '时',
		minuteText: '分',
		monthNames: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
		monthNamesShort: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
		monthText: '月',
		secText: '秒',
		timeFormat: 'HH:ii',
		timeWheels: 'HHii',
		yearText: '年'
	});
	$.mobiscroll.i18n.zh = $.extend($.mobiscroll.i18n.zh, {
		setText: '确定',
		cancelText: '取消'
	});
	var theme = {
		defaults: {
			dateOrder: 'Mddyy',
			mode: 'mixed',
			rows: 5,
			width: 70,
			height: 36,
			showLabel: true,
			useShortLabels: true
		}
	}
	$.mobiscroll.themes['android-ics'] = theme;
	$.mobiscroll.themes['android-ics light'] = theme;
})(jQuery);