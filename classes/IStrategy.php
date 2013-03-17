<?php
interface IStrategy
{
    /**
    * solve sell value wich will be saved in protected property $value
    * @return false
    */
    public function solve();
    
    /**
    * set cell's value. Save it in protected propery $value
    * @param mixed $var string
    * @return false
    */
    public function setValue($var);
    
    /**
    * return cell's value
    * @return string
    */
    public function getValue();
}
?>