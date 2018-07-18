/* jshint ignore:start */
/*
 * 	Easy Slider 1.7.5 - jQuery plugin
 *	written by Alen Grakalic
 *	http://cssglobe.com/post/4004/easy-slider-15-the-easiest-jquery-plugin-for-sliding
 *
 *	Copyright (c) 2009 Alen Grakalic (http://cssglobe.com)
 *	Dual licensed under the MIT (MIT-LICENSE.txt)
 *	and GPL (GPL-LICENSE.txt) licenses.
 *
 *	Built for jQuery library
 *	http://jquery.com
 *
 * 	Easy Slider 1.75 - jQuery plugin
 *	updated by Justin Carroll
 *	http://www.3circlestudio.com/
 *
 *	Added option "allControls" to show both next/previous/first/last and
 *  numeric paging all at once
 *
 */

/*
 *	markup example for $("#slider").easySlider();
 *
 * 	<div id="slider">
 *		<ul>
 *			<li><img src="images/01.jpg" alt="" /></li>
 *			<li><img src="images/02.jpg" alt="" /></li>
 *			<li><img src="images/03.jpg" alt="" /></li>
 *			<li><img src="images/04.jpg" alt="" /></li>
 *			<li><img src="images/05.jpg" alt="" /></li>
 *		</ul>
 *	</div>
 *
 */

(function($) {

	$.fn.easySlider = function(options){

		// default configuration properties
		var defaults = {
			prevId: 		'prevBtn',
			prevText: 		'Previous',
			nextId: 		'nextBtn',
			nextText: 		'Next',
			controlsShow:	true,
			controlsBefore:	'',
			controlsAfter:	'',
			controlsFade:	true,
			firstId: 		'firstBtn',
			firstText: 		'First',
			firstShow:		false,
			lastId: 		'lastBtn',
			lastText: 		'Last',
			lastShow:		false,
			vertical:		false,
			speed: 			800,
			auto:			true,
			pause:			7000,
			continuous:		false,
			numeric: 		false,
			numericId: 		'controls',
			allControls:	false,
			startIndex:		0
		};

		var options = $.extend(defaults, options);

		this.each(function() {
			var obj = $(this);
			var s = $("li", obj).length;
			var w = $("li", obj).width();
			var h = $("li", obj).height();
			var clickable = true;
			obj.width(w);
			obj.height(h);
			obj.css("overflow","hidden");
			var ts = s-1;
			var t = options.startIndex;

			$("ul", obj).css('width',s*w);

			if(options.continuous){
				$("ul", obj).prepend($("ul li:last-child", obj).clone().css("margin-left","-"+ w +"px"));
				$("ul", obj).append($("ul li:nth-child(2)", obj).clone());
				$("ul", obj).css('width',(s+1)*w);
			};

			if(!options.vertical) $("li", obj).css('float','left');

			if(options.controlsShow){
				var html = options.controlsBefore;
				if(options.numeric){
					html += '<ol id="'+ options.numericId +'"></ol>';
				} else if (options.allControls) {
                                        html += '<ol id="' + options.numericId + '">';
					if(options.firstShow) html += '<li id="'+ options.firstId +'"><a href=\"javascript:void(0);\">'+ options.firstText +'</a></li>';
					if(options.lastShow) html += ' <span id="'+ options.lastId +'"><a href=\"javascript:void(0);\">'+ options.lastText +'</a></li>';
					html += '</ol>';
					html += '<ol id="prevNextControls">';
                                        html += ' <li id="'+ options.prevId +'"><a href=\"javascript:void(0);\">'+ options.prevText +'</a></li>';
					html += ' <li id="'+ options.nextId +'"><a href=\"javascript:void(0);\">'+ options.nextText +'</a></li>';
                                        html += '</ol>';
				} else {
					html += '<div id="' + options.numericId + '">';
					html += '<a id="'+ options.prevId +'" href=\"javascript:void(0);\"><span class="sprite '+ options.prevId +'">'+ options.prevText +'</span></a>';
					html += '<a id="'+ options.nextId +'" href=\"javascript:void(0);\"><span class="sprite '+ options.nextId +'">'+ options.nextText +'</span></a>';
					html += '</div>';
				};

				html += options.controlsAfter;
				$(obj).after(html);
			};

			$("#"+options.nextId).click(function(){
				animate("next",true);
			});
			$("#"+options.prevId).click(function(){
				animate("prev",true);
			});

			function setCurrent(i){
				i = parseInt(i)+1;
				$('li', "#" + options.numericId).removeClass("current");
				$('li#' + options.numericId + i).addClass("current");
				setControlState(0, 1);
			};

			function setControlState(t, ts){
				if(t==ts){
					$("#"+options.nextId).addClass('disabled');
				} else {
					$("#"+options.nextId).removeClass('disabled');
				};
				if(t==0){
					$("#"+options.prevId).addClass('disabled');
				} else {
					$("#"+options.prevId).removeClass('disabled');
				};
			}

			function adjust(){
				if(t>ts) t=0;
				if(t<0) t=ts;
				if(!options.vertical) {
					$("ul",obj).css("margin-left",(t*w*-1));
				} else {
					$("ul",obj).css("margin-left",(t*h*-1));
				}
				clickable = true;
				if(options.numeric || options.allControls) setCurrent(t);
			};

			function animate(dir,clicked){
				if (clickable){
					clickable = false;
					var ot = t;
					switch(dir){
						case "next":
							t = (ot>=ts) ? (options.continuous ? parseInt(t)+1 : ts) : parseInt(t)+1;
							break;
						case "prev":
							t = (t<=0) ? (options.continuous ? t-1 : 0) : t-1;
							break;
						case "first":
							t = 0;
							break;
						case "last":
							t = ts;
							break;
						default:
							t = dir;
							break;
					};
					var diff = Math.abs(ot-t);
					var speed = diff*options.speed;
					if(!options.vertical) {
						p = (t*w*-1);
						$("ul",obj).animate(
							{ marginLeft: p },
							{ queue:false, duration:speed, complete:adjust }
						);
					} else {
						p = (t*h*-1);
						$("ul",obj).animate(
							{ marginTop: p },
							{ queue:false, duration:speed, complete:adjust }
						);
					};

					if(!options.continuous && options.controlsFade){
						setControlState(t, ts);
					};

					if(clicked) clearTimeout(timeout);
					if(options.auto && dir=="next" && !clicked){;
						timeout = setTimeout(function(){
							animate("next",false);
						},diff*options.speed+options.pause);
					};

				};

			};

                        if (options.startIndex > 0) {
                            $("ul",obj).css('marginLeft',options.startIndex*w*-1);
                        }

			// init
			var timeout;
			if(options.auto){;
                            timeout = setTimeout(function(){
                                    animate("next",false);
                            },options.pause);
			};

                        setCurrent(options.startIndex);

                        if(options.numeric || options.allControls) setCurrent(options.startIndex);

			if(!options.continuous && options.controlsFade){
				$("a","#"+options.prevId).hide();
				$("a","#"+options.firstId).hide();
			};
		});
	};
})(jQuery);
