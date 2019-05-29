<?php
class Vulnerable
{
    var $test;
    function __construct()
    {
        $this->test=new jumpbroad();
    }
    function __destruct()
    {
        $this->test->action();
    }
}
class jumpbroad
{
    public function action()
    {
        echo "jumpbroad".'<br>';
    }
}
class dest
{
    var $test2;
    public function action()
    {
		echo $this->test2.'<br>';
        eval($this->test2);
    }
}
$a=new Vulnerable();
serialize($a);
unserialize($a);