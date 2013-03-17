<?php
set_time_limit(1);
ini_set('display_errors',0);

//function __autoload($class_name) 
//{
//    include './classes/'.$class_name . '.php';
//}

include './classes/Matrix.php';
     
$data = array();

if(is_array($argv))
{
    foreach($argv as $v)
    {
        if($v=='--h' || $v=='-h')
        {
            Matrix::echoHelp();
            exit();
        }
        if($v=='-t=1')
        {
            $data =  Matrix::$demo_1;
            $flag = true;
        }
        if($v=='-t=2')
        {
            $data =  Matrix::$demo_2;
            $flag = true;
        }
        if($v=='-t=3')
        {
            $data =  Matrix::$demo_3;
            $flag = true;
        }
    }

    /**
     * parsing input data
     */
    $c = 3;    
    if(isset($argv[1]) && isset($argv[2]))
	    if(is_numeric($argv[1]) && is_numeric($argv[2]) && !$flag)
	    {
	        for($x=0;$x<intval($argv[1]);$x++)
	        {
	            for($y=0;$y<intval($argv[2]);$y++)
	            {
            		if(isset($argv[$c]))
            		{
	                	$data[$x][$y] = $argv[$c];
	                	$c++;
					}
	            }
	        }
	    }
}


if(count($data)==0)
{
    print 'Enter the raw data! for help use -h or --h
    
';
    exit();
}

Matrix::setMatrix($data);
Matrix::fillMatrix();
Matrix::echoMatrix();
?>