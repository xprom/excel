<?php 
class Number implements IStrategy 
{
    protected $value = null;
    
    function __construct($val)
    {
        $this->setValue($val);
    }
    
    function solve()
    {
        return 1;   
    }
    
    function getValue()
    {
        return $this->value;
    }
    
    function setValue( $str )
    {
        $this->value = $str;
    }
}
?>