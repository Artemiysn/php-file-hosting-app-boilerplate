<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class fileProccessTest extends TestCase
{

    public function testIconsList()
    {
        $fileProccess =  new \App\Http\Controllers\FileProccess();
        $arr = $fileProccess->_getIconslist();
        $this->assertArrayHasKey('_blank', $arr);
        //dump($arr);
    }
    public function testThumbName()
    {

    }
}
