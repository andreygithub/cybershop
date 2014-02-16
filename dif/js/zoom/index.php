<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <title>jQuery Widgets — Скрипт для увеличения изображений. Image zoom v2.1</title>
    <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
    <script type="text/javascript" src="zoom/zoom.js"></script>
    <link rel="stylesheet" type="text/css" media="all" href="../../css/style.css" />
    <link rel="stylesheet" type="text/css" media="all" href="zoom/zoom.css" />
</head>

<body>

<div id="main">
    <div id="mw">
		<h2>Скрипт для увеличения изображений. Image zoom v2.3</h2>
    
    	<div class="elem">
        	<div class="elemCont">
                <h3>Описание</h3>
                <p>Позволяет сделать из любой конструкции вида</p>
                <code>
                    &#60;a href=<font color="#FFFFFF">"img/big-picture.jpg"</font>&#62;&#60;img src=<font color="#FFFFFF">"img/small-picture.jpg"</font> /&#62;&#60;/a&#62;</font>
                </code>
                <p>всплывающий попап с большим изображением, простым добавлением класса .zoom к ссылке</p>
                <p>Имеет 2 опции вида: <strong><a href="index.php">обычный</a></strong> и <a href="index2.php">центрированный</a></p>
                <p>Опции меняются изменением переменной <b>placeToCenter</b>. True - картинки выводяться в центр экрана, фон затемняется. False - картинки увеличиваются на месте.</p>
            </div>
        </div>
        
		<div class="elem dark">
        	<div class="elemCont">
            	<h3>Демо</h3>
                
                <p>
                    <a href="img/face-big-01.jpg" class="zoom"><img src="img/face-small-01.jpg" /></a>
                    <a href="img/face-big-02.jpg" class="zoom"><img src="img/face-small-02.jpg" /></a>
                    <a href="img/face-big-03.jpg" class="zoom"><img src="img/face-small-03.jpg" /></a>
                    <a href="img/face-big-04.jpg" class="zoom"><img src="img/face-small-04.jpg" /></a>
                    <a href="img/face-big-05.jpg" class="zoom"><img src="img/face-small-05.jpg" /></a>
                    <a href="img/face-big-06.jpg" class="zoom"><img src="img/face-small-06.jpg" /></a>
                    <a href="img/face-big-07.jpg" class="zoom"><img src="img/face-small-07.jpg" /></a>
                    <a href="img/face-big-08.jpg" class="zoom"><img src="img/face-small-08.jpg" /></a>
                    <a href="img/face-big-09.jpg" class="zoom"><img src="img/face-small-09.jpg" /></a>
                    <a href="img/face-big-10.jpg" class="zoom"><img src="img/face-small-10.jpg" /></a>
                    <a href="img/face-big-11.jpg" class="zoom"><img src="img/face-small-11.jpg" /></a>
				</p>
                <p>
                    <a href="img/test-big-01.jpg" class="zoom"><img src="img/test-small-01.jpg" /></a>
                    <a href="img/test-big-02.jpg" class="zoom"><img src="img/test-small-02.jpg" /></a>
                    <a href="img/test-big-03.jpg" class="zoom"><img src="img/test-small-03.jpg" /></a>
				</p>
                <p> 
                    <a href="img/face-big-10.jpg" class="zoom" style="vertical-align:top;">Просто любой блок</a>
                    <a href="img/test-big-02.jpg" class="zoom">Без превью</a>
                </p>
            </div>
        </div>
        
        <div class="elem">
        	<div class="elemCont">
                <h3>Фичи <select><option>Упс, у нас тут селект, IE6 не уважает</option></select></h3>
                <p>
                    <b>+</b> Увеличение любого изображения<br />
                    <b>+</b> Изображения больше экрана автоматически уменьшаются<br />
                    <b>+</b> Управление стралками влево/вправо<br />
                    <b>+</b> Закрытие окошка по ESC
                </p>
            </div>
        </div>

        <div class="elem">
        	<div class="elemCont">
                <h3>Подключение</h3>
                
                <p>Директорию zoom/ ложим в корень сайта</p>
                <code>
                    &#60;head&#62;<br />
                    &nbsp;&nbsp;&#60;script type=<font color="#FFFFFF">"text/javascript"</font> src=<font color="#FFFFFF">"http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"</font>&#62;&#60;/script&#62;<br />
                    &nbsp;&nbsp;&#60;script type=<font color="#FFFFFF">"text/javascript"</font> src=<font color="#FFFFFF">"zoom/zoom.js"</font>&#62;&#60;/script&#62;<br />
                    &nbsp;&nbsp;&#60;link rel=<font color="#FFFFFF">"stylesheet"</font> type=<font color="#FFFFFF">"text/css"</font> media=<font color="#FFFFFF">"all"</font> href=<font color="#FFFFFF">"zoom/zoom.css"</font> /&#62;<br />
                    &#60;/head&#62;</font>
                </code>
                
                <p>Добавляем класс .zoom</p>
                
                <code>
                    &#60;a href=<font color="#FFFFFF">"img/big-picture.jpg"</font> <b>class=<font color="#FFFFFF">"zoom"</font></b>&#62;&#60;img src=<font color="#FFFFFF">"img/small-picture.jpg"</font> /&#62;&#60;/a&#62;</font>
                </code>
                
                <h3>Скачать</h3>
                <p><a href="../zoom.rar">Image zoom</a></p>
            </div>
        </div>
        <h5>&copy; 2010 Автор проекта: <a href="http://www.ionden.com">IonDen</a></h5>

    </div><!--#mw-->
    <a href="../../" id="goBack"><img src="../../img/back.png" width="26" height="120" alt="" /></a>
</div><!--#main-->

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-447855-7");
pageTracker._trackPageview();
} catch(err) {}</script>

</body>
</html>