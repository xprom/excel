<?php
$cols = intval($_POST['cols']);
$rows = intval($_POST['rows']);

$data = array();
$c = 0;
if($cols>0 && $rows>0)
{
    for($x=0;$x<$rows;$x++)
    {
        for($y=0;$y<$cols;$y++)
        {
            $data[$x][$y] = $_POST['data'][$c];
            $c++;
        }
    }
}

include './classes/Matrix.php';

Matrix::setMatrix($data);
Matrix::fillMatrix();
Matrix::echoMatrix('json');
?>