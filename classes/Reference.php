<?php
class Reference implements IStrategy {
    
    protected $value = null;
    protected $array_cell;
    
    protected $solved_start = false;
    protected $solved_finish = false;
    
    function __construct($val, & $array_cell)
    {
        $this->setValue($val);
        $this->array_cell = & $array_cell;
    }
      
    /**
    * conver ABC(26) scale to dec(10)
    * 
    * for exemple a  = 1 
    *             b  = 2 
    *             ...
    *             z  = 26
    *             aa = 27 
    *             ab = 28 etc.  
    *                   
    * 
    * @param mixed $str string number in ABC scale
    * @return int dec number value 
    */
    function abcToInt($str)
    {
        $dec_value = 0;
        for($x=0;$x<strlen($str);$x++)
        {
            $c = $str[$x];
            $dec_value += (base_convert($c,36,10)-9 ) * pow(26,strlen($str)-$x-1) ;
        }
        return $dec_value;
    }

    function remouteCell()
    {
        return $this->remoute;
    }
    
    function solve()
    {           
        if($this->solved_start and !$this->solved_finish)
        {
            $this->value = Matrix::ERROR_LOOPING;
            return false;
        }
        
        $this->solved_start = true;
        
        if(strpos( $this->value, '=' )!==false && $this->value[0]=='=')
        {
            $this->value = str_replace('=','',$this->value);
            $column = preg_replace('/[0-9]/','',$this->value);
            $row = intval( str_replace($column,'',$this->value) );
            
            if(empty($this->array_cell[$row-1][ $this->abcToInt($column) -1 ]))
            {
                if(Matrix::CONFIG_EMPTY_CELL==0)
                    $this->value = '';
                else
                    $this->value = Matrix::ERROR_LINKING;
            }
            else
                $this->value = $this->array_cell[$row-1][ $this->abcToInt($column) -1 ]->getValue();
        }
        
        $this->solved_finish = true;
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
}
?>
