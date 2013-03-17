<?php 
class Text implements IStrategy 
{
    protected $value = null;
    
    public function __construct($val)
    {
        $this->setValue($val);
    }
                           
    public function solve()
    {
        return false;
    }                           
    
    public function getValue()
    {
        return substr($this->value,1);  
    }
    
    public function setValue( $str )
    {
        $this->value = $str;
    }
}
?>