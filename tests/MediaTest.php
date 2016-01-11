<?php

/**
 * Created by PhpStorm.
 * User: Wailovet
 * Date: 2016/1/11
 * Time: 11:58
 */
class MediaTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
    }

    public function tearDown()
    {
    }

    public function testConnectionIsValid()
    {
        // test to ensure that the object from an fsockopen is valid

        require_once(dirname(__FILE__)."/../autoload.php");
    }
}
