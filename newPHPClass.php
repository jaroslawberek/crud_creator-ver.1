<?php
class test{
    public function __constructor(){
        private $r = "chuj";
        public function test($f){
            $this->r = $f;
        }
    }
}

$n = new test();
$g = n->test();