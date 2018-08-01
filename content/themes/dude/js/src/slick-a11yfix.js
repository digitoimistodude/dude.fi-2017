/*
     _ _      _       _
 ___| (_) ___| | __  (_)___
/ __| | |/ __| |/ /  | / __|
\__ \ | | (__|   < _ | \__ \
|___/_|_|\___|_|\_(_)/ |___/
                   |__/

 Version: 1.6.0
  Author: Ken Wheeler
 Website: http://kenwheeler.github.io
    Docs: http://kenwheeler.github.io/slick
    Repo: http://github.com/kenwheeler/slick
  Issues: http://github.com/kenwheeler/slick/issues

 */
/* global window, document, define, jQuery, setInterval, clearInterval */
(function(factory) {
    'use strict';
    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    } else if (typeof exports !== 'undefined') {
        module.exports = factory(require('jquery'));
    } else {
        factory(jQuery);
    }

}(function($) {
    'use strict';
    var Slick = window.Slick || {};

    Slick = (function() {

        var instanceUid = 0;

        function Slick(element, settings) {

            var _ = this, dataSettings;

            _.defaults = {
                accessibility: true,
                adaptiveHeight: false,
                appendArrows: $(element),
                appendDots: $(element),
                arrows: true,
                asNavFor: null,
                prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="Previous" tabindex="0" role="button">Previous</button>',
                nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="Next" tabindex="0" role="button">Next</button>',
                autoplay: false,
                autoplaySpeed: 3000,
                centerMode: false,
                centerPadding: '50px',
                cssEase: 'ease',
                customPaging: function(blockr, i) {
                    return $('<button type="button" data-role="none" role="button" tabindex="0" />').text(i + 1);
                },
                dots: false,
                dotsClass: 'slick-dots',
                draggable: true,
                easing: 'linear',
                edgeFriction: 0.35,
                fade: false,
                focusOnSelect: false,
                infinite: true,
                initialblock: 0,
                lazyLoad: 'ondemand',
                mobileFirst: false,
                pauseOnHover: true,
                pauseOnFocus: true,
                pauseOnDotsHover: false,
                respondTo: 'window',
                responsive: null,
                rows: 1,
                rtl: false,
                block: '',
                blocksPerRow: 1,
                blocksToShow: 1,
                blocksToScroll: 1,
                speed: 500,
                swipe: true,
                swipeToblock: false,
                touchMove: true,
                touchThreshold: 5,
                useCSS: true,
                useTransform: true,
                variableWidth: false,
                vertical: false,
                verticalSwiping: false,
                waitForAnimate: true,
                zIndex: 1000
            };

            _.initials = {
                animating: false,
                dragging: false,
                autoPlayTimer: null,
                currentDirection: 0,
                currentLeft: null,
                currentblock: 0,
                direction: 1,
                $dots: null,
                listWidth: null,
                listHeight: null,
                loadIndex: 0,
                $nextArrow: null,
                $prevArrow: null,
                blockCount: null,
                blockWidth: null,
                $blockTrack: null,
                $blocks: null,
                sliding: false,
                blockOffset: 0,
                swipeLeft: null,
                $list: null,
                touchObject: {},
                transformsEnabled: false,
                unslicked: false
            };

            $.extend(_, _.initials);

            _.activeBreakpoint = null;
            _.animType = null;
            _.animProp = null;
            _.breakpoints = [];
            _.breakpointSettings = [];
            _.cssTransitions = false;
            _.focussed = false;
            _.interrupted = false;
            _.hidden = 'hidden';
            _.paused = true;
            _.positionProp = null;
            _.respondTo = null;
            _.rowCount = 1;
            _.shouldClick = true;
            _.$blockr = $(element);
            _.$blocksCache = null;
            _.transformType = null;
            _.transitionType = null;
            _.visibilityChange = 'visibilitychange';
            _.windowWidth = 0;
            _.windowTimer = null;

            dataSettings = $(element).data('slick') || {};

            _.options = $.extend({}, _.defaults, settings, dataSettings);

            _.currentblock = _.options.initialblock;

            _.originalSettings = _.options;

            if (typeof document.mozHidden !== 'undefined') {
                _.hidden = 'mozHidden';
                _.visibilityChange = 'mozvisibilitychange';
            } else if (typeof document.webkitHidden !== 'undefined') {
                _.hidden = 'webkitHidden';
                _.visibilityChange = 'webkitvisibilitychange';
            }

            _.autoPlay = $.proxy(_.autoPlay, _);
            _.autoPlayClear = $.proxy(_.autoPlayClear, _);
            _.autoPlayIterator = $.proxy(_.autoPlayIterator, _);
            _.changeblock = $.proxy(_.changeblock, _);
            _.clickHandler = $.proxy(_.clickHandler, _);
            _.selectHandler = $.proxy(_.selectHandler, _);
            _.setPosition = $.proxy(_.setPosition, _);
            _.swipeHandler = $.proxy(_.swipeHandler, _);
            _.dragHandler = $.proxy(_.dragHandler, _);
            _.keyHandler = $.proxy(_.keyHandler, _);

            _.instanceUid = instanceUid++;

            // A simple way to check for HTML strings
            // Strict HTML recognition (must start with <)
            // Extracted from jQuery v1.11 source
            _.htmlExpr = /^(?:\s*(<[\w\W]+>)[^>]*)$/;


            _.registerBreakpoints();
            _.init(true);

        }

        return Slick;

    }());

    Slick.prototype.activateADA = function() {
        var _ = this;

        _.$blockTrack.find('.slick-active').attr({
            'aria-hidden': 'false'
        }).find('a, input, button, select').attr({
            'tabindex': '0'
        });

    };

    Slick.prototype.addblock = Slick.prototype.slickAdd = function(markup, index, addBefore) {

        var _ = this;

        if (typeof(index) === 'boolean') {
            addBefore = index;
            index = null;
        } else if (index < 0 || (index >= _.blockCount)) {
            return false;
        }

        _.unload();

        if (typeof(index) === 'number') {
            if (index === 0 && _.$blocks.length === 0) {
                $(markup).appendTo(_.$blockTrack);
            } else if (addBefore) {
                $(markup).insertBefore(_.$blocks.eq(index));
            } else {
                $(markup).insertAfter(_.$blocks.eq(index));
            }
        } else {
            if (addBefore === true) {
                $(markup).prependTo(_.$blockTrack);
            } else {
                $(markup).appendTo(_.$blockTrack);
            }
        }

        _.$blocks = _.$blockTrack.children(this.options.block);

        _.$blockTrack.children(this.options.block).detach();

        _.$blockTrack.append(_.$blocks);

        _.$blocks.each(function(index, element) {
            $(element).attr('data-slick-index', index);
        });

        _.$blocksCache = _.$blocks;

        _.reinit();

    };

    Slick.prototype.animateHeight = function() {
        var _ = this;
        if (_.options.blocksToShow === 1 && _.options.adaptiveHeight === true && _.options.vertical === false) {
            var targetHeight = _.$blocks.eq(_.currentblock).outerHeight(true);
            _.$list.animate({
                height: targetHeight
            }, _.options.speed);
        }
    };

    Slick.prototype.animateblock = function(targetLeft, callback) {

        var animProps = {},
            _ = this;

        _.animateHeight();

        if (_.options.rtl === true && _.options.vertical === false) {
            targetLeft = -targetLeft;
        }
        if (_.transformsEnabled === false) {
            if (_.options.vertical === false) {
                _.$blockTrack.animate({
                    left: targetLeft
                }, _.options.speed, _.options.easing, callback);
            } else {
                _.$blockTrack.animate({
                    top: targetLeft
                }, _.options.speed, _.options.easing, callback);
            }

        } else {

            if (_.cssTransitions === false) {
                if (_.options.rtl === true) {
                    _.currentLeft = -(_.currentLeft);
                }
                $({
                    animStart: _.currentLeft
                }).animate({
                    animStart: targetLeft
                }, {
                    duration: _.options.speed,
                    easing: _.options.easing,
                    step: function(now) {
                        now = Math.ceil(now);
                        if (_.options.vertical === false) {
                            animProps[_.animType] = 'translate(' +
                                now + 'px, 0px)';
                            _.$blockTrack.css(animProps);
                        } else {
                            animProps[_.animType] = 'translate(0px,' +
                                now + 'px)';
                            _.$blockTrack.css(animProps);
                        }
                    },
                    complete: function() {
                        if (callback) {
                            callback.call();
                        }
                    }
                });

            } else {

                _.applyTransition();
                targetLeft = Math.ceil(targetLeft);

                if (_.options.vertical === false) {
                    animProps[_.animType] = 'translate3d(' + targetLeft + 'px, 0px, 0px)';
                } else {
                    animProps[_.animType] = 'translate3d(0px,' + targetLeft + 'px, 0px)';
                }
                _.$blockTrack.css(animProps);

                if (callback) {
                    setTimeout(function() {

                        _.disableTransition();

                        callback.call();
                    }, _.options.speed);
                }

            }

        }

    };

    Slick.prototype.getNavTarget = function() {

        var _ = this,
            asNavFor = _.options.asNavFor;

        if ( asNavFor && asNavFor !== null ) {
            asNavFor = $(asNavFor).not(_.$blockr);
        }

        return asNavFor;

    };

    Slick.prototype.asNavFor = function(index) {

        var _ = this,
            asNavFor = _.getNavTarget();

        if ( asNavFor !== null && typeof asNavFor === 'object' ) {
            asNavFor.each(function() {
                var target = $(this).slick('getSlick');
                if(!target.unslicked) {
                    target.blockHandler(index, true);
                }
            });
        }

    };

    Slick.prototype.applyTransition = function(block) {

        var _ = this,
            transition = {};

        if (_.options.fade === false) {
            transition[_.transitionType] = _.transformType + ' ' + _.options.speed + 'ms ' + _.options.cssEase;
        } else {
            transition[_.transitionType] = 'opacity ' + _.options.speed + 'ms ' + _.options.cssEase;
        }

        if (_.options.fade === false) {
            _.$blockTrack.css(transition);
        } else {
            _.$blocks.eq(block).css(transition);
        }

    };

    Slick.prototype.autoPlay = function() {

        var _ = this;

        _.autoPlayClear();

        if ( _.blockCount > _.options.blocksToShow ) {
            _.autoPlayTimer = setInterval( _.autoPlayIterator, _.options.autoplaySpeed );
        }

    };

    Slick.prototype.autoPlayClear = function() {

        var _ = this;

        if (_.autoPlayTimer) {
            clearInterval(_.autoPlayTimer);
        }

    };

    Slick.prototype.autoPlayIterator = function() {

        var _ = this,
            blockTo = _.currentblock + _.options.blocksToScroll;

        if ( !_.paused && !_.interrupted && !_.focussed ) {

            if ( _.options.infinite === false ) {

                if ( _.direction === 1 && ( _.currentblock + 1 ) === ( _.blockCount - 1 )) {
                    _.direction = 0;
                }

                else if ( _.direction === 0 ) {

                    blockTo = _.currentblock - _.options.blocksToScroll;

                    if ( _.currentblock - 1 === 0 ) {
                        _.direction = 1;
                    }

                }

            }

            _.blockHandler( blockTo );

        }

    };

    Slick.prototype.buildArrows = function() {

        var _ = this;

        if (_.options.arrows === true ) {

            _.$prevArrow = $(_.options.prevArrow).addClass('slick-arrow');
            _.$nextArrow = $(_.options.nextArrow).addClass('slick-arrow');

            if( _.blockCount > _.options.blocksToShow ) {

                _.$prevArrow.removeClass('slick-hidden').removeAttr('aria-hidden tabindex');
                _.$nextArrow.removeClass('slick-hidden').removeAttr('aria-hidden tabindex');

                if (_.htmlExpr.test(_.options.prevArrow)) {
                    _.$prevArrow.prependTo(_.options.appendArrows);
                }

                if (_.htmlExpr.test(_.options.nextArrow)) {
                    _.$nextArrow.appendTo(_.options.appendArrows);
                }

                if (_.options.infinite !== true) {
                    _.$prevArrow
                        .addClass('slick-disabled')
                        .attr('aria-disabled', 'true');
                }

            } else {

                _.$prevArrow.add( _.$nextArrow )

                    .addClass('slick-hidden')
                    .attr({
                        'aria-disabled': 'true',
                        'tabindex': '-1'
                    });

            }

        }

    };

    Slick.prototype.buildDots = function() {

        var _ = this,
            i, dot;

        if (_.options.dots === true && _.blockCount > _.options.blocksToShow) {

            _.$blockr.addClass('slick-dotted');

            dot = $('<ul />').addClass(_.options.dotsClass);

            for (i = 0; i <= _.getDotCount(); i += 1) {
                dot.append($('<li />').append(_.options.customPaging.call(this, _, i)));
            }

            _.$dots = dot.appendTo(_.options.appendDots);

            _.$dots.find('li').first().addClass('slick-active').attr('aria-hidden', 'false');

        }

    };

    Slick.prototype.buildOut = function() {

        var _ = this;

        _.$blocks =
            _.$blockr
                .children( _.options.block + ':not(.slick-cloned)')
                .addClass('slick-block');

        _.blockCount = _.$blocks.length;

        _.$blocks.each(function(index, element) {
            $(element)
                .attr('data-slick-index', index)
                .data('originalStyling', $(element).attr('style') || '');
        });

        _.$blockr.addClass('slick-blockr');

        _.$blockTrack = (_.blockCount === 0) ?
            $('<div class="slick-track"/>').appendTo(_.$blockr) :
            _.$blocks.wrapAll('<div class="slick-track"/>').parent();

        _.$list = _.$blockTrack.wrap(
            '<div aria-live="polite" class="slick-list"/>').parent();
        _.$blockTrack.css('opacity', 0);

        if (_.options.centerMode === true || _.options.swipeToblock === true) {
            _.options.blocksToScroll = 1;
        }

        $('img[data-lazy]', _.$blockr).not('[src]').addClass('slick-loading');

        _.setupInfinite();

        _.buildArrows();

        _.buildDots();

        _.updateDots();


        _.setblockClasses(typeof _.currentblock === 'number' ? _.currentblock : 0);

        if (_.options.draggable === true) {
            _.$list.addClass('draggable');
        }

    };

    Slick.prototype.buildRows = function() {

        var _ = this, a, b, c, newblocks, numOfblocks, originalblocks,blocksPerSection;

        newblocks = document.createDocumentFragment();
        originalblocks = _.$blockr.children();

        if(_.options.rows > 1) {

            blocksPerSection = _.options.blocksPerRow * _.options.rows;
            numOfblocks = Math.ceil(
                originalblocks.length / blocksPerSection
            );

            for(a = 0; a < numOfblocks; a++){
                var block = document.createElement('div');
                for(b = 0; b < _.options.rows; b++) {
                    var row = document.createElement('div');
                    for(c = 0; c < _.options.blocksPerRow; c++) {
                        var target = (a * blocksPerSection + ((b * _.options.blocksPerRow) + c));
                        if (originalblocks.get(target)) {
                            row.appendChild(originalblocks.get(target));
                        }
                    }
                    block.appendChild(row);
                }
                newblocks.appendChild(block);
            }

            _.$blockr.empty().append(newblocks);
            _.$blockr.children().children().children()
                .css({
                    'width':(100 / _.options.blocksPerRow) + '%',
                    'display': 'inline-block'
                });

        }

    };

    Slick.prototype.checkResponsive = function(initial, forceUpdate) {

        var _ = this,
            breakpoint, targetBreakpoint, respondToWidth, triggerBreakpoint = false;
        var blockrWidth = _.$blockr.width();
        var windowWidth = window.innerWidth || $(window).width();

        if (_.respondTo === 'window') {
            respondToWidth = windowWidth;
        } else if (_.respondTo === 'blockr') {
            respondToWidth = blockrWidth;
        } else if (_.respondTo === 'min') {
            respondToWidth = Math.min(windowWidth, blockrWidth);
        }

        if ( _.options.responsive &&
            _.options.responsive.length &&
            _.options.responsive !== null) {

            targetBreakpoint = null;

            for (breakpoint in _.breakpoints) {
                if (_.breakpoints.hasOwnProperty(breakpoint)) {
                    if (_.originalSettings.mobileFirst === false) {
                        if (respondToWidth < _.breakpoints[breakpoint]) {
                            targetBreakpoint = _.breakpoints[breakpoint];
                        }
                    } else {
                        if (respondToWidth > _.breakpoints[breakpoint]) {
                            targetBreakpoint = _.breakpoints[breakpoint];
                        }
                    }
                }
            }

            if (targetBreakpoint !== null) {
                if (_.activeBreakpoint !== null) {
                    if (targetBreakpoint !== _.activeBreakpoint || forceUpdate) {
                        _.activeBreakpoint =
                            targetBreakpoint;
                        if (_.breakpointSettings[targetBreakpoint] === 'unslick') {
                            _.unslick(targetBreakpoint);
                        } else {
                            _.options = $.extend({}, _.originalSettings,
                                _.breakpointSettings[
                                    targetBreakpoint]);
                            if (initial === true) {
                                _.currentblock = _.options.initialblock;
                            }
                            _.refresh(initial);
                        }
                        triggerBreakpoint = targetBreakpoint;
                    }
                } else {
                    _.activeBreakpoint = targetBreakpoint;
                    if (_.breakpointSettings[targetBreakpoint] === 'unslick') {
                        _.unslick(targetBreakpoint);
                    } else {
                        _.options = $.extend({}, _.originalSettings,
                            _.breakpointSettings[
                                targetBreakpoint]);
                        if (initial === true) {
                            _.currentblock = _.options.initialblock;
                        }
                        _.refresh(initial);
                    }
                    triggerBreakpoint = targetBreakpoint;
                }
            } else {
                if (_.activeBreakpoint !== null) {
                    _.activeBreakpoint = null;
                    _.options = _.originalSettings;
                    if (initial === true) {
                        _.currentblock = _.options.initialblock;
                    }
                    _.refresh(initial);
                    triggerBreakpoint = targetBreakpoint;
                }
            }

            // only trigger breakpoints during an actual break. not on initialize.
            if( !initial && triggerBreakpoint !== false ) {
                _.$blockr.trigger('breakpoint', [_, triggerBreakpoint]);
            }
        }

    };

    Slick.prototype.changeblock = function(event, dontAnimate) {

        var _ = this,
            $target = $(event.currentTarget),
            indexOffset, blockOffset, unevenOffset;

        // If target is a link, prevent default action.
        if($target.is('a')) {
            event.preventDefault();
        }

        // If target is not the <li> element (ie: a child), find the <li>.
        if(!$target.is('li')) {
            $target = $target.closest('li');
        }

        unevenOffset = (_.blockCount % _.options.blocksToScroll !== 0);
        indexOffset = unevenOffset ? 0 : (_.blockCount - _.currentblock) % _.options.blocksToScroll;

        switch (event.data.message) {

            case 'previous':
                blockOffset = indexOffset === 0 ? _.options.blocksToScroll : _.options.blocksToShow - indexOffset;
                if (_.blockCount > _.options.blocksToShow) {
                    _.blockHandler(_.currentblock - blockOffset, false, dontAnimate);
                }
                break;

            case 'next':
                blockOffset = indexOffset === 0 ? _.options.blocksToScroll : indexOffset;
                if (_.blockCount > _.options.blocksToShow) {
                    _.blockHandler(_.currentblock + blockOffset, false, dontAnimate);
                }
                break;

            case 'index':
                var index = event.data.index === 0 ? 0 :
                    event.data.index || $target.index() * _.options.blocksToScroll;

                _.blockHandler(_.checkNavigable(index), false, dontAnimate);
                $target.children().trigger('focus');
                break;

            default:
                return;
        }

    };

    Slick.prototype.checkNavigable = function(index) {

        var _ = this,
            navigables, prevNavigable;

        navigables = _.getNavigableIndexes();
        prevNavigable = 0;
        if (index > navigables[navigables.length - 1]) {
            index = navigables[navigables.length - 1];
        } else {
            for (var n in navigables) {
                if (index < navigables[n]) {
                    index = prevNavigable;
                    break;
                }
                prevNavigable = navigables[n];
            }
        }

        return index;
    };

    Slick.prototype.cleanUpEvents = function() {

        var _ = this;

        if (_.options.dots && _.$dots !== null) {

            $('li', _.$dots)
                .off('click.slick', _.changeblock)
                .off('mouseenter.slick', $.proxy(_.interrupt, _, true))
                .off('mouseleave.slick', $.proxy(_.interrupt, _, false));

        }

        _.$blockr.off('focus.slick blur.slick');

        if (_.options.arrows === true && _.blockCount > _.options.blocksToShow) {
            _.$prevArrow && _.$prevArrow.off('click.slick', _.changeblock);
            _.$nextArrow && _.$nextArrow.off('click.slick', _.changeblock);
        }

        _.$list.off('touchstart.slick mousedown.slick', _.swipeHandler);
        _.$list.off('touchmove.slick mousemove.slick', _.swipeHandler);
        _.$list.off('touchend.slick mouseup.slick', _.swipeHandler);
        _.$list.off('touchcancel.slick mouseleave.slick', _.swipeHandler);

        _.$list.off('click.slick', _.clickHandler);

        $(document).off(_.visibilityChange, _.visibility);

        _.cleanUpblockEvents();

        if (_.options.accessibility === true) {
            _.$list.off('keydown.slick', _.keyHandler);
        }

        if (_.options.focusOnSelect === true) {
            $(_.$blockTrack).children().off('click.slick', _.selectHandler);
        }

        $(window).off('orientationchange.slick.slick-' + _.instanceUid, _.orientationChange);

        $(window).off('resize.slick.slick-' + _.instanceUid, _.resize);

        $('[draggable!=true]', _.$blockTrack).off('dragstart', _.preventDefault);

        $(window).off('load.slick.slick-' + _.instanceUid, _.setPosition);
        $(document).off('ready.slick.slick-' + _.instanceUid, _.setPosition);

    };

    Slick.prototype.cleanUpblockEvents = function() {

        var _ = this;

        _.$list.off('mouseenter.slick', $.proxy(_.interrupt, _, true));
        _.$list.off('mouseleave.slick', $.proxy(_.interrupt, _, false));

    };

    Slick.prototype.cleanUpRows = function() {

        var _ = this, originalblocks;

        if(_.options.rows > 1) {
            originalblocks = _.$blocks.children().children();
            originalblocks.removeAttr('style');
            _.$blockr.empty().append(originalblocks);
        }

    };

    Slick.prototype.clickHandler = function(event) {

        var _ = this;

        if (_.shouldClick === false) {
            event.stopImmediatePropagation();
            event.stopPropagation();
            event.preventDefault();
        }

    };

    Slick.prototype.destroy = function(refresh) {

        var _ = this;

        _.autoPlayClear();

        _.touchObject = {};

        _.cleanUpEvents();

        $('.slick-cloned', _.$blockr).detach();

        if (_.$dots) {
            _.$dots.remove();
        }


        if ( _.$prevArrow && _.$prevArrow.length ) {

            _.$prevArrow
                .removeClass('slick-disabled slick-arrow slick-hidden')
                .removeAttr('aria-hidden aria-disabled tabindex')
                .css('display','');

            if ( _.htmlExpr.test( _.options.prevArrow )) {
                _.$prevArrow.remove();
            }
        }

        if ( _.$nextArrow && _.$nextArrow.length ) {

            _.$nextArrow
                .removeClass('slick-disabled slick-arrow slick-hidden')
                .removeAttr('aria-hidden aria-disabled tabindex')
                .css('display','');

            if ( _.htmlExpr.test( _.options.nextArrow )) {
                _.$nextArrow.remove();
            }

        }


        if (_.$blocks) {

            _.$blocks
                .removeClass('slick-block slick-active slick-center slick-visible slick-current')
                .removeAttr('aria-hidden')
                .removeAttr('data-slick-index')
                .each(function(){
                    $(this).attr('style', $(this).data('originalStyling'));
                });

            _.$blockTrack.children(this.options.block).detach();

            _.$blockTrack.detach();

            _.$list.detach();

            _.$blockr.append(_.$blocks);
        }

        _.cleanUpRows();

        _.$blockr.removeClass('slick-blockr');
        _.$blockr.removeClass('slick-initialized');
        _.$blockr.removeClass('slick-dotted');

        _.unslicked = true;

        if(!refresh) {
            _.$blockr.trigger('destroy', [_]);
        }

    };

    Slick.prototype.disableTransition = function(block) {

        var _ = this,
            transition = {};

        transition[_.transitionType] = '';

        if (_.options.fade === false) {
            _.$blockTrack.css(transition);
        } else {
            _.$blocks.eq(block).css(transition);
        }

    };

    Slick.prototype.fadeblock = function(blockIndex, callback) {

        var _ = this;

        if (_.cssTransitions === false) {

            _.$blocks.eq(blockIndex).css({
                zIndex: _.options.zIndex
            });

            _.$blocks.eq(blockIndex).animate({
                opacity: 1
            }, _.options.speed, _.options.easing, callback);

        } else {

            _.applyTransition(blockIndex);

            _.$blocks.eq(blockIndex).css({
                opacity: 1,
                zIndex: _.options.zIndex
            });

            if (callback) {
                setTimeout(function() {

                    _.disableTransition(blockIndex);

                    callback.call();
                }, _.options.speed);
            }

        }

    };

    Slick.prototype.fadeblockOut = function(blockIndex) {

        var _ = this;

        if (_.cssTransitions === false) {

            _.$blocks.eq(blockIndex).animate({
                opacity: 0,
                zIndex: _.options.zIndex - 2
            }, _.options.speed, _.options.easing);

        } else {

            _.applyTransition(blockIndex);

            _.$blocks.eq(blockIndex).css({
                opacity: 0,
                zIndex: _.options.zIndex - 2
            });

        }

    };

    Slick.prototype.filterblocks = Slick.prototype.slickFilter = function(filter) {

        var _ = this;

        if (filter !== null) {

            _.$blocksCache = _.$blocks;

            _.unload();

            _.$blockTrack.children(this.options.block).detach();

            _.$blocksCache.filter(filter).appendTo(_.$blockTrack);

            _.reinit();

        }

    };

    Slick.prototype.focusHandler = function() {

        var _ = this;

        _.$blockr
            .off('focus.slick blur.slick')
            .on('focus.slick blur.slick',
                '*:not(.slick-arrow)', function(event) {

            event.stopImmediatePropagation();
            var $sf = $(this);

            setTimeout(function() {

                if( _.options.pauseOnFocus ) {
                    _.focussed = $sf.is(':focus');
                    _.autoPlay();
                }

            }, 0);

        });
    };

    Slick.prototype.getCurrent = Slick.prototype.slickCurrentblock = function() {

        var _ = this;
        return _.currentblock;

    };

    Slick.prototype.getDotCount = function() {

        var _ = this;

        var breakPoint = 0;
        var counter = 0;
        var pagerQty = 0;

        if (_.options.infinite === true) {
            while (breakPoint < _.blockCount) {
                ++pagerQty;
                breakPoint = counter + _.options.blocksToScroll;
                counter += _.options.blocksToScroll <= _.options.blocksToShow ? _.options.blocksToScroll : _.options.blocksToShow;
            }
        } else if (_.options.centerMode === true) {
            pagerQty = _.blockCount;
        } else if(!_.options.asNavFor) {
            pagerQty = 1 + Math.ceil((_.blockCount - _.options.blocksToShow) / _.options.blocksToScroll);
        }else {
            while (breakPoint < _.blockCount) {
                ++pagerQty;
                breakPoint = counter + _.options.blocksToScroll;
                counter += _.options.blocksToScroll <= _.options.blocksToShow ? _.options.blocksToScroll : _.options.blocksToShow;
            }
        }

        return pagerQty - 1;

    };

    Slick.prototype.getLeft = function(blockIndex) {

        var _ = this,
            targetLeft,
            verticalHeight,
            verticalOffset = 0,
            targetblock;

        _.blockOffset = 0;
        verticalHeight = _.$blocks.first().outerHeight(true);

        if (_.options.infinite === true) {
            if (_.blockCount > _.options.blocksToShow) {
                _.blockOffset = (_.blockWidth * _.options.blocksToShow) * -1;
                verticalOffset = (verticalHeight * _.options.blocksToShow) * -1;
            }
            if (_.blockCount % _.options.blocksToScroll !== 0) {
                if (blockIndex + _.options.blocksToScroll > _.blockCount && _.blockCount > _.options.blocksToShow) {
                    if (blockIndex > _.blockCount) {
                        _.blockOffset = ((_.options.blocksToShow - (blockIndex - _.blockCount)) * _.blockWidth) * -1;
                        verticalOffset = ((_.options.blocksToShow - (blockIndex - _.blockCount)) * verticalHeight) * -1;
                    } else {
                        _.blockOffset = ((_.blockCount % _.options.blocksToScroll) * _.blockWidth) * -1;
                        verticalOffset = ((_.blockCount % _.options.blocksToScroll) * verticalHeight) * -1;
                    }
                }
            }
        } else {
            if (blockIndex + _.options.blocksToShow > _.blockCount) {
                _.blockOffset = ((blockIndex + _.options.blocksToShow) - _.blockCount) * _.blockWidth;
                verticalOffset = ((blockIndex + _.options.blocksToShow) - _.blockCount) * verticalHeight;
            }
        }

        if (_.blockCount <= _.options.blocksToShow) {
            _.blockOffset = 0;
            verticalOffset = 0;
        }

        if (_.options.centerMode === true && _.options.infinite === true) {
            _.blockOffset += _.blockWidth * Math.floor(_.options.blocksToShow / 2) - _.blockWidth;
        } else if (_.options.centerMode === true) {
            _.blockOffset = 0;
            _.blockOffset += _.blockWidth * Math.floor(_.options.blocksToShow / 2);
        }

        if (_.options.vertical === false) {
            targetLeft = ((blockIndex * _.blockWidth) * -1) + _.blockOffset;
        } else {
            targetLeft = ((blockIndex * verticalHeight) * -1) + verticalOffset;
        }

        if (_.options.variableWidth === true) {

            if (_.blockCount <= _.options.blocksToShow || _.options.infinite === false) {
                targetblock = _.$blockTrack.children('.slick-block').eq(blockIndex);
            } else {
                targetblock = _.$blockTrack.children('.slick-block').eq(blockIndex + _.options.blocksToShow);
            }

            if (_.options.rtl === true) {
                if (targetblock[0]) {
                    targetLeft = (_.$blockTrack.width() - targetblock[0].offsetLeft - targetblock.width()) * -1;
                } else {
                    targetLeft =  0;
                }
            } else {
                targetLeft = targetblock[0] ? targetblock[0].offsetLeft * -1 : 0;
            }

            if (_.options.centerMode === true) {
                if (_.blockCount <= _.options.blocksToShow || _.options.infinite === false) {
                    targetblock = _.$blockTrack.children('.slick-block').eq(blockIndex);
                } else {
                    targetblock = _.$blockTrack.children('.slick-block').eq(blockIndex + _.options.blocksToShow + 1);
                }

                if (_.options.rtl === true) {
                    if (targetblock[0]) {
                        targetLeft = (_.$blockTrack.width() - targetblock[0].offsetLeft - targetblock.width()) * -1;
                    } else {
                        targetLeft =  0;
                    }
                } else {
                    targetLeft = targetblock[0] ? targetblock[0].offsetLeft * -1 : 0;
                }

                targetLeft += (_.$list.width() - targetblock.outerWidth()) / 2;
            }
        }

        return targetLeft;

    };

    Slick.prototype.getOption = Slick.prototype.slickGetOption = function(option) {

        var _ = this;

        return _.options[option];

    };

    Slick.prototype.getNavigableIndexes = function() {

        var _ = this,
            breakPoint = 0,
            counter = 0,
            indexes = [],
            max;

        if (_.options.infinite === false) {
            max = _.blockCount;
        } else {
            breakPoint = _.options.blocksToScroll * -1;
            counter = _.options.blocksToScroll * -1;
            max = _.blockCount * 2;
        }

        while (breakPoint < max) {
            indexes.push(breakPoint);
            breakPoint = counter + _.options.blocksToScroll;
            counter += _.options.blocksToScroll <= _.options.blocksToShow ? _.options.blocksToScroll : _.options.blocksToShow;
        }

        return indexes;

    };

    Slick.prototype.getSlick = function() {

        return this;

    };

    Slick.prototype.getblockCount = function() {

        var _ = this,
            blocksTraversed, swipedblock, centerOffset;

        centerOffset = _.options.centerMode === true ? _.blockWidth * Math.floor(_.options.blocksToShow / 2) : 0;

        if (_.options.swipeToblock === true) {
            _.$blockTrack.find('.slick-block').each(function(index, block) {
                if (block.offsetLeft - centerOffset + ($(block).outerWidth() / 2) > (_.swipeLeft * -1)) {
                    swipedblock = block;
                    return false;
                }
            });

            blocksTraversed = Math.abs($(swipedblock).attr('data-slick-index') - _.currentblock) || 1;

            return blocksTraversed;

        } else {
            return _.options.blocksToScroll;
        }

    };

    Slick.prototype.goTo = Slick.prototype.slickGoTo = function(block, dontAnimate) {

        var _ = this;

        _.changeblock({
            data: {
                message: 'index',
                index: parseInt(block)
            }
        }, dontAnimate);

    };

    Slick.prototype.init = function(creation) {

        var _ = this;

        if (!$(_.$blockr).hasClass('slick-initialized')) {

            $(_.$blockr).addClass('slick-initialized');

            _.buildRows();
            _.buildOut();
            _.setProps();
            _.startLoad();
            _.loadblockr();
            _.initializeEvents();
            _.updateArrows();
            _.updateDots();
            _.checkResponsive(true);
            _.focusHandler();

        }

        if (creation) {
            _.$blockr.trigger('init', [_]);
        }

        if (_.options.accessibility === true) {
            _.initADA();
        }

        if ( _.options.autoplay ) {

            _.paused = false;
            _.autoPlay();

        }

    };

    Slick.prototype.initADA = function() {
        var _ = this;
        _.$blocks.add(_.$blockTrack.find('.slick-cloned')).attr({
            'aria-hidden': 'true',
            'tabindex': '-1'
        }).find('a, input, button, select').attr({
            'tabindex': '-1'
        });

        _.$blockTrack.attr('role', 'listbox');

        _.$blocks.not(_.$blockTrack.find('.slick-cloned')).each(function(i) {
            $(this).attr({
                'role': 'option'
            });
        });

        if (_.$dots !== null) {
            _.$dots.attr('role', 'tablist').find('li').each(function(i) {
                $(this).attr({
                    'role': 'presentation',
                    'aria-selected': 'false',
                    'aria-controls': 'navigation' + _.instanceUid + i + '',
                    'id': 'slick-block' + _.instanceUid + i + ''
                });
            })
                .first().attr('aria-selected', 'true').end()
                .find('button').attr('role', 'button').end()
                .closest('div').attr('role', 'toolbar');
        }
        _.activateADA();

    };

    Slick.prototype.initArrowEvents = function() {

        var _ = this;

        if (_.options.arrows === true && _.blockCount > _.options.blocksToShow) {
            _.$prevArrow
               .off('click.slick')
               .on('click.slick', {
                    message: 'previous'
               }, _.changeblock);
            _.$nextArrow
               .off('click.slick')
               .on('click.slick', {
                    message: 'next'
               }, _.changeblock);
        }

    };

    Slick.prototype.initDotEvents = function() {

        var _ = this;

        if (_.options.dots === true && _.blockCount > _.options.blocksToShow) {
            $('li', _.$dots).on('click.slick', {
                message: 'index'
            }, _.changeblock);
        }

        if ( _.options.dots === true && _.options.pauseOnDotsHover === true ) {

            $('li', _.$dots)
                .on('mouseenter.slick', $.proxy(_.interrupt, _, true))
                .on('mouseleave.slick', $.proxy(_.interrupt, _, false));

        }

    };

    Slick.prototype.initblockEvents = function() {

        var _ = this;

        if ( _.options.pauseOnHover ) {

            _.$list.on('mouseenter.slick', $.proxy(_.interrupt, _, true));
            _.$list.on('mouseleave.slick', $.proxy(_.interrupt, _, false));

        }

    };

    Slick.prototype.initializeEvents = function() {

        var _ = this;

        _.initArrowEvents();

        _.initDotEvents();
        _.initblockEvents();

        _.$list.on('touchstart.slick mousedown.slick', {
            action: 'start'
        }, _.swipeHandler);
        _.$list.on('touchmove.slick mousemove.slick', {
            action: 'move'
        }, _.swipeHandler);
        _.$list.on('touchend.slick mouseup.slick', {
            action: 'end'
        }, _.swipeHandler);
        _.$list.on('touchcancel.slick mouseleave.slick', {
            action: 'end'
        }, _.swipeHandler);

        _.$list.on('click.slick', _.clickHandler);

        $(document).on(_.visibilityChange, $.proxy(_.visibility, _));

        if (_.options.accessibility === true) {
            _.$list.on('keydown.slick', _.keyHandler);
        }

        if (_.options.focusOnSelect === true) {
            $(_.$blockTrack).children().on('click.slick', _.selectHandler);
        }

        $(window).on('orientationchange.slick.slick-' + _.instanceUid, $.proxy(_.orientationChange, _));

        $(window).on('resize.slick.slick-' + _.instanceUid, $.proxy(_.resize, _));

        $('[draggable!=true]', _.$blockTrack).on('dragstart', _.preventDefault);

        $(window).on('load.slick.slick-' + _.instanceUid, _.setPosition);
        $(document).on('ready.slick.slick-' + _.instanceUid, _.setPosition);

    };

    Slick.prototype.initUI = function() {

        var _ = this;

        if (_.options.arrows === true && _.blockCount > _.options.blocksToShow) {

            _.$prevArrow.show();
            _.$nextArrow.show();

        }

        if (_.options.dots === true && _.blockCount > _.options.blocksToShow) {

            _.$dots.show();

        }

    };

    Slick.prototype.keyHandler = function(event) {

        var _ = this;
         //Dont block if the cursor is inside the form fields and arrow keys are pressed
        if(!event.target.tagName.match('TEXTAREA|INPUT|SELECT')) {
            if (event.keyCode === 37 && _.options.accessibility === true) {
                _.changeblock({
                    data: {
                        message: _.options.rtl === true ? 'next' :  'previous'
                    }
                });
            } else if (event.keyCode === 39 && _.options.accessibility === true) {
                _.changeblock({
                    data: {
                        message: _.options.rtl === true ? 'previous' : 'next'
                    }
                });
            }
        }

    };

    Slick.prototype.lazyLoad = function() {

        var _ = this,
            loadRange, cloneRange, rangeStart, rangeEnd;

        function loadImages(imagesScope) {

            $('img[data-lazy]', imagesScope).each(function() {

                var image = $(this),
                    imageSource = $(this).attr('data-lazy'),
                    imageToLoad = document.createElement('img');

                imageToLoad.onload = function() {

                    image
                        .animate({ opacity: 0 }, 100, function() {
                            image
                                .attr('src', imageSource)
                                .animate({ opacity: 1 }, 200, function() {
                                    image
                                        .removeAttr('data-lazy')
                                        .removeClass('slick-loading');
                                });
                            _.$blockr.trigger('lazyLoaded', [_, image, imageSource]);
                        });

                };

                imageToLoad.onerror = function() {

                    image
                        .removeAttr( 'data-lazy' )
                        .removeClass( 'slick-loading' )
                        .addClass( 'slick-lazyload-error' );

                    _.$blockr.trigger('lazyLoadError', [ _, image, imageSource ]);

                };

                imageToLoad.src = imageSource;

            });

        }

        if (_.options.centerMode === true) {
            if (_.options.infinite === true) {
                rangeStart = _.currentblock + (_.options.blocksToShow / 2 + 1);
                rangeEnd = rangeStart + _.options.blocksToShow + 2;
            } else {
                rangeStart = Math.max(0, _.currentblock - (_.options.blocksToShow / 2 + 1));
                rangeEnd = 2 + (_.options.blocksToShow / 2 + 1) + _.currentblock;
            }
        } else {
            rangeStart = _.options.infinite ? _.options.blocksToShow + _.currentblock : _.currentblock;
            rangeEnd = Math.ceil(rangeStart + _.options.blocksToShow);
            if (_.options.fade === true) {
                if (rangeStart > 0) rangeStart--;
                if (rangeEnd <= _.blockCount) rangeEnd++;
            }
        }

        loadRange = _.$blockr.find('.slick-block').slice(rangeStart, rangeEnd);
        loadImages(loadRange);

        if (_.blockCount <= _.options.blocksToShow) {
            cloneRange = _.$blockr.find('.slick-block');
            loadImages(cloneRange);
        } else
        if (_.currentblock >= _.blockCount - _.options.blocksToShow) {
            cloneRange = _.$blockr.find('.slick-cloned').slice(0, _.options.blocksToShow);
            loadImages(cloneRange);
        } else if (_.currentblock === 0) {
            cloneRange = _.$blockr.find('.slick-cloned').slice(_.options.blocksToShow * -1);
            loadImages(cloneRange);
        }

    };

    Slick.prototype.loadblockr = function() {

        var _ = this;

        _.setPosition();

        _.$blockTrack.css({
            opacity: 1
        });

        _.$blockr.removeClass('slick-loading');

        _.initUI();

        if (_.options.lazyLoad === 'progressive') {
            _.progressiveLazyLoad();
        }

    };

    Slick.prototype.next = Slick.prototype.slickNext = function() {

        var _ = this;

        _.changeblock({
            data: {
                message: 'next'
            }
        });

    };

    Slick.prototype.orientationChange = function() {

        var _ = this;

        _.checkResponsive();
        _.setPosition();

    };

    Slick.prototype.pause = Slick.prototype.slickPause = function() {

        var _ = this;

        _.autoPlayClear();
        _.paused = true;

    };

    Slick.prototype.play = Slick.prototype.slickPlay = function() {

        var _ = this;

        _.autoPlay();
        _.options.autoplay = true;
        _.paused = false;
        _.focussed = false;
        _.interrupted = false;

    };

    Slick.prototype.postblock = function(index) {

        var _ = this;

        if( !_.unslicked ) {

            _.$blockr.trigger('afterChange', [_, index]);

            _.animating = false;

            _.setPosition();

            _.swipeLeft = null;

            if ( _.options.autoplay ) {
                _.autoPlay();
            }

            if (_.options.accessibility === true) {
                _.initADA();
            }

        }

    };

    Slick.prototype.prev = Slick.prototype.slickPrev = function() {

        var _ = this;

        _.changeblock({
            data: {
                message: 'previous'
            }
        });

    };

    Slick.prototype.preventDefault = function(event) {

        event.preventDefault();

    };

    Slick.prototype.progressiveLazyLoad = function( tryCount ) {

        tryCount = tryCount || 1;

        var _ = this,
            $imgsToLoad = $( 'img[data-lazy]', _.$blockr ),
            image,
            imageSource,
            imageToLoad;

        if ( $imgsToLoad.length ) {

            image = $imgsToLoad.first();
            imageSource = image.attr('data-lazy');
            imageToLoad = document.createElement('img');

            imageToLoad.onload = function() {

                image
                    .attr( 'src', imageSource )
                    .removeAttr('data-lazy')
                    .removeClass('slick-loading');

                if ( _.options.adaptiveHeight === true ) {
                    _.setPosition();
                }

                _.$blockr.trigger('lazyLoaded', [ _, image, imageSource ]);
                _.progressiveLazyLoad();

            };

            imageToLoad.onerror = function() {

                if ( tryCount < 3 ) {

                    /**
                     * try to load the image 3 times,
                     * leave a slight delay so we don't get
                     * servers blocking the request.
                     */
                    setTimeout( function() {
                        _.progressiveLazyLoad( tryCount + 1 );
                    }, 500 );

                } else {

                    image
                        .removeAttr( 'data-lazy' )
                        .removeClass( 'slick-loading' )
                        .addClass( 'slick-lazyload-error' );

                    _.$blockr.trigger('lazyLoadError', [ _, image, imageSource ]);

                    _.progressiveLazyLoad();

                }

            };

            imageToLoad.src = imageSource;

        } else {

            _.$blockr.trigger('allImagesLoaded', [ _ ]);

        }

    };

    Slick.prototype.refresh = function( initializing ) {

        var _ = this, currentblock, lastVisibleIndex;

        lastVisibleIndex = _.blockCount - _.options.blocksToShow;

        // in non-infinite blockrs, we don't want to go past the
        // last visible index.
        if( !_.options.infinite && ( _.currentblock > lastVisibleIndex )) {
            _.currentblock = lastVisibleIndex;
        }

        // if less blocks than to show, go to start.
        if ( _.blockCount <= _.options.blocksToShow ) {
            _.currentblock = 0;

        }

        currentblock = _.currentblock;

        _.destroy(true);

        $.extend(_, _.initials, { currentblock: currentblock });

        _.init();

        if( !initializing ) {

            _.changeblock({
                data: {
                    message: 'index',
                    index: currentblock
                }
            }, false);

        }

    };

    Slick.prototype.registerBreakpoints = function() {

        var _ = this, breakpoint, currentBreakpoint, l,
            responsiveSettings = _.options.responsive || null;

        if ( $.type(responsiveSettings) === 'array' && responsiveSettings.length ) {

            _.respondTo = _.options.respondTo || 'window';

            for ( breakpoint in responsiveSettings ) {

                l = _.breakpoints.length-1;
                currentBreakpoint = responsiveSettings[breakpoint].breakpoint;

                if (responsiveSettings.hasOwnProperty(breakpoint)) {

                    // loop through the breakpoints and cut out any existing
                    // ones with the same breakpoint number, we don't want dupes.
                    while( l >= 0 ) {
                        if( _.breakpoints[l] && _.breakpoints[l] === currentBreakpoint ) {
                            _.breakpoints.splice(l,1);
                        }
                        l--;
                    }

                    _.breakpoints.push(currentBreakpoint);
                    _.breakpointSettings[currentBreakpoint] = responsiveSettings[breakpoint].settings;

                }

            }

            _.breakpoints.sort(function(a, b) {
                return ( _.options.mobileFirst ) ? a-b : b-a;
            });

        }

    };

    Slick.prototype.reinit = function() {

        var _ = this;

        _.$blocks =
            _.$blockTrack
                .children(_.options.block)
                .addClass('slick-block');

        _.blockCount = _.$blocks.length;

        if (_.currentblock >= _.blockCount && _.currentblock !== 0) {
            _.currentblock = _.currentblock - _.options.blocksToScroll;
        }

        if (_.blockCount <= _.options.blocksToShow) {
            _.currentblock = 0;
        }

        _.registerBreakpoints();

        _.setProps();
        _.setupInfinite();
        _.buildArrows();
        _.updateArrows();
        _.initArrowEvents();
        _.buildDots();
        _.updateDots();
        _.initDotEvents();
        _.cleanUpblockEvents();
        _.initblockEvents();

        _.checkResponsive(false, true);

        if (_.options.focusOnSelect === true) {
            $(_.$blockTrack).children().on('click.slick', _.selectHandler);
        }

        _.setblockClasses(typeof _.currentblock === 'number' ? _.currentblock : 0);

        _.setPosition();
        _.focusHandler();

        _.paused = !_.options.autoplay;
        _.autoPlay();

        _.$blockr.trigger('reInit', [_]);

    };

    Slick.prototype.resize = function() {

        var _ = this;

        if ($(window).width() !== _.windowWidth) {
            clearTimeout(_.windowDelay);
            _.windowDelay = window.setTimeout(function() {
                _.windowWidth = $(window).width();
                _.checkResponsive();
                if( !_.unslicked ) { _.setPosition(); }
            }, 50);
        }
    };

    Slick.prototype.removeblock = Slick.prototype.slickRemove = function(index, removeBefore, removeAll) {

        var _ = this;

        if (typeof(index) === 'boolean') {
            removeBefore = index;
            index = removeBefore === true ? 0 : _.blockCount - 1;
        } else {
            index = removeBefore === true ? --index : index;
        }

        if (_.blockCount < 1 || index < 0 || index > _.blockCount - 1) {
            return false;
        }

        _.unload();

        if (removeAll === true) {
            _.$blockTrack.children().remove();
        } else {
            _.$blockTrack.children(this.options.block).eq(index).remove();
        }

        _.$blocks = _.$blockTrack.children(this.options.block);

        _.$blockTrack.children(this.options.block).detach();

        _.$blockTrack.append(_.$blocks);

        _.$blocksCache = _.$blocks;

        _.reinit();

    };

    Slick.prototype.setCSS = function(position) {

        var _ = this,
            positionProps = {},
            x, y;

        if (_.options.rtl === true) {
            position = -position;
        }
        x = _.positionProp == 'left' ? Math.ceil(position) + 'px' : '0px';
        y = _.positionProp == 'top' ? Math.ceil(position) + 'px' : '0px';

        positionProps[_.positionProp] = position;

        if (_.transformsEnabled === false) {
            _.$blockTrack.css(positionProps);
        } else {
            positionProps = {};
            if (_.cssTransitions === false) {
                positionProps[_.animType] = 'translate(' + x + ', ' + y + ')';
                _.$blockTrack.css(positionProps);
            } else {
                positionProps[_.animType] = 'translate3d(' + x + ', ' + y + ', 0px)';
                _.$blockTrack.css(positionProps);
            }
        }

    };

    Slick.prototype.setDimensions = function() {

        var _ = this;

        if (_.options.vertical === false) {
            if (_.options.centerMode === true) {
                _.$list.css({
                    padding: ('0px ' + _.options.centerPadding)
                });
            }
        } else {
            _.$list.height(_.$blocks.first().outerHeight(true) * _.options.blocksToShow);
            if (_.options.centerMode === true) {
                _.$list.css({
                    padding: (_.options.centerPadding + ' 0px')
                });
            }
        }

        _.listWidth = _.$list.width();
        _.listHeight = _.$list.height();


        if (_.options.vertical === false && _.options.variableWidth === false) {
            _.blockWidth = Math.ceil(_.listWidth / _.options.blocksToShow);
            _.$blockTrack.width(Math.ceil((_.blockWidth * _.$blockTrack.children('.slick-block').length)));

        } else if (_.options.variableWidth === true) {
            _.$blockTrack.width(5000 * _.blockCount);
        } else {
            _.blockWidth = Math.ceil(_.listWidth);
            _.$blockTrack.height(Math.ceil((_.$blocks.first().outerHeight(true) * _.$blockTrack.children('.slick-block').length)));
        }

        var offset = _.$blocks.first().outerWidth(true) - _.$blocks.first().width();
        if (_.options.variableWidth === false) _.$blockTrack.children('.slick-block').width(_.blockWidth - offset);

    };

    Slick.prototype.setFade = function() {

        var _ = this,
            targetLeft;

        _.$blocks.each(function(index, element) {
            targetLeft = (_.blockWidth * index) * -1;
            if (_.options.rtl === true) {
                $(element).css({
                    position: 'relative',
                    right: targetLeft,
                    top: 0,
                    zIndex: _.options.zIndex - 2,
                    opacity: 0
                });
            } else {
                $(element).css({
                    position: 'relative',
                    left: targetLeft,
                    top: 0,
                    zIndex: _.options.zIndex - 2,
                    opacity: 0
                });
            }
        });

        _.$blocks.eq(_.currentblock).css({
            zIndex: _.options.zIndex - 1,
            opacity: 1
        });

    };

    Slick.prototype.setHeight = function() {

        var _ = this;

        if (_.options.blocksToShow === 1 && _.options.adaptiveHeight === true && _.options.vertical === false) {
            var targetHeight = _.$blocks.eq(_.currentblock).outerHeight(true);
            _.$list.css('height', targetHeight);
        }

    };

    Slick.prototype.setOption =
    Slick.prototype.slickSetOption = function() {

        /**
         * accepts arguments in format of:
         *
         *  - for changing a single option's value:
         *     .slick("setOption", option, value, refresh )
         *
         *  - for changing a set of responsive options:
         *     .slick("setOption", 'responsive', [{}, ...], refresh )
         *
         *  - for updating multiple values at once (not responsive)
         *     .slick("setOption", { 'option': value, ... }, refresh )
         */

        var _ = this, l, item, option, value, refresh = false, type;

        if( $.type( arguments[0] ) === 'object' ) {

            option =  arguments[0];
            refresh = arguments[1];
            type = 'multiple';

        } else if ( $.type( arguments[0] ) === 'string' ) {

            option =  arguments[0];
            value = arguments[1];
            refresh = arguments[2];

            if ( arguments[0] === 'responsive' && $.type( arguments[1] ) === 'array' ) {

                type = 'responsive';

            } else if ( typeof arguments[1] !== 'undefined' ) {

                type = 'single';

            }

        }

        if ( type === 'single' ) {

            _.options[option] = value;


        } else if ( type === 'multiple' ) {

            $.each( option , function( opt, val ) {

                _.options[opt] = val;

            });


        } else if ( type === 'responsive' ) {

            for ( item in value ) {

                if( $.type( _.options.responsive ) !== 'array' ) {

                    _.options.responsive = [ value[item] ];

                } else {

                    l = _.options.responsive.length-1;

                    // loop through the responsive object and splice out duplicates.
                    while( l >= 0 ) {

                        if( _.options.responsive[l].breakpoint === value[item].breakpoint ) {

                            _.options.responsive.splice(l,1);

                        }

                        l--;

                    }

                    _.options.responsive.push( value[item] );

                }

            }

        }

        if ( refresh ) {

            _.unload();
            _.reinit();

        }

    };

    Slick.prototype.setPosition = function() {

        var _ = this;

        _.setDimensions();

        _.setHeight();

        if (_.options.fade === false) {
            _.setCSS(_.getLeft(_.currentblock));
        } else {
            _.setFade();
        }

        _.$blockr.trigger('setPosition', [_]);

    };

    Slick.prototype.setProps = function() {

        var _ = this,
            bodyStyle = document.body.style;

        _.positionProp = _.options.vertical === true ? 'top' : 'left';

        if (_.positionProp === 'top') {
            _.$blockr.addClass('slick-vertical');
        } else {
            _.$blockr.removeClass('slick-vertical');
        }

        if (bodyStyle.WebkitTransition !== undefined ||
            bodyStyle.MozTransition !== undefined ||
            bodyStyle.msTransition !== undefined) {
            if (_.options.useCSS === true) {
                _.cssTransitions = true;
            }
        }

        if ( _.options.fade ) {
            if ( typeof _.options.zIndex === 'number' ) {
                if( _.options.zIndex < 3 ) {
                    _.options.zIndex = 3;
                }
            } else {
                _.options.zIndex = _.defaults.zIndex;
            }
        }

        if (bodyStyle.OTransform !== undefined) {
            _.animType = 'OTransform';
            _.transformType = '-o-transform';
            _.transitionType = 'OTransition';
            if (bodyStyle.perspectiveProperty === undefined && bodyStyle.webkitPerspective === undefined) _.animType = false;
        }
        if (bodyStyle.MozTransform !== undefined) {
            _.animType = 'MozTransform';
            _.transformType = '-moz-transform';
            _.transitionType = 'MozTransition';
            if (bodyStyle.perspectiveProperty === undefined && bodyStyle.MozPerspective === undefined) _.animType = false;
        }
        if (bodyStyle.webkitTransform !== undefined) {
            _.animType = 'webkitTransform';
            _.transformType = '-webkit-transform';
            _.transitionType = 'webkitTransition';
            if (bodyStyle.perspectiveProperty === undefined && bodyStyle.webkitPerspective === undefined) _.animType = false;
        }
        if (bodyStyle.msTransform !== undefined) {
            _.animType = 'msTransform';
            _.transformType = '-ms-transform';
            _.transitionType = 'msTransition';
            if (bodyStyle.msTransform === undefined) _.animType = false;
        }
        if (bodyStyle.transform !== undefined && _.animType !== false) {
            _.animType = 'transform';
            _.transformType = 'transform';
            _.transitionType = 'transition';
        }
        _.transformsEnabled = _.options.useTransform && (_.animType !== null && _.animType !== false);
    };


    Slick.prototype.setblockClasses = function(index) {

        var _ = this,
            centerOffset, allblocks, indexOffset, remainder;

        allblocks = _.$blockr
            .find('.slick-block')
            .removeClass('slick-active slick-center slick-current')
            .attr('aria-hidden', 'true');

        _.$blocks
            .eq(index)
            .addClass('slick-current');

        if (_.options.centerMode === true) {

            centerOffset = Math.floor(_.options.blocksToShow / 2);

            if (_.options.infinite === true) {

                if (index >= centerOffset && index <= (_.blockCount - 1) - centerOffset) {

                    _.$blocks
                        .slice(index - centerOffset, index + centerOffset + 1)
                        .addClass('slick-active')
                        .attr('aria-hidden', 'false');

                } else {

                    indexOffset = _.options.blocksToShow + index;
                    allblocks
                        .slice(indexOffset - centerOffset + 1, indexOffset + centerOffset + 2)
                        .addClass('slick-active')
                        .attr('aria-hidden', 'false');

                }

                if (index === 0) {

                    allblocks
                        .eq(allblocks.length - 1 - _.options.blocksToShow)
                        .addClass('slick-center');

                } else if (index === _.blockCount - 1) {

                    allblocks
                        .eq(_.options.blocksToShow)
                        .addClass('slick-center');

                }

            }

            _.$blocks
                .eq(index)
                .addClass('slick-center');

        } else {

            if (index >= 0 && index <= (_.blockCount - _.options.blocksToShow)) {

                _.$blocks
                    .slice(index, index + _.options.blocksToShow)
                    .addClass('slick-active')
                    .attr('aria-hidden', 'false');

            } else if (allblocks.length <= _.options.blocksToShow) {

                allblocks
                    .addClass('slick-active')
                    .attr('aria-hidden', 'false');

            } else {

                remainder = _.blockCount % _.options.blocksToShow;
                indexOffset = _.options.infinite === true ? _.options.blocksToShow + index : index;

                if (_.options.blocksToShow == _.options.blocksToScroll && (_.blockCount - index) < _.options.blocksToShow) {

                    allblocks
                        .slice(indexOffset - (_.options.blocksToShow - remainder), indexOffset + remainder)
                        .addClass('slick-active')
                        .attr('aria-hidden', 'false');

                } else {

                    allblocks
                        .slice(indexOffset, indexOffset + _.options.blocksToShow)
                        .addClass('slick-active')
                        .attr('aria-hidden', 'false');

                }

            }

        }

        if (_.options.lazyLoad === 'ondemand') {
            _.lazyLoad();
        }

    };

    Slick.prototype.setupInfinite = function() {

        var _ = this,
            i, blockIndex, infiniteCount;

        if (_.options.fade === true) {
            _.options.centerMode = false;
        }

        if (_.options.infinite === true && _.options.fade === false) {

            blockIndex = null;

            if (_.blockCount > _.options.blocksToShow) {

                if (_.options.centerMode === true) {
                    infiniteCount = _.options.blocksToShow + 1;
                } else {
                    infiniteCount = _.options.blocksToShow;
                }

                for (i = _.blockCount; i > (_.blockCount -
                        infiniteCount); i -= 1) {
                    blockIndex = i - 1;
                    $(_.$blocks[blockIndex]).clone(true).attr('id', '')
                        .attr('data-slick-index', blockIndex - _.blockCount)
                        .prependTo(_.$blockTrack).addClass('slick-cloned');
                }
                for (i = 0; i < infiniteCount; i += 1) {
                    blockIndex = i;
                    $(_.$blocks[blockIndex]).clone(true).attr('id', '')
                        .attr('data-slick-index', blockIndex + _.blockCount)
                        .appendTo(_.$blockTrack).addClass('slick-cloned');
                }
                _.$blockTrack.find('.slick-cloned').find('[id]').each(function() {
                    $(this).attr('id', '');
                });

            }

        }

    };

    Slick.prototype.interrupt = function( toggle ) {

        var _ = this;

        if( !toggle ) {
            _.autoPlay();
        }
        _.interrupted = toggle;

    };

    Slick.prototype.selectHandler = function(event) {

        var _ = this;

        var targetElement =
            $(event.target).is('.slick-block') ?
                $(event.target) :
                $(event.target).parents('.slick-block');

        var index = parseInt(targetElement.attr('data-slick-index'));

        if (!index) index = 0;

        if (_.blockCount <= _.options.blocksToShow) {

            _.setblockClasses(index);
            _.asNavFor(index);
            return;

        }

        _.blockHandler(index);

    };

    Slick.prototype.blockHandler = function(index, sync, dontAnimate) {

        var targetblock, animblock, oldblock, blockLeft, targetLeft = null,
            _ = this, navTarget;

        sync = sync || false;

        if (_.animating === true && _.options.waitForAnimate === true) {
            return;
        }

        if (_.options.fade === true && _.currentblock === index) {
            return;
        }

        if (_.blockCount <= _.options.blocksToShow) {
            return;
        }

        if (sync === false) {
            _.asNavFor(index);
        }

        targetblock = index;
        targetLeft = _.getLeft(targetblock);
        blockLeft = _.getLeft(_.currentblock);

        _.currentLeft = _.swipeLeft === null ? blockLeft : _.swipeLeft;

        if (_.options.infinite === false && _.options.centerMode === false && (index < 0 || index > _.getDotCount() * _.options.blocksToScroll)) {
            if (_.options.fade === false) {
                targetblock = _.currentblock;
                if (dontAnimate !== true) {
                    _.animateblock(blockLeft, function() {
                        _.postblock(targetblock);
                    });
                } else {
                    _.postblock(targetblock);
                }
            }
            return;
        } else if (_.options.infinite === false && _.options.centerMode === true && (index < 0 || index > (_.blockCount - _.options.blocksToScroll))) {
            if (_.options.fade === false) {
                targetblock = _.currentblock;
                if (dontAnimate !== true) {
                    _.animateblock(blockLeft, function() {
                        _.postblock(targetblock);
                    });
                } else {
                    _.postblock(targetblock);
                }
            }
            return;
        }

        if ( _.options.autoplay ) {
            clearInterval(_.autoPlayTimer);
        }

        if (targetblock < 0) {
            if (_.blockCount % _.options.blocksToScroll !== 0) {
                animblock = _.blockCount - (_.blockCount % _.options.blocksToScroll);
            } else {
                animblock = _.blockCount + targetblock;
            }
        } else if (targetblock >= _.blockCount) {
            if (_.blockCount % _.options.blocksToScroll !== 0) {
                animblock = 0;
            } else {
                animblock = targetblock - _.blockCount;
            }
        } else {
            animblock = targetblock;
        }

        _.animating = true;

        _.$blockr.trigger('beforeChange', [_, _.currentblock, animblock]);

        oldblock = _.currentblock;
        _.currentblock = animblock;

        _.setblockClasses(_.currentblock);

        if ( _.options.asNavFor ) {

            navTarget = _.getNavTarget();
            navTarget = navTarget.slick('getSlick');

            if ( navTarget.blockCount <= navTarget.options.blocksToShow ) {
                navTarget.setblockClasses(_.currentblock);
            }

        }

        _.updateDots();
        _.updateArrows();

        if (_.options.fade === true) {
            if (dontAnimate !== true) {

                _.fadeblockOut(oldblock);

                _.fadeblock(animblock, function() {
                    _.postblock(animblock);
                });

            } else {
                _.postblock(animblock);
            }
            _.animateHeight();
            return;
        }

        if (dontAnimate !== true) {
            _.animateblock(targetLeft, function() {
                _.postblock(animblock);
            });
        } else {
            _.postblock(animblock);
        }

    };

    Slick.prototype.startLoad = function() {

        var _ = this;

        if (_.options.arrows === true && _.blockCount > _.options.blocksToShow) {

            _.$prevArrow.hide();
            _.$nextArrow.hide();

        }

        if (_.options.dots === true && _.blockCount > _.options.blocksToShow) {

            _.$dots.hide();

        }

        _.$blockr.addClass('slick-loading');

    };

    Slick.prototype.swipeDirection = function() {

        var xDist, yDist, r, swipeAngle, _ = this;

        xDist = _.touchObject.startX - _.touchObject.curX;
        yDist = _.touchObject.startY - _.touchObject.curY;
        r = Math.atan2(yDist, xDist);

        swipeAngle = Math.round(r * 180 / Math.PI);
        if (swipeAngle < 0) {
            swipeAngle = 360 - Math.abs(swipeAngle);
        }

        if ((swipeAngle <= 45) && (swipeAngle >= 0)) {
            return (_.options.rtl === false ? 'left' : 'right');
        }
        if ((swipeAngle <= 360) && (swipeAngle >= 315)) {
            return (_.options.rtl === false ? 'left' : 'right');
        }
        if ((swipeAngle >= 135) && (swipeAngle <= 225)) {
            return (_.options.rtl === false ? 'right' : 'left');
        }
        if (_.options.verticalSwiping === true) {
            if ((swipeAngle >= 35) && (swipeAngle <= 135)) {
                return 'down';
            } else {
                return 'up';
            }
        }

        return 'vertical';

    };

    Slick.prototype.swipeEnd = function(event) {

        var _ = this,
            blockCount,
            direction;

        _.dragging = false;
        _.interrupted = false;
        _.shouldClick = ( _.touchObject.swipeLength > 10 ) ? false : true;

        if ( _.touchObject.curX === undefined ) {
            return false;
        }

        if ( _.touchObject.edgeHit === true ) {
            _.$blockr.trigger('edge', [_, _.swipeDirection() ]);
        }

        if ( _.touchObject.swipeLength >= _.touchObject.minSwipe ) {

            direction = _.swipeDirection();

            switch ( direction ) {

                case 'left':
                case 'down':

                    blockCount =
                        _.options.swipeToblock ?
                            _.checkNavigable( _.currentblock + _.getblockCount() ) :
                            _.currentblock + _.getblockCount();

                    _.currentDirection = 0;

                    break;

                case 'right':
                case 'up':

                    blockCount =
                        _.options.swipeToblock ?
                            _.checkNavigable( _.currentblock - _.getblockCount() ) :
                            _.currentblock - _.getblockCount();

                    _.currentDirection = 1;

                    break;

                default:


            }

            if( direction != 'vertical' ) {

                _.blockHandler( blockCount );
                _.touchObject = {};
                _.$blockr.trigger('swipe', [_, direction ]);

            }

        } else {

            if ( _.touchObject.startX !== _.touchObject.curX ) {

                _.blockHandler( _.currentblock );
                _.touchObject = {};

            }

        }

    };

    Slick.prototype.swipeHandler = function(event) {

        var _ = this;

        if ((_.options.swipe === false) || ('ontouchend' in document && _.options.swipe === false)) {
            return;
        } else if (_.options.draggable === false && event.type.indexOf('mouse') !== -1) {
            return;
        }

        _.touchObject.fingerCount = event.originalEvent && event.originalEvent.touches !== undefined ?
            event.originalEvent.touches.length : 1;

        _.touchObject.minSwipe = _.listWidth / _.options
            .touchThreshold;

        if (_.options.verticalSwiping === true) {
            _.touchObject.minSwipe = _.listHeight / _.options
                .touchThreshold;
        }

        switch (event.data.action) {

            case 'start':
                _.swipeStart(event);
                break;

            case 'move':
                _.swipeMove(event);
                break;

            case 'end':
                _.swipeEnd(event);
                break;

        }

    };

    Slick.prototype.swipeMove = function(event) {

        var _ = this,
            edgeWasHit = false,
            curLeft, swipeDirection, swipeLength, positionOffset, touches;

        touches = event.originalEvent !== undefined ? event.originalEvent.touches : null;

        if (!_.dragging || touches && touches.length !== 1) {
            return false;
        }

        curLeft = _.getLeft(_.currentblock);

        _.touchObject.curX = touches !== undefined ? touches[0].pageX : event.clientX;
        _.touchObject.curY = touches !== undefined ? touches[0].pageY : event.clientY;

        _.touchObject.swipeLength = Math.round(Math.sqrt(
            Math.pow(_.touchObject.curX - _.touchObject.startX, 2)));

        if (_.options.verticalSwiping === true) {
            _.touchObject.swipeLength = Math.round(Math.sqrt(
                Math.pow(_.touchObject.curY - _.touchObject.startY, 2)));
        }

        swipeDirection = _.swipeDirection();

        if (swipeDirection === 'vertical') {
            return;
        }

        if (event.originalEvent !== undefined && _.touchObject.swipeLength > 4) {
            event.preventDefault();
        }

        positionOffset = (_.options.rtl === false ? 1 : -1) * (_.touchObject.curX > _.touchObject.startX ? 1 : -1);
        if (_.options.verticalSwiping === true) {
            positionOffset = _.touchObject.curY > _.touchObject.startY ? 1 : -1;
        }


        swipeLength = _.touchObject.swipeLength;

        _.touchObject.edgeHit = false;

        if (_.options.infinite === false) {
            if ((_.currentblock === 0 && swipeDirection === 'right') || (_.currentblock >= _.getDotCount() && swipeDirection === 'left')) {
                swipeLength = _.touchObject.swipeLength * _.options.edgeFriction;
                _.touchObject.edgeHit = true;
            }
        }

        if (_.options.vertical === false) {
            _.swipeLeft = curLeft + swipeLength * positionOffset;
        } else {
            _.swipeLeft = curLeft + (swipeLength * (_.$list.height() / _.listWidth)) * positionOffset;
        }
        if (_.options.verticalSwiping === true) {
            _.swipeLeft = curLeft + swipeLength * positionOffset;
        }

        if (_.options.fade === true || _.options.touchMove === false) {
            return false;
        }

        if (_.animating === true) {
            _.swipeLeft = null;
            return false;
        }

        _.setCSS(_.swipeLeft);

    };

    Slick.prototype.swipeStart = function(event) {

        var _ = this,
            touches;

        _.interrupted = true;

        if (_.touchObject.fingerCount !== 1 || _.blockCount <= _.options.blocksToShow) {
            _.touchObject = {};
            return false;
        }

        if (event.originalEvent !== undefined && event.originalEvent.touches !== undefined) {
            touches = event.originalEvent.touches[0];
        }

        _.touchObject.startX = _.touchObject.curX = touches !== undefined ? touches.pageX : event.clientX;
        _.touchObject.startY = _.touchObject.curY = touches !== undefined ? touches.pageY : event.clientY;

        _.dragging = true;

    };

    Slick.prototype.unfilterblocks = Slick.prototype.slickUnfilter = function() {

        var _ = this;

        if (_.$blocksCache !== null) {

            _.unload();

            _.$blockTrack.children(this.options.block).detach();

            _.$blocksCache.appendTo(_.$blockTrack);

            _.reinit();

        }

    };

    Slick.prototype.unload = function() {

        var _ = this;

        $('.slick-cloned', _.$blockr).remove();

        if (_.$dots) {
            _.$dots.remove();
        }

        if (_.$prevArrow && _.htmlExpr.test(_.options.prevArrow)) {
            _.$prevArrow.remove();
        }

        if (_.$nextArrow && _.htmlExpr.test(_.options.nextArrow)) {
            _.$nextArrow.remove();
        }

        _.$blocks
            .removeClass('slick-block slick-active slick-visible slick-current')
            .attr('aria-hidden', 'true')
            .css('width', '');

    };

    Slick.prototype.unslick = function(fromBreakpoint) {

        var _ = this;
        _.$blockr.trigger('unslick', [_, fromBreakpoint]);
        _.destroy();

    };

    Slick.prototype.updateArrows = function() {

        var _ = this,
            centerOffset;

        centerOffset = Math.floor(_.options.blocksToShow / 2);

        if ( _.options.arrows === true &&
            _.blockCount > _.options.blocksToShow &&
            !_.options.infinite ) {

            _.$prevArrow.removeClass('slick-disabled').attr('aria-disabled', 'false');
            _.$nextArrow.removeClass('slick-disabled').attr('aria-disabled', 'false');

            if (_.currentblock === 0) {

                _.$prevArrow.addClass('slick-disabled').attr('aria-disabled', 'true');
                _.$nextArrow.removeClass('slick-disabled').attr('aria-disabled', 'false');

            } else if (_.currentblock >= _.blockCount - _.options.blocksToShow && _.options.centerMode === false) {

                _.$nextArrow.addClass('slick-disabled').attr('aria-disabled', 'true');
                _.$prevArrow.removeClass('slick-disabled').attr('aria-disabled', 'false');

            } else if (_.currentblock >= _.blockCount - 1 && _.options.centerMode === true) {

                _.$nextArrow.addClass('slick-disabled').attr('aria-disabled', 'true');
                _.$prevArrow.removeClass('slick-disabled').attr('aria-disabled', 'false');

            }

        }

    };

    Slick.prototype.updateDots = function() {

        var _ = this;

        if (_.$dots !== null) {

            _.$dots
                .find('li')
                .removeClass('slick-active')
                .attr('aria-hidden', 'true');

            _.$dots
                .find('li')
                .eq(Math.floor(_.currentblock / _.options.blocksToScroll))
                .addClass('slick-active')
                .attr('aria-hidden', 'false');

        }

    };

    Slick.prototype.visibility = function() {

        var _ = this;

        if ( _.options.autoplay ) {

            if ( document[_.hidden] ) {

                _.interrupted = true;

            } else {

                _.interrupted = false;

            }

        }

    };

    $.fn.slick = function() {
        var _ = this,
            opt = arguments[0],
            args = Array.prototype.slice.call(arguments, 1),
            l = _.length,
            i,
            ret;
        for (i = 0; i < l; i++) {
            if (typeof opt == 'object' || typeof opt == 'undefined')
                _[i].slick = new Slick(_[i], opt);
            else
                ret = _[i].slick[opt].apply(_[i].slick, args);
            if (typeof ret != 'undefined') return ret;
        }
        return _;
    };

}));
