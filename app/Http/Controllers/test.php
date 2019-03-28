<?php
trait FFF { abstract $size; }
class RRR {
    use FFF; 
    //$size = 10;
    function __invoke() { 
        echo $this->size; 
    }
}

$g = new RRR();
$g();
 
