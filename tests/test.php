<?php

require_once '../vendor/autoload.php';
require_once '../src/Xbdv/Trace.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of test
 *
 * @author xhg
 */
class test
{
    public function test1()
    {
        $trace = new Xbdv\Trace();
        $trace->dump(array(5,"toto"=> "roi"));
    }
}

$test = new test();
$test->test1();