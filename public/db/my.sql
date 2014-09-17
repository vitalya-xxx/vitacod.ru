-- phpMyAdmin SQL Dump
-- version 4.0.10
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 16 2014 г., 16:34
-- Версия сервера: 5.5.38-log
-- Версия PHP: 5.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `my`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `idAdmin` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `role` tinyint(2) NOT NULL,
  PRIMARY KEY (`idAdmin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `admins`
--

INSERT INTO `admins` (`idAdmin`, `login`, `password`, `role`) VALUES
(1, 'login', '698d51a19d8a121ce581499d7b701668', 7),
(6, 'сссссс', 'b71797cbf8dd8fd59cfe4ee517ed7b65', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `ansvers`
--

CREATE TABLE IF NOT EXISTS `ansvers` (
  `idAnsver` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idQuestion` int(10) unsigned NOT NULL,
  `text` text NOT NULL,
  `idUser` int(10) unsigned NOT NULL DEFAULT '0',
  `nameUser` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idAnsver`),
  KEY `ansvers_ibfk_2` (`idUser`),
  KEY `ansvers_ibfk_1` (`idQuestion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `idArticle` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `text` text NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `idUser` int(10) unsigned NOT NULL,
  `dateCreate` datetime DEFAULT NULL,
  `dateUpdate` datetime DEFAULT NULL,
  `moderationAppruv` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `public` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `deleted` tinyint(1) unsigned DEFAULT '0',
  `idCategory` int(10) unsigned DEFAULT NULL,
  `idMenu` tinyint(2) unsigned NOT NULL,
  `numberOfViews` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`idArticle`),
  KEY `articles_ibfk_3` (`idCategory`),
  KEY `articles_ibfk_1` (`idUser`),
  KEY `idMenu` (`idMenu`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- Дамп данных таблицы `articles`
--

INSERT INTO `articles` (`idArticle`, `title`, `description`, `text`, `photo`, `idUser`, `dateCreate`, `dateUpdate`, `moderationAppruv`, `public`, `deleted`, `idCategory`, `idMenu`, `numberOfViews`) VALUES
(35, 'Использование конструктора форм', 'При создании HTML форм часто приходится писать довольно большое количество повторяющегося кода, который почти невозможно использовать в других проектах. К примеру, для каждого поля ввода нам необходимо вывести описание и возможные ошибки валидации. Для того чтобы сделать… ', '<h2 id="sec-2">1. Общая идея&nbsp;</h2>\r\n<p>Конструктор форм использует объект&nbsp;CForm&nbsp;для описания параметров, необходимых для создания HTML формы, таких как модели и поля, используемые в форме, а также параметры построения самой формы. Разработчику достаточно создать объект&nbsp;CForm, задать его параметры и вызвать метод для построения формы.</p>\r\n<p>Параметры формы организованы в виде иерархии элементов формы. Корнем является объект&nbsp;CForm. Корневой объект формы включает в себя две коллекции, содержащие другие элементы:&nbsp;CForm::buttons&nbsp;иCForm::elements. Первая содержит кнопки (такие как &laquo;Сохранить&raquo; или &laquo;Очистить&raquo;), вторая &mdash; поля ввода, статический текст и вложенные формы &mdash; объекты&nbsp;CForm, находящиеся в коллекции&nbsp;CForm::elementsдругой формы. Вложенная форма может иметь свою модель данных и коллекции&nbsp;CForm::buttons&nbsp;иCForm::elements.</p>\r\n<p>Когда пользователи отправляют форму, данные, введённые в поля ввода всей иерархии формы, включая вложенные формы, передаются на сервер.&nbsp;CForm&nbsp;включает в себя методы, позволяющие автоматически присвоить данные полям соответствующей модели и провести валидацию.</p>\r\n<h2 id="sec-3">2. Создание простой формы&nbsp;</h2>\r\n<p>Ниже будет показано, как построить форму входа на сайт.</p>\r\n<p>Сначала реализуем действие&nbsp;<code>login</code>:</p>\r\n<div class="hl-code">\r\n<div class="hl-main">\r\n<pre><span class="hl-reserved">public</span> <span class="hl-reserved">function</span> <span class="hl-identifier">actionLogin</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span>\r\n<span class="hl-brackets">{</span>\r\n    <span class="hl-var">$model</span><span class="hl-code"> = </span><span class="hl-reserved">new</span> <span class="hl-identifier">LoginForm</span><span class="hl-code">;\r\n    </span><span class="hl-var">$form</span><span class="hl-code"> = </span><span class="hl-reserved">new</span> <span class="hl-identifier">CForm</span><span class="hl-brackets">(</span><span class="hl-quotes">''</span><span class="hl-string">application.views.site.loginForm</span><span class="hl-quotes">''</span><span class="hl-code">, </span><span class="hl-var">$model</span><span class="hl-brackets">)</span><span class="hl-code">;\r\n    </span><span class="hl-reserved">if</span><span class="hl-brackets">(</span><span class="hl-var">$form</span><span class="hl-code">-&gt;</span><span class="hl-identifier">submitted</span><span class="hl-brackets">(</span><span class="hl-quotes">''</span><span class="hl-string">login</span><span class="hl-quotes">''</span><span class="hl-brackets">)</span><span class="hl-code"> &amp;&amp; </span><span class="hl-var">$form</span><span class="hl-code">-&gt;</span><span class="hl-identifier">validate</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-brackets">)</span>\r\n        <span class="hl-var">$this</span><span class="hl-code">-&gt;</span><span class="hl-identifier">redirect</span><span class="hl-brackets">(</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-quotes">''</span><span class="hl-string">site/index</span><span class="hl-quotes">''</span><span class="hl-brackets">)</span><span class="hl-brackets">)</span><span class="hl-code">;\r\n    </span><span class="hl-reserved">else</span>\r\n        <span class="hl-var">$this</span><span class="hl-code">-&gt;</span><span class="hl-identifier">render</span><span class="hl-brackets">(</span><span class="hl-quotes">''</span><span class="hl-string">login</span><span class="hl-quotes">''</span><span class="hl-code">, </span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-quotes">''</span><span class="hl-string">form</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-var">$form</span><span class="hl-brackets">)</span><span class="hl-brackets">)</span><span class="hl-code">;\r\n</span><span class="hl-brackets">}</span></pre>\r\n</div>\r\n</div>\r\n<p>Вкратце, здесь мы создали объект&nbsp;CForm, используя конфигурацию, найденную по пути, который задан псевдонимом&nbsp;<code>application.views.site.loginForm</code>. Объект&nbsp;CForm, как описано в разделе &laquo;Создание модели&raquo;, использует модель&nbsp;<code>LoginForm</code>.</p>\r\n<p>Если форма отправлена, и все входные данные прошли проверку без ошибок, перенаправляем пользователя на страницу&nbsp;<code>site/index</code>. Иначе выводим представление&nbsp;<code>login</code>, описывающее форму.</p>\r\n<p>Псевдоним пути&nbsp;<code>application.views.site.loginForm</code>&nbsp;указывает на файл PHP<code>protected/views/site/loginForm.php</code>. Этот файл возвращает массив, описывающий настройки, необходимые для&nbsp;CForm:</p>\r\n<div class="hl-code">\r\n<div class="hl-main">\r\n<pre><span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span>\r\n    <span class="hl-quotes">''</span><span class="hl-string">title</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-quotes">''</span><span class="hl-string">Пожалуйста, представьтесь</span><span class="hl-quotes">''</span><span class="hl-code">,\r\n \r\n    </span><span class="hl-quotes">''</span><span class="hl-string">elements</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>\r\n        <span class="hl-quotes">''</span><span class="hl-string">username</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>\r\n            <span class="hl-quotes">''</span><span class="hl-string">type</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-quotes">''</span><span class="hl-string">text</span><span class="hl-quotes">''</span><span class="hl-code">,\r\n            </span><span class="hl-quotes">''</span><span class="hl-string">maxlength</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-number">32</span><span class="hl-code">,\r\n        </span><span class="hl-brackets">)</span><span class="hl-code">,\r\n        </span><span class="hl-quotes">''</span><span class="hl-string">password</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>\r\n            <span class="hl-quotes">''</span><span class="hl-string">type</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-quotes">''</span><span class="hl-string">password</span><span class="hl-quotes">''</span><span class="hl-code">,\r\n            </span><span class="hl-quotes">''</span><span class="hl-string">maxlength</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-number">32</span><span class="hl-code">,\r\n        </span><span class="hl-brackets">)</span><span class="hl-code">,\r\n        </span><span class="hl-quotes">''</span><span class="hl-string">rememberMe</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>\r\n            <span class="hl-quotes">''</span><span class="hl-string">type</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-quotes">''</span><span class="hl-string">checkbox</span><span class="hl-quotes">''</span><span class="hl-code">,\r\n        </span><span class="hl-brackets">)</span>\r\n    <span class="hl-brackets">)</span><span class="hl-code">,\r\n \r\n    </span><span class="hl-quotes">''</span><span class="hl-string">buttons</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>\r\n        <span class="hl-quotes">''</span><span class="hl-string">login</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>\r\n            <span class="hl-quotes">''</span><span class="hl-string">type</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-quotes">''</span><span class="hl-string">submit</span><span class="hl-quotes">''</span><span class="hl-code">,\r\n            </span><span class="hl-quotes">''</span><span class="hl-string">label</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-quotes">''</span><span class="hl-string">Вход</span><span class="hl-quotes">''</span><span class="hl-code">,\r\n        </span><span class="hl-brackets">)</span><span class="hl-code">,\r\n    </span><span class="hl-brackets">)</span><span class="hl-code">,\r\n</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre>\r\n</div>\r\n</div>\r\n<p>Настройки, приведённые выше, являются ассоциативным массивом, состоящим из пар имя-значение, используемых для инициализации соответствующих свойств&nbsp;CForm. Самыми важными свойствами, как мы уже упомянули, являются&nbsp;CForm::elements&nbsp;и&nbsp;CForm::buttons. Каждое из них содержит массив, определяющий элементы формы. Более детальное описание элементов формы будет приведено в следующем подразделе.</p>\r\n<p>Опишем шаблон представления&nbsp;<code>login</code>:</p>\r\n<div class="hl-code">\r\n<div class="hl-main">\r\n<pre><span class="hl-code">&lt;</span><span class="hl-identifier">h1</span><span class="hl-code">&gt;Вход&lt;/</span><span class="hl-identifier">h1</span><span class="hl-code">&gt;\r\n \r\n&lt;</span><span class="hl-identifier">div</span> <span class="hl-reserved">class</span><span class="hl-code">=</span><span class="hl-quotes">"</span><span class="hl-string">form</span><span class="hl-quotes">"</span><span class="hl-code">&gt;\r\n&lt;?</span><span class="hl-identifier">php</span> <span class="hl-reserved">echo</span> <span class="hl-var">$form</span><span class="hl-code">; </span><span class="hl-inlinetags">?&gt;</span><span class="hl-code">\r\n&lt;/</span><span class="hl-identifier">div</span><span class="hl-code">&gt;</span></pre>\r\n</div>\r\n</div>\r\n<blockquote class="tip">\r\n<p><strong>Подсказка:</strong>&nbsp;Приведённый выше код&nbsp;<code>echo $form;</code>&nbsp;эквивалентен&nbsp;<code>echo $form-&gt;render();</code>. Использование более компактной записи возможно, так как&nbsp;CForm&nbsp;реализует магический метод<code>__toString</code>, в котором вызывается метод&nbsp;<code>render()</code>, возвращающий код формы.</p>\r\n</blockquote>\r\n<h2 id="sec-4">3. Описание элементов формы&nbsp;</h2>\r\n<p>При использовании конструктора форм вместо написания разметки мы, главным образом, описываем элементы формы. В данном подразделе мы опишем, как задать свойство&nbsp;CForm::elements. Мы не будем описывать&nbsp;CForm::buttons, так как конфигурация этого свойства практически ничем не отличается отCForm::elements.</p>\r\n<p>Свойство&nbsp;CForm::elements&nbsp;является массивом, каждый элемент которого соответствует элементу формы. Это может быть поле ввода, статический текст или вложенная форма.</p>\r\n<h3 id="sec-8">Описание поля ввода</h3>\r\n<p>Поле ввода, главным образом, состоит из заголовка, самого поля, подсказки и текста ошибки и должно соответствовать определённому атрибуту модели. Описание поля ввода содержится в экземпляре классаCFormInputElement. Приведённый ниже код массива&nbsp;CForm::elements&nbsp;описывает одно поле ввода:</p>\r\n<div class="hl-code">\r\n<div class="hl-main">\r\n<pre><span class="hl-quotes">''</span><span class="hl-string">username</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>\r\n    <span class="hl-quotes">''</span><span class="hl-string">type</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-quotes">''</span><span class="hl-string">text</span><span class="hl-quotes">''</span><span class="hl-code">,\r\n    </span><span class="hl-quotes">''</span><span class="hl-string">maxlength</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-number">32</span><span class="hl-code">,\r\n</span><span class="hl-brackets">)</span><span class="hl-code">,</span></pre>\r\n</div>\r\n</div>\r\n<p>Здесь указано, что атрибут модели называется&nbsp;<code>username</code>, тип поля &mdash;&nbsp;<code>text</code>&nbsp;и его атрибут&nbsp;<code>maxlength</code>равен 32.</p>\r\n<p>Любое доступное для записи свойство&nbsp;CFormInputElement&nbsp;может быть настроено приведённым выше способом. К примеру, можно задать свойство&nbsp;hint&nbsp;для того, чтобы показывать подсказку или свойствоitems, если поле является выпадающим списком или группой элементов checkbox или radio. Если имя опции не является свойством&nbsp;CFormInputElement, оно будет считаться атрибутом соответствующего HTML-тега input. Например, так как опция&nbsp;<code>maxlength</code>&nbsp;не является свойством&nbsp;CFormInputElement, она будет использована как атрибут&nbsp;<code>maxlength</code>&nbsp;HTML-элемента input.</p>\r\n<p>Следует отдельно остановиться на свойстве&nbsp;type. Оно определяет тип поля ввода. К примеру, тип&nbsp;<code>text</code>означает, что будет использован элемент формы&nbsp;<code>input</code>, а&nbsp;<code>password</code>&nbsp;&mdash; поле для ввода пароля. ВCFormInputElement&nbsp;реализованы следующие типы полей ввода:</p>\r\n<ul>\r\n<li>text</li>\r\n<li>hidden</li>\r\n<li>password</li>\r\n<li>textarea</li>\r\n<li>file</li>\r\n<li>radio</li>\r\n<li>checkbox</li>\r\n<li>listbox</li>\r\n<li>dropdownlist</li>\r\n<li>checkboxlist</li>\r\n<li>radiolist</li>\r\n</ul>\r\n<p>Отдельно следует описать использование "списочных" типов&nbsp;<code>dropdownlist</code>,&nbsp;<code>checkboxlist</code>&nbsp;и&nbsp;<code>radiolist</code>. Для них необходимо задать свойство&nbsp;items&nbsp;соответствующего элемента input. Сделать это можно так:</p>\r\n<div class="hl-code">\r\n<div class="hl-main">\r\n<pre><span class="hl-quotes">''</span><span class="hl-string">gender</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>\r\n    <span class="hl-quotes">''</span><span class="hl-string">type</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-quotes">''</span><span class="hl-string">dropdownlist</span><span class="hl-quotes">''</span><span class="hl-code">,\r\n    </span><span class="hl-quotes">''</span><span class="hl-string">items</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-identifier">User</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">getGenderOptions</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">,\r\n    </span><span class="hl-quotes">''</span><span class="hl-string">prompt</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-quotes">''</span><span class="hl-string">Выберите значение:</span><span class="hl-quotes">''</span><span class="hl-code">,\r\n</span><span class="hl-brackets">)</span><span class="hl-code">,\r\n \r\n&hellip;\r\n \r\n</span><span class="hl-reserved">class</span> <span class="hl-identifier">User</span> <span class="hl-reserved">extends</span> <span class="hl-identifier">CActiveRecord</span>\r\n<span class="hl-brackets">{</span>\r\n    <span class="hl-reserved">public</span> <span class="hl-reserved">function</span> <span class="hl-identifier">getGenderOptions</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span>\r\n    <span class="hl-brackets">{</span>\r\n        <span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span>\r\n            <span class="hl-number">0</span><span class="hl-code"> =&gt; </span><span class="hl-quotes">''</span><span class="hl-string">Мужчина</span><span class="hl-quotes">''</span><span class="hl-code">,\r\n            </span><span class="hl-number">1</span><span class="hl-code"> =&gt; </span><span class="hl-quotes">''</span><span class="hl-string">Женщина</span><span class="hl-quotes">''</span><span class="hl-code">,\r\n        </span><span class="hl-brackets">)</span><span class="hl-code">;\r\n    </span><span class="hl-brackets">}</span>\r\n<span class="hl-brackets">}</span></pre>\r\n</div>\r\n</div>\r\n<p>Данный код сгенерирует выпадающий список с текстом &laquo;Выберите значение:&raquo; и опциями &laquo;Мужчина&raquo; и &laquo;Женщина&raquo;, которые мы получаем из метода&nbsp;<code>getGenderOptions</code>&nbsp;модели&nbsp;<code>User</code>.</p>\r\n<p>Кроме данных типов полей, в свойстве&nbsp;type&nbsp;можно указать класс или псевдоним пути виджета. Класс виджета должен наследовать&nbsp;CInputWidget&nbsp;или&nbsp;CJuiInputWidget. В ходе генерации элемента формы будет создан и выполнен экземпляр класса виджета. Виджет будет использовать конфигурацию, переданную через настройки элемента формы.</p>\r\n<h3 id="sec-9">Описание статического текста</h3>\r\n<p>Довольно часто в форме, помимо полей ввода, содержится некоторая декоративная HTML разметка. К примеру, горизонтальный разделитель для выделения определённых частей формы или изображение, улучшающее внешний вид формы. Подобный HTML код можно описать в коллекции&nbsp;CForm::elements&nbsp;как статический текст. Для этого в&nbsp;CForm::elements&nbsp;в нужном нам месте вместо массива необходимо использовать строку. Например:</p>\r\n<div class="hl-code">\r\n<div class="hl-main">\r\n<pre><span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span>\r\n    <span class="hl-quotes">''</span><span class="hl-string">elements</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-code">\r\n        ......\r\n        </span><span class="hl-quotes">''</span><span class="hl-string">password</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>\r\n            <span class="hl-quotes">''</span><span class="hl-string">type</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-quotes">''</span><span class="hl-string">password</span><span class="hl-quotes">''</span><span class="hl-code">,\r\n            </span><span class="hl-quotes">''</span><span class="hl-string">maxlength</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-number">32</span><span class="hl-code">,\r\n        </span><span class="hl-brackets">)</span><span class="hl-code">,\r\n \r\n        </span><span class="hl-quotes">''</span><span class="hl-string">&lt;hr /&gt;</span><span class="hl-quotes">''</span><span class="hl-code">,\r\n \r\n        </span><span class="hl-quotes">''</span><span class="hl-string">rememberMe</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>\r\n            <span class="hl-quotes">''</span><span class="hl-string">type</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-quotes">''</span><span class="hl-string">checkbox</span><span class="hl-quotes">''</span><span class="hl-code">,\r\n        </span><span class="hl-brackets">)</span>\r\n    <span class="hl-brackets">)</span><span class="hl-code">,\r\n    ......\r\n</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre>\r\n</div>\r\n</div>\r\n<p>В приведённом коде мы вставили горизонтальный разделитель между полями&nbsp;<code>password</code>&nbsp;и&nbsp;<code>rememberMe</code>.</p>\r\n<p>Статический текст лучше всего использовать в том случае, когда разметка и её расположение достаточно уникальны. Если некоторую разметку должен содержать каждый элемент формы, лучше всего переопределить непосредственно построение разметки формы, как будет описано далее.</p>', '541827e80bd7c.png', 10, '2014-09-16 16:07:04', NULL, 1, 1, 0, 28, 26, 2);

--
-- Триггеры `articles`
--
DROP TRIGGER IF EXISTS `deleteArticles`;
DELIMITER //
CREATE TRIGGER `deleteArticles` AFTER DELETE ON `articles`
 FOR EACH ROW BEGIN
    DELETE FROM `searcharticles` WHERE `idArticle`=OLD.`idArticle`;
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `insertArticles`;
DELIMITER //
CREATE TRIGGER `insertArticles` AFTER INSERT ON `articles`
 FOR EACH ROW BEGIN 
	INSERT INTO `searcharticles` (`idArticle`, `title`, `description`, `text`) VALUES 
	(NEW.`idArticle`, NEW.`title`, NEW.`description`, NEW.`text`);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `updateArticles`;
DELIMITER //
CREATE TRIGGER `updateArticles` AFTER UPDATE ON `articles`
 FOR EACH ROW BEGIN
        UPDATE `searcharticles` SET
            `title`=OLD.`title`,
            `description`=OLD.`description`,
            `text`=OLD.`text`
        WHERE `idArticle`=OLD.`idArticle`;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `bookmarks`
--

CREATE TABLE IF NOT EXISTS `bookmarks` (
  `idBookmarks` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idUser` int(10) unsigned NOT NULL,
  `idArticle` int(10) unsigned NOT NULL,
  `idMenu` tinyint(2) unsigned NOT NULL,
  `idCategory` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idBookmarks`),
  KEY `idArticle` (`idArticle`),
  KEY `idMenu` (`idMenu`),
  KEY `idCategory` (`idCategory`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Структура таблицы `categorys`
--

CREATE TABLE IF NOT EXISTS `categorys` (
  `idCategory` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `photo` varchar(255) DEFAULT NULL,
  `idMenu` tinyint(2) unsigned NOT NULL,
  `active` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`idCategory`),
  KEY `idMenu` (`idMenu`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Дамп данных таблицы `categorys`
--

INSERT INTO `categorys` (`idCategory`, `title`, `description`, `photo`, `idMenu`, `active`) VALUES
(25, 'MySQL', '', NULL, 28, 1),
(26, 'MongoDB', '', NULL, 28, 1),
(28, 'Формы', '', NULL, 26, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `chat`
--

CREATE TABLE IF NOT EXISTS `chat` (
  `idChat` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `text` varchar(255) NOT NULL,
  `idUser` int(10) unsigned NOT NULL DEFAULT '0',
  `nameUser` varchar(255) NOT NULL DEFAULT '0',
  `date` int(20) DEFAULT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`idChat`),
  KEY `chat_ibfk_1` (`idUser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Дамп данных таблицы `chat`
--

INSERT INTO `chat` (`idChat`, `text`, `idUser`, `nameUser`, `date`, `active`) VALUES
(11, 'hhh', 10, '0', 1410855081, 1),
(12, 'uuu', 10, '0', 1410855085, 1),
(13, 'Привет)', 11, '0', 1410855164, 1),
(14, 'Здарова))', 10, '0', 1410855205, 0),
(15, 'fff', 10, '0', 1410856674, 1),
(16, 'hh', 10, '0', 1410858172, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `idComment` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idUser` int(10) unsigned NOT NULL,
  `idArticle` int(10) unsigned NOT NULL,
  `text` text NOT NULL,
  `deleted` tinyint(1) unsigned DEFAULT '0',
  `typeUser` varchar(50) DEFAULT '0',
  `public` tinyint(1) unsigned DEFAULT '1',
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`idComment`),
  KEY `idArticle` (`idArticle`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Структура таблицы `dialogs`
--

CREATE TABLE IF NOT EXISTS `dialogs` (
  `idDialog` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idDiscussion` int(10) unsigned NOT NULL,
  `idUser` int(10) unsigned NOT NULL,
  `nameUser` varchar(255) NOT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`idDialog`),
  KEY `idDiscussion` (`idDiscussion`),
  KEY `dialogs_ibfk_2` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `discussions`
--

CREATE TABLE IF NOT EXISTS `discussions` (
  `idDiscussion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idArticle` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idDiscussion`),
  KEY `idArticle` (`idArticle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `links`
--

CREATE TABLE IF NOT EXISTS `links` (
  `link_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `link` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`link_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Дамп данных таблицы `links`
--

INSERT INTO `links` (`link_id`, `link`, `description`) VALUES
(5, '/articles/list_articles/', 'список статей (разделов, категорий)'),
(6, 'default/list_razdels', 'список разделов в админке'),
(7, 'default/list_categorys', 'список категорий в админке'),
(8, 'default/list_articles', 'список статей в админке'),
(9, '/admin/default/list_admins', 'список админов в админке'),
(10, '/admin/default/list_users', 'список пользователей в админке'),
(11, '/admin/default/list_chat_msg', 'список сообщений чата в админке'),
(12, '/admin/default/list_links', 'список ссылок в админке'),
(13, '/users/user_cabinet', 'личный кабинет пользователя на сайте');

-- --------------------------------------------------------

--
-- Структура таблицы `mainmenu`
--

CREATE TABLE IF NOT EXISTS `mainmenu` (
  `idMenu` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `position` tinyint(2) unsigned NOT NULL,
  `type` enum('top','middle','bottom') NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `partSite` enum('site','admin') NOT NULL,
  `visible` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `mayBeCat` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `photo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idMenu`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Дамп данных таблицы `mainmenu`
--

INSERT INTO `mainmenu` (`idMenu`, `title`, `position`, `type`, `link`, `partSite`, `visible`, `mayBeCat`, `photo`) VALUES
(15, 'Разделы', 1, 'middle', 'default/list_razdels', 'admin', 1, 1, NULL),
(16, 'Категории', 2, 'middle', 'default/list_categorys', 'admin', 1, 1, NULL),
(17, 'Статьи', 3, 'middle', 'default/list_articles', 'admin', 1, 1, NULL),
(19, 'Вопросы и ответы', 4, 'middle', 'default/list_questions', 'admin', 1, 1, NULL),
(21, 'Администраторы', 1, 'top', '/admin/default/list_admins', 'admin', 1, 0, NULL),
(22, 'Пользователи', 5, 'middle', '/admin/default/list_users', 'admin', 1, 1, NULL),
(23, 'Чат', 6, 'middle', '/admin/default/list_chat_msg', 'admin', 1, 1, NULL),
(24, 'Ссылки', 8, 'middle', '/admin/default/list_links', 'admin', 1, 1, NULL),
(26, 'Yii', 1, 'middle', '/articles/list_articles/', 'site', 1, 1, NULL),
(27, 'PHP', 2, 'middle', '/articles/list_articles/', 'site', 1, 1, NULL),
(28, 'Базы данных', 3, 'middle', '/articles/list_articles/', 'site', 1, 1, NULL),
(29, 'HTML/CSS', 4, 'middle', '/articles/list_articles/', 'site', 1, 1, NULL),
(30, 'JS/jQuery', 6, 'middle', '/articles/list_articles/', 'site', 1, 1, NULL),
(31, 'FLASH/ActionScript', 7, 'middle', '/articles/list_articles/', 'site', 1, 1, NULL),
(32, 'Сервер', 1, 'middle', '/articles/list_articles/', 'site', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `idQuestion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `text` text,
  `idUser` int(10) unsigned NOT NULL,
  `nameUser` varchar(255) DEFAULT NULL,
  `idThem` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idQuestion`),
  KEY `idThem` (`idThem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `razdels`
--

CREATE TABLE IF NOT EXISTS `razdels` (
  `idRazdel` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `photo` varchar(255) DEFAULT NULL,
  `active` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`idRazdel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `idRole` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idRole`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`idRole`, `title`, `description`) VALUES
(1, 'fromAdmins', 'Из админки'),
(2, 'user', 'зарегестрированный');

-- --------------------------------------------------------

--
-- Структура таблицы `searcharticles`
--

CREATE TABLE IF NOT EXISTS `searcharticles` (
  `idArticle` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `text` text NOT NULL,
  FULLTEXT KEY `IX_searchArticles` (`title`,`description`,`text`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `searcharticles`
--

INSERT INTO `searcharticles` (`idArticle`, `title`, `description`, `text`) VALUES
(34, 'text test', 'text test', '<p>text test</p>'),
(35, 'Использование конструктора форм', 'При создании HTML форм часто приходится писать довольно большое количество повторяющегося кода, который почти невозможно использовать в других проектах. К примеру, для каждого поля ввода нам необходимо вывести описание и возможные ошибки валидации. Для того чтобы сделать… ', '<h2 id="sec-2">1. Общая идея&nbsp;</h2>\r\n<p>Конструктор форм использует объект&nbsp;CForm&nbsp;для описания параметров, необходимых для создания HTML формы, таких как модели и поля, используемые в форме, а также параметры построения самой формы. Разработчику достаточно создать объект&nbsp;CForm, задать его параметры и вызвать метод для построения формы.</p>\r\n<p>Параметры формы организованы в виде иерархии элементов формы. Корнем является объект&nbsp;CForm. Корневой объект формы включает в себя две коллекции, содержащие другие элементы:&nbsp;CForm::buttons&nbsp;иCForm::elements. Первая содержит кнопки (такие как &laquo;Сохранить&raquo; или &laquo;Очистить&raquo;), вторая &mdash; поля ввода, статический текст и вложенные формы &mdash; объекты&nbsp;CForm, находящиеся в коллекции&nbsp;CForm::elementsдругой формы. Вложенная форма может иметь свою модель данных и коллекции&nbsp;CForm::buttons&nbsp;иCForm::elements.</p>\r\n<p>Когда пользователи отправляют форму, данные, введённые в поля ввода всей иерархии формы, включая вложенные формы, передаются на сервер.&nbsp;CForm&nbsp;включает в себя методы, позволяющие автоматически присвоить данные полям соответствующей модели и провести валидацию.</p>\r\n<h2 id="sec-3">2. Создание простой формы&nbsp;</h2>\r\n<p>Ниже будет показано, как построить форму входа на сайт.</p>\r\n<p>Сначала реализуем действие&nbsp;<code>login</code>:</p>\r\n<div class="hl-code">\r\n<div class="hl-main">\r\n<pre><span class="hl-reserved">public</span> <span class="hl-reserved">function</span> <span class="hl-identifier">actionLogin</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span>\r\n<span class="hl-brackets">{</span>\r\n    <span class="hl-var">$model</span><span class="hl-code"> = </span><span class="hl-reserved">new</span> <span class="hl-identifier">LoginForm</span><span class="hl-code">;\r\n    </span><span class="hl-var">$form</span><span class="hl-code"> = </span><span class="hl-reserved">new</span> <span class="hl-identifier">CForm</span><span class="hl-brackets">(</span><span class="hl-quotes">''</span><span class="hl-string">application.views.site.loginForm</span><span class="hl-quotes">''</span><span class="hl-code">, </span><span class="hl-var">$model</span><span class="hl-brackets">)</span><span class="hl-code">;\r\n    </span><span class="hl-reserved">if</span><span class="hl-brackets">(</span><span class="hl-var">$form</span><span class="hl-code">-&gt;</span><span class="hl-identifier">submitted</span><span class="hl-brackets">(</span><span class="hl-quotes">''</span><span class="hl-string">login</span><span class="hl-quotes">''</span><span class="hl-brackets">)</span><span class="hl-code"> &amp;&amp; </span><span class="hl-var">$form</span><span class="hl-code">-&gt;</span><span class="hl-identifier">validate</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-brackets">)</span>\r\n        <span class="hl-var">$this</span><span class="hl-code">-&gt;</span><span class="hl-identifier">redirect</span><span class="hl-brackets">(</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-quotes">''</span><span class="hl-string">site/index</span><span class="hl-quotes">''</span><span class="hl-brackets">)</span><span class="hl-brackets">)</span><span class="hl-code">;\r\n    </span><span class="hl-reserved">else</span>\r\n        <span class="hl-var">$this</span><span class="hl-code">-&gt;</span><span class="hl-identifier">render</span><span class="hl-brackets">(</span><span class="hl-quotes">''</span><span class="hl-string">login</span><span class="hl-quotes">''</span><span class="hl-code">, </span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-quotes">''</span><span class="hl-string">form</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-var">$form</span><span class="hl-brackets">)</span><span class="hl-brackets">)</span><span class="hl-code">;\r\n</span><span class="hl-brackets">}</span></pre>\r\n</div>\r\n</div>\r\n<p>Вкратце, здесь мы создали объект&nbsp;CForm, используя конфигурацию, найденную по пути, который задан псевдонимом&nbsp;<code>application.views.site.loginForm</code>. Объект&nbsp;CForm, как описано в разделе &laquo;Создание модели&raquo;, использует модель&nbsp;<code>LoginForm</code>.</p>\r\n<p>Если форма отправлена, и все входные данные прошли проверку без ошибок, перенаправляем пользователя на страницу&nbsp;<code>site/index</code>. Иначе выводим представление&nbsp;<code>login</code>, описывающее форму.</p>\r\n<p>Псевдоним пути&nbsp;<code>application.views.site.loginForm</code>&nbsp;указывает на файл PHP<code>protected/views/site/loginForm.php</code>. Этот файл возвращает массив, описывающий настройки, необходимые для&nbsp;CForm:</p>\r\n<div class="hl-code">\r\n<div class="hl-main">\r\n<pre><span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span>\r\n    <span class="hl-quotes">''</span><span class="hl-string">title</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-quotes">''</span><span class="hl-string">Пожалуйста, представьтесь</span><span class="hl-quotes">''</span><span class="hl-code">,\r\n \r\n    </span><span class="hl-quotes">''</span><span class="hl-string">elements</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>\r\n        <span class="hl-quotes">''</span><span class="hl-string">username</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>\r\n            <span class="hl-quotes">''</span><span class="hl-string">type</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-quotes">''</span><span class="hl-string">text</span><span class="hl-quotes">''</span><span class="hl-code">,\r\n            </span><span class="hl-quotes">''</span><span class="hl-string">maxlength</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-number">32</span><span class="hl-code">,\r\n        </span><span class="hl-brackets">)</span><span class="hl-code">,\r\n        </span><span class="hl-quotes">''</span><span class="hl-string">password</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>\r\n            <span class="hl-quotes">''</span><span class="hl-string">type</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-quotes">''</span><span class="hl-string">password</span><span class="hl-quotes">''</span><span class="hl-code">,\r\n            </span><span class="hl-quotes">''</span><span class="hl-string">maxlength</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-number">32</span><span class="hl-code">,\r\n        </span><span class="hl-brackets">)</span><span class="hl-code">,\r\n        </span><span class="hl-quotes">''</span><span class="hl-string">rememberMe</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>\r\n            <span class="hl-quotes">''</span><span class="hl-string">type</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-quotes">''</span><span class="hl-string">checkbox</span><span class="hl-quotes">''</span><span class="hl-code">,\r\n        </span><span class="hl-brackets">)</span>\r\n    <span class="hl-brackets">)</span><span class="hl-code">,\r\n \r\n    </span><span class="hl-quotes">''</span><span class="hl-string">buttons</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>\r\n        <span class="hl-quotes">''</span><span class="hl-string">login</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>\r\n            <span class="hl-quotes">''</span><span class="hl-string">type</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-quotes">''</span><span class="hl-string">submit</span><span class="hl-quotes">''</span><span class="hl-code">,\r\n            </span><span class="hl-quotes">''</span><span class="hl-string">label</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-quotes">''</span><span class="hl-string">Вход</span><span class="hl-quotes">''</span><span class="hl-code">,\r\n        </span><span class="hl-brackets">)</span><span class="hl-code">,\r\n    </span><span class="hl-brackets">)</span><span class="hl-code">,\r\n</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre>\r\n</div>\r\n</div>\r\n<p>Настройки, приведённые выше, являются ассоциативным массивом, состоящим из пар имя-значение, используемых для инициализации соответствующих свойств&nbsp;CForm. Самыми важными свойствами, как мы уже упомянули, являются&nbsp;CForm::elements&nbsp;и&nbsp;CForm::buttons. Каждое из них содержит массив, определяющий элементы формы. Более детальное описание элементов формы будет приведено в следующем подразделе.</p>\r\n<p>Опишем шаблон представления&nbsp;<code>login</code>:</p>\r\n<div class="hl-code">\r\n<div class="hl-main">\r\n<pre><span class="hl-code">&lt;</span><span class="hl-identifier">h1</span><span class="hl-code">&gt;Вход&lt;/</span><span class="hl-identifier">h1</span><span class="hl-code">&gt;\r\n \r\n&lt;</span><span class="hl-identifier">div</span> <span class="hl-reserved">class</span><span class="hl-code">=</span><span class="hl-quotes">"</span><span class="hl-string">form</span><span class="hl-quotes">"</span><span class="hl-code">&gt;\r\n&lt;?</span><span class="hl-identifier">php</span> <span class="hl-reserved">echo</span> <span class="hl-var">$form</span><span class="hl-code">; </span><span class="hl-inlinetags">?&gt;</span><span class="hl-code">\r\n&lt;/</span><span class="hl-identifier">div</span><span class="hl-code">&gt;</span></pre>\r\n</div>\r\n</div>\r\n<blockquote class="tip">\r\n<p><strong>Подсказка:</strong>&nbsp;Приведённый выше код&nbsp;<code>echo $form;</code>&nbsp;эквивалентен&nbsp;<code>echo $form-&gt;render();</code>. Использование более компактной записи возможно, так как&nbsp;CForm&nbsp;реализует магический метод<code>__toString</code>, в котором вызывается метод&nbsp;<code>render()</code>, возвращающий код формы.</p>\r\n</blockquote>\r\n<h2 id="sec-4">3. Описание элементов формы&nbsp;</h2>\r\n<p>При использовании конструктора форм вместо написания разметки мы, главным образом, описываем элементы формы. В данном подразделе мы опишем, как задать свойство&nbsp;CForm::elements. Мы не будем описывать&nbsp;CForm::buttons, так как конфигурация этого свойства практически ничем не отличается отCForm::elements.</p>\r\n<p>Свойство&nbsp;CForm::elements&nbsp;является массивом, каждый элемент которого соответствует элементу формы. Это может быть поле ввода, статический текст или вложенная форма.</p>\r\n<h3 id="sec-8">Описание поля ввода</h3>\r\n<p>Поле ввода, главным образом, состоит из заголовка, самого поля, подсказки и текста ошибки и должно соответствовать определённому атрибуту модели. Описание поля ввода содержится в экземпляре классаCFormInputElement. Приведённый ниже код массива&nbsp;CForm::elements&nbsp;описывает одно поле ввода:</p>\r\n<div class="hl-code">\r\n<div class="hl-main">\r\n<pre><span class="hl-quotes">''</span><span class="hl-string">username</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>\r\n    <span class="hl-quotes">''</span><span class="hl-string">type</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-quotes">''</span><span class="hl-string">text</span><span class="hl-quotes">''</span><span class="hl-code">,\r\n    </span><span class="hl-quotes">''</span><span class="hl-string">maxlength</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-number">32</span><span class="hl-code">,\r\n</span><span class="hl-brackets">)</span><span class="hl-code">,</span></pre>\r\n</div>\r\n</div>\r\n<p>Здесь указано, что атрибут модели называется&nbsp;<code>username</code>, тип поля &mdash;&nbsp;<code>text</code>&nbsp;и его атрибут&nbsp;<code>maxlength</code>равен 32.</p>\r\n<p>Любое доступное для записи свойство&nbsp;CFormInputElement&nbsp;может быть настроено приведённым выше способом. К примеру, можно задать свойство&nbsp;hint&nbsp;для того, чтобы показывать подсказку или свойствоitems, если поле является выпадающим списком или группой элементов checkbox или radio. Если имя опции не является свойством&nbsp;CFormInputElement, оно будет считаться атрибутом соответствующего HTML-тега input. Например, так как опция&nbsp;<code>maxlength</code>&nbsp;не является свойством&nbsp;CFormInputElement, она будет использована как атрибут&nbsp;<code>maxlength</code>&nbsp;HTML-элемента input.</p>\r\n<p>Следует отдельно остановиться на свойстве&nbsp;type. Оно определяет тип поля ввода. К примеру, тип&nbsp;<code>text</code>означает, что будет использован элемент формы&nbsp;<code>input</code>, а&nbsp;<code>password</code>&nbsp;&mdash; поле для ввода пароля. ВCFormInputElement&nbsp;реализованы следующие типы полей ввода:</p>\r\n<ul>\r\n<li>text</li>\r\n<li>hidden</li>\r\n<li>password</li>\r\n<li>textarea</li>\r\n<li>file</li>\r\n<li>radio</li>\r\n<li>checkbox</li>\r\n<li>listbox</li>\r\n<li>dropdownlist</li>\r\n<li>checkboxlist</li>\r\n<li>radiolist</li>\r\n</ul>\r\n<p>Отдельно следует описать использование "списочных" типов&nbsp;<code>dropdownlist</code>,&nbsp;<code>checkboxlist</code>&nbsp;и&nbsp;<code>radiolist</code>. Для них необходимо задать свойство&nbsp;items&nbsp;соответствующего элемента input. Сделать это можно так:</p>\r\n<div class="hl-code">\r\n<div class="hl-main">\r\n<pre><span class="hl-quotes">''</span><span class="hl-string">gender</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>\r\n    <span class="hl-quotes">''</span><span class="hl-string">type</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-quotes">''</span><span class="hl-string">dropdownlist</span><span class="hl-quotes">''</span><span class="hl-code">,\r\n    </span><span class="hl-quotes">''</span><span class="hl-string">items</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-identifier">User</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">getGenderOptions</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">,\r\n    </span><span class="hl-quotes">''</span><span class="hl-string">prompt</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-quotes">''</span><span class="hl-string">Выберите значение:</span><span class="hl-quotes">''</span><span class="hl-code">,\r\n</span><span class="hl-brackets">)</span><span class="hl-code">,\r\n \r\n&hellip;\r\n \r\n</span><span class="hl-reserved">class</span> <span class="hl-identifier">User</span> <span class="hl-reserved">extends</span> <span class="hl-identifier">CActiveRecord</span>\r\n<span class="hl-brackets">{</span>\r\n    <span class="hl-reserved">public</span> <span class="hl-reserved">function</span> <span class="hl-identifier">getGenderOptions</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span>\r\n    <span class="hl-brackets">{</span>\r\n        <span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span>\r\n            <span class="hl-number">0</span><span class="hl-code"> =&gt; </span><span class="hl-quotes">''</span><span class="hl-string">Мужчина</span><span class="hl-quotes">''</span><span class="hl-code">,\r\n            </span><span class="hl-number">1</span><span class="hl-code"> =&gt; </span><span class="hl-quotes">''</span><span class="hl-string">Женщина</span><span class="hl-quotes">''</span><span class="hl-code">,\r\n        </span><span class="hl-brackets">)</span><span class="hl-code">;\r\n    </span><span class="hl-brackets">}</span>\r\n<span class="hl-brackets">}</span></pre>\r\n</div>\r\n</div>\r\n<p>Данный код сгенерирует выпадающий список с текстом &laquo;Выберите значение:&raquo; и опциями &laquo;Мужчина&raquo; и &laquo;Женщина&raquo;, которые мы получаем из метода&nbsp;<code>getGenderOptions</code>&nbsp;модели&nbsp;<code>User</code>.</p>\r\n<p>Кроме данных типов полей, в свойстве&nbsp;type&nbsp;можно указать класс или псевдоним пути виджета. Класс виджета должен наследовать&nbsp;CInputWidget&nbsp;или&nbsp;CJuiInputWidget. В ходе генерации элемента формы будет создан и выполнен экземпляр класса виджета. Виджет будет использовать конфигурацию, переданную через настройки элемента формы.</p>\r\n<h3 id="sec-9">Описание статического текста</h3>\r\n<p>Довольно часто в форме, помимо полей ввода, содержится некоторая декоративная HTML разметка. К примеру, горизонтальный разделитель для выделения определённых частей формы или изображение, улучшающее внешний вид формы. Подобный HTML код можно описать в коллекции&nbsp;CForm::elements&nbsp;как статический текст. Для этого в&nbsp;CForm::elements&nbsp;в нужном нам месте вместо массива необходимо использовать строку. Например:</p>\r\n<div class="hl-code">\r\n<div class="hl-main">\r\n<pre><span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span>\r\n    <span class="hl-quotes">''</span><span class="hl-string">elements</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-code">\r\n        ......\r\n        </span><span class="hl-quotes">''</span><span class="hl-string">password</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>\r\n            <span class="hl-quotes">''</span><span class="hl-string">type</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-quotes">''</span><span class="hl-string">password</span><span class="hl-quotes">''</span><span class="hl-code">,\r\n            </span><span class="hl-quotes">''</span><span class="hl-string">maxlength</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-number">32</span><span class="hl-code">,\r\n        </span><span class="hl-brackets">)</span><span class="hl-code">,\r\n \r\n        </span><span class="hl-quotes">''</span><span class="hl-string">&lt;hr /&gt;</span><span class="hl-quotes">''</span><span class="hl-code">,\r\n \r\n        </span><span class="hl-quotes">''</span><span class="hl-string">rememberMe</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>\r\n            <span class="hl-quotes">''</span><span class="hl-string">type</span><span class="hl-quotes">''</span><span class="hl-code">=&gt;</span><span class="hl-quotes">''</span><span class="hl-string">checkbox</span><span class="hl-quotes">''</span><span class="hl-code">,\r\n        </span><span class="hl-brackets">)</span>\r\n    <span class="hl-brackets">)</span><span class="hl-code">,\r\n    ......\r\n</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre>\r\n</div>\r\n</div>\r\n<p>В приведённом коде мы вставили горизонтальный разделитель между полями&nbsp;<code>password</code>&nbsp;и&nbsp;<code>rememberMe</code>.</p>\r\n<p>Статический текст лучше всего использовать в том случае, когда разметка и её расположение достаточно уникальны. Если некоторую разметку должен содержать каждый элемент формы, лучше всего переопределить непосредственно построение разметки формы, как будет описано далее.</p>');

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `idSettings` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parameter` varchar(50) DEFAULT '0',
  `value` varchar(255) DEFAULT '0',
  PRIMARY KEY (`idSettings`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `settings` (`idSettings`, `parameter`, `value`) VALUES
(1, 'chatOnOff', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `idTag` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `textTag` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idTag`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `tags`
--

INSERT INTO `tags` (`idTag`, `textTag`) VALUES
(1, 'Yii'),
(2, 'формы'),
(3, 'конструктор');

-- --------------------------------------------------------

--
-- Структура таблицы `tagstoarticles`
--

CREATE TABLE IF NOT EXISTS `tagstoarticles` (
  `idTags2Art` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idArticle` int(10) unsigned NOT NULL DEFAULT '0',
  `idTag` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`idTags2Art`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `tagstoarticles`
--

INSERT INTO `tagstoarticles` (`idTags2Art`, `idArticle`, `idTag`) VALUES
(1, 35, 1),
(2, 35, 2),
(3, 35, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `thems`
--

CREATE TABLE IF NOT EXISTS `thems` (
  `idThem` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`idThem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `idUser` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hash` varchar(255) NOT NULL DEFAULT '0',
  `login` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `idRole` tinyint(2) unsigned NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `lastFirstName` varchar(255) DEFAULT NULL,
  `ban` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`idUser`),
  KEY `users_ibfk_1` (`idRole`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`idUser`, `hash`, `login`, `email`, `password`, `idRole`, `photo`, `lastFirstName`, `ban`) VALUES
(6, '0', '111', 'ddd@www.ww', '698d51a19d8a121ce581499d7b701668', 2, '52e771c8483a8.jpg', 'Головин Виталий Валентинович', 0),
(7, '0', 'vit', 'admin@ya.ru', '202cb962ac59075b964b07152d234b70', 2, NULL, 'витал', 0),
(8, '0', 'vit', 'zzz@ww.ee', '698d51a19d8a121ce581499d7b701668', 2, NULL, 'Ветал', 0),
(9, '0', 'vit', 'zzz@ww.ee', '698d51a19d8a121ce581499d7b701668', 2, NULL, 'Ветал', 0),
(10, '8883b7a427a3f787ba4c0904b24ac766', 'login', '', 'd41d8cd98f00b204e9800998ecf8427e', 1, NULL, 'Админ', 0),
(11, '0', 'vitalya-xxx', 'vitalya-xxx@ya.ru', '827ccb0eea8a706c4c34a16891f84e7b', 2, NULL, 'Витал', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `{{storage}}`
--

CREATE TABLE IF NOT EXISTS `{{storage}}` (
  `key` varchar(255) DEFAULT NULL,
  `value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `{{storage}}`
--

INSERT INTO `{{storage}}` (`key`, `value`) VALUES
('28b2db248d9cef740638335ee2a6d020', '"{\\"0\\":1386934333,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/categories\\\\\\/2\\\\\\/52aaf03d27f84.jpg\\",\\"resize\\":{\\"width\\":40,\\"height\\":30,\\"master\\":2},\\"crop\\":{\\"width\\":30,\\"height\\":30,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('722074ec23aaff4aca4e6b73dc9b698b', '"{\\"0\\":1386935059,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/categories\\\\\\/1\\\\\\/52aaf3137171a.jpg\\",\\"resize\\":{\\"width\\":40,\\"height\\":30,\\"master\\":2},\\"crop\\":{\\"width\\":30,\\"height\\":30,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('0e5320e5ccfa387b3104f495f4b4bc06', '"{\\"0\\":1386939546,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/categories\\\\\\/3\\\\\\/52ab049b0912d.jpg\\",\\"resize\\":{\\"width\\":53,\\"height\\":30,\\"master\\":2},\\"crop\\":{\\"width\\":30,\\"height\\":30,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('f139204d581d0532d704adfa5adc4664', '"{\\"0\\":1386939558,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/categories\\\\\\/3\\\\\\/52ab04a68503d.jpg\\",\\"resize\\":{\\"width\\":40,\\"height\\":30,\\"master\\":2},\\"crop\\":{\\"width\\":30,\\"height\\":30,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('63f144d9eeda8e33673f3c5d902c2ec0', '"{\\"0\\":1386939608,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/categories\\\\\\/4\\\\\\/52ab04d89acfe.jpg\\",\\"resize\\":{\\"width\\":48,\\"height\\":30,\\"master\\":2},\\"crop\\":{\\"width\\":30,\\"height\\":30,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('519fb5731a163b120d9dad7c3da8fb23', '"{\\"0\\":1386940225,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/categories\\\\\\/default\\\\\\/category.jpg\\",\\"resize\\":{\\"width\\":154,\\"height\\":150,\\"master\\":2},\\"crop\\":{\\"width\\":150,\\"height\\":150,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('668a1725520a182aabfe69ae1050f963', '"{\\"0\\":1386940225,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/categories\\\\\\/default\\\\\\/category.jpg\\",\\"resize\\":{\\"width\\":123,\\"height\\":120,\\"master\\":2},\\"crop\\":{\\"width\\":120,\\"height\\":120,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('5831fd2e6b7c65fa6e07de2fb0e4671a', '"{\\"0\\":1386939558,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/categories\\\\\\/3\\\\\\/52ab04a68503d.jpg\\",\\"resize\\":{\\"width\\":160,\\"height\\":120,\\"master\\":2},\\"crop\\":{\\"width\\":120,\\"height\\":120,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('b2c9b04d00d9197a5f226a909df1ba84', '"{\\"0\\":1386939608,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/categories\\\\\\/4\\\\\\/52ab04d89acfe.jpg\\",\\"resize\\":{\\"width\\":192,\\"height\\":120,\\"master\\":2},\\"crop\\":{\\"width\\":120,\\"height\\":120,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('243b9903faede8df614c44ddacf61c1c', '"{\\"0\\":1386940225,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/images\\\\\\/default\\\\\\/category.jpg\\",\\"resize\\":{\\"width\\":123,\\"height\\":120,\\"master\\":2},\\"crop\\":{\\"width\\":120,\\"height\\":120,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('3b166fdbaa11efb61f9f9a290e0fa1b8', '"{\\"0\\":1387358514,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/categories\\\\\\/3\\\\\\/52b169328fce2.jpg\\",\\"resize\\":{\\"width\\":40,\\"height\\":30,\\"master\\":2},\\"crop\\":{\\"width\\":30,\\"height\\":30,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('314b43e21d51f21174459a8bd4cdd9ed', '"{\\"0\\":1387358514,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/categories\\\\\\/3\\\\\\/52b169328fce2.jpg\\",\\"resize\\":{\\"width\\":160,\\"height\\":120,\\"master\\":2},\\"crop\\":{\\"width\\":120,\\"height\\":120,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('13978f8e9ca99723576effa6c1c90526', '"{\\"0\\":1387358753,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/categories\\\\\\/3\\\\\\/52b16a2165962.jpg\\",\\"resize\\":{\\"width\\":40,\\"height\\":30,\\"master\\":2},\\"crop\\":{\\"width\\":30,\\"height\\":30,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('2e8dfe61eae8f6724125b147edf08d0a', '"{\\"0\\":1387456569,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/articles\\\\\\/2\\\\\\/52b2e839be8e0.jpg\\",\\"resize\\":{\\"width\\":40,\\"height\\":30,\\"master\\":2},\\"crop\\":{\\"width\\":30,\\"height\\":30,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('380fa86c3aabba5b90872cf220a4a155', '"{\\"0\\":1387456685,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/articles\\\\\\/2\\\\\\/52b2e8ad6b8ec.jpg\\",\\"resize\\":{\\"width\\":48,\\"height\\":30,\\"master\\":2},\\"crop\\":{\\"width\\":30,\\"height\\":30,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('5113eaca90b38cfd677594e5824fb5c4', '"{\\"0\\":1387456685,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/articles\\\\\\/2\\\\\\/52b2e8ad6b8ec.jpg\\",\\"resize\\":{\\"width\\":192,\\"height\\":120,\\"master\\":2},\\"crop\\":{\\"width\\":120,\\"height\\":120,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('269336387e04318a62bab799f1bb3663', '"{\\"0\\":1387456864,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/articles\\\\\\/2\\\\\\/52b2e96037c1e.jpg\\",\\"resize\\":{\\"width\\":40,\\"height\\":30,\\"master\\":2},\\"crop\\":{\\"width\\":30,\\"height\\":30,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('410ce6591454e2343c06bab7a249e433', '"{\\"0\\":1387456864,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/articles\\\\\\/2\\\\\\/52b2e96037c1e.jpg\\",\\"resize\\":{\\"width\\":160,\\"height\\":120,\\"master\\":2},\\"crop\\":{\\"width\\":120,\\"height\\":120,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('e9c69d38f5d19db63a2594638611c305', '"{\\"0\\":1387786844,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/images\\\\\\/default\\\\\\/Articles.png\\",\\"resize\\":{\\"width\\":257,\\"height\\":251,\\"master\\":2},\\"crop\\":{\\"width\\":257,\\"height\\":173,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('7ba84a9ed860d0bf3f03042c9c821660', '"{\\"0\\":1387456864,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/articles\\\\\\/2\\\\\\/52b2e96037c1e.jpg\\",\\"resize\\":{\\"width\\":257,\\"height\\":193,\\"master\\":2},\\"crop\\":{\\"width\\":257,\\"height\\":173,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('0f6631b97a15d15732825693bd961b11', '"{\\"0\\":1387786826,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/images\\\\\\/default\\\\\\/Categorys.png\\",\\"resize\\":{\\"width\\":257,\\"height\\":257,\\"master\\":2},\\"crop\\":{\\"width\\":257,\\"height\\":173,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('968fa9d701d08f349eb471041aed9f7f', '"{\\"0\\":1389171524,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/images\\\\\\/default\\\\\\/users.png\\",\\"resize\\":{\\"width\\":186,\\"height\\":149,\\"master\\":2},\\"crop\\":{\\"width\\":186,\\"height\\":146,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('a578d277deebfca266abfcdbfaa3e487', '"{\\"0\\":1389257433,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/users\\\\\\/6\\\\\\/52ce62d98cab6.jpg\\",\\"resize\\":{\\"width\\":195,\\"height\\":146,\\"master\\":2},\\"crop\\":{\\"width\\":186,\\"height\\":146,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('9e7e7c0f6865c45c3278f9901d203178', '"{\\"0\\":1389257469,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/users\\\\\\/6\\\\\\/52ce62fd4789b.jpg\\",\\"resize\\":{\\"width\\":186,\\"height\\":180,\\"master\\":2},\\"crop\\":{\\"width\\":186,\\"height\\":146,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('64f69d8bd9d8623deaeb2f845dbdd0d1', '"{\\"0\\":1389257493,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/users\\\\\\/6\\\\\\/52ce6315383b8.jpg\\",\\"resize\\":{\\"width\\":195,\\"height\\":146,\\"master\\":2},\\"crop\\":{\\"width\\":186,\\"height\\":146,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('e29695095d99c26e235d8fe0de8649d8', '"{\\"0\\":1389257513,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/users\\\\\\/6\\\\\\/52ce632982913.jpg\\",\\"resize\\":{\\"width\\":186,\\"height\\":180,\\"master\\":2},\\"crop\\":{\\"width\\":186,\\"height\\":146,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('0c9fb038ad272428784a4a75b8dc5dd7', '"{\\"0\\":1389257665,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/users\\\\\\/6\\\\\\/52ce63c10fb26.jpg\\",\\"resize\\":{\\"width\\":195,\\"height\\":146,\\"master\\":2},\\"crop\\":{\\"width\\":186,\\"height\\":146,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('90863c484132b58b8e2d226c6d8b6861', '"{\\"0\\":1389257675,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/users\\\\\\/6\\\\\\/52ce63cbe9a7b.jpg\\",\\"resize\\":{\\"width\\":186,\\"height\\":180,\\"master\\":2},\\"crop\\":{\\"width\\":186,\\"height\\":146,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('c26474183971a81be43e243bec77f982', '"{\\"0\\":1387786844,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/images\\\\\\/default\\\\\\/Articles.png\\",\\"resize\\":{\\"width\\":228,\\"height\\":223,\\"master\\":2},\\"crop\\":{\\"width\\":228,\\"height\\":167,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('fe072f7259d14425734623083e80fef3', '"{\\"0\\":1389881576,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/users\\\\\\/6\\\\\\/52d7e8ec17063.jpg\\",\\"resize\\":{\\"width\\":186,\\"height\\":248,\\"master\\":2},\\"crop\\":{\\"width\\":186,\\"height\\":146,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('6eee74add83a1bd9b0f94fe46a331f77', '"{\\"0\\":1389881626,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/users\\\\\\/6\\\\\\/52d7e91a8fcfa.gif\\",\\"resize\\":{\\"width\\":260,\\"height\\":146,\\"master\\":2},\\"crop\\":{\\"width\\":186,\\"height\\":146,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('1b00355a7bbd7c52868da5e52009b856', '"{\\"0\\":1389965060,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/images\\\\\\/default\\\\\\/menu.png\\",\\"resize\\":{\\"width\\":228,\\"height\\":228,\\"master\\":2},\\"crop\\":{\\"width\\":228,\\"height\\":167,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('48efb77f41d204d89ba4d6d166becb7f', '"{\\"0\\":1389965060,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/images\\\\\\/default\\\\\\/menu.png\\",\\"resize\\":{\\"width\\":257,\\"height\\":257,\\"master\\":2},\\"crop\\":{\\"width\\":257,\\"height\\":173,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('543c130e5f68c0a8394a895379bd2ac6', '"{\\"0\\":1386939608,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/categorys\\\\\\/4\\\\\\/52ab04d89acfe.jpg\\",\\"resize\\":{\\"width\\":48,\\"height\\":30,\\"master\\":2},\\"crop\\":{\\"width\\":30,\\"height\\":30,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('6df97c9ca1402c6485920feae686b070', '"{\\"0\\":1390291764,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/images\\\\\\/default\\\\\\/mainmenu.png\\",\\"resize\\":{\\"width\\":228,\\"height\\":228,\\"master\\":2},\\"crop\\":{\\"width\\":228,\\"height\\":167,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('35143be26e98e8f2a130a1eb5be5ef7a', '"{\\"0\\":1390291764,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/images\\\\\\/default\\\\\\/mainmenu.png\\",\\"resize\\":{\\"width\\":257,\\"height\\":257,\\"master\\":2},\\"crop\\":{\\"width\\":257,\\"height\\":173,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('4e3504a34720ebf6fcdb044165edaf7c', '"{\\"0\\":1389171524,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/images\\\\\\/default\\\\\\/users.png\\",\\"resize\\":{\\"width\\":18,\\"height\\":14,\\"master\\":2},\\"crop\\":{\\"width\\":18,\\"height\\":14,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('7e1b48a8ac5276ba2ad519654935e7b0', '"{\\"0\\":1389881626,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/users\\\\\\/6\\\\\\/52d7e91a8fcfa.gif\\",\\"resize\\":{\\"width\\":25,\\"height\\":14,\\"master\\":2},\\"crop\\":{\\"width\\":18,\\"height\\":14,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('b103feb4849e525ae3e17d61a541c4dd', '"{\\"0\\":1389171524,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/images\\\\\\/default\\\\\\/users.png\\",\\"resize\\":{\\"width\\":23,\\"height\\":18,\\"master\\":2},\\"crop\\":{\\"width\\":22,\\"height\\":18,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('983c137065ad2789e21bb3dd5b49992c', '"{\\"0\\":1389881626,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/users\\\\\\/6\\\\\\/52d7e91a8fcfa.gif\\",\\"resize\\":{\\"width\\":32,\\"height\\":18,\\"master\\":2},\\"crop\\":{\\"width\\":22,\\"height\\":18,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('fdb79cf20d0d290c444a270c55f1275b', '"{\\"0\\":1390898524,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/users\\\\\\/6\\\\\\/52e76d5c64d44.jpg\\",\\"resize\\":{\\"width\\":195,\\"height\\":146,\\"master\\":2},\\"crop\\":{\\"width\\":186,\\"height\\":146,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('f200c5d6b6fbd08ebd1b89ae0f123fb3', '"{\\"0\\":1390899191,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/users\\\\\\/6\\\\\\/52e76ff76fffe.jpg\\",\\"resize\\":{\\"width\\":186,\\"height\\":148,\\"master\\":2},\\"crop\\":{\\"width\\":186,\\"height\\":146,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('70ad8b8971fbab608aa243aec227f416', '"{\\"0\\":1390899656,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/users\\\\\\/6\\\\\\/52e771c8483a8.jpg\\",\\"resize\\":{\\"width\\":234,\\"height\\":146,\\"master\\":2},\\"crop\\":{\\"width\\":186,\\"height\\":146,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('18640fa580a11c65544e60d2d57866cc', '"{\\"0\\":1390899656,\\"1\\":\\"Z:\\\\\\/home\\\\\\/world-of-women.com.ua\\\\\\/www\\\\\\/uploads\\\\\\/users\\\\\\/6\\\\\\/52e771c8483a8.jpg\\",\\"resize\\":{\\"width\\":29,\\"height\\":18,\\"master\\":2},\\"crop\\":{\\"width\\":22,\\"height\\":18,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('d57c086d071770c1d7e22bbea6f17d22', '"{\\"0\\":1399062073,\\"1\\":\\"C:\\\\\\/OpenServer\\\\\\/domains\\\\\\/my_site\\\\\\/public\\\\\\/images\\\\\\/default\\\\\\/mainmenu.png\\",\\"resize\\":{\\"width\\":239,\\"height\\":239,\\"master\\":2},\\"crop\\":{\\"width\\":239,\\"height\\":228,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('e61c014e03718d80b9c95c4a01fcdb59', '"{\\"0\\":1399100823,\\"1\\":\\"C:\\\\\\/OpenServer\\\\\\/domains\\\\\\/my_site\\\\\\/public\\\\\\/images\\\\\\/default\\\\\\/Articles.png\\",\\"resize\\":{\\"width\\":216,\\"height\\":154,\\"master\\":2}}"'),
('422e48e9ab048978363e030583abcb99', '"{\\"0\\":1399100823,\\"1\\":\\"C:\\\\\\/OpenServer\\\\\\/domains\\\\\\/my_site\\\\\\/public\\\\\\/images\\\\\\/default\\\\\\/Articles.png\\",\\"resize\\":{\\"width\\":257,\\"height\\":251,\\"master\\":2},\\"crop\\":{\\"width\\":257,\\"height\\":173,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('e47ccd5c86d01037983e772d7d187b2d', '"{\\"0\\":1399061292,\\"1\\":\\"C:\\\\\\/OpenServer\\\\\\/domains\\\\\\/my_site\\\\\\/public\\\\\\/images\\\\\\/default\\\\\\/Categorys.png\\",\\"resize\\":{\\"width\\":257,\\"height\\":257,\\"master\\":2},\\"crop\\":{\\"width\\":257,\\"height\\":173,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('78c8e8acaf54f487f77a1de88b963796', '"{\\"0\\":1399062073,\\"1\\":\\"C:\\\\\\/OpenServer\\\\\\/domains\\\\\\/my_site\\\\\\/public\\\\\\/images\\\\\\/default\\\\\\/mainmenu.png\\",\\"resize\\":{\\"width\\":257,\\"height\\":257,\\"master\\":2},\\"crop\\":{\\"width\\":257,\\"height\\":173,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('08c5fc65be02c64ab958081b4f8fe1d6', '"{\\"0\\":1399100606,\\"1\\":\\"C:\\\\\\/OpenServer\\\\\\/domains\\\\\\/my_site\\\\\\/public\\\\\\/uploads\\\\\\/users\\\\\\/6\\\\\\/52e771c8483a8.jpg\\",\\"resize\\":{\\"width\\":48,\\"height\\":30,\\"master\\":2},\\"crop\\":{\\"width\\":30,\\"height\\":30,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('aec948ab6ba128efc6b36de454bf192e', '"{\\"0\\":1399100749,\\"1\\":\\"C:\\\\\\/OpenServer\\\\\\/domains\\\\\\/my_site\\\\\\/public\\\\\\/images\\\\\\/default\\\\\\/users.png\\",\\"resize\\":{\\"width\\":23,\\"height\\":18,\\"master\\":2},\\"crop\\":{\\"width\\":22,\\"height\\":18,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('160b3ecd831925d075a4210a49c8ffe9', '"{\\"0\\":1399100749,\\"1\\":\\"C:\\\\\\/OpenServer\\\\\\/domains\\\\\\/my_site\\\\\\/public\\\\\\/images\\\\\\/default\\\\\\/users.png\\",\\"resize\\":{\\"width\\":186,\\"height\\":146,\\"master\\":2}}"'),
('7769702037931b649bb35daf7cda85f6', '"{\\"0\\":1410869222,\\"1\\":\\"C:\\\\\\/OpenServer\\\\\\/domains\\\\\\/my_site\\\\\\/public\\\\\\/uploads\\\\\\/articles\\\\\\/35\\\\\\/541827e80bd7c.png\\",\\"resize\\":{\\"width\\":133,\\"height\\":30,\\"master\\":2},\\"crop\\":{\\"width\\":30,\\"height\\":30,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"'),
('b93653f46cddb1650600a2ff670846d5', '"{\\"0\\":1410869222,\\"1\\":\\"C:\\\\\\/OpenServer\\\\\\/domains\\\\\\/my_site\\\\\\/public\\\\\\/uploads\\\\\\/articles\\\\\\/35\\\\\\/541827e80bd7c.png\\",\\"resize\\":{\\"width\\":216,\\"height\\":154,\\"master\\":2}}"'),
('8830b019386aba0b23bb14d83f4b6cdb', '"{\\"0\\":1410869222,\\"1\\":\\"C:\\\\\\/OpenServer\\\\\\/domains\\\\\\/my_site\\\\\\/public\\\\\\/uploads\\\\\\/articles\\\\\\/35\\\\\\/541827e80bd7c.png\\",\\"resize\\":{\\"width\\":400,\\"height\\":300,\\"master\\":2}}"'),
('dfb2c0cbe800457b032ce2e4e543cbc0', '"{\\"0\\":1410869092,\\"1\\":\\"C:\\\\\\/OpenServer\\\\\\/domains\\\\\\/my_site\\\\\\/public\\\\\\/uploads\\\\\\/categorys\\\\\\/27\\\\\\/541827654d27f.png\\",\\"resize\\":{\\"width\\":43,\\"height\\":30,\\"master\\":2},\\"crop\\":{\\"width\\":30,\\"height\\":30,\\"top\\":\\"center\\",\\"left\\":\\"center\\"}}"');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `ansvers`
--
ALTER TABLE `ansvers`
  ADD CONSTRAINT `ansvers_ibfk_1` FOREIGN KEY (`idQuestion`) REFERENCES `questions` (`idQuestion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ansvers_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `articles_ibfk_4` FOREIGN KEY (`idMenu`) REFERENCES `mainmenu` (`idMenu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD CONSTRAINT `bookmarks_ibfk_1` FOREIGN KEY (`idArticle`) REFERENCES `articles` (`idArticle`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bookmarks_ibfk_2` FOREIGN KEY (`idMenu`) REFERENCES `mainmenu` (`idMenu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bookmarks_ibfk_4` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `categorys`
--
ALTER TABLE `categorys`
  ADD CONSTRAINT `categorys_ibfk_1` FOREIGN KEY (`idMenu`) REFERENCES `mainmenu` (`idMenu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`idArticle`) REFERENCES `articles` (`idArticle`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `dialogs`
--
ALTER TABLE `dialogs`
  ADD CONSTRAINT `dialogs_ibfk_1` FOREIGN KEY (`idDiscussion`) REFERENCES `discussions` (`idDiscussion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dialogs_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `discussions`
--
ALTER TABLE `discussions`
  ADD CONSTRAINT `discussions_ibfk_1` FOREIGN KEY (`idArticle`) REFERENCES `articles` (`idArticle`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`idThem`) REFERENCES `thems` (`idThem`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`idRole`) REFERENCES `roles` (`idRole`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
