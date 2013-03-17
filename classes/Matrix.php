<?php
include './classes/IStrategy.php';
include './classes/Expression.php';
include './classes/Text.php';
include './classes/Cell.php';
include './classes/Number.php';
include './classes/Reference.php';

final class Matrix
{
    /**
    * 0 - empty cell is parsed as 0
    * e - emty cell is parsed as ERROR
    */
    const CONFIG_EMPTY_CELL = 0;
    
    const ERROR_UNDEFINDED_TYPE = '#undefined_type';
    const ERROR_UNDEFINDED_OPERATION = '#undefined_operation';
    const ERROR_LINKING = '#link_error';
    const ERROR_LOOPING = '#looping_error';
    const ERROR_OPERATION_ERROR = '#expression_oparetion_error';
    
    public static $demo_1 = array( 
                array('12','=C2','3','\'Sample'),
                array('=A1+B1*C1/5','=A2*B1','=B3-C3','\'Spread'),
                array('\'Test','=4-3','5','\'Sheet')
    );
    
    public static $demo_2 = array( 
                array('12','=C20','3','\'Sample'),
                array('=A1+C1/5','=A2','=4*3','\'Spread')
    );
    
    public static $demo_3 = array( 
                array('=B1','=C1','=A1'),
                array('\'this is','\'a loopng','\'exemple')
    );
    
    /**
    * protected array of text value source matrix
    * @var array[int][int]string
    */
    protected static $src_matrix = array();
    
    /**
    * protected array of object 
    * 
    * @var array[int][int]IStrategy
    */
    protected static $obj_matrix = array();
    
    /**
    * an array of links to detect looping
    * for exemple cell A2 content =A3 and cell A3 content =A2
    * @var array
    */
    public static $referal_store = array();
    
    /**
    * set data to matrix
    * 
    * @param mixed $arr 
    * @return boolean
    */
    public static function setMatrix(array $arr)
    {
        if(count(self::$src_matrix)==0 && count($arr)!=0)
            self::$src_matrix = $arr;
        return false;
    }
    
    /**
    * 
    */
    public static function fillMatrix()
    {
        foreach(self::$src_matrix as $i => $row)
        {
            foreach($row as $j => $cell)
            {
                $class_name = null;
                if(preg_match('|\'([A-z0-9]*)|is',$cell))
                    self::$obj_matrix[$i][$j] = new Cell(new Text($cell));
                elseif(preg_match('/^[0-9]+$/',$cell))
                    self::$obj_matrix[$i][$j] = new Cell(new Number($cell));
                elseif(preg_match('/^=[A-z]+[0-9]+$/',$cell))
                    self::$obj_matrix[$i][$j] = new Cell(new Reference($cell,& self::$obj_matrix));
                elseif(preg_match('/^=[A-z0-9\\\+\-\*]*/',$cell))
                    self::$obj_matrix[$i][$j] = new Cell(new Expression($cell,& self::$obj_matrix));
                else
                {
                    if(Matrix::CONFIG_EMPTY_CELL==0)
                        self::$obj_matrix[$i][$j] = new Cell(new Text('',& self::$obj_matrix));
                    else
                        self::$obj_matrix[$i][$j] = new Cell(new Text('/'.Matrix::CONFIG_EMPTY_CELL,& self::$obj_matrix));
                }
            }
        }
    }
    
    /**
    * echo matrix as plan/text
    */
    public static function echoMatrix($w = 'text')
    {
        if($w=='text')
        {
            print "Source data:\n\n";
            foreach(self::$src_matrix as $row)
            {
                foreach($row as $cell)
                {
                    printf(" [%30s] ",$cell);
                }
                print "\n";
            }
            
            print "Return data:\n\n";
            
            foreach(self::$obj_matrix as $row)
            {
                foreach($row as /** @var IStrategy */ $cell)
                {
                    printf(" [%30s] ",$cell->getValue());
                }
                print "\n";
            }
        }
        if($w=='json')
        {
            $res = array();
            foreach(self::$obj_matrix as $row)
            {
                foreach($row as /** @var IStrategy */ $cell)
                {            
                    $res[] = $cell->getValue();
                }
            }
            
            
            header('Content-type:text/json;charset=utf8');
            print json_encode($res);
        }
    }
    
    public static function echoHelp()
    {
        print "*********************************
PHP EXEL
FOR view some exemple you can run this script with opt -t=1 
                                                       -t=2
                                                       -t=3
where 1, 2 and 3 is a number of demo.


For user input you should data transfer by a space.
For exemple:
    php index.php 3 4 12 =C2 3 'Sample =A1+B1*C1/5 =A2*B1 =B3-C3 'Spread 'Test =4-3 5 'Sheet
where first two number is a rowcount and collcount.
*********************************


";
    }
}
?>