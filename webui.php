<?php
    header('Content-type:text/html;charset=utf-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.1//EN" "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>  
    <title>php exel</title>  
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
    <meta http-equiv="imagetoolbar" content="no" />  
    <meta name="robots" content="index, follow" />  
    
    <link rel="stylesheet" href="s/style.css" media="screen" type="text/css" />  
    <link rel="stylesheet" href="s/print.css" media="print" type="text/css" />  
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" charset="UTF-8"></script>  
    <script type="text/javascript" src="js/jquery.func.js"></script>  

</head>
<body>
    <div class="page">
    <p class="line-holder">Текущее положение:<input type="text" id="nav" readonly="readonly" />
    Формула:<input type="text" id="line" /></p>
    <div class="table-holder">
        <div class="line">
            <div class="void-block"></div>
            <div class="top-cell">A</div>
            <div class="top-cell">B</div>
            <div class="top-cell">C</div>
            <div class="top-cell">D</div>
            <div class="top-cell">E</div>
            <div class="top-cell">F</div>
            <div class="top-cell">G</div>
            <div class="top-cell">H</div>
            <div class="top-cell cell-last">I</div>
        </div>
        <div class="line">
            <div class="void-block void-block2">1</div>
            <div class="cell"><input type="text" /></div>
            <div class="cell"><input type="text" /></div>
            <div class="cell"><input type="text" /></div>
            <div class="cell"><input type="text" /></div>
            <div class="cell"><input type="text" /></div>
            <div class="cell"><input type="text" /></div>
            <div class="cell"><input type="text" /></div>
            <div class="cell"><input type="text" /></div>
            <div class="cell cell-last"><input type="text" /></div>
        </div>
        <div class="line">
            <div class="void-block void-block2">2</div>
            <div class="cell"><input type="text" /></div>
            <div class="cell"><input type="text" /></div>
            <div class="cell"><input type="text" /></div>
            <div class="cell"><input type="text" /></div>
            <div class="cell"><input type="text" /></div>
            <div class="cell"><input type="text" /></div>
            <div class="cell"><input type="text" /></div>
            <div class="cell"><input type="text" /></div>
            <div class="cell cell-last"><input type="text" /></div>
        </div>
        <div class="line">
            <div class="void-block void-block2">3</div>
            <div class="cell"><input type="text" /></div>
            <div class="cell"><input type="text" /></div>
            <div class="cell"><input type="text" /></div>
            <div class="cell"><input type="text" /></div>
            <div class="cell"><input type="text" /></div>
            <div class="cell"><input type="text" /></div>
            <div class="cell"><input type="text" /></div>
            <div class="cell"><input type="text" /></div>
            <div class="cell cell-last"><input type="text" /></div>
        </div>
        <div class="line last-line">
            <div class="void-block void-block2">4</div>
            <div class="cell"><input type="text" /></div>
            <div class="cell"><input type="text" /></div>
            <div class="cell"><input type="text" /></div>
            <div class="cell"><input type="text" /></div>
            <div class="cell"><input type="text" /></div>
            <div class="cell"><input type="text" /></div>
            <div class="cell"><input type="text" /></div>
            <div class="cell"><input type="text" /></div>
            <div class="cell cell-last"><input type="text" /></div>
        </div>
    </div>
    <div id="status-line"></div>
    </div>
</body>
</html>