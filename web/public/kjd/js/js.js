if (navigator.appName == "Microsoft Internet Explorer") {
	$('body').addClass('ie');
	isie = true;
};
/*if (navigator.appName == "Microsoft Internet Explorer" && parseInt(navigator.appVersion.split(";")[1].replace(/[ ]/g, "").replace("MSIE", "")) < 9) {
	$('body').addClass('ie');
	isie = true;
};*/
//$('body').addClass('ie');
$(function() {
	var h = $(document).height();
	$('.bg').height(h);
	var flag = true;
	$(document).on('click', '.top .nav li', function() {
		var $t = $(this);
		var i = $t.index();
		$('.detail>ul>li').eq(i).show().siblings().hide();
		if (!$('body').is('.on')) {
			$('body').addClass('on');
			$('.detail').stop(true, true).slideDown(1000);
			$('.bg,.cbg').fadeOut(600);
			$('.tbg, .bbg').fadeIn(1000);
		} else {
			if ($t.is('.on')) {
				if (!flag) {
					return;
				}
				$('.detail').stop(true, true).slideUp(1000, function() {
					$('body').removeClass('on');
					$t.removeClass('on').addClass('rotate');
				});
				$('.bg,.cbg').fadeIn(1000);
				$('.tbg, .bbg').fadeOut(600);
			};
		};
		$t.addClass('on').removeClass('rotate').siblings().removeClass('on').addClass('rotate');
		slide(0, $('.detail>ul>li').eq(i).find('.tab'));
		flag = false
		setTimeout(function() {
			flag = true;
		}, 500);
	});

	//$('.nav.wrap li').eq(1).trigger('click');
	$('.centerwrpper .tab').tab({
		event: 'click',
		auto: false,
		after: function(i, e) {
			slide(i, e);
		}
	});

	function slide(i, e) {
		slider = e.find('.content>ul>li').eq(i).find('.canslider');
		if (!slider.parent().is('.sl-viewport')) {
			slider.slider({
				move: 1,
				num: 1,
				slideMargin: 0,
				loop: false,
				disableBtn: true
			});
		};
	}

	function resize() {
		var w = $(window).width();
		if (w > 1300) {
			$('body').removeClass('w1300');
		} else {
			$('body').addClass('w1300');
		}
	}
	resize();
	window.onresize = function() {
		resize();
	};

	var ishover = false;
	$('.buss3').hover(function() {
		ishover = true;
		$('.hoverbox').stop(false, true).fadeIn();
		$('.bussback3 .wave').addClass('wave3').removeClass('wave33');
	}, function() {
		ishover = false;
		setTimeout(function() {
			if (!ishover) {
				$('.hoverbox').stop(false, true).fadeOut();
				$('.bussback3 .wave').addClass('wave33').removeClass('wave3');
			}
		}, 10);
	});
	$('.hoverbox').hover(function() {
		ishover = true;
		$(this).stop(false, true).fadeIn();
		$('.bussback3 .wave').addClass('wave3').removeClass('wave33');
	}, function() {
		ishover = false;
		var t = $(this);
		setTimeout(function() {
			if (!ishover) {
				t.stop(false, true).fadeOut();
				$('.bussback3 .wave').addClass('wave33').removeClass('wave3');
			}
		}, 10);
	})

	$('.buss1').hover(function() {
		$('.bussback1 .wave').addClass('wave1').removeClass('wave11');
	}, function() {
		$('.bussback1 .wave').addClass('wave11').removeClass('wave1');
	});
	$('.buss2').hover(function() {
		$('.bussback2 .wave').addClass('wave2').removeClass('wave22');
	}, function() {
		$('.bussback2 .wave').addClass('wave22').removeClass('wave2');
	});
	$('.bcbtn1').hover(function() {
		$('.cir1 .circlet').addClass('circle1').removeClass('circle11');
	}, function() {
		$('.cir1 .circlet').addClass('circle11').removeClass('circle1');
	});
	$('.bcbtn2').hover(function() {
		$('.cir2 .circlet').addClass('circle1').removeClass('circle11');
	}, function() {
		$('.cir2 .circlet').addClass('circle11').removeClass('circle1');
	});
	$('.morebtn').hover(function() {
		$('.morebtnback1 .morewave').addClass('morewave1').removeClass('morewave11');
	}, function() {
		$('.morebtnback1 .morewave').addClass('morewave11').removeClass('morewave1');
	});

	$(document).on('click', '.show1title', function() {
		var t = $(this);
		p = t.parents('.showContent');
		p.find('.show2').hide();
		p.find('.show1').show();
	});

	var tipRemind = getCookie('tip');
	if (!tipRemind) {
		setCookie('tip', 1);
		tipRemind = getCookie('tip');
	}
	if (tipRemind <= 3) {
		$('.nav .tip').show();
		setCookie('tip', Number(tipRemind) + 1);
	};
	$(document).on('click', '.nav .tip .close', function() {
		$('.nav .tip').remove();
		setCookie('tip', 4);
	});
});