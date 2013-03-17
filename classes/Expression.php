<?php
class Expression implements IStrategy {
    
    const MATH_SUMM   = '+';
    const MATH_DEVEL  = '-';
    const MATH_MUL    = '*';
    const MATH_DIV    = '/';
    
    protected $value = null;
    protected $array_cell;
    
    function __construct($val, & $array_cell)
    {
        $this->setValue($val);
        $this->array_cell = & $array_cell;
    }
    
    function solve()
    {
        if( $this->value[0] != '=' )
            return $this->value;

        /**
        * dismantle formula
        */
        if($this->value[0]=='=')
        {
            $this->value = str_replace('=','',$this->value);
            
            $tmp = str_replace(array('*','/','+','-'),'|',$this->value);
            $numeric_arr = explode('|',$tmp);
            
            foreach($numeric_arr as $i=>$v)
            {
                // cache link, text and numeric
                if(preg_match('/^[A-z]+[0-9]+$/',$v))
                {
                    $tmp = new Reference('='.$v,& $this->array_cell);
                    $v = $tmp->getValue();
                }
                    
                if(is_numeric($v))
                    $numeric_arr[$i] = new Number($v,& $this->array_cell);
                elseif(preg_match('|\'([A-z0-9]*)|is',$v))
                    $numeric_arr[$i] = new Text($v,& $this->array_cell);
                else
                {      
                    /**
                    * error undefined type in expression
                    */
                    if(empty($v) && Matrix::CONFIG_EMPTY_CELL==0)
                        $numeric_arr[$i] = new Number(0,& $this->array_cell);
                    else
                    {
                        $this->value = Matrix::ERROR_UNDEFINDED_OPERATION;
                        return false;
                    }
                }
            }
            
            
            /**
            * store for return value 
            * @var int 
            */
            $return_value = new Number(0);
            
            $c = 0; // counter
            for($x=0;$x<strlen($this->value);$x++)
            {
                $val = $this->value[$x];
                
                if(!($return_value instanceof Number))
                {   
                    $this->value = $return_value;
                    return false;
                }
                
                
                switch ($val) 
                {
                   case Expression::MATH_SUMM:
                            $return_value = $this->summ($numeric_arr[$c],$numeric_arr[$c+1]);
                            $numeric_arr[$c+1] = $return_value;
                            $c++;
                        break;
                        
                   case Expression::MATH_DEVEL:
                            $return_value = $this->sub($numeric_arr[$c],$numeric_arr[$c+1]);
                            $numeric_arr[$c+1] = $return_value;
                            $c++;
                        break;
                        
                   case Expression::MATH_MUL:
                            $return_value = $this->mul($numeric_arr[$c],$numeric_arr[$c+1]);
                            $numeric_arr[$c+1] = $return_value;
                            $c++;
                        break;
                        
                   case Expression::MATH_DIV:
                            $return_value = $this->div($numeric_arr[$c],$numeric_arr[$c+1]);
                            $numeric_arr[$c+1] = $return_value;
                            $c++;
                        break;
                   default:

                   break;
                }   
            }

            $this->value = $return_value->getValue();
        }
    }

    function getValue()
    {
        $this->solve();
        return $this->value;
    }
    
    function setValue( $str )
    {
        $this->value = $str;
    }
    
    /**
    * @param IStrategy $num1
    * @param IStrategy $num2
    * @return IStrategy|string
    */
    function summ(IStrategy $num1,IStrategy $num2)
    {
        if(!($num1 instanceof Number) || !($num2 instanceof Number))
        {
            return Matrix::ERROR_UNDEFINDED_TYPE;
        }
        return new Number(intval($num1->getValue()+$num2->getValue()));
    }
    
    /**
    * @param IStrategy $num1
    * @param IStrategy $num2
    * @return IStrategy|string
    */
    function sub(IStrategy $num1,IStrategy $num2)
    {          
        if(!($num1 instanceof Number) || !($num2 instanceof Number))
        {
            return Matrix::ERROR_UNDEFINDED_TYPE;
        }             
        return new Number(intval($num1->getValue()-$num2->getValue()));
    }
    
    /**
    * @param IStrategy $num1
    * @param IStrategy $num2
    * @return IStrategy|string
    */
    function mul(IStrategy $num1,IStrategy $num2)
    {   
        if(!($num1 instanceof Number) || !($num2 instanceof Number))
        {
            return Matrix::ERROR_UNDEFINDED_TYPE;
        }
        return new Number(intval($num1->getValue()*$num2->getValue()));
    }
    
    /**
    * @param IStrategy $num1
    * @param IStrategy $num2
    * @return IStrategy|string
    */
    function div(IStrategy $num1,IStrategy $num2)
    {      
        if(!($num1 instanceof Number) || !($num2 instanceof Number))
        {
            return Matrix::ERROR_UNDEFINDED_TYPE;
        }                          
        return new Number(intval($num1->getValue()/$num2->getValue()));
    } 
}
?>