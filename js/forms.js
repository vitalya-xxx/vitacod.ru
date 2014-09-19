$(document).ready(function(){
    var lastChecked = null;
//    setInterval(function () {updateListChat();}, 20000);
//    showInfoPopup('info', false, '', 'Сайт находится на стадии разроботки!');
    var listMenusNavigation = jQuery('body').find('.listMenusNavigation');
    jQuery(listMenusNavigation).find('li.active a').addClass('activeMenu');

    /**
     * Инициализацич вкладок в кабиенте пользователя.
     */
    var tabs = $( "#tabs" ).tabs();


    /**
     * Ссылка для удаления фото
     */
    $('#deletePhoto').on('click', function(){
        var model       = $(this).attr('model'),
            idRow       = $(this).attr('idRow'),
            url         = $(this).attr('urlPhoto'),
            action      = $(this).attr('action'),
            widthImg    = $(this).attr('widthImg'),
            heightImg   = $(this).attr('heightImg');

        var data = {
            "model"     : model,
            "idRow"     : idRow,
            "urlPhoto"  : '/uploads/' + url
        };

        $.ajax({
            url     : yii.urls.base + action,
            type    : 'POST',
            data    : data,
            dataType: 'json',
            success : function(data){
                if (data.response) {
                    if ('undefined' != typeof(widthImg) && 'undefined' != typeof(widthImg)) {
                        $('img.uploadImg').attr('src', yii.urls.baseUrl + '/images/default/'+model+'.png').imgResizeCenter(parseInt(widthImg), parseInt(heightImg));
                    }
                    else {
                        $('img.uploadImg').attr('src', yii.urls.baseUrl + '/images/default/'+model+'.png').imgResizeCenter(257, 173);
                    }
                    $('#deletePhoto').hide();
                }
            }
        });
    });

    /**
     * Отображение превью добавляемой открытки и сохранения на сервере фото пользователя.
     */
    jQuery(document).on('change', '#dialog-add-file', function () {
        // Удаляем превью открытки (иначе глючит ресайз)
        var divPhoto    = jQuery('.divPreviewPhoto'),
            form        = jQuery(divPhoto).closest('form'),
            preview     = jQuery(divPhoto).find('.card'),
            widthImg    = jQuery(preview).attr('widthImg'),
            heightImg   = jQuery(preview).attr('heightImg');

        preview.empty();
        try {
            var file = this.files[0];
            var reader = new FileReader();
            reader.onload = function (e) {
                if (file.type.match('image.*')) {
                    if ('undefined' != typeof(widthImg) && 'undefined' != typeof(widthImg)) {
                        jQuery(preview).html('<img alt="Открытка" src="' + e.target.result + '" />').find("img").imgResizeCenter(parseInt(widthImg), parseInt(heightImg));
                    }
                    else {
                        jQuery(preview).html('<img alt="Открытка" src="' + e.target.result + '" />').find("img").imgResizeCenter(257, 173);
                    }
                }
            };
            reader.readAsDataURL(file);
        }
        catch (e) {
            jQuery(preview).html('<img alt="Предварительный просмотр недоступен" src="" />').find("img").imgResizeCenter(257, 173);
        }

        var ajaxUpload = jQuery(form).attr('ajaxUploadPhoto');

        if ('undefined' != typeof(ajaxUpload) && 1 == ajaxUpload) {
            var options,
                beforeSubmit,
                afterSubmit;

            beforeSubmit = function () {
                if (jQuery('#dialog-add-file').val() == "" && !file) {
                    alert("Ошибка", "Пожалуйста выберите файл");
                    return false;
                }

                if (file.size > (2 * 1024 * 1024)) {
                    alert("Ошибка", "Размер файла не должен превышаь 2 Мб");
                    return false;
                }
                return true;
            };

            afterSubmit = function(uploadData){
                if (uploadData.hasOwnProperty("error")) {
                    alert("Ошибка загрузки");
                    return false;
                }
                return true;
            };

            options = {
                beforeSubmit: beforeSubmit,
                success:      afterSubmit,
                url:          yii.urls.base + '/users/user_cabinet',
                type:         "post",
                dataType:     "json",
                timeout:      20000
            };

            // Вешаем события на форму
            jQuery(form).ajaxForm(options);
            jQuery(form).submit();
        }
    });


    /**
     * Ресайз картинки.
     */
    jQuery.fn.imgResizeCenter = function (wrapW, wrapH) {
        if (!jQuery(this).is('img')) {
            return false;
        }

        setTimeout(function(){
            jQuery(this).css('display', 'block')
        }, 500);

        jQuery(this).css('display', 'none').one("load",function () {
            // Размеры изображения
            var originalW   = jQuery(this)[0].naturalWidth,
                originalH   = jQuery(this)[0].naturalHeight,
                newW        = 0,
                newH        = 0,
                top         = 0,
                left        = 0,
                ratio       = 0;

            // Определяем какую из сторон приводим к нужному размеру
            if ((originalW / wrapW) > (originalH / wrapH)) {
                ratio = originalW / wrapW;
                newW = wrapW;
                newH = Math.floor(originalH / ratio);
                top = Math.floor((wrapH - newH) / 2);
            } else {
                ratio = originalH / wrapH;
                newW = Math.floor(originalW / ratio);
                newH = wrapH;
                left = Math.floor((wrapW - newW) / 2);
            }

            // Проверяем чтобы размеры были больше нуля
            newW = (newW < 1) ? 1 : newW;
            newH = (newH < 1) ? 1 : newH;

            // Считаем отступы
            jQuery(this).css({
                'width':         newW,
                'height':        newH,
                'display':       'block',
                'margin-top':    top,
                'margin-left':   left,
                'margin-right':  (wrapW - newW - left),
                'margin-bottom': (wrapH - newH - top)
            });
        }).each(function () {
                if (this.complete && jQuery(this).width() > 0) {
                    jQuery(this).trigger("load");
                }

                if (jQuery.browser === "msie" && this.readyState == 4) {
                    jQuery(this).trigger("load");
                }
            });

        return true;
    };


    /**
     * Попап добавления новой категории при создании статьи.
     */
    $('#showNewCategoryPopup').on('click', function(){
        var popup   = $(this).attr('popup'),
            body    = $('body');

        $.ajax({
            type		: 'POST',
            url			: yii.urls.base + '/admin/default/save_category',
            data		: {'popup' : popup},
            cache		: false,
            dataType	: 'json',
            success		: function (data) {
                $(body).append("<div class='popup-box' id='"+popup+"'></div>")
                    .find('#'+popup)
                    .append(data.popup);
                showPopup('#'+popup);

                var formObj     = $(body).find('#'+popup),
                    form        = $(formObj).find('form'),
                    idMenu      = $("#Articles_idMenu option:selected").val(),
                    titleMenu   = $("#Articles_idMenu option:selected").text();

                $(form).find('#Categorys_idMenu')
                    .empty()
                    .append( $('<option value="'+idMenu+'">'+titleMenu+'</option>'));

                $(formObj).find('#saveCategoryButton')
                    .click(function(){
                        var beforeSubmit,
                            afterSubmit;

                        beforeSubmit = function () {
                            var input = jQuery('#Categorys_title');
                            if (jQuery(input).val() == "" && jQuery(input).next('.errorMessage').length == 0) {
                                jQuery(input).after('<div class="errorMessage">Необходимо заполнить поле «Название».</div>');
                                return false;
                            }
                            return true;
                        };

                        afterSubmit = function (data) {
                            if (data.result) {
                                $('#Articles_idCategory').append( $('<option value="'+data.result.id+'">'+data.result.title+'</option>'));
                                $("#Articles_idCategory :last").attr("selected", "selected");
                                dialogDestroy(formObj);
                            }
                        };

                        options = {
                            beforeSubmit    : beforeSubmit,
                            success         : afterSubmit,
                            url             : yii.urls.base + '/admin/default/save_category',
                            type            : "post",
                            dataType        : "json",
                            timeout         : 20000
                        };

                        // Вешаем события на форму
                        jQuery(form).ajaxForm(options);
                    });

                $(formObj).find('#cancelButton')
                    .click(function(){
                        dialogDestroy(formObj);
                    });
            }
        });

        return false;
    });


    /**
     * Подстановка категорий под пункт меню при создании статьи.
     */
    $('#Articles_idMenu').on('change', function(){
        var idMenu = $(this).val();

        $.ajax({
            type		: 'POST',
            url			: yii.urls.base + '/articles/new_article',
            data		: {'idMenu' : idMenu},
            cache		: false,
            dataType	: 'json',
            success		: function (data) {
                var count   = data.categorys.length,
                    options = '';
                for ($i = 0; $i < count; $i++) {
                    options += '<option value="'+data.categorys[$i].id+'">'+data.categorys[$i].title+'</option>';
                }
                $('#Articles_idCategory').empty();
                $('#Articles_idCategory').append($(options));
            }
        });
    });

    
    /**
     * Кнопка "Написать статью" (проверка авторизации).
     */
    jQuery('#newArticleButtonInMenu').click(function(){
        if (yii.user.isGuest) {
            jQuery('#baseLoginLink').trigger('click');
        }
        else {
            document.location.href=yii.urls.base + '/articles/new_article';
        }
    });

    /**
     * Авторизиция админа
     */
    $('#loginBtnAdmin').on('click', function(){
        var form        = $(this).closest("#login-form"),
            inputLogin  = $(form).find("#LoginForm_login"),
            inputPass   = $(form).find("#LoginForm_password");

        validationLogin  = validationData(inputLogin, 'Логин');
        validationPass   = validationData(inputPass, 'пароль');

        if (!validationLogin || !validationPass) {
            return false;
        }
    });


    /**
     * Попап авторизации пользователя.
     */
    $('.baseLoginLink').on('click', function(){
        var popup       = $(this).attr('popup'),
            body        = $('body'),
            titlePopup  = 'Авторизация';

        $.ajax({
            type		: 'POST',
            url			: yii.urls.base + '/base/login',
            data		: {'popup' : popup},
            cache		: false,
            dataType	: 'json',
            success		: function (data) {
                $(body).append("<div class='popup-box' id='"+popup+"'></div>")
                    .find('#'+popup)
                    .append(data.popup);
                showPopup('#'+popup);

                var formObj     = $(body).find('#'+popup),
                    form        = $(formObj).find('form');

                $(form).find('#baseLoginButton')
                    .click(function(){
                        var inputLogin       = $(form).find('#LoginForm_login'),
                            inputPassword    = $(form).find('#LoginForm_password');

                        if (inputLogin.val() == "") {
                            if (jQuery(inputLogin).next('.errorMessage').length == 0) {
                                jQuery(inputLogin).after('<div class="errorMessage">Необходимо заполнить поле «Логин».</div>');
                            }
                        }
                        else {
                            jQuery(inputLogin).next('.errorMessage').remove();
                        }

                        if (inputPassword.val() == "") {
                            if (jQuery(inputPassword).next('.errorMessage').length == 0) {
                                jQuery(inputPassword).after('<div class="errorMessage">Необходимо заполнить поле «Пароль».</div>');
                            }
                        }
                        else {
                            jQuery(inputPassword).next('.errorMessage').remove();
                        }

                        if (inputLogin.val() == "" || inputPassword.val() == "") {
                            return false;
                        }

                        var LoginForm = {
                            'login'     : inputLogin.val(),
                            'password'  : inputPassword.val(),
                            'rememberMe': jQuery("#LoginForm_rememberMe").prop("checked") ? 1 : 0
                        };

                        $.ajax({
                            type		: 'POST',
                            url			: yii.urls.base + '/base/login',
                            data		: {"LoginForm" : LoginForm},
                            dataType	: 'json',
                            success		: function (data) {
                                if ('error' == data.result && jQuery(inputPassword).next('.errorMessage').length == 0) {
                                    jQuery(inputPassword).after('<div class="errorMessage">Не корректный логин или пароль.</div>');
                                        return false;
                                }
                                else if ('undefined' != typeof(data.url)) {
                                    window.location.replace(data.url);
                                }
                            }
                        });

                        return false;
                    });

                $(formObj).find('#closeAuthorise')
                    .click(function(){
                        dialogDestroy(formObj);
                    });
            }
        });
        return false;
    });


    /**
     * Поиск по сайту
     */
    jQuery('#searchInput').keypress(function(eventObject){
        if(eventObject.keyCode == 13){
            eventObject.preventDefault();
            if (jQuery(this).val().length == 0) {
                showInfoPopup('error', false, '', 'Вы ни чего не выбрали для поиска!!!');
                return false;
            }
            else {
                var params = {
                    'listType'      : 'search',
                    'soughtValue'   : jQuery(this).val()
                };

                $.ajax({
                    type		: 'POST',
                    url			: yii.urls.base + '/articles/list_articles',
                    data		: params,
                    cache		: false,
                    dataType	: 'json',
                    success		: function (data) {
                        var content = jQuery('body').find('.content');
                        if (data.popup) {
                            jQuery(content).empty().
                                html(data.popup);
                        }
                        else {
                            jQuery(content).empty().
                                html('По запросу "'+params.soughtValue+'" ни чего не найдено!');
                        }
                        return false;
                    }
                });
            }
        }
    });

    /**
     * Форма обратной связи
     */
    jQuery('#feedbackBtn').click(function(){
        jQuery.ajax({
            type		: 'POST',
            url			: yii.urls.base + '/base/feedback',
            cache		: false,
            dataType	: 'json',
            success		: function (data) {
                var popup = new Popup({
                    title   : 'Обратная связь',
                    body    : data.popup
                });

                popup.create().append();
                popup.show();
                jQuery('html,body').css('overflow', 'hidden');

                var form            = jQuery('body').find('form#feedback-form-feedbackView-form'),
                    inputName       = jQuery(form).find('#FeedbackForm_name'),
                    inputEmail      = jQuery(form).find('#FeedbackForm_email'),
                    inputMessage    = jQuery(form).find('#FeedbackForm_message');

                jQuery(form).find('#feedbackBtn')
                    .click(function(){
                        validationName  = validationData(inputName, 'Ваше имя');
                        validationEmail = checkmail(inputEmail, 'E-mail');
                        validationMsg   = validationData(inputMessage, 'Сообщение');

                        if (!validationName || !validationEmail || !validationMsg) {
                            return false;
                        }
                        else {
                            var params = {
                                'name'      : jQuery(inputName).val(),
                                'email'     : jQuery(inputEmail).val(),
                                'message'   : jQuery(inputMessage).val()
                            };

                            jQuery.ajax({
                                type		: 'POST',
                                url			: yii.urls.base + '/base/feedback',
                                cache		: false,
                                data        : {'FeedbackForm' : params},
                                dataType	: 'json',
                                success		: function (data) {
                                    if (data.hasOwnProperty("error")) {
                                        showInfoPopup('error', false, '', 'Не корректные данные!!!');
                                    }
                                    else {
                                        popup.hide();
                                        showInfoPopup('success', false, 'Все ок))', 'Сообщение успешно отправленно администратору');
                                    }
                                }
                            });
                        }

                });

                return false;
            }
        });
    });

    /**
     * Попап с списком статей пользователя в кабинете.
     */
    $('.userListArticles').on('click', function(){
        var listType    = $(this).attr('listType'),
            body        = $('body'),
            titlePopup  = '',
            idMenu      = null,
            idCategory  = null;

        switch (listType) {
            case 'cabinet_appruve' :
                titlePopup  = 'Ожидают модерацию';
                break;

            case 'cabinet_public' :
                titlePopup  = 'Опубликаванны';
                break;

            case 'cabinet_bookmarks' :
                titlePopup  = 'Закладки';
                idMenu      = ('undefined' != typeof($(this).attr('data-idMenu'))) ? $(this).attr('data-idMenu') : null;
                idCategory  = ('undefined' != typeof($(this).attr('data-idCategory'))) ? $(this).attr('data-idCategory') : null;
                break;
        }

        $.ajax({
            type		: 'POST',
            url			: yii.urls.base + '/articles/list_articles',
            data		: {
                'listType'      : listType,
                'idMenu'        : idMenu,
                'idCategory'    : idCategory
            },
            cache		: false,
            dataType	: 'json',
            success		: function (data) {
                var popup = new Popup({
                    title   : titlePopup,
                    body    : data.popup
                });

                popup.create().append();
                popup.show();
                $('html,body').css('overflow', 'hidden');

                return false;
            }
        });

        return false;
    });

    /**
     * Добавление комментария
     */
    jQuery(document).on('click', '#addCommentButton', null, function() {
        var form        = jQuery(this).closest('form'),
            idArticle   = jQuery(form).find('#idArticle').val(),
            idAuthor    = jQuery(form).find('#idAuthor').val(),
            inputText   = jQuery(form).find('#Comments_text'),
            text        = inputText.val();


        if (text == "" && jQuery(inputText).next('.errorMessage').length == 0) {
            jQuery(inputText).after('<div class="errorMessage">Комментарий не может быть пустым.</div>');
            return false;
        }
        if (text.length > 255 && jQuery(inputText).next('.errorMessage').length == 0) {
            jQuery(inputText).after('<div class="errorMessage">Текст не должен превышать 255 символов. Напечатано '+inputText.val().length+'</div>');
            return false;
        }

        jQuery(inputText).val('');
        jQuery('.errorMessage').remove();

        jQuery.ajax({
            type		: 'POST',
            url			: yii.urls.base + '/comments/save_comment',
            data		: {
                'idArticle' : idArticle,
                'text'      : text,
                'idAuthor'  : idAuthor
            },
            cache		: false,
            dataType	: 'json',
            success		: function (data) {
                if (!data) {
                    return false;
                }

                var divComments = jQuery('.listComments :first'),
                    prevElem    = jQuery(divComments).prev();

                jQuery(divComments).remove();
                jQuery(prevElem).after(data.listComments);
                return true;
            }
        });
        return false;
    });


    /**
     * Отправка сообщения в чат
     */
    jQuery(document).on('click', '#sendChat', null, function() {
        var form                = jQuery(this).closest('#formChat'),
            inputText           = jQuery(form).find('#inputChat'),
            text                = inputText.val(),
            lastMessageBlock    = $(form).next().find('.message:first'),
            addErrorDiv;

        addErrorDiv = function(errorText){
            if (jQuery(inputText).next('.errorMessage').length == 0) {
                jQuery(inputText).after('<div class="errorMessage">'+errorText+'</div>');
            }
            else {
                jQuery(inputText).next('.errorMessage').text(errorText);
            }
        };

        if (text == "") {
            addErrorDiv('Нет текста.');
            return false;
        }
        if (text.length > 100) {
            addErrorDiv('Текст не должен превышать 100 символов. Напечатано '+inputText.val().length+'.');
            return false;
        }

        jQuery(inputText).val('');
        jQuery('.errorMessage').remove();

        jQuery.ajax({
            type	: 'POST',
            url		: yii.urls.base + '/chat/save_chat',
            data	: {
                'action' : 'add',
                'text'   : text
            },
            cache		: false,
            dataType	: 'json',
            success		: function (data) {
                if (!data) {
                    return false;
                }

                var newMessage = '<div class="message">';
                newMessage += '<div class="author">'+data.result.nameUser+'</div>';
                newMessage += '<div class="date">'+data.result.date+'</div>';
                newMessage += '<div class="text">'+data.result.text+'</div>';
                newMessage += '</div>';

                if (0 != $(lastMessageBlock).length) {
                    $(lastMessageBlock).before(newMessage);
                }
                else {
                    $(form).next().append(newMessage);
                }

            }
        });
        return false;
    });


    /**
     * Добавление статьи в закладки
     */
    jQuery(document).on('click', '#buttonBookMarks', null, function() {
        var button      = jQuery(this),
            type        = jQuery(button).attr('data-type'),
            paramsAdd   = {
                'Bookmarks[idArticle]'   : jQuery(button).attr('data-idArticle'),
                'Bookmarks[idMenu]'      : jQuery(button).attr('data-idMenu'),
                'Bookmarks[idCategory]'  : jQuery(button).attr('data-idCategory')
            },
            paramsDelete = {
                'idBookmarks' : jQuery(button).attr('data-idBookmarks')
            };

        if ('add' == type) {
            jQuery.ajax({
                type		: 'POST',
                url			: yii.urls.base + '/bookmarks/save_bookmark',
                data		: paramsAdd,
                cache		: false,
                dataType	: 'json',
                success		: function (data) {
                    if (!data) {
                        return false;
                    }

                    jQuery(button).attr('data-idBookmarks', data.idBookmarks);
                    jQuery(button).attr('data-type', 'delete');
                    jQuery(button).text('Удалить из закладок');

                    return true;
                }
            });
        }

        if ('delete' == type) {
            jQuery.ajax({
                type		: 'POST',
                url			: yii.urls.base + '/bookmarks/delete_bookmark',
                data		: paramsDelete,
                cache		: false,
                dataType	: 'json',
                success		: function (data) {
                    if (!data) {
                        return false;
                    }

                    jQuery(button).attr('data-idBookmarks', '');
                    jQuery(button).attr('data-type', 'add');
                    jQuery(button).text('Добавить в закладки');

                    return true;
                }
            });
        }

        return false;
    });

    /**
     * Множественный выбор checkBoxs
     */
    jQuery(document).on('click', '#selectAll', null, function() {
        var checkBoxs   = jQuery('input:checkbox'),
            count       = jQuery(checkBoxs).length;

        if (jQuery(this).is(':checked')) {
            for ($i = 0; $i < count; $i++) {
                jQuery(checkBoxs).eq($i).attr('checked', true);
            }
        }
        else {
            for ($i = 0; $i < count; $i++) {
                jQuery(checkBoxs).eq($i).attr('checked', false);
            }
        }
    });


    /**
     * Множественный выбор checkBoxs удерживая SHIFT
     */
    jQuery(document).on('click', 'input:checkbox', null, function(event) {
        if(!lastChecked) {
            lastChecked = this;
            return;
        }

        if(event.shiftKey) {
            var start = jQuery('input:checkbox').index(this);
            var end = jQuery('input:checkbox').index(lastChecked);

            for(i=Math.min(start,end);i<=Math.max(start,end);i++) {
                jQuery('input:checkbox')[i].checked = lastChecked.checked;
            }
        }

        lastChecked = this;
    });

    /**
     * Включить - отключить чат
     */
    jQuery(document).on('click', '#chatOnOff', null, function(event) {
        var $this   = jQuery(this),
            action  = jQuery($this).attr('data-action');

        $.ajax({
            type		: 'POST',
            url			: yii.urls.base + '/admin/default/list_chat_msg',
            data		: {'action' : action},
            cache		: false,
            dataType	: 'json',
            success		: function (data) {
                if (data.hasOwnProperty('result')) {
                    var textBtn     = (1 == data.result) ? 'Отключить чат' : 'Включить чат',
                        newAction   = (1 == data.result) ? 'off' : 'on';
                    jQuery($this).text(textBtn).attr('data-action', newAction);
                }
            }
        });
    });

    /**
     * Скрыть/Открыть сообщение
     */
    jQuery(document).on('click', '#showHideMsg', null, function(event) {
        var $this           = this,
            idMsg           = parseInt(jQuery($this).closest('tr').children().eq(1).text()),
            selectedMsgId   = [];

        selectedMsgId.push(parseInt(idMsg));
        performAction ('hide', selectedMsgId, $this);
    });

    /**
     * Кнопка "Множественное действие с сообщениями"
     */
    jQuery('#multiActionChat').click(function(){
        var selectedCheckBox  = jQuery('input.selectOne:checkbox:checked'),
            countCHB          = jQuery(selectedCheckBox).length,
            selectedMsgId     = [],
            closepopup;

        if (0 >= countCHB) {
            showInfoPopup('error', true, 'Множественное действие с сообщениями', 'Не выбранно ни одного сообщения!');
            return false;
        }
        else {
            for ($i = 0; $i < countCHB; $i++) {
                selectedMsgId.push(parseInt(jQuery(selectedCheckBox).eq($i).parent().next().text()));
            }

            var text = "Выбранно "+countCHB+" сообщений.";
                text += "<br />";
                text += "Выберите действие:";
                text += "<br />";
                text += "<br />";
                text += "<div id='btnHideMsg' class='btnMsgPopup orangePopup'>Скрыть/Открыть</div>";
                text += "<div id='btnDeleteMsg' class='btnMsgPopup orangePopup'>Удалить</div>";
                text += "<div id='btnClosePopup' class='btnMsgPopup orangePopup'>Отмена</div>";

            showInfoPopup('info', false, 'Множественное действие с сообщениями', text, false);
            var editMessagePopup = jQuery('.errorMessagePopup');
            jQuery(editMessagePopup).css({'height':'146px'}).find('.message').css({'height':'80px'});

            jQuery(editMessagePopup).find('#btnClosePopup').click(function(){
                jQuery(editMessagePopup).remove();
            });

            jQuery(editMessagePopup).find('#btnHideMsg').click(function(){
                performAction ('hide', selectedMsgId, selectedCheckBox, closepopup);
            });

            jQuery(editMessagePopup).find('#btnDeleteMsg').click(function(){
                performAction ('delete', selectedMsgId, selectedCheckBox, closepopup);
            });

            closepopup = function () {
                jQuery(editMessagePopup).remove();
            };
        }
    });
});

/**
 * Отправка на сервер удаление/скрытие сообщения из чата
 */
function performAction (action, msgIds, selectedCheckBox, callback){
    callback = callback || null;

    var countCHB = jQuery(selectedCheckBox).length;

    // Отправка данных на сервер
    jQuery.ajax({
        url     : yii.urls.base + '/admin/default/list_chat_msg',
        type    : 'POST',
        data    : {
            'action': action,
            'msgIds': msgIds
        },
        dataType: 'json',
        success : function(data){
            if (data.hasOwnProperty('modifiedMsg')) {
                for ($i = 0; $i < countCHB; $i++) {
                    var tr          = jQuery(selectedCheckBox).eq($i).closest('tr'),
                        newState    = ('Скрыто' == jQuery(tr).children().eq(3).text()) ? 'Видно' : 'Скрыто',
                        img         = jQuery(tr).children().eq(8).find('img'),
                        newImg      = ('visible' == jQuery(img).attr('data-state')) ? 'hidden' : 'visible';

                    jQuery(tr).children().eq(3).text(newState);
                    jQuery(img).attr('data-state', newImg);
                    jQuery(img).attr('src', '/images/default/'+newImg+'.png');
                    jQuery(selectedCheckBox).eq($i).attr('checked', false);
                }
            }
            else if (data.hasOwnProperty('deletedMsg')) {
                for ($i = 0; $i < countCHB; $i++) {
                    var tr = jQuery(selectedCheckBox).eq($i).closest('tr');
                    jQuery(tr).remove();
                }

            }
            jQuery('#selectAll').attr('checked', false);
            if (callback) {
                callback();
            }
            return true;
        }
    });
};

/**
 * Обновление сообщений в чате
 */
function updateListChat(){
    var oldList     = $('.listChat'),
        lastMsgId   = $(oldList).find('.message:first').find('.idChat').text();

    $.ajax({
        type		: 'POST',
        url			: yii.urls.base + '/chat/UpdateListChat',
        data        : {'lastMsgId':lastMsgId},
        cache		: false,
        dataType	: 'json',
        success		: function (data) {
            if(!data){
                return false;
            }

            if ('undefined' != typeof(data.listChat) && '' != data.listChat) {
                $(oldList).children().remove();
                $(oldList).append(data.listChat);
            }
        }
    });
}

/**
 * Закрывает диалоговые окна
 */
function dialogDestroy(obj){
    $('#blackout').remove();
    $(obj).remove();
    $('html,body').css('overflow', 'visible');
}

/**
 * Просмотр статьи пользователя (из кабинета) в ПОПАПЕ
 */
function showArticlePopup(idArticle, type, from){
    from = from || 'cabinet';
    $.ajax({
        type		: 'POST',
        url			: yii.urls.base + '/articles/view_article',
        data		: {
            'idArticle' : idArticle,
            'type'      : type
        },
        cache		: false,
        dataType	: 'json',
        success		: function (data) {
            var popup = new Popup({
                title   : 'Просмотр статьи',
                body    : data.popup,
                close   : true
            });

            popup.create().append();
            popup.show();
            $('html,body').css('overflow', 'hidden');
            if ('cabinet' == from) {
                $('body').find('.popup :first').hide();
            }
            return false;
        }
    });
}


/**
 * Показывает попап окно с текстом ошибки.
 */
function showInfoPopup(type, btnOk, title, message, hideByTimer){
    title       = title || 'Внимание';
    message     = message || 'Ошибка';

    var nameClass;
    switch (type) {
        case 'error' :
            nameClass = 'redPopup';
            break;
        case 'info' :
            nameClass = 'orangePopup';
            break;
        case 'success' :
            nameClass = 'greenPopup';
            break;
    }

    var html = '<div class="errorMessagePopup '+nameClass+'"><div class="title '+nameClass+'">'+title+'</div><div class="message">'+message+'</div><div style="clear: both"></div><div class="btnContainer">';
    if (btnOk) {
        html += '<div class="btnMessagePopupClose '+nameClass+'">Ok</div></div><div style="clear: both">';
    }
    html += '</div></div>';

    var  body = jQuery('body'),
        popup;

    jQuery(body).append(html);
    popup = jQuery(body).find('.errorMessagePopup');

    var winWidth	= jQuery(window).width() + 20,
        scrollPos	= jQuery(window).scrollTop(),
        boxWidth	= jQuery(popup).width(),
        disWidth	= (winWidth - boxWidth) / 2,
        disHeight	= scrollPos + 20;

    if ('undefined' == typeof(hideByTimer) || true == hideByTimer) {
        jQuery(popup).css({'width' : boxWidth+'px', 'left' : disWidth+'px', 'top' : disHeight+'px', opacity : 0})
            .animate({opacity: 1.0}, 300);
    }
    else {
        jQuery(popup).css({'width' : boxWidth+'px', 'left' : disWidth+'px', 'top' : disHeight+'px', opacity : 1.0});
    }

    if (btnOk) {
        jQuery(popup).find('.btnMessagePopupClose').click(function(){
            jQuery(popup).remove();
        });
    }
    else {
        if ('undefined' == typeof(hideByTimer) || true == hideByTimer) {
            jQuery(popup).animate({opacity: 0}, 3000, 'swing', function(){jQuery(popup).remove()});
        }
    }

    return false;
}

/**
 * Проверка на заполнение поля
 */
function validationData(input, nameField){
    var errorMessage = null;

    if (jQuery(input).val() == "") {
        if (jQuery(input).next('.errorMessage').length == 1) {
            errorMessage = jQuery(input).next('.errorMessage');
            jQuery(errorMessage).show();

        }
        else {
            jQuery(input).after('<div class="errorMessage"></div>');
            errorMessage = jQuery(input).next('.errorMessage');
        }

        if (null != errorMessage && "" == jQuery(errorMessage).text()) {
            jQuery(errorMessage).text("Необходимо заполнить поле «"+nameField+"».")
        }

        return false;
    }
    else {
        jQuery(input).next('.errorMessage').remove();
        return true;
    }
}

/**
 * Проверка корректности email
 */
function checkmail(input, nameField) {
    var empty = validationData(input, nameField);

    if (!empty) {
        return false;
    }
    else {
        var value = jQuery(input).val();
        reg = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;

        if (!value.match(reg)) {
            if (jQuery(input).next('.errorMessage').length == 0) {
                jQuery(input).after('<div class="errorMessage">Введите корректный email.</div>');
            }
            return false;
        }
        else {
            jQuery(input).next('.errorMessage').remove();
            return true;
        }
    }
}

