<?php
	Yii::app()->clientScript->registerCoreScript('jquery');
	Yii::app()->clientScript->registerCssFile(Yii::app()->assetManager->publish('css/style.css'));
    Yii::app()->clientScript->registerCssFile(Yii::app()->assetManager->publish('css/forms_styles.css'));
    Yii::app()->clientScript->registerCssFile(Yii::app()->assetManager->publish('css/popup.css'));
    Yii::app()->clientScript->registerCssFile(Yii::app()->assetManager->publish('css/myPager.css'));

    Yii::app()->clientScript->registerCssFile(
        Yii::app()->clientScript->getCoreScriptUrl().
            '/jui/css/base/jquery-ui.css'
    );
    Yii::app()->clientScript->registerScriptFile(Yii::app()->assetManager->publish('js/libs/popup.jquery.js'));
    Yii::app()->clientScript->registerScriptFile(Yii::app()->assetManager->publish('js/forms.js'));
    Yii::app()->clientScript->registerScriptFile(Yii::app()->assetManager->publish('js/popup.js'));
    Yii::app()->clientScript->registerScriptFile(Yii::app()->assetManager->publish('js/libs/jquery.form.min.js'));
    Yii::app()->getClientScript()->registerCoreScript('jquery.ui');
	Yii::app()->clientScript->registerScript('helpers', '
	    yii = {
            urls: {
                base      : '.CJSON::encode(Yii::app()->createUrl('')).',
                baseUrl   : '.CJSON::encode(Yii::app()->getBaseUrl()).'
            },
            user: {
                isGuest : '.CJSON::encode(Yii::app()->user->isGuest).'
            }
        };
    ');
?>
<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.2/styles/default.min.css">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.2/highlight.min.js"></script>
</head>

<body>
    <div class="header">
        <div>
            <?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/vitacod_com_logo.png', '', array('class'=>'logoImg')), Yii::app()->request->baseUrl.'/base/index')?>
            <!--ВЕРХНЕЕ МЕНЮ-->
            <div class="navigation">
                <?php $this->widget('zii.widgets.CMenu',array(
                    'items'         => $this->topMenu,
                    'htmlOptions'   => array('class'=>'first'),
                )); ?>

                <?php if ('default' != Yii::app()->controller->id):?>
                    <!-- КНОПКА КАРТА САЙТА-->
                    <ul>
                        <li><?php echo CHtml::link('Карта сайта', array('base/site_map'))?></li>
                    </ul>

                    <!-- КНОПКА ОБРАТНАЯ СВЯЗЬ-->
                    <ul>
                        <li><?php echo CHtml::link('Обратная связь', 'javascript:void(0)', array('id'=>'feedbackBtn'))?></li>
                    </ul>

                    <!-- КНОПКА ЛИЧНЫЙ КАБИНЕТ-->
                    <?php if (!Yii::app()->user->isGuest && 'Admins' != Yii::app()->session->get("typeAuthorize")):?>
                        <ul>
                            <li><?php echo CHtml::link('Личный кабинет', array('users/user_cabinet', 'idUser' => Yii::app()->user->id))?></li>
                        </ul>
                    <?php endif;?>
                <?php endif;?>

                <!--КНОПРКА ВХОД/ВЫХОД-->
                <?php if (!Yii::app()->user->isGuest):?>

                    <?php if ('Users' == Yii::app()->session->get("typeAuthorize")) :?>
                        <ul>
                            <li><?php echo CHtml::link('Выход ('.Yii::app()->user->login.')', array('base/logout'))?></li>
                        </ul>
                    <?php elseif ('Admins' == Yii::app()->session->get("typeAuthorize")) :?>
                        <ul>
                            <li><?php echo CHtml::link('Выход ('.Yii::app()->user->login.')', array('/admin/default/logout'))?></li>
                        </ul>
                    <?php endif;?>

                <?php elseif (Yii::app()->user->isGuest):?>
                    <?php if ('default' == Yii::app()->controller->id):?>
                        <ul>
                            <li><?php echo CHtml::link('Вход', array('default/index'))?></li>
                        </ul>
                    <?php else :?>
                        <ul>
                            <li class="baseLoginLink" popup="baseLogin"><?php echo CHtml::link('Вход', array('base/login'))?></li>
                        </ul>
                    <?php endif;?>
                <?php endif;?>

            </div>

            <?php if ('default' != Yii::app()->controller->id):?>
                <!--ПОИСК ПО САЙТУ-->
                <form action="" class="search">
                    <input id="searchInput" type="text" value="Поиск" onblur="this.value=!this.value?'Поиск':this.value;" onclick="this.value='';"/>
                    <input type="button" id="submit" value=""/>
                </form>
            <?php endif;?>
        </div>
        <!--СРЕДНЕЕ МЕНЮ ПО САЙТУ-->
        <div id="navigation">
            <div class="menuContainer">
                <div class="listMenusNavigation">
                    <?php $this->widget('zii.widgets.CMenu',array(
                    'items' => $this->middleMenu,
                )); ?>
                </div>
                <!--КНОПРКА ДОБАВИТЬ СТАТЬЮ-->
<!--                --><?php //echo CHtml::link("<div id='newArticleButtonInMenu' class='greenButton'>Написать статью</div>", 'javascript:void(0)')?>
            </div>
        </div>
    </div>

    <?php echo $content; ?>

    <div class="footer">
        <p>&#169; 2011 Herdesigns. All Rights Reserved.</p>
    </div>
</body>
</html>
