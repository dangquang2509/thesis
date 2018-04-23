jQuery(document).ready(function($) {
	{
		$('.dropdown').on('show.bs.dropdown', function() {
			$(this).find('.dropdown-menu').first().stop(true, true).slideDown(200);
		});

		$('.dropdown').on('hide.bs.dropdown', function() {
			$(this).find('.dropdown-menu').first().stop(true, true).slideUp(200);
		});

		$('#main-menu .navbar-nav>li.dropdown').hover(function(){
			// $(this).addClass('open');
			$(this).find('.dropdown-menu').first().stop(true, true).slideDown(200);
		}, function(){
			// $(this).addClass('open');
			$(this).find('.dropdown-menu').first().stop(true, true).slideUp(200);
		});
	}
	{
		var slider = setSlide();
		if (slider.length > 0)
			$(window).resize(function(){
				slider.reloadSlider();
			})
		function setSlide(){
			return $("section.slider ul.bxslider").bxSlider({
				mode: 'fade',
				pager: false,
				controls: true,
				prevText: "<i class='icon ion-ios-arrow-thin-left'></i>",
				prevSelector: 'section.slider .control .prev',
				nextText: "<i class='icon ion-ios-arrow-thin-right'></i>",
				nextSelector: 'section.slider .control .next'
			});
		}
	}
	{
		if ($("main#homepage").length > 0 && $(window).width() > 991){
			function stickyScroll(){
				if($(window).scrollTop() > 50)
					$("#main-menu").addClass('sticky');
				else $("#main-menu").removeClass('sticky');
			}
			stickyScroll();
			$(window).scroll(function(event) {
				stickyScroll();
			});
		} else {
			$("#main-menu").addClass('sticky');
		}
		function scrollTopBtn(){
			if($(window).scrollTop() > 60)
				$("#scroll-top").addClass('open');
			else $("#scroll-top").removeClass('open');
		}
		scrollTopBtn();
		$(window).scroll(function(event) {
			scrollTopBtn();
		});
		$("#scroll-top").click(function(event) {
			$("body").animate({scrollTop: 0}, 400);
		});
		$(".scroll-next").click(function(event) {
			$("body").animate({scrollTop: $("section.filter").position().top - $('#main-menu').innerHeight()}, 300)
			return false;
		});
	}
	{
		function loadWidthPropertyOverlay(){
			$(".property-info").each(function(index, el) {
				var width = $(this).find(".property-container").innerWidth();
				$(this).find(".overlay").width(width);
				var height = $(this).find(".property-container").innerHeight();
				$(this).find(".overlay").height(height);
			});
		}
		loadWidthPropertyOverlay();
		$(window).resize(function(event) {
			loadWidthPropertyOverlay();
		});
		$(".property-info").hover(function(){
			var responsive = $(this).data("responsive");
			responsive = (responsive) ? parseInt(responsive) : -1;
			if (responsive==-1 || $(window).width() > responsive){
				$(this).addClass('open');
				$(this).find('.description').stop(true, false).slideDown();
			}
		}, function(){
			$(this).removeClass('open');
			$(this).find('.description').stop(true, false).slideUp();
		})
	}
	{
		$(".archive-blog .blog-list").owlCarousel({
			loop: false,
			items: 2,
			nav:true,
			navText: ["<i class='icon ion-ios-arrow-thin-left'></i>","<i class='icon ion-ios-arrow-thin-right'></i>"],
			responsive: {
				0: {
					items: 1
				},
				767: {
					items: 2
				}
			}
		});
	}
	{
		$(".select2").select2();
		$(window).resize(function(event) {
			$(".select2").select2();
		});
	}
	{
		if($("#sub-menu").length > 0){
			var mainMenu = $("#main-menu");
			var subMenu = $("#sub-menu");
			mainMenu.css({"transition": "none"})
			stickySub()
			$(window).scroll(function(event) {
				stickySub()
			});
			function stickySub(){
				var scrollTop = $(window).scrollTop();
				mainMenu.css({ top: "-"+scrollTop+"px" });
				var topSubMenu = Math.min(scrollTop, mainMenu.innerHeight())
				subMenu.css({ top: "-"+topSubMenu+"px" });
			}
		}
	}
	{
		$("section.property-content .block .slider").each(function(index, el) {
			var sliderContainer = $(this);
			var slider = sliderContainer.find('.slider-list');
			var items = slider.children();
			slider.bxSlider({
				pager: false,
				nextText: "<i class='ion-ios-arrow-forward icon'></i>",
				prevText: "<i class='ion-ios-arrow-back icon'></i>",
				nextSelector: sliderContainer.find('.control'),
				prevSelector: sliderContainer.find('.control'),

				onSliderLoad: function(currentIndex){
					sliderContainer.find('.counter .count-slide').text(items.length)
					sliderContainer.find('.counter .current-slide').text(currentIndex + 1)
				},
				onSlideAfter: function($slideElement, oldIndex, newIndex){
					sliderContainer.find('.counter .current-slide').text(newIndex + 1)
				}
			});
			function loadCounter(){

			}
		});
	}
	{
		$('a').click(function(event) {
			href = $(this).attr("href");
			if (!href.startsWith("#") || href.length < 2) return;
			var popup = $(href);
			if (popup.hasClass('nvh_popup') && popup.length > 0){
				openPopup(popup);
				return false;
			}
		});
		$('.nvh_popup').each(function(index, el) {
			var popup = $(this);
			popup.find(".close-popup").click(function(event) {
				closePopup(popup);
			});
			setTimeoutOpenPopup(popup);

		});
		function openPopup(popup){
			popup.addClass('open');
			openFix()
		}
		function closePopup(popup){
			popup.removeClass('open');
			closeFix();
			setTimeoutOpenPopup(popup);
		}
		function setTimeoutOpenPopup(popup){
			var timeout = popup.data("auto-open");
			timeout = parseInt(timeout);
			if (!timeout) return;
			setTimeout(function(){
				openPopup(popup)
			}, timeout);
		}
		function openFix(){
			$("body").css({
				'overflow': 'hidden',
				'padding-right': getScrollBarWidth () + "px"
			});
		}
		function closeFix(){
			$("body").css({
				'overflow': '',
				'padding-right': ""
			});
		}
		function getScrollBarWidth () {
			var inner = document.createElement('p');
			inner.style.width = "100%";
			inner.style.height = "200px";

			var outer = document.createElement('div');
			outer.style.position = "absolute";
			outer.style.top = "0px";
			outer.style.left = "0px";
			outer.style.visibility = "hidden";
			outer.style.width = "200px";
			outer.style.height = "150px";
			outer.style.overflow = "hidden";
			outer.appendChild (inner);

			document.body.appendChild (outer);
			var w1 = inner.offsetWidth;
			outer.style.overflow = 'scroll';
			var w2 = inner.offsetWidth;
			if (w1 == w2) w2 = outer.clientWidth;

			document.body.removeChild (outer);

			return (w1 - w2);
		};
	}
	{
		var sendDataOption = {
			action: "",
			nName: "",
			nEmail: "",
			nPhone: "",
			nContent: "",
			nUrl: "",
			nFormName: ""
		};
		$(".form-submit").each(function(index, el) {
			var form = $(this);
			form.find('.submit').click(function(event) {
				var name = form.find("[name=name]").val();
				var email = form.find("[name=email]").val();
				var phone = form.find("[name=phone]").val();
				var content = form.find("[name=content]").val();
				content = (content) ? content : "";
				var url = form.find("[name=url]").val();
				var form_name = form.find("[name=form_name]").val();
				var redirect = form.find("[name=redirect]").val();
				redirect = (redirect) ? redirect : "/thank-you";

				var result = "";
				var reg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
				var regPhone = /^(\()?\d{3}(\))?(-|\s)?\d{3}(-|\s)\d{4}$/;
				if (name == "")
					result += "<p>Vui lòng nhập Họ và Tên</p>";
				if (email == ""){
					result += "<p>Vui lòng nhập Email</p>";
				} else if (!reg.test(email)){
					result += "<p>Vui lòng nhập đúng định dạng Email</p>";
				}
				if (phone == "")
					result += "<p>Vui lòng nhập số điện thoại</p>";

				if (result.length > 0) { bootbox.alert(result); return false; }

				bootbox.alert("Đang nhận thông tin. Vui lòng đợi trong giây lát...");
				sendData({
					name: name,
					email: email,
					phone: phone,
					content: content,
					url: url,
					form_name: form_name
				}, function(){
					bootbox.hideAll();
					window.location = redirect;
				})
			});
		});
		function sendData(data, callback=false){
			var dataPost = {};
			dataPost[sendDataOption.nName] = data.name;
			dataPost[sendDataOption.nEmail] = data.email;
			dataPost[sendDataOption.nPhone] = data.phone;
			dataPost[sendDataOption.nContent] = data.content;
			dataPost[sendDataOption.nUrl] = data.url;
			dataPost[sendDataOption.nFormName] = data.form_name;
			$.post(sendDataOption.action, dataPost, function(data,status){ });
			setTimeout(function(){
				if(callback) callback();
			}, 1000);
		}
	}
	{
		$("#sub-menu .navbar-inverse .navbar-nav>li>a").click(function(event) {
			var href = $(this).attr("href");
			if (!href.startsWith("#") || href.length < 2) return;
			var e2Scroll = $(href);
			if (e2Scroll.length > 0){
				var top = e2Scroll.offset().top;
				var offsetTop = $("#sub-menu .navbar").outerHeight();
				$('body').animate({
					scrollTop: top - offsetTop
				},400);
				return false;
			}
		});
		$(document).on("scroll", onScroll);
		function onScroll(event){
			var scrollPosition = $(document).scrollTop();
			$('#sub-menu .navbar-inverse .navbar-nav>li').each(function () {
				var eParent = $(this);
				var currentLink = $(this).find("a");
				var href = currentLink.attr("href");
				if (!href.startsWith("#") || href.length < 2) return;
				var refElement = $(href);
				if (refElement.offset().top <= scrollPosition 
					&& refElement.offset().top + refElement.height() > scrollPosition) {
					$('#sub-menu .navbar-inverse .navbar-nav>li').removeClass("active");
					eParent.addClass("active");
				}
				else{
					currentLink.removeClass("active");
				}
			});
		}
	}
});

