<?php
class Cell 
{
    /**
    * @var IStrategy
    */
    public $stategy;
    protected $value;
    
    function __construct(IStrategy $stategy)
    {
        $this->stategy = $stategy;
    }
    
    public function solve()
    {
        $this->stategy->solve();
    }
    
    public function getStratege()
    {
        return $this->stategy;
    }
    
    public function getValue()
    {
        return $this->stategy->getValue();
    }
}
?>