/**
 * Создает HTML элемент всплывающего окна
 * @return:object HTML обьект всплывающего окна
 */
function Popup(params){
	params=params || {};

	//свойства
	this.title=params.title || '';
	this.body=params.body || '';

	this.object=null;

	//метод создание окна
	this.create=function(){
		this.object=$('<div class="popup" style="display:none;"></div>');

		var header=$('<div class="popup-header"><div class="float-left">'+this.title+'</div><div class="float-right text-btn close-popup-btn">Закрыть</div><div class="float-clear"></div></div>'),
			body=$('<div class="popup-body">'+this.body+'</div>');

		this.object.append(header).append(body);

		return this;
	}

	//метод отображения окна
	this.show=function(){
		var csstop=this.object.outerHeight()>$(window).height()?50:$(window).height()/2-this.object.outerHeight()/2;

		this.object
				.css({
					top:csstop,
					left:$(window).width()/2-this.object.outerWidth()/2
				})
				.show();

		return true;
	}

	//метод добавления окна
	this.append=function(){
		//изменяем ширину всего контента, чтобы выглядел нормально скролл
        //ЗАКОМЕНЧЕНО - ИЗ-ЗА ЭТОГО НЕ РАБОТАЕТ JS В CGRIDVIEW
//		$('body').wrapInner('<div class="fix-scroll-wrap"></div>');
//		$('.fix-scroll-wrap').css('width', $('body').width());
		$('body').addClass('overflow-hidden');

		//отображаем overlay
		$('body').append('<div id="overlay"></div>');

		//создаем враппер для всплывающего окна(для скроллинга)
		var wrap=$('<div class="popup-wrapper"></div>');
		wrap.appendTo('body');

		//центрируем всплывающее окно
		this.object.appendTo(wrap);

		var _this=this;
		this.object.find('.close-popup-btn').click(function(){
			_this.hide();
		});

		return this;
	}

	//закрыть всплывающее окно
	this.hide=function(){
        $('#overlay :last, .popup-wrapper :last').remove();
		$('body').removeClass('overflow-hidden :last').children().each(function(){
			$(this).unwrap();
		});

        var firstPopup = $('body').find('.popup :first');
        if (firstPopup.length > 0) {
            $(firstPopup).show();
        }
        else {
            $('#overlay').remove();
            $("html,body").css("overflow","auto");
        }

		return true;
	}
}