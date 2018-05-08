/* ------------------------------------------------------------------------ */
/* Plugins
/* ------------------------------------------------------------------------ */
/*
 * jQuery Superfish Menu Plugin - v1.7.8
 * Copyright (c) 2016 Joel Birch
 *
 * Dual licensed under the MIT and GPL licenses:
 *	http://www.opensource.org/licenses/mit-license.php
 *	http://www.gnu.org/licenses/gpl.html
 */

;!function(a,b){"use strict";var c=function(){var c={bcClass:"sf-breadcrumb",menuClass:"sf-js-enabled",anchorClass:"sf-with-ul",menuArrowClass:"sf-arrows"},d=function(){var b=/^(?![\w\W]*Windows Phone)[\w\W]*(iPhone|iPad|iPod)/i.test(navigator.userAgent);return b&&a("html").css("cursor","pointer").on("click",a.noop),b}(),e=function(){var a=document.documentElement.style;return"behavior"in a&&"fill"in a&&/iemobile/i.test(navigator.userAgent)}(),f=function(){return!!b.PointerEvent}(),g=function(a,b,d){var e,f=c.menuClass;b.cssArrows&&(f+=" "+c.menuArrowClass),e=d?"addClass":"removeClass",a[e](f)},h=function(b,d){return b.find("li."+d.pathClass).slice(0,d.pathLevels).addClass(d.hoverClass+" "+c.bcClass).filter(function(){return a(this).children(d.popUpSelector).hide().show().length}).removeClass(d.pathClass)},i=function(a,b){var d=b?"addClass":"removeClass";a.children("a")[d](c.anchorClass)},j=function(a){var b=a.css("ms-touch-action"),c=a.css("touch-action");c=c||b,c="pan-y"===c?"auto":"pan-y",a.css({"ms-touch-action":c,"touch-action":c})},k=function(a){return a.closest("."+c.menuClass)},l=function(a){return k(a).data("sfOptions")},m=function(){var b=a(this),c=l(b);clearTimeout(c.sfTimer),b.siblings().superfish("hide").end().superfish("show")},n=function(b){b.retainPath=a.inArray(this[0],b.$path)>-1,this.superfish("hide"),this.parents("."+b.hoverClass).length||(b.onIdle.call(k(this)),b.$path.length&&a.proxy(m,b.$path)())},o=function(){var b=a(this),c=l(b);d?a.proxy(n,b,c)():(clearTimeout(c.sfTimer),c.sfTimer=setTimeout(a.proxy(n,b,c),c.delay))},p=function(b){var c=a(this),d=l(c),e=c.siblings(b.data.popUpSelector);return d.onHandleTouch.call(e)===!1?this:void(e.length>0&&e.is(":hidden")&&(c.one("click.superfish",!1),"MSPointerDown"===b.type||"pointerdown"===b.type?c.trigger("focus"):a.proxy(m,c.parent("li"))()))},q=function(b,c){var g="li:has("+c.popUpSelector+")";a.fn.hoverIntent&&!c.disableHI?b.hoverIntent(m,o,g):b.on("mouseenter.superfish",g,m).on("mouseleave.superfish",g,o);var h="MSPointerDown.superfish";f&&(h="pointerdown.superfish"),d||(h+=" touchend.superfish"),e&&(h+=" mousedown.superfish"),b.on("focusin.superfish","li",m).on("focusout.superfish","li",o).on(h,"a",c,p)};return{hide:function(b){if(this.length){var c=this,d=l(c);if(!d)return this;var e=d.retainPath===!0?d.$path:"",f=c.find("li."+d.hoverClass).add(this).not(e).removeClass(d.hoverClass).children(d.popUpSelector),g=d.speedOut;if(b&&(f.show(),g=0),d.retainPath=!1,d.onBeforeHide.call(f)===!1)return this;f.stop(!0,!0).animate(d.animationOut,g,function(){var b=a(this);d.onHide.call(b)})}return this},show:function(){var a=l(this);if(!a)return this;var b=this.addClass(a.hoverClass),c=b.children(a.popUpSelector);return a.onBeforeShow.call(c)===!1?this:(c.stop(!0,!0).animate(a.animation,a.speed,function(){a.onShow.call(c)}),this)},destroy:function(){return this.each(function(){var b,d=a(this),e=d.data("sfOptions");return e?(b=d.find(e.popUpSelector).parent("li"),clearTimeout(e.sfTimer),g(d,e),i(b),j(d),d.off(".superfish").off(".hoverIntent"),b.children(e.popUpSelector).attr("style",function(a,b){return b.replace(/display[^;]+;?/g,"")}),e.$path.removeClass(e.hoverClass+" "+c.bcClass).addClass(e.pathClass),d.find("."+e.hoverClass).removeClass(e.hoverClass),e.onDestroy.call(d),void d.removeData("sfOptions")):!1})},init:function(b){return this.each(function(){var d=a(this);if(d.data("sfOptions"))return!1;var e=a.extend({},a.fn.superfish.defaults,b),f=d.find(e.popUpSelector).parent("li");e.$path=h(d,e),d.data("sfOptions",e),g(d,e,!0),i(f,!0),j(d),q(d,e),f.not("."+c.bcClass).superfish("hide",!0),e.onInit.call(this)})}}}();a.fn.superfish=function(b,d){return c[b]?c[b].apply(this,Array.prototype.slice.call(arguments,1)):"object"!=typeof b&&b?a.error("Method "+b+" does not exist on jQuery.fn.superfish"):c.init.apply(this,arguments)},a.fn.superfish.defaults={popUpSelector:"ul,.sf-mega",hoverClass:"sfHover",pathClass:"overrideThisToUse",pathLevels:1,delay:800,animation:{opacity:"show"},animationOut:{opacity:"hide"},speed:"normal",speedOut:"fast",cssArrows:!0,disableHI:!1,onInit:a.noop,onBeforeShow:a.noop,onShow:a.noop,onBeforeHide:a.noop,onHide:a.noop,onIdle:a.noop,onDestroy:a.noop,onHandleTouch:a.noop}}(jQuery,window);

/*
 * hoverIntent
 */
 !function(e){e.fn.hoverIntent=function(t,n,o){var r={interval:100,sensitivity:6,timeout:0};r="object"==typeof t?e.extend(r,t):e.isFunction(n)?e.extend(r,{over:t,out:n,selector:o}):e.extend(r,{over:t,out:t,selector:n});var v,i,u,s,h=function(e){v=e.pageX,i=e.pageY},I=function(t,n){return n.hoverIntent_t=clearTimeout(n.hoverIntent_t),Math.sqrt((u-v)*(u-v)+(s-i)*(s-i))<r.sensitivity?(e(n).off("mousemove.hoverIntent",h),n.hoverIntent_s=!0,r.over.apply(n,[t])):(u=v,s=i,n.hoverIntent_t=setTimeout(function(){I(t,n)},r.interval),void 0)},a=function(e,t){return t.hoverIntent_t=clearTimeout(t.hoverIntent_t),t.hoverIntent_s=!1,r.out.apply(t,[e])},c=function(t){var n=e.extend({},t),o=this;o.hoverIntent_t&&(o.hoverIntent_t=clearTimeout(o.hoverIntent_t)),"mouseenter"===t.type?(u=n.pageX,s=n.pageY,e(o).on("mousemove.hoverIntent",h),o.hoverIntent_s||(o.hoverIntent_t=setTimeout(function(){I(n,o)},r.interval))):(e(o).off("mousemove.hoverIntent",h),o.hoverIntent_s&&(o.hoverIntent_t=setTimeout(function(){a(n,o)},r.timeout)))};return this.on({"mouseenter.hoverIntent":c,"mouseleave.hoverIntent":c},r.selector)}}(jQuery);

/*!
 * jQuery SimpleSelect
 * http://pioul.fr/jquery-simpleselect
 *
 * Copyright 2014, Philippe Masset
 * Dual licensed under the MIT or GPL Version 2 licenses
 */
!function(a){"use strict";var b=null,c=null,d=[],e=!1,f=!1,g=function(b){b=a.extend({},{fadingDuration:b&&b.fadeSpeed||0,containerMargin:5,displayContainerInside:"window"},b),this.each(function(){var c=a(this).addClass("simpleselected"),d=a('<div class="simpleselect"></div>'),f=a('<div class="placeholder"></div>').appendTo(d),g=a('<div class="options"></div>').appendTo(d),h=c.attr("id");h&&d.attr("id","simpleselect_"+h),c.off("change"),c.attr("size",2);var i={select:c,selectOptions:null,simpleselect:d,ssPlaceholder:f,ssOptionsContainer:g,ssOptionsContainerHeight:null,ssOptions:null,canBeClosed:!0,isActive:!1,isScrollable:!1,isDisabled:!1,options:b};d.data("simpleselect",i).on({mousedown:function(){i.canBeClosed=!1},click:function(b){var c=a(b.target);c.hasClass("placeholder")?t.setActive.call(i):c.hasClass("option")&&(e=!0,o.call(i,c),t.setInactive.call(i))},mouseup:function(){i.canBeClosed=!0},mouseover:function(b){var c=a(b.target);c.hasClass("option")&&m.call(i,c)}}),c.data("simpleselect",i).on({keydown:function(a){13==a.keyCode&&t.setInactive.call(i)},focus:function(){e||t.setActive.call(i)},blur:function(){i.canBeClosed&&t.setInactive.call(i)},change:function(a,b){b||a.stopImmediatePropagation();var c=n.call(i);m.call(i,c,!0)},click:function(a){a.stopPropagation()}}),c.after(d);var j=a('<div class="hidden_select_container"></div>');c.after(j).appendTo(j),k.call(i),l.call(i),t.updatePresentationDependentVariables.call(i)})},h=function(){b=a(window).height()},i=function(a){d.push(a)},j=function(b){d=a.grep(d,function(a){return a!==b})},k=function(){this.selectOptions=this.select.find("option");var b="",c=function(a){b+='<div class="option">'+a.text()+"</div>"},d=function(d){b+='<div class="optgroup">';var f=d.attr("label");f&&(b+='<div class="optgroup-label">'+e(f)+"</div>"),d.children("option").each(function(){c(a(this))}),b+="</div>"},e=function(a){return a.replace(/&/g,"&amp;").replace(/"/g,"&quot;").replace(/'/g,"&#039;").replace(/</g,"&lt;").replace(/>/g,"&gt;")},f=this.select.children("optgroup, option"),g=!1;f.each(function(){var b=a(this);b.is("optgroup")?(d(b),g=!0):c(b)}),this.ssOptions=this.ssOptionsContainer.html(b).find(".option"),this.ssPlaceholder.text(n.call(this).text())},l=function(){this.isDisabled=this.select.prop("disabled"),this.simpleselect[this.isDisabled?"addClass":"removeClass"]("disabled")},m=function(a,b){if(this.ssOptions.removeClass("active"),a.addClass("active"),b&&this.isScrollable){var g,c=a.position(),d=this.ssOptionsContainer.scrollTop(),e=c.top,f=this.ssOptionsContainer.height()-(c.top+a.outerHeight());0>e?g=d+e:0>f&&(g=d-f),this.ssOptionsContainer.scrollTop(g)}},n=function(){var b=p.call(this),c=b.length?this.selectOptions.index(b):0;return a(this.ssOptions[c])},o=function(b){var c=a(this.selectOptions[this.ssOptions.index(b)]);this.select.val(c.val())},p=function(){return this.selectOptions.filter(":selected").first()},q=function(){this.ssOptionsContainer.css({height:"auto","overflow-y":"visible"})},r=function(){this.ssOptionsContainer.hide(),this.ssOptionsContainer[0].offsetHeight,this.ssOptionsContainer.show()},s=function(d){q.call(this);var e,f,g,h,i,j,k,l="window"==this.options.displayContainerInside,m=a.proxy(function(){e=d.position(),f=this.ssPlaceholderOffset.top-this.options.containerMargin-(l?a(window).scrollTop():0),g=(l?b:c)-f-this.ssPlaceholderHeight-2*this.options.containerMargin,h=f-e.top,i=g-(this.ssOptionsContainerOuterHeight-e.top-this.ssPlaceholderHeight),j=0>h?Math.abs(h):0,k=0>i?Math.abs(i):0},this);m();var n=this.isScrollable;if(this.isScrollable=0>h||0>i,this.isScrollable){this.ssOptionsContainer.css({height:"auto","overflow-y":"scroll"}),this.ssOptionsContainer.height()!=this.ssOptionsContainerHeight&&(r.call(this),t.updatePresentationDependentVariables.call(this,"ssOptionsContainer",!1),m());var o=this.ssOptionsContainer.height()-j-k;this.ssOptionsContainer.css({top:-(e.top-j)}).height(o).scrollTop(j)}else this.ssOptionsContainer.css({top:-e.top}),n&&r.call(this)},t={updatePresentationDependentVariables:function(a,b){a&&"ssPlaceholder"!=a||(this.ssPlaceholderOffset=this.ssPlaceholder.offset(),this.ssPlaceholderHeight=this.ssPlaceholder.outerHeight()),a&&"ssOptionsContainer"!=a||(b!==!1&&q.call(this),this.ssOptionsContainerOuterHeight=this.ssOptionsContainer.outerHeight(!0),this.ssOptionsContainerHeight=this.ssOptionsContainer.height())},refreshContents:function(){k.call(this),t.updatePresentationDependentVariables.call(this)},refreshState:function(){l.call(this)},disable:function(){this.select.prop("disabled",!0),t.refreshState.call(this)},enable:function(){this.select.prop("disabled",!1),t.refreshState.call(this)},setActive:function(){if(!this.isActive&&!this.isDisabled&&this.ssOptions.length){this.lastValue=this.select.val(),this.simpleselect.addClass("active"),this.isActive=!0,i.call(this,this.simpleselect);var b=n.call(this);m.call(this,b),c=a(document).height(),this.ssOptionsContainer.fadeTo(0,0).fadeTo(this.options.fadingDuration,1),this.select.is(":focus")||this.select.focus(),s.call(this,b),f=!0}},setInactive:function(){if(this.isActive){this.simpleselect.removeClass("active"),this.isActive=!1,j.call(this,this.simpleselect),this.ssOptionsContainer.fadeOut(this.options.fadingDuration),this.select.is(":focus")&&this.select.blur();var a=this.select.val();this.lastValue!=a&&(this.ssPlaceholder.text(p.call(this).text()),this.select.trigger("change",[!0]))}}};a.fn.simpleselect=function(b){if(t[b]){var c=Array.prototype.slice.call(arguments,1);this.each(function(){t[b].apply(a(this).data("simpleselect"),c)})}else g.apply(this,arguments);return this},a(document).ready(function(){h(),a(window).on("resize.simpleselect",function(){h()}),a(document).on("click.simpleselect keyup.simpleselect",function(a){if("click"==a.type&&(setTimeout(function(){e=!1},0),f))return f=!1,void 0;if("click"==a.type||"keyup"==a.type&&27==a.keyCode){var b=d.length;if(b)for(var c=d.slice(0),g=0;b>g;g++)c[g].simpleselect("setInactive")}})})}(jQuery);

/*!
 * imagesLoaded PACKAGED v3.1.8
 * JavaScript is all like "You images are done yet or what?"
 * MIT License
 */
(function(){function e(){}function t(e,t){for(var n=e.length;n--;)if(e[n].listener===t)return n;return-1}function n(e){return function(){return this[e].apply(this,arguments)}}var i=e.prototype,r=this,o=r.EventEmitter;i.getListeners=function(e){var t,n,i=this._getEvents();if("object"==typeof e){t={};for(n in i)i.hasOwnProperty(n)&&e.test(n)&&(t[n]=i[n])}else t=i[e]||(i[e]=[]);return t},i.flattenListeners=function(e){var t,n=[];for(t=0;e.length>t;t+=1)n.push(e[t].listener);return n},i.getListenersAsObject=function(e){var t,n=this.getListeners(e);return n instanceof Array&&(t={},t[e]=n),t||n},i.addListener=function(e,n){var i,r=this.getListenersAsObject(e),o="object"==typeof n;for(i in r)r.hasOwnProperty(i)&&-1===t(r[i],n)&&r[i].push(o?n:{listener:n,once:!1});return this},i.on=n("addListener"),i.addOnceListener=function(e,t){return this.addListener(e,{listener:t,once:!0})},i.once=n("addOnceListener"),i.defineEvent=function(e){return this.getListeners(e),this},i.defineEvents=function(e){for(var t=0;e.length>t;t+=1)this.defineEvent(e[t]);return this},i.removeListener=function(e,n){var i,r,o=this.getListenersAsObject(e);for(r in o)o.hasOwnProperty(r)&&(i=t(o[r],n),-1!==i&&o[r].splice(i,1));return this},i.off=n("removeListener"),i.addListeners=function(e,t){return this.manipulateListeners(!1,e,t)},i.removeListeners=function(e,t){return this.manipulateListeners(!0,e,t)},i.manipulateListeners=function(e,t,n){var i,r,o=e?this.removeListener:this.addListener,s=e?this.removeListeners:this.addListeners;if("object"!=typeof t||t instanceof RegExp)for(i=n.length;i--;)o.call(this,t,n[i]);else for(i in t)t.hasOwnProperty(i)&&(r=t[i])&&("function"==typeof r?o.call(this,i,r):s.call(this,i,r));return this},i.removeEvent=function(e){var t,n=typeof e,i=this._getEvents();if("string"===n)delete i[e];else if("object"===n)for(t in i)i.hasOwnProperty(t)&&e.test(t)&&delete i[t];else delete this._events;return this},i.removeAllListeners=n("removeEvent"),i.emitEvent=function(e,t){var n,i,r,o,s=this.getListenersAsObject(e);for(r in s)if(s.hasOwnProperty(r))for(i=s[r].length;i--;)n=s[r][i],n.once===!0&&this.removeListener(e,n.listener),o=n.listener.apply(this,t||[]),o===this._getOnceReturnValue()&&this.removeListener(e,n.listener);return this},i.trigger=n("emitEvent"),i.emit=function(e){var t=Array.prototype.slice.call(arguments,1);return this.emitEvent(e,t)},i.setOnceReturnValue=function(e){return this._onceReturnValue=e,this},i._getOnceReturnValue=function(){return this.hasOwnProperty("_onceReturnValue")?this._onceReturnValue:!0},i._getEvents=function(){return this._events||(this._events={})},e.noConflict=function(){return r.EventEmitter=o,e},"function"==typeof define&&define.amd?define("eventEmitter/EventEmitter",[],function(){return e}):"object"==typeof module&&module.exports?module.exports=e:this.EventEmitter=e}).call(this),function(e){function t(t){var n=e.event;return n.target=n.target||n.srcElement||t,n}var n=document.documentElement,i=function(){};n.addEventListener?i=function(e,t,n){e.addEventListener(t,n,!1)}:n.attachEvent&&(i=function(e,n,i){e[n+i]=i.handleEvent?function(){var n=t(e);i.handleEvent.call(i,n)}:function(){var n=t(e);i.call(e,n)},e.attachEvent("on"+n,e[n+i])});var r=function(){};n.removeEventListener?r=function(e,t,n){e.removeEventListener(t,n,!1)}:n.detachEvent&&(r=function(e,t,n){e.detachEvent("on"+t,e[t+n]);try{delete e[t+n]}catch(i){e[t+n]=void 0}});var o={bind:i,unbind:r};"function"==typeof define&&define.amd?define("eventie/eventie",o):e.eventie=o}(this),function(e,t){"function"==typeof define&&define.amd?define(["eventEmitter/EventEmitter","eventie/eventie"],function(n,i){return t(e,n,i)}):"object"==typeof exports?module.exports=t(e,require("wolfy87-eventemitter"),require("eventie")):e.imagesLoaded=t(e,e.EventEmitter,e.eventie)}(window,function(e,t,n){function i(e,t){for(var n in t)e[n]=t[n];return e}function r(e){return"[object Array]"===d.call(e)}function o(e){var t=[];if(r(e))t=e;else if("number"==typeof e.length)for(var n=0,i=e.length;i>n;n++)t.push(e[n]);else t.push(e);return t}function s(e,t,n){if(!(this instanceof s))return new s(e,t);"string"==typeof e&&(e=document.querySelectorAll(e)),this.elements=o(e),this.options=i({},this.options),"function"==typeof t?n=t:i(this.options,t),n&&this.on("always",n),this.getImages(),a&&(this.jqDeferred=new a.Deferred);var r=this;setTimeout(function(){r.check()})}function f(e){this.img=e}function c(e){this.src=e,v[e]=this}var a=e.jQuery,u=e.console,h=u!==void 0,d=Object.prototype.toString;s.prototype=new t,s.prototype.options={},s.prototype.getImages=function(){this.images=[];for(var e=0,t=this.elements.length;t>e;e++){var n=this.elements[e];"IMG"===n.nodeName&&this.addImage(n);var i=n.nodeType;if(i&&(1===i||9===i||11===i))for(var r=n.querySelectorAll("img"),o=0,s=r.length;s>o;o++){var f=r[o];this.addImage(f)}}},s.prototype.addImage=function(e){var t=new f(e);this.images.push(t)},s.prototype.check=function(){function e(e,r){return t.options.debug&&h&&u.log("confirm",e,r),t.progress(e),n++,n===i&&t.complete(),!0}var t=this,n=0,i=this.images.length;if(this.hasAnyBroken=!1,!i)return this.complete(),void 0;for(var r=0;i>r;r++){var o=this.images[r];o.on("confirm",e),o.check()}},s.prototype.progress=function(e){this.hasAnyBroken=this.hasAnyBroken||!e.isLoaded;var t=this;setTimeout(function(){t.emit("progress",t,e),t.jqDeferred&&t.jqDeferred.notify&&t.jqDeferred.notify(t,e)})},s.prototype.complete=function(){var e=this.hasAnyBroken?"fail":"done";this.isComplete=!0;var t=this;setTimeout(function(){if(t.emit(e,t),t.emit("always",t),t.jqDeferred){var n=t.hasAnyBroken?"reject":"resolve";t.jqDeferred[n](t)}})},a&&(a.fn.imagesLoaded=function(e,t){var n=new s(this,e,t);return n.jqDeferred.promise(a(this))}),f.prototype=new t,f.prototype.check=function(){var e=v[this.img.src]||new c(this.img.src);if(e.isConfirmed)return this.confirm(e.isLoaded,"cached was confirmed"),void 0;if(this.img.complete&&void 0!==this.img.naturalWidth)return this.confirm(0!==this.img.naturalWidth,"naturalWidth"),void 0;var t=this;e.on("confirm",function(e,n){return t.confirm(e.isLoaded,n),!0}),e.check()},f.prototype.confirm=function(e,t){this.isLoaded=e,this.emit("confirm",this,t)};var v={};return c.prototype=new t,c.prototype.check=function(){if(!this.isChecked){var e=new Image;n.bind(e,"load",this),n.bind(e,"error",this),e.src=this.src,this.isChecked=!0}},c.prototype.handleEvent=function(e){var t="on"+e.type;this[t]&&this[t](e)},c.prototype.onload=function(e){this.confirm(!0,"onload"),this.unbindProxyEvents(e)},c.prototype.onerror=function(e){this.confirm(!1,"onerror"),this.unbindProxyEvents(e)},c.prototype.confirm=function(e,t){this.isConfirmed=!0,this.isLoaded=e,this.emit("confirm",this,t)},c.prototype.unbindProxyEvents=function(e){n.unbind(e.target,"load",this),n.unbind(e.target,"error",this)},s});

/*!
 * FitVids 1.1
 * Copyright 2013, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
 * Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
 * Released under the WTFPL license - http://sam.zoy.org/wtfpl/
 */
!function($){"use strict";$.fn.fitVids=function(options){var settings={customSelector:null};if(!document.getElementById("fit-vids-style")){var head=document.head||document.getElementsByTagName("head")[0],css=".fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}",div=document.createElement("div");div.innerHTML='<p>x</p><style id="fit-vids-style">'+css+"</style>",head.appendChild(div.childNodes[1])}return options&&$.extend(settings,options),this.each(function(){var selectors=["iframe[src*='player.vimeo.com']","iframe[src*='youtube.com']","iframe[src*='youtube-nocookie.com']","iframe[src*='kickstarter.com'][src*='video.html']","object","embed"];settings.customSelector&&selectors.push(settings.customSelector);var $allVideos=$(this).find(selectors.join(","));$allVideos=$allVideos.not("object object"),$allVideos.each(function(){var $this=$(this);if(!("embed"===this.tagName.toLowerCase()&&$this.parent("object").length||$this.parent(".fluid-width-video-wrapper").length)){$this.css("height")||$this.css("width")||!isNaN($this.attr("height"))&&!isNaN($this.attr("width"))||($this.attr("height",9),$this.attr("width",16));var height="object"===this.tagName.toLowerCase()||$this.attr("height")&&!isNaN(parseInt($this.attr("height"),10))?parseInt($this.attr("height"),10):$this.height(),width=isNaN(parseInt($this.attr("width"),10))?$this.width():parseInt($this.attr("width"),10),aspectRatio=height/width;if(!$this.attr("id")){var videoID="fitvid"+Math.floor(999999*Math.random());$this.attr("id",videoID)}$this.wrap('<div class="fluid-width-video-wrapper"></div>').parent(".fluid-width-video-wrapper").css("padding-top",100*aspectRatio+"%"),$this.removeAttr("height").removeAttr("width")}})})}}(window.jQuery||window.Zepto);

/*!
 * scrollTo
 * Copyright (c) 2007-2015 Ariel Flesler - aflesler<a>gmail<d>com | http://flesler.blogspot.com
 * Licensed under MIT
 * @author Ariel Flesler
 * @version 2.1.1
 */
;(function(f){"use strict";"function"===typeof define&&define.amd?define(["jquery"],f):"undefined"!==typeof module&&module.exports?module.exports=f(require("jquery")):f(jQuery)})(function($){"use strict";function n(a){return!a.nodeName||-1!==$.inArray(a.nodeName.toLowerCase(),["iframe","#document","html","body"])}function h(a){return $.isFunction(a)||$.isPlainObject(a)?a:{top:a,left:a}}var p=$.scrollTo=function(a,d,b){return $(window).scrollTo(a,d,b)};p.defaults={axis:"xy",duration:0,limit:!0};$.fn.scrollTo=function(a,d,b){"object"=== typeof d&&(b=d,d=0);"function"===typeof b&&(b={onAfter:b});"max"===a&&(a=9E9);b=$.extend({},p.defaults,b);d=d||b.duration;var u=b.queue&&1<b.axis.length;u&&(d/=2);b.offset=h(b.offset);b.over=h(b.over);return this.each(function(){function k(a){var k=$.extend({},b,{queue:!0,duration:d,complete:a&&function(){a.call(q,e,b)}});r.animate(f,k)}if(null!==a){var l=n(this),q=l?this.contentWindow||window:this,r=$(q),e=a,f={},t;switch(typeof e){case "number":case "string":if(/^([+-]=?)?\d+(\.\d+)?(px|%)?$/.test(e)){e= h(e);break}e=l?$(e):$(e,q);if(!e.length)return;case "object":if(e.is||e.style)t=(e=$(e)).offset()}var v=$.isFunction(b.offset)&&b.offset(q,e)||b.offset;$.each(b.axis.split(""),function(a,c){var d="x"===c?"Left":"Top",m=d.toLowerCase(),g="scroll"+d,h=r[g](),n=p.max(q,c);t?(f[g]=t[m]+(l?0:h-r.offset()[m]),b.margin&&(f[g]-=parseInt(e.css("margin"+d),10)||0,f[g]-=parseInt(e.css("border"+d+"Width"),10)||0),f[g]+=v[m]||0,b.over[m]&&(f[g]+=e["x"===c?"width":"height"]()*b.over[m])):(d=e[m],f[g]=d.slice&& "%"===d.slice(-1)?parseFloat(d)/100*n:d);b.limit&&/^\d+$/.test(f[g])&&(f[g]=0>=f[g]?0:Math.min(f[g],n));!a&&1<b.axis.length&&(h===f[g]?f={}:u&&(k(b.onAfterFirst),f={}))});k(b.onAfter)}})};p.max=function(a,d){var b="x"===d?"Width":"Height",h="scroll"+b;if(!n(a))return a[h]-$(a)[b.toLowerCase()]();var b="client"+b,k=a.ownerDocument||a.document,l=k.documentElement,k=k.body;return Math.max(l[h],k[h])-Math.min(l[b],k[b])};$.Tween.propHooks.scrollLeft=$.Tween.propHooks.scrollTop={get:function(a){return $(a.elem)[a.prop]()}, set:function(a){var d=this.get(a);if(a.options.interrupt&&a._last&&a._last!==d)return $(a.elem).stop();var b=Math.round(a.now);d!==b&&($(a.elem)[a.prop](b),a._last=this.get(a))}};return p});

// tipsy, facebook style tooltips for jquery
// version 1.0.0a
// (c) 2008-2010 jason frame [jason@onehackoranother.com]
// released under the MIT license
(function($) {
    
    function maybeCall(thing, ctx) {
        return (typeof thing == 'function') ? (thing.call(ctx)) : thing;
    };
    
    function isElementInDOM(ele) {
      while (ele = ele.parentNode) {
        if (ele == document) return true;
      }
      return false;
    };
    
    function Tipsy(element, options) {
        this.$element = $(element);
        this.options = options;
        this.enabled = true;
        this.fixTitle();
    };
    
    Tipsy.prototype = {
        show: function() {
            var title = this.getTitle();
            if (title && this.enabled) {
                var $tip = this.tip();
                
                $tip.find('.tipsy-inner')[this.options.html ? 'html' : 'text'](title);
                $tip[0].className = 'tipsy'; // reset classname in case of dynamic gravity
                $tip.remove().css({top: 0, left: 0, visibility: 'hidden', display: 'block'}).prependTo(document.body);
                
                var pos = $.extend({}, this.$element.offset(), {
                    width: this.$element[0].offsetWidth,
                    height: this.$element[0].offsetHeight
                });
                
                var actualWidth = $tip[0].offsetWidth,
                    actualHeight = $tip[0].offsetHeight,
                    gravity = maybeCall(this.options.gravity, this.$element[0]);
                
                var tp;
                switch (gravity.charAt(0)) {
                    case 'n':
                        tp = {top: pos.top + pos.height + this.options.offset, left: pos.left + pos.width / 2 - actualWidth / 2};
                        break;
                    case 's':
                        tp = {top: pos.top - actualHeight - this.options.offset, left: pos.left + pos.width / 2 - actualWidth / 2};
                        break;
                    case 'e':
                        tp = {top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left - actualWidth - this.options.offset};
                        break;
                    case 'w':
                        tp = {top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left + pos.width + this.options.offset};
                        break;
                }
                
                if (gravity.length == 2) {
                    if (gravity.charAt(1) == 'w') {
                        tp.left = pos.left + pos.width / 2 - 15;
                    } else {
                        tp.left = pos.left + pos.width / 2 - actualWidth + 15;
                    }
                }
                
                $tip.css(tp).addClass('tipsy-' + gravity);
                $tip.find('.tipsy-arrow')[0].className = 'tipsy-arrow tipsy-arrow-' + gravity.charAt(0);
                if (this.options.className) {
                    $tip.addClass(maybeCall(this.options.className, this.$element[0]));
                }
                
                if (this.options.fade) {
                    $tip.stop().css({opacity: 0, display: 'block', visibility: 'visible'}).animate({opacity: this.options.opacity});
                } else {
                    $tip.css({visibility: 'visible', opacity: this.options.opacity});
                }
            }
        },
        
        hide: function() {
            if (this.options.fade) {
                this.tip().stop().fadeOut(function() { $(this).remove(); });
            } else {
                this.tip().remove();
            }
        },
        
        fixTitle: function() {
            var $e = this.$element;
            if ($e.attr('title') || typeof($e.attr('original-title')) != 'string') {
                $e.attr('original-title', $e.attr('title') || '').removeAttr('title');
            }
        },
        
        getTitle: function() {
            var title, $e = this.$element, o = this.options;
            this.fixTitle();
            var title, o = this.options;
            if (typeof o.title == 'string') {
                title = $e.attr(o.title == 'title' ? 'original-title' : o.title);
            } else if (typeof o.title == 'function') {
                title = o.title.call($e[0]);
            }
            title = ('' + title).replace(/(^\s*|\s*$)/, "");
            return title || o.fallback;
        },
        
        tip: function() {
            if (!this.$tip) {
                this.$tip = $('<div class="tipsy"></div>').html('<div class="tipsy-arrow"></div><div class="tipsy-inner"></div>');
                this.$tip.data('tipsy-pointee', this.$element[0]);
            }
            return this.$tip;
        },
        
        validate: function() {
            if (!this.$element[0].parentNode) {
                this.hide();
                this.$element = null;
                this.options = null;
            }
        },
        
        enable: function() { this.enabled = true; },
        disable: function() { this.enabled = false; },
        toggleEnabled: function() { this.enabled = !this.enabled; }
    };
    
    $.fn.tipsy = function(options) {
        
        if (options === true) {
            return this.data('tipsy');
        } else if (typeof options == 'string') {
            var tipsy = this.data('tipsy');
            if (tipsy) tipsy[options]();
            return this;
        }
        
        options = $.extend({}, $.fn.tipsy.defaults, options);
        
        function get(ele) {
            var tipsy = $.data(ele, 'tipsy');
            if (!tipsy) {
                tipsy = new Tipsy(ele, $.fn.tipsy.elementOptions(ele, options));
                $.data(ele, 'tipsy', tipsy);
            }
            return tipsy;
        }
        
        function enter() {
            var tipsy = get(this);
            tipsy.hoverState = 'in';
            if (options.delayIn == 0) {
                tipsy.show();
            } else {
                tipsy.fixTitle();
                setTimeout(function() { if (tipsy.hoverState == 'in') tipsy.show(); }, options.delayIn);
            }
        };
        
        function leave() {
            var tipsy = get(this);
            tipsy.hoverState = 'out';
            if (options.delayOut == 0) {
                tipsy.hide();
            } else {
                setTimeout(function() { if (tipsy.hoverState == 'out') tipsy.hide(); }, options.delayOut);
            }
        };
        
        if (!options.live) this.each(function() { get(this); });
        
        if (options.trigger != 'manual') {
            var binder   = options.live ? 'live' : 'bind',
                eventIn  = options.trigger == 'hover' ? 'mouseenter' : 'focus',
                eventOut = options.trigger == 'hover' ? 'mouseleave' : 'blur';
            this[binder](eventIn, enter)[binder](eventOut, leave);
        }
        
        return this;
        
    };
    
    $.fn.tipsy.defaults = {
        className: null,
        delayIn: 0,
        delayOut: 0,
        fade: false,
        fallback: '',
        gravity: 'n',
        html: false,
        live: false,
        offset: 0,
        opacity: 0.8,
        title: 'title',
        trigger: 'hover'
    };
    
    $.fn.tipsy.revalidate = function() {
      $('.tipsy').each(function() {
        var pointee = $.data(this, 'tipsy-pointee');
        if (!pointee || !isElementInDOM(pointee)) {
          $(this).remove();
        }
      });
    };
    
    // Overwrite this method to provide options on a per-element basis.
    // For example, you could store the gravity in a 'tipsy-gravity' attribute:
    // return $.extend({}, options, {gravity: $(ele).attr('tipsy-gravity') || 'n' });
    // (remember - do not modify 'options' in place!)
    $.fn.tipsy.elementOptions = function(ele, options) {
        return $.metadata ? $.extend({}, options, $(ele).metadata()) : options;
    };
    
    $.fn.tipsy.autoNS = function() {
        return $(this).offset().top > ($(document).scrollTop() + $(window).height() / 2) ? 's' : 'n';
    };
    
    $.fn.tipsy.autoWE = function() {
        return $(this).offset().left > ($(document).scrollLeft() + $(window).width() / 2) ? 'e' : 'w';
    };
    
    /**
     * yields a closure of the supplied parameters, producing a function that takes
     * no arguments and is suitable for use as an autogravity function like so:
     *
     * @param margin (int) - distance from the viewable region edge that an
     *        element should be before setting its tooltip's gravity to be away
     *        from that edge.
     * @param prefer (string, e.g. 'n', 'sw', 'w') - the direction to prefer
     *        if there are no viewable region edges effecting the tooltip's
     *        gravity. It will try to vary from this minimally, for example,
     *        if 'sw' is preferred and an element is near the right viewable 
     *        region edge, but not the top edge, it will set the gravity for
     *        that element's tooltip to be 'se', preserving the southern
     *        component.
     */
     $.fn.tipsy.autoBounds = function(margin, prefer) {
		return function() {
			var dir = {ns: prefer[0], ew: (prefer.length > 1 ? prefer[1] : false)},
			    boundTop = $(document).scrollTop() + margin,
			    boundLeft = $(document).scrollLeft() + margin,
			    $this = $(this);

			if ($this.offset().top < boundTop) dir.ns = 'n';
			if ($this.offset().left < boundLeft) dir.ew = 'w';
			if ($(window).width() + $(document).scrollLeft() - $this.offset().left < margin) dir.ew = 'e';
			if ($(window).height() + $(document).scrollTop() - $this.offset().top < margin) dir.ns = 's';

			return dir.ns + (dir.ew ? dir.ew : '');
		}
	};
    
})(jQuery);

/*
Plugin: jQuery Parallax
Version 1.1.3
Author: Ian Lunn
Twitter: @IanLunn
Author URL: http://www.ianlunn.co.uk/
Plugin URL: http://www.ianlunn.co.uk/plugins/jquery-parallax/

Dual licensed under the MIT and GPL licenses:
http://www.opensource.org/licenses/mit-license.php
http://www.gnu.org/licenses/gpl.html
*/

(function( $ ){
    var $window = $(window);
    var windowHeight = $window.height();

    $window.resize(function () {
        windowHeight = $window.height();
    });

    $.fn.parallax = function(xpos, speedFactor, outerHeight) {
        var $this = $(this);
        var getHeight;
        var firstTop;
        var paddingTop = 0;
        
        //get the starting position of each element to have parallax applied to it      
        $this.each(function(){
            firstTop = $this.offset().top;
        });

        if (outerHeight) {
            getHeight = function(jqo) {
                return jqo.outerHeight(true);
            };
        } else {
            getHeight = function(jqo) {
                return jqo.height();
            };
        }
            
        // setup defaults if arguments aren't specified
        if (arguments.length < 1 || xpos === null) xpos = "50%";
        if (arguments.length < 2 || speedFactor === null) speedFactor = 0.1;
        if (arguments.length < 3 || outerHeight === null) outerHeight = true;
        
        // function to be called whenever the window is scrolled or resized
        function update(){
            var pos = $window.scrollTop();              

            $this.each(function(){
                var $element = $(this);
                var top = $element.offset().top;
                var height = getHeight($element);

                // Check if totally above or totally below viewport
                // if (top + height < pos || top > pos + windowHeight) {
                //     return;
                // }

                $this.css('backgroundPosition', xpos + " " + Math.round((firstTop - pos) * speedFactor) + "px");
            });
        }       

        $window.bind('scroll', update).resize(update);
        update();
    };
})(jQuery);

/*!
 * jquery.countTo()
 * https://github.com/mhuggins/jquery-countTo
 *
 * Copyright 2013 Adam Coulombe
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
(function(e){function t(e,t){return e.toFixed(t.decimals)}e.fn.countTo=function(t){t=t||{};return e(this).each(function(){function l(){a+=i;u++;c(a);if(typeof n.onUpdate=="function"){n.onUpdate.call(s,a)}if(u>=r){o.removeData("countTo");clearInterval(f.interval);a=n.to;if(typeof n.onComplete=="function"){n.onComplete.call(s,a)}}}function c(e){var t=n.formatter.call(s,e,n);o.text(t)}var n=e.extend({},e.fn.countTo.defaults,{from:e(this).data("from"),to:e(this).data("to"),speed:e(this).data("speed"),refreshInterval:e(this).data("refresh-interval"),decimals:e(this).data("decimals")},t);var r=Math.ceil(n.speed/n.refreshInterval),i=(n.to-n.from)/r;var s=this,o=e(this),u=0,a=n.from,f=o.data("countTo")||{};o.data("countTo",f);if(f.interval){clearInterval(f.interval)}f.interval=setInterval(l,n.refreshInterval);c(a)})};e.fn.countTo.defaults={from:0,to:0,speed:1e3,refreshInterval:100,decimals:0,formatter:t,onUpdate:null,onComplete:null}})(jQuery)

/*!
 * Packery layout mode PACKAGED v1.1.0
 * sub-classes Packery
 * http://packery.metafizzy.com
 */
!function(a){function b(a){return new RegExp("(^|\\s+)"+a+"(\\s+|$)")}function c(a,b){var c=d(a,b)?f:e;c(a,b)}var d,e,f;"classList"in document.documentElement?(d=function(a,b){return a.classList.contains(b)},e=function(a,b){a.classList.add(b)},f=function(a,b){a.classList.remove(b)}):(d=function(a,c){return b(c).test(a.className)},e=function(a,b){d(a,b)||(a.className=a.className+" "+b)},f=function(a,c){a.className=a.className.replace(b(c)," ")});var g={hasClass:d,addClass:e,removeClass:f,toggleClass:c,has:d,add:e,remove:f,toggle:c};"function"==typeof define&&define.amd?define("classie/classie",g):"object"==typeof exports?module.exports=g:a.classie=g}(window),function(a){function b(){function a(b){for(var c in a.defaults)this[c]=a.defaults[c];for(c in b)this[c]=b[c]}return c.Rect=a,a.defaults={x:0,y:0,width:0,height:0},a.prototype.contains=function(a){var b=a.width||0,c=a.height||0;return this.x<=a.x&&this.y<=a.y&&this.x+this.width>=a.x+b&&this.y+this.height>=a.y+c},a.prototype.overlaps=function(a){var b=this.x+this.width,c=this.y+this.height,d=a.x+a.width,e=a.y+a.height;return this.x<d&&b>a.x&&this.y<e&&c>a.y},a.prototype.getMaximalFreeRects=function(b){if(!this.overlaps(b))return!1;var c,d=[],e=this.x+this.width,f=this.y+this.height,g=b.x+b.width,h=b.y+b.height;return this.y<b.y&&(c=new a({x:this.x,y:this.y,width:this.width,height:b.y-this.y}),d.push(c)),e>g&&(c=new a({x:g,y:this.y,width:e-g,height:this.height}),d.push(c)),f>h&&(c=new a({x:this.x,y:h,width:this.width,height:f-h}),d.push(c)),this.x<b.x&&(c=new a({x:this.x,y:this.y,width:b.x-this.x,height:this.height}),d.push(c)),d},a.prototype.canFit=function(a){return this.width>=a.width&&this.height>=a.height},a}var c=a.Packery=function(){};"function"==typeof define&&define.amd?define("packery/js/rect",b):"object"==typeof exports?module.exports=b():(a.Packery=a.Packery||{},a.Packery.Rect=b())}(window),function(a){function b(a){function b(a,b,c){this.width=a||0,this.height=b||0,this.sortDirection=c||"downwardLeftToRight",this.reset()}b.prototype.reset=function(){this.spaces=[],this.newSpaces=[];var b=new a({x:0,y:0,width:this.width,height:this.height});this.spaces.push(b),this.sorter=c[this.sortDirection]||c.downwardLeftToRight},b.prototype.pack=function(a){for(var b=0,c=this.spaces.length;c>b;b++){var d=this.spaces[b];if(d.canFit(a)){this.placeInSpace(a,d);break}}},b.prototype.placeInSpace=function(a,b){a.x=b.x,a.y=b.y,this.placed(a)},b.prototype.placed=function(a){for(var b=[],c=0,d=this.spaces.length;d>c;c++){var e=this.spaces[c],f=e.getMaximalFreeRects(a);f?b.push.apply(b,f):b.push(e)}this.spaces=b,this.mergeSortSpaces()},b.prototype.mergeSortSpaces=function(){b.mergeRects(this.spaces),this.spaces.sort(this.sorter)},b.prototype.addSpace=function(a){this.spaces.push(a),this.mergeSortSpaces()},b.mergeRects=function(a){for(var b=0,c=a.length;c>b;b++){var d=a[b];if(d){var e=a.slice(0);e.splice(b,1);for(var f=0,g=0,h=e.length;h>g;g++){var i=e[g],j=b>g?0:1;d.contains(i)&&(a.splice(g+j-f,1),f++)}}}return a};var c={downwardLeftToRight:function(a,b){return a.y-b.y||a.x-b.x},rightwardTopToBottom:function(a,b){return a.x-b.x||a.y-b.y}};return b}if("function"==typeof define&&define.amd)define("packery/js/packer",["./rect"],b);else if("object"==typeof exports)module.exports=b(require("./rect"));else{var c=a.Packery=a.Packery||{};c.Packer=b(c.Rect)}}(window),function(a){function b(a,b,c){var d=a("transform"),e=function(){b.Item.apply(this,arguments)};e.prototype=new b.Item;var f=e.prototype._create;return e.prototype._create=function(){f.call(this),this.rect=new c,this.placeRect=new c},e.prototype.dragStart=function(){this.getPosition(),this.removeTransitionStyles(),this.isTransitioning&&d&&(this.element.style[d]="none"),this.getSize(),this.isPlacing=!0,this.needsPositioning=!1,this.positionPlaceRect(this.position.x,this.position.y),this.isTransitioning=!1,this.didDrag=!1},e.prototype.dragMove=function(a,b){this.didDrag=!0;var c=this.layout.size;a-=c.paddingLeft,b-=c.paddingTop,this.positionPlaceRect(a,b)},e.prototype.dragStop=function(){this.getPosition();var a=this.position.x!==this.placeRect.x,b=this.position.y!==this.placeRect.y;this.needsPositioning=a||b,this.didDrag=!1},e.prototype.positionPlaceRect=function(a,b,c){this.placeRect.x=this.getPlaceRectCoord(a,!0),this.placeRect.y=this.getPlaceRectCoord(b,!1,c)},e.prototype.getPlaceRectCoord=function(a,b,c){var d=b?"Width":"Height",e=this.size["outer"+d],f=this.layout[b?"columnWidth":"rowHeight"],g=this.layout.size["inner"+d];b||(g=Math.max(g,this.layout.maxY),this.layout.rowHeight||(g-=this.layout.gutter));var h;if(f){f+=this.layout.gutter,g+=b?this.layout.gutter:0,a=Math.round(a/f);var i;i=this.layout.options.isHorizontal?b?"ceil":"floor":b?"floor":"ceil";var j=Math[i](g/f);j-=Math.ceil(e/f),h=j}else h=g-e;return a=c?a:Math.min(a,h),a*=f||1,Math.max(0,a)},e.prototype.copyPlaceRectPosition=function(){this.rect.x=this.placeRect.x,this.rect.y=this.placeRect.y},e.prototype.removeElem=function(){this.element.parentNode.removeChild(this.element),this.layout.packer.addSpace(this.rect),this.emitEvent("remove",[this])},e}"function"==typeof define&&define.amd?define("packery/js/item",["get-style-property/get-style-property","outlayer/outlayer","./rect"],b):"object"==typeof exports?module.exports=b(require("desandro-get-style-property"),require("outlayer"),require("./rect")):a.Packery.Item=b(a.getStyleProperty,a.Outlayer,a.Packery.Rect)}(window),function(a){function b(a,b,c,d,e,f){function g(a,b){return a.position.y-b.position.y||a.position.x-b.position.x}function h(a,b){return a.position.x-b.position.x||a.position.y-b.position.y}var i=c.create("packery");return i.Item=f,i.prototype._create=function(){c.prototype._create.call(this),this.packer=new e,this.stamp(this.options.stamped);var a=this;this.handleDraggabilly={dragStart:function(b){a.itemDragStart(b.element)},dragMove:function(b){a.itemDragMove(b.element,b.position.x,b.position.y)},dragEnd:function(b){a.itemDragEnd(b.element)}},this.handleUIDraggable={start:function(b){a.itemDragStart(b.currentTarget)},drag:function(b,c){a.itemDragMove(b.currentTarget,c.position.left,c.position.top)},stop:function(b){a.itemDragEnd(b.currentTarget)}}},i.prototype._resetLayout=function(){this.getSize(),this._getMeasurements();var a=this.packer;this.options.isHorizontal?(a.width=Number.POSITIVE_INFINITY,a.height=this.size.innerHeight+this.gutter,a.sortDirection="rightwardTopToBottom"):(a.width=this.size.innerWidth+this.gutter,a.height=Number.POSITIVE_INFINITY,a.sortDirection="downwardLeftToRight"),a.reset(),this.maxY=0,this.maxX=0},i.prototype._getMeasurements=function(){this._getMeasurement("columnWidth","width"),this._getMeasurement("rowHeight","height"),this._getMeasurement("gutter","width")},i.prototype._getItemLayoutPosition=function(a){return this._packItem(a),a.rect},i.prototype._packItem=function(a){this._setRectSize(a.element,a.rect),this.packer.pack(a.rect),this._setMaxXY(a.rect)},i.prototype._setMaxXY=function(a){this.maxX=Math.max(a.x+a.width,this.maxX),this.maxY=Math.max(a.y+a.height,this.maxY)},i.prototype._setRectSize=function(a,c){var d=b(a),e=d.outerWidth,f=d.outerHeight;if(e||f){var g=this.columnWidth+this.gutter,h=this.rowHeight+this.gutter;e=this.columnWidth?Math.ceil(e/g)*g:e+this.gutter,f=this.rowHeight?Math.ceil(f/h)*h:f+this.gutter}c.width=Math.min(e,this.packer.width),c.height=Math.min(f,this.packer.height)},i.prototype._getContainerSize=function(){return this.options.isHorizontal?{width:this.maxX-this.gutter}:{height:this.maxY-this.gutter}},i.prototype._manageStamp=function(a){var b,c=this.getItem(a);if(c&&c.isPlacing)b=c.placeRect;else{var e=this._getElementOffset(a);b=new d({x:this.options.isOriginLeft?e.left:e.right,y:this.options.isOriginTop?e.top:e.bottom})}this._setRectSize(a,b),this.packer.placed(b),this._setMaxXY(b)},i.prototype.sortItemsByPosition=function(){var a=this.options.isHorizontal?h:g;this.items.sort(a)},i.prototype.fit=function(a,b,c){var d=this.getItem(a);d&&(this._getMeasurements(),this.stamp(d.element),d.getSize(),d.isPlacing=!0,b=void 0===b?d.rect.x:b,c=void 0===c?d.rect.y:c,d.positionPlaceRect(b,c,!0),this._bindFitEvents(d),d.moveTo(d.placeRect.x,d.placeRect.y),this.layout(),this.unstamp(d.element),this.sortItemsByPosition(),d.isPlacing=!1,d.copyPlaceRectPosition())},i.prototype._bindFitEvents=function(a){function b(){d++,2===d&&c.emitEvent("fitComplete",[c,a])}var c=this,d=0;a.on("layout",function(){return b(),!0}),this.on("layoutComplete",function(){return b(),!0})},i.prototype.resize=function(){var a=b(this.element),c=this.size&&a,d=this.options.isHorizontal?"innerHeight":"innerWidth";c&&a[d]===this.size[d]||this.layout()},i.prototype.itemDragStart=function(a){this.stamp(a);var b=this.getItem(a);b&&b.dragStart()},i.prototype.itemDragMove=function(a,b,c){function d(){f.layout(),delete f.dragTimeout}var e=this.getItem(a);e&&e.dragMove(b,c);var f=this;this.clearDragTimeout(),this.dragTimeout=setTimeout(d,40)},i.prototype.clearDragTimeout=function(){this.dragTimeout&&clearTimeout(this.dragTimeout)},i.prototype.itemDragEnd=function(b){var c,d=this.getItem(b);if(d&&(c=d.didDrag,d.dragStop()),!d||!c&&!d.needsPositioning)return void this.unstamp(b);a.add(d.element,"is-positioning-post-drag");var e=this._getDragEndLayoutComplete(b,d);d.needsPositioning?(d.on("layout",e),d.moveTo(d.placeRect.x,d.placeRect.y)):d&&d.copyPlaceRectPosition(),this.clearDragTimeout(),this.on("layoutComplete",e),this.layout()},i.prototype._getDragEndLayoutComplete=function(b,c){var d=c&&c.needsPositioning,e=0,f=d?2:1,g=this;return function(){return e++,e!==f?!0:(c&&(a.remove(c.element,"is-positioning-post-drag"),c.isPlacing=!1,c.copyPlaceRectPosition()),g.unstamp(b),g.sortItemsByPosition(),d&&g.emitEvent("dragItemPositioned",[g,c]),!0)}},i.prototype.bindDraggabillyEvents=function(a){a.on("dragStart",this.handleDraggabilly.dragStart),a.on("dragMove",this.handleDraggabilly.dragMove),a.on("dragEnd",this.handleDraggabilly.dragEnd)},i.prototype.bindUIDraggableEvents=function(a){a.on("dragstart",this.handleUIDraggable.start).on("drag",this.handleUIDraggable.drag).on("dragstop",this.handleUIDraggable.stop)},i.Rect=d,i.Packer=e,i}"function"==typeof define&&define.amd?define("packery/js/packery",["classie/classie","get-size/get-size","outlayer/outlayer","./rect","./packer","./item"],b):"object"==typeof exports?module.exports=b(require("desandro-classie"),require("get-size"),require("outlayer"),require("./rect"),require("./packer"),require("./item")):a.Packery=b(a.classie,a.getSize,a.Outlayer,a.Packery.Rect,a.Packery.Packer,a.Packery.Item)}(window),function(a){function b(a,b){for(var c in b)a[c]=b[c];return a}function c(a,c,d){var e=a.create("packery"),f=e.prototype._getElementOffset,g=e.prototype._getMeasurement;b(e.prototype,c.prototype),e.prototype._getElementOffset=f,e.prototype._getMeasurement=g;var h=e.prototype._resetLayout;e.prototype._resetLayout=function(){this.packer=this.packer||new c.Packer,h.apply(this,arguments)};var i=e.prototype._getItemLayoutPosition;e.prototype._getItemLayoutPosition=function(a){return a.rect=a.rect||new c.Rect,i.call(this,a)};var j=e.prototype._manageStamp;return e.prototype._manageStamp=function(){this.options.isOriginLeft=this.isotope.options.isOriginLeft,this.options.isOriginTop=this.isotope.options.isOriginTop,j.apply(this,arguments)},e.prototype.needsResizeLayout=function(){var a=d(this.element),b=this.size&&a,c=this.options.isHorizontal?"innerHeight":"innerWidth";return b&&a[c]!==this.size[c]},e}"function"==typeof define&&define.amd?define(["isotope/js/layout-mode","packery/js/packery","get-size/get-size"],c):"object"==typeof exports?module.exports=c(require("isotope-layout/js/layout-mode"),require("packery"),require("get-size")):c(a.Isotope.LayoutMode,a.Packery,a.getSize)}(window);

/* ========================================================================
 * bootstrap-spin - v1.0
 * https://github.com/wpic/bootstrap-spin
 * ========================================================================
 * Copyright 2014 WPIC, Hamed Abdollahpour
 *
 * ========================================================================
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================================
 */
(function ( $ ) {

	$.fn.bootstrapNumber = function( options ) {

		var settings = $.extend({
			upClass: 'default',
			downClass: 'default',
			center: true
			}, options );

		return this.each(function(e) {
			var self = $(this);
			var clone = self.clone();

			var min = self.attr('min');
			var max = self.attr('max');

			function setText(n) {
				if((min && n < min) || (max && n > max)) {
					return false;
				}

				clone.val(n);
				clone.trigger('change');
				return true;
			}

			var group = $("<div class='input-group'></div>");
			var down = $("<button type='button'>-</button>").attr('class', 'btn btn-' + settings.downClass).click(function() {
				setText(parseInt(clone.val()) - 1);
			});
			var up = $("<button type='button'>+</button>").attr('class', 'btn btn-' + settings.upClass).click(function() {
				setText(parseInt(clone.val()) + 1);
			});
			$("<span class='input-group-btn'></span>").append(down).appendTo(group);
			clone.appendTo(group);
			if(clone && settings.center) {
				clone.css('text-align', 'center');
			}
			$("<span class='input-group-btn'></span>").append(up).appendTo(group);

			// remove spins from original
			clone.attr('type', 'text').keydown(function (e) {
				if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
					(e.keyCode == 65 && e.ctrlKey === true) || 
					(e.keyCode >= 35 && e.keyCode <= 39)) {
					return;
				}
				if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {				
					e.preventDefault();
				}

				var c = String.fromCharCode(e.which);
				var n = parseInt(clone.val() + c);

				if((min && n < min) || (max && n > max)) {
					e.preventDefault();
				}
			});

			self.replaceWith(group);
		});
	};
} ( jQuery ));

/* ------------------------------------------------------------------------ */
/* Main JS File - functions.js 1.0
/* ------------------------------------------------------------------------ */
jQuery(document).ready(function($){
	'use strict';

	/* ------------------------------------------------------------------------ */
    /* Add .on-mobile Class for mobile devices
    /* ------------------------------------------------------------------------ */
    function mobileClass() {
    	if (/Android|BlackBerry|iPhone|iPad|iPod|IEMobile|Opera Mini|webOS/i.test(navigator.userAgent) === true) {
	        $('body').addClass('on-mobile');
	    }
    }

    mobileClass();


	/* ------------------------------------------------------------------------ */
	/* Menu
	/* ------------------------------------------------------------------------ */	
	function sfLoad() {

		$("#navigation ul.menu").superfish({
			delay:       	300,
			hoverClass:    	'sfHover',
			animation:     {opacity:'show'},
			animationOut:  {opacity:'hide'},
			speed:       	'normal',
			speedOut: 	 	'fast',
			cssArrows:   	true
		});

	}

	sfLoad();

	/* Open Submenu on left side when Screen is too small */
	var wapoMainWindowWidth;
	var subMenuExist;
	var subMenuWidth;
	var subMenuOffset;
	var newSubMenuPosition;

	function sfSubmenuPosition() {
		wapoMainWindowWidth = $(window).width();
		$('#navigation ul li ul').mouseover(function(){     
		    subMenuExist = $(this).find('.sub-menu').length;            
		    if( subMenuExist > 0){
		        subMenuWidth = $(this).find('.sub-menu').width();
		        subMenuOffset = $(this).find('.sub-menu').parent().offset().left + subMenuWidth;

		        // if sub menu is off screen, give new position
		        if((subMenuOffset + subMenuWidth) > wapoMainWindowWidth){                  
		            newSubMenuPosition = subMenuWidth + 3;
		            $(this).find('.sub-menu').css({
		                left: -newSubMenuPosition,
		                top: '0',
		            });
		        } else {
		        	$(this).find('.sub-menu').css({
		                left: newSubMenuPosition,
		                top: '0',
		            });
		        }
		    }
		 });
	}
	
	sfSubmenuPosition();

	/* ------------------------------------------------------------------------ */
	/* Header
	/* ------------------------------------------------------------------------ */
	$('.header-v1 #search-btn').click(function(){
		$('#search-top').stop(true,true).fadeIn(100);
		$('#logo-navigation, .header-icons-divider').stop().animate({'opacity' : 0}, 100);
		$('#search-top input[type=text]').focus();
		return false;
	});

	function closeSearch(){
		$('#search-top').stop(true,true).fadeOut(100);
		$('#logo-navigation, .header-icons-divider').stop().animate({'opacity' : 1}, 100);
	}
	
	$('#close-search-btn').click(function(){
		closeSearch();
		return false;
	});

	$('#search-top input[type=text]').blur(function(e){
		closeSearch();
	});

	$(window).resize(function() {
		if ($(window).width() < 960) {
			$('#search-top').hide();
		}
		else {
			$('#mobile-navigation').hide();
		}
	});

	// Shopping Cart Hover
	$(".header-v1 #shopping-btn, .header .widget_shopping_cart, .cart-popup").on({
    mouseenter: function () {
        $('.widget_shopping_cart').stop(true, false).fadeIn(200);
    },
    mouseleave: function () {
        $('.widget_shopping_cart').stop(true, false).fadeOut(200);
    }
	});

	// Remove Top Margin when Slider is first element
	function headerPadding(){
		$(window).resize(function() {
			if ($(window).width() < 945) {
				var headerHeight = $('#header').height();
				$('.header-is-transparent #page-wrap').has('#content > :first-child > .col > .wpb_column > .wpb_wrapper > .wpb_revslider_element').css({'padding-top': headerHeight});
			} else {
				$('.header-is-transparent #page-wrap').has('#content > :first-child > .col > .wpb_column > .wpb_wrapper > .wpb_revslider_element').css({'padding-top': '0'});
			}
		}).resize();
	}

	headerPadding();
    
	/* ------------------------------------------------------------------------ */
	/* Mobile Navigation
	/* ------------------------------------------------------------------------ */
	$('#mobile-navigation-btn').click(function(){
		$('#mobile-navigation').stop(true,true).slideToggle(300, 'easeOutBack'); //easeInOutSine works also nice at 200ms
		return false;
	});
	
	$('#mobile-navigation .container ul li').each(function(){
		if($(this).find('> ul').length > 0) {
			 $(this).addClass('has-ul');
			 $(this).find('> a').append('<i class="fa fa-chevron-down"></i>');
		}
	});
	
	$('#mobile-navigation .container ul li:has(">ul") > a i').click(function(){
		$(this).parent().parent().toggleClass('open');
		$(this).parent().parent().find('> ul').stop(true,true).slideToggle(300, 'easeOutBack');
		return false;
	});

	/* ------------------------------------------------------------------------ */
	/* Smooth Anchor Scrolling & onePage Scroll Version 2.0
	/* ------------------------------------------------------------------------ */
	function onePage() {

		if($("body").hasClass("pagescroll")){

			var scrolleffect = "easeOutQuad",
				scrollspeed	= 400,
				onepage_offset = $("#header").height(),
				onepage_offset2 = 150;
		
			if( window.location.hash ) {
				if($.browser.webkit){
					setTimeout ( function () {
						$.scrollTo( window.location.hash , 260 , { easing: scrolleffect , offset: -onepage_offset , "axis":"y" } );											
					}, 600);
				}
				else {
					$.scrollTo( window.location.hash , 260 , { easing: scrolleffect , offset: -onepage_offset , "axis":"y" } );		
				}
			}

			$("#nav li a[href*=\\#], a[href*=\\#].pagescroll").on("click", function(e){
				var linkhref = $(this.hash);
				$.scrollTo( linkhref, scrollspeed, { easing: scrolleffect , offset: -onepage_offset , 'axis':'y' } );	
				$(this).blur();
				e.preventDefault();
				//window.location.hash = $(this).attr('href').split('#')[1];
			})

			var currentNode = null;

			$('#nav li').removeClass('current-menu-item');
			
			$(window).scroll(function () {
				$('.section').each(function(){		
					if($(this).attr('id') != undefined && $(window).scrollTop() >= ($(this).offset().top - onepage_offset2)){
						currentNode = $(this).attr('id');
						$('#nav a').parent("li").removeClass('current-menu-item');
						$('#nav a[href$="#'+currentNode+'"]').parent("li").addClass('current-menu-item');
					}
				});
			});
	
		}

	}

	onePage();

	/* ------------------------------------------------------------------------ */
	/* Post Navigation
	/* ------------------------------------------------------------------------ */
	$('#post-navigation .prev').hover(
		function() {
			$(this).stop().animate({'left' : 0, 'opacity' : 1}, 160, 'easeOutSine');
		}, function() {
			$(this).stop().animate({'left' : -25, 'opacity' : 0.2}, 160, 'easeOutSine');
		}
	);

	$('#post-navigation .next').hover(
		function() {
			$(this).stop().animate({'right' : 0, 'opacity' : 1}, 160, 'easeOutSine');
		}, function() {
			$(this).stop().animate({'right' : -25, 'opacity' : 0.2}, 160, 'easeOutSine');
		}
	);
	
	/* ------------------------------------------------------------------------ */
	/* Back To Top
	/* ------------------------------------------------------------------------ */
	function backToTop() {

		$(window).scroll(function(){
			if($(window).scrollTop() > 200){
				$("#back-to-top").fadeIn(200);
			} else{
				$("#back-to-top").fadeOut(200);
			}
		});
		
		$('#back-to-top, .back-to-top').click(function() {
			  $('html, body').animate({ scrollTop:0 }, '800');
			  return false;
		});

	}
	
	backToTop();

	/* ------------------------------------------------------------------------ */
	/* Blog
	/* ------------------------------------------------------------------------ */
	// Blog Image Overlay
	$('.blog-item .blog-pic').hover(function() {
		$(this).find('.blog-overlay').stop().animate({'opacity' : 0.94}, 160);
		$(this).find('i').stop().animate({'margin-top' : '-33px', 'opacity' : 1}, 160, 'easeOutSine');
	}, function(){
		$(this).find('.blog-overlay').stop().animate({'opacity' : 0}, 160);
		$(this).find('i').stop().animate({'margin-top' : '23px', 'opacity' : 0}, 160);
	});

	// Blog Image Overlay
	$('.blog-wrap .post .entry-image a').append( '<div class="entry-overlay"><i class="icon-minti-plus"></i></div>' );
	$('.blog-single .post .entry-image a').append( '<div class="entry-overlay"><i class="icon-minti-search"></i></div>' );
	
	$('.post .entry-image').hover(function() {
		$(this).find('.entry-overlay').stop().animate({'opacity' : 0.94}, 160);
	}, function(){
		$(this).find('.entry-overlay').stop().animate({'opacity' : 0}, 160);
	});

	// Blog Isotope
	function blogMasonry() {

		var $blogcontainer = $('.blog-masonry .blog-wrap');

		$blogcontainer.imagesLoaded( function() {
			setTimeout(function(){
		        $blogcontainer.isotope({ layoutMode : 'masonry' });
				$blogcontainer.animate({'opacity' : 1}, 600);
				flexsliderLoad();
		    }, 500);
	    });
	    
	}

	blogMasonry();

    /* ------------------------------------------------------------------------ */
    /* Portfolio
    /* ------------------------------------------------------------------------ */

    // Portfolio Hover
    $('.widget_portfolio .portfolio-widget-item').hover(function() {
		$(this).find('.portfolio-overlay').stop().animate({'opacity' : 0.9}, 180);
	}, function(){
		$(this).find('.portfolio-overlay').stop().animate({'opacity' : 0}, 180);
	});

	// Overlay-Effect
    $('.portfolio-overlay-effect .portfolio-item .portfolio-image').hover(function() {
        $(this).find('.portfolio-overlay').stop().animate({'bottom' : 0}, 200,'easeOutCubic');
        $(this).find('.portfolio-image-img').stop().animate({'top' : '-60px'}, 440,'easeOutCubic');
    }, function(){
        $(this).find('.portfolio-overlay').stop().animate({'bottom' : '-80px'}, 440,'easeOutCubic');
        $(this).find('.portfolio-image-img').stop().animate({'top' : '0px'}, 200,'easeOutCubic');
    });

    // Overlay-Icon
    $('.portfolio-overlay-icon .portfolio-item .portfolio-image').hover(function() {
        $(this).find('.portfolio-overlay').stop().animate({'opacity' : 0.94}, 160);
        $(this).find('i').stop().animate({'margin-top' : '-33px', 'opacity' : 1}, 160, 'easeOutSine');
    }, function(){
        $(this).find('.portfolio-overlay').stop().animate({'opacity' : 0}, 160);
        $(this).find('i').stop().animate({'margin-top' : '23px', 'opacity' : 0}, 160);
    });

    // Overlay-Name
    $('.portfolio-overlay-name .portfolio-item .portfolio-image').hover(function() {
        $(this).find('.portfolio-overlay').stop().animate({'opacity' : 0.94}, 160);
    }, function(){
        $(this).find('.portfolio-overlay').stop().animate({'opacity' : 0}, 160);
    });

    // Portfolio Isotope
    function portfolioIsotope(){
    	
    	var $portfoliocontainer = $('.portfolio-items');
   		$('.portfolio-item').css({visibility: "visible", opacity: "0"});

	    $portfoliocontainer.imagesLoaded( function() {
	        $portfoliocontainer.fadeIn(1000).isotope({
	            transitionDuration: '0.6s',
	            itemSelector: '.portfolio-item',
	            resizable: false,
	            layoutMode: 'packery',
	            sortBy: 'origorder'
	        });

	        // Fade In
	        $('.portfolio-item').each(function(index){
	            $(this).delay(80*index).animate({opacity: 1}, 200);
	        });
	    });

	    /*$(window).resize(function() {
	        $portfoliocontainer.isotope('layout');
	    });*/

	    $('.portfolio-filters a').click(function(){
	        $('.portfolio-items').addClass('animatedcontainer');
	        $(this).closest('.portfolio-filters').find('a').removeClass('active');
	        $(this).addClass('active');
	        var selector = $(this).attr('data-filter');
	        var portfolioID = $(this).closest('.portfolio-filters').attr("data-id");
	        $('.portfolio-items[data-id=' + portfolioID + ']').isotope({ filter: selector });
	        return false;
	    });

    }

    portfolioIsotope();

    /* ------------------------------------------------------------------------ */
	/* FlexSlider
	/* ------------------------------------------------------------------------ */
	function flexsliderLoad() {

		$('.flexslider:not(.blogslider_holder)').each(function() {

			$(this).flexslider({
		        selector: ".slides > li",
		        animation: "slide", 
		        prevText: "",
		        nextText: "",
		        easing: "easeOutQuad", 
		        smoothHeight: true,
		        pauseOnHover: true,
		        animationSpeed: 300,
				start: function(slider) {
					$(slider).find('.slides')
					.mousedown(function(e) {
						$(this).attr('data-mousestart',e.screenX);
					})
					.mouseup(function(e) {
						var mousestart = parseInt($(this).attr('data-mousestart'),10);
						var mouseend = e.screenX;
						$(this).parents('.flexslider').find('.flex-direction-nav .flex-' + (mousestart - mouseend >= 0 ? 'next' : 'prev')).trigger('click');
					});
				}
		    });

		});

	}
   	
   	flexsliderLoad();

   	function blogsliderLoad() {

   		$('.blogslider_holder.flexslider').each(function() {

	   		var interval = 4000;
	   		var autoslide = true;

	   		interval = $(this).data("interval");
	   		
	   		if(interval == 0){
	   			autoslide = false;
	   		} else {
				autoslide = true;
	   		}

			 $(this).flexslider({
		        selector: ".slides > li",
		        animation: "slide", 
		        prevText: "",
		        nextText: "",
		        smoothHeight: true,
		        pauseOnHover: true,
		        animationLoop: true,
		        animationSpeed: 300,
		        slideshowSpeed: interval,
		        slideshow: autoslide,
		        controlNav: false, 
		        start: function(slider) {
					$(slider).find('.slides')
					.mousedown(function(e) {
						$(this).attr('data-mousestart',e.screenX);
					})
					.mouseup(function(e) {
						var mousestart = parseInt($(this).attr('data-mousestart'),10);
						var mouseend = e.screenX;
						$(this).parents('.flexslider').find('.flex-direction-nav .flex-' + (mousestart - mouseend >= 0 ? 'next' : 'prev')).trigger('click');
					});
				}
		    });

		});

	}
   	
   	blogsliderLoad();

   	function zoomingSlider() {
		if ($('.minti_zooming_slider').length) {
			$('.minti_zooming_slider').each(function() {
				var $slider = $(this);
				$slider.find('.minti_zooming_slider_item').eq(0).addClass('active');
				$slider.flexslider({
					animation: "slide",
					animationSpeed: 400,
					useCSS: true,
					touch: true,
					directionNav: true,
					start: function(slider) {
						$slider.find('.minti_zooming_slider_item').css({ 'opacity': '1', 'filter': 'alpha(opacity=100)' });
						var $titles = $slider.find('li:not(.clone) .minti_zooming_slider_item .image_wrapper .minti_zooming_slider_title');
						var $control_nav = $slider.find('.flex-control-nav');
						$control_nav.addClass('clearfix').find('li').css('width', 100 / $control_nav.find('li').length + '%').prepend('<div class="backline"></div>');
						var $control_links = $control_nav.find('li > a');
						$control_links.each(function() {
							$(this).html('');
							$('<div class="minti_zooming_slider_ghost'+($(this).parent().is(':first-child') ? ' shown' : '')+'"></div><div class="nav_title"><h6>' + $titles.eq($control_links.index($(this))).html() + '</h6></div>').insertAfter($(this)).click(function() {
								$(this).siblings('a').trigger('click');
							});
						});
						$(slider).find('.slides').mousedown(function(e) {
							$(this).attr('data-mousestart',e.screenX);
						}).mouseup(function(e) {
							var mousestart = parseInt($(this).attr('data-mousestart'),10);
							var mouseend = e.screenX;
							$(this).parents('.minti_zooming_slider').find('.flex-direction-nav .flex-' + (mousestart - mouseend >= 0 ? 'next' : 'prev')).trigger('click');
						});
					},
					before: function(slider) {
						var target = slider.animatingTo;
						var current = slider.find('.flex-active').parent().index();
						var $items = slider.find('.minti_zooming_slider_item').removeClass('active');
						$items.eq(target+1).add((target==0) ? $items.last() : (target==$items.length-3 ? $items.first() : '')).addClass('active');
						if (target==0) {
							$('.minti_zooming_slider .slides li:first-child').next().next().clone().appendTo('.minti_zooming_slider .slides').removeClass('clone').addClass('clone_end');
						}
						else if (target==$items.length-3) {
							$('.minti_zooming_slider .slides li:last-child').prev().prev().clone().appendTo('.minti_zooming_slider .slides').removeClass('clone').addClass('clone_start');
						}
						slider.find('.minti_zooming_slider_ghost.shown').css('left',(target-current)*100 + 50 + '%').removeClass('shown');
						slider.find('.flex-control-nav li').eq(target).find('.minti_zooming_slider_ghost').addClass('shown');
					},
					after: function(slider) {
						slider.find('.clone_start, .clone_end').remove();
						slider.find('.flex-control-nav li .minti_zooming_slider_ghost').css('left','');
					}
				});
			});
		}
	}

	zoomingSlider();
    
    /* ------------------------------------------------------------------------ */
    /* Alert Messages
    /* ------------------------------------------------------------------------ */
    $(".alert-message .close").click(function(){
        $(this).parent().animate({'opacity' : '0'}, 300).slideUp(300);
        return false;
    });

    /* ------------------------------------------------------------------------ */
    /* Counter
    /* ------------------------------------------------------------------------ */

    function counterLoad() {

    	$(".counter-number").each(function() {
	        var $countNumber = parseInt($(this).text());
	        $(this).waypoint(function(){ 
	            $(this).countTo({
	                from: 0,
	                to: $countNumber,
	                speed: 900,
	                refreshInterval: 25
	            });
	        },{ 
	            triggerOnce: true,
	            offset: '99%' 
	        }); 
	    });

    }

    counterLoad();

    /* ------------------------------------------------------------------------ */
    /* Parallax Background // By http://net.tutsplus.com/
    /* ------------------------------------------------------------------------ */

    function parallaxLoad() {

	    if (/Android|BlackBerry|iPhone|iPad|iPod|webOS/i.test(navigator.userAgent) === false) {
	        $('.section-parallax').each(function() {
	            var speed = $(this).data('speed')*0.4;
	            $(this).parallax("50%", speed);
	        });
	        $('.section-parallax').animate({'opacity': 1}, 600);
	    } else {
	        $('.section-parallax').animate({'opacity': 1}, 600);
	        $('.section-parallax').addClass('on-mobile');
	    }

    }

    parallaxLoad();

    /* ------------------------------------------------------------------------ */
    /* Columns Height & Vertical Center
    /* ------------------------------------------------------------------------ */
    function columnAlign(){

        $('.section:has(.vertical-center)').each(function(){

        	$(this).find('.vertical-center').animate({'opacity': 1}, 300);
            
            // Find tallest Column & set heights for all others
            var findTallest = 0;
            var columnHeight = 0;
            
            $(this).find('> .span_12 > .col').each(function(){
                var $padding = parseInt($(this).css('padding-top'));
                ($(this).find('> .wpb_wrapper').height() + ($padding*2) > findTallest) ? findTallest = $(this).find('> .wpb_wrapper').height() + ($padding*2) : findTallest = findTallest;
            }); 
            
            $(this).find('> .span_12 > .col').each(function(){
                $(this).css('height', findTallest);
            });

            // Vertical Center
            if($(this).find('> .span_12 > .col').hasClass('vertical-center') && window.innerWidth > 767){
                $(this).find('> .span_12 > .col').each(function(){
                    columnHeight = $(this).find('> .wpb_wrapper').height();
                    var $setMargins = ($(this).height()/2)-(columnHeight/2);

                    if($setMargins <= 0){
                        $setMargins = 0;
                    }

                    $(this).find('> .wpb_wrapper').css('margin-top', $setMargins);
                    //$(this).find('> .wpb_wrapper').css('margin-bottom', $setMargins);
                });
            }
           
        });

    }

    columnAlign();

    // Late Column Align
    // setTimeout(columnAlign,500);

    $(window).load(function(){
	 	 columnAlign();
	});

    /* ------------------------------------------------------------------------ */
    /* Masonry Grid
    /* ------------------------------------------------------------------------ */
	function initMasonryGrid(){

	    resizeMasonryGrid($('.grid-sizer').width());

	    $('.minti_masonrygrid_item').hover(function(){
	    	$(this).find('.minti_masonrygrid_item_overlay').stop().animate({'opacity' : 1}, 140);
	    }, function(){
	    	$(this).find('.minti_masonrygrid_item_overlay').stop().animate({'opacity' : 0}, 140);
	    });

	    $('.minti_masonrygrid_item').css({visibility: "visible", opacity: "0"});

	    if($('.minti_masonrygrid').length){

	        $('.minti_masonrygrid').each(function(){
	            var $this = $(this);
	            $this.imagesLoaded(function(){
	                $this.animate({opacity:1});
	                $this.isotope({
	                    itemSelector: '.minti_masonrygrid_item',
	                    masonry: {
	                        columnWidth: '.grid-sizer'
	                    }
	                });
	            });
		    
		    });

	        // Fade In
		    $('.minti_masonrygrid_item').each(function(index){
		        $(this).delay(80*index).animate({opacity: 1}, 200);
		    });

	        $(window).resize(function(){
	            resizeMasonryGrid($('.grid-sizer').width());
	            $('.minti_masonrygrid').isotope('reloadItems');
	        });

	    }
	}

	initMasonryGrid();

	function resizeMasonryGrid(size){

		var square_small = $('.masonry_ss .minti_masonrygrid_item_wrap');
		var square_big = $('.masonry_sb .minti_masonrygrid_item_wrap');
	    var rectangle_portrait = $('.masonry_rp .minti_masonrygrid_item_wrap');
	    var rectangle_landscape = $('.masonry_rl .minti_masonrygrid_item_wrap');

	    rectangle_portrait.css({'height': 2*size, 'width': size});
	    rectangle_landscape.css({'height': size, 'width': 2*size});
	    square_big.css({'height': 2*size, 'width': 2*size});
	    square_small.css({'height': size, 'width': size});

	    if (window.innerWidth < 768) {
        	square_big.css({'height': 2*size, 'width': size});
        	rectangle_landscape.css({'height': size, 'width': size});
    	}
	}

    /* ------------------------------------------------------------------------ */
    /* Video Section
    /* ------------------------------------------------------------------------ */
    var min_w = 1200; // minimum video width allowed
    var video_width_original = 1280;  // original video dimensions
    var video_height_original = 720;
    var vid_ratio = 1280/720;
 
    function resizeToCover() {
        $('.video-wrap').each(function(i){
            
            var $sectionHeight = $(this).parents('.wpb_row').outerHeight();         
            var $sectionWidth = $(this).parents('.wpb_row').outerWidth();

            $(this).width($sectionWidth);
            $(this).height($sectionHeight);
        
            // calculate scale ratio
            var scale_h = $sectionWidth / video_width_original;
            var scale_v = ($sectionHeight - $sectionHeight) / video_height_original; 
            var scale = scale_h > scale_v ? scale_h : scale_v;
            
            // limit minimum width
            min_w = vid_ratio * ($sectionHeight+20);
            
            if (scale * video_width_original < min_w) {scale = min_w / video_width_original;}
                
            $(this).find('video, .mejs-overlay, .mejs-poster').width(Math.ceil(scale * video_width_original + 20));
            $(this).find('video, .mejs-overlay, .mejs-poster').height(Math.ceil(scale * video_height_original + 20));
            
            $(this).scrollLeft(($(this).find('video').width() - $sectionWidth) / 2);
            $(this).scrollTop(($(this).find('video').height() - ($sectionHeight)) / 2);

            $(this).find('.mejs-overlay, .mejs-poster').scrollTop(($(this).find('video').height() - ($sectionHeight)) / 2);

        });
    }
    
    setTimeout(function(){
        resizeToCover();
        $('.video-wrap').animate({'opacity' : '1'}, 600);
    }, 600);

    // Remove Video on mobile Devices
    if (/Android|BlackBerry|iPhone|iPad|iPod|webOS/i.test(navigator.userAgent) === true) {
        $('.video-wrap').remove();      
    }
    
    /* ------------------------------------------------------------------------ */
    /* Skillbar
    /* ------------------------------------------------------------------------ */
    function progressbarLoad(){

	    $('.progressbar').each(function() {
	        $(this).waypoint(function(){ 
	            var dataperc = $(this).attr('data-perc');
	            $(this).find('.progress-percentage').animate({ "width" : dataperc + "%"}, dataperc*14);
	        },{ offset: '96%' }); 
	    });

    }

    progressbarLoad();
    
    /* ------------------------------------------------------------------------ */
    /* Toggle
    /* ------------------------------------------------------------------------ */
    if( $(".toggle .toggle-title").hasClass('active') ){
        $(".toggle .toggle-title.active").closest('.toggle').find('.toggle-inner').show();
    }
    
    $(".toggle .toggle-title").click(function(){
        if( $(this).hasClass('active') ){
            $(this).removeClass("active").closest('.toggle').find('.toggle-inner').slideUp(200,'easeOutQuad');
        }
        else{
            $(this).addClass("active").closest('.toggle').find('.toggle-inner').slideDown(200,'easeOutQuad');
        }
    });

    /* ------------------------------------------------------------------------ */
    /* Misc
    /* ------------------------------------------------------------------------ */
  	// Number Field Stepper
  	$('.qty').bootstrapNumber({
		upClass: 'plus',
		downClass: 'minus'
	});

  	// Open Sharebox links in Popup
	$('.sharebox a[target=_blank]').on('click', function(){
        newwindow=window.open($(this).attr('href'),'','height=450,width=700');
        if (window.focus) {newwindow.focus()}
        return false;
    });

	// Prevent iPad from Double Clicking in Dropdowns
	function ipadClick() {

		if (/Android|BlackBerry|iPhone|iPad|iPod|webOS/i.test(navigator.userAgent) === true) {
		    $('#navigation li ul li a').on('click touchend', function(e) {
			    var el = $(this);
			    var link = el.attr('href');
			    window.location = link;
			});
		}

	}

	ipadClick();

	// Tipsy Tooltips
	function tipsyLoad() {

		$('.meta-author a, .meta-comment a, .meta-category a, .portfolio-widget-item a, .sharebox li a').tipsy({
			fade: true,
			gravity: 's',
	        offset: 2
		});

		$('.tooltips a').tipsy({
			fade: true,
			gravity: 's',
			offset: 0,
		});

	}

	tipsyLoad();

	// FitVids
	function fitvidsLoad(){
		$("#portfolio-embed, .format-video, .format-audio, .video-embed").fitVids();
	}

	fitvidsLoad();
	
    // Animate Class
    function animateClass() {

    	if (/Android|BlackBerry|iPhone|iPad|iPod|webOS/i.test(navigator.userAgent) === false) {
	        setTimeout(function(){ 
	            $('.animate').each(function() {
	                
	                $(this).waypoint(function(){  

	                    if($(this).attr('data-animation') == 'fade-in-from-left'){
	                        $(this).delay($(this).attr('data-delay')).animate({'opacity' : 1, 'left' : '0px'},400,'easeOutSine');
	                    } else if($(this).attr('data-animation') == 'fade-in-from-right'){
	                        $(this).delay($(this).attr('data-delay')).animate({'opacity' : 1, 'right' : '0px'},400,'easeOutSine');
	                    } else if($(this).attr('data-animation') == 'fade-in-from-bottom'){
	                        $(this).delay($(this).attr('data-delay')).animate({'opacity' : 1, 'bottom' : '0px'},400,'easeOutSine');
	                    } else if($(this).attr('data-animation') == 'fade-in-from-top'){
	                        $(this).delay($(this).attr('data-delay')).animate({'opacity' : 1, 'top' : '0px'},400,'easeOutSine');
	                    } else if($(this).attr('data-animation') == 'fade-in') {
	                        $(this).delay($(this).attr('data-delay')).animate({'opacity' : 1},400,'easeOutSine');   
	                    }

	                },{ offset: '90%' }); 
	            
	            });
	        }, 100);
	    } else {
	        $('.animate').each(function() {
	            if($(this).attr('data-animation') == 'fade-in-from-left'){
	                $(this).delay($(this).attr('data-delay')).css({'opacity' : 1, 'left' : '0px'});
	            } else if($(this).attr('data-animation') == 'fade-in-from-right'){
	                $(this).delay($(this).attr('data-delay')).css({'opacity' : 1, 'right' : '0px'});
	            } else if($(this).attr('data-animation') == 'fade-in-from-bottom'){
	                $(this).delay($(this).attr('data-delay')).css({'opacity' : 1, 'bottom' : '0px'});
	            } else if($(this).attr('data-animation') == 'fade-in-from-top'){
	                $(this).delay($(this).attr('data-delay')).css({'opacity' : 1, 'top' : '0px'});
	            } else if($(this).attr('data-animation') == 'fade-in') {
	                $(this).delay($(this).attr('data-delay')).css({'opacity' : 1});   
	            }
	        });
	    } 

    }

    animateClass();
    
    // Add Parameters to YouTube Videos oEmbed
    $('.video-embed iframe[src^="http://www.youtube.com"], .video-embed iframe[src^="https://www.youtube.com"], .entry-video iframe[src^="http://www.youtube.com"], .entry-video iframe[src^="https://www.youtube.com"]').each(function() {
        var url = $(this).attr("src")
        $(this).attr("src",url.substring(0,url.indexOf('?')) + '?autohide=1&modestbranding=1&rel=0&showinfo=0')
    });

    // Window Resize Functions
    $(window).resize(function () { 
        resizeToCover(); 
        columnAlign();
        sfSubmenuPosition();
    });

	/* ---------------------------- */
	
}); // end document.ready()
/* ------------------------------------------------------------------------ */
/* EOF
/* ------------------------------------------------------------------------ */