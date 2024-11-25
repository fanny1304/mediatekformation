<?php


namespace App\Tests;

use App\Entity\Formation;
use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * Description of FormationTest
 *
 * @author fanny
 */
class FormationTest extends TestCase{
    public function testGetPublishedAtString(){
        $formation = new Formation();
        $formation->setPublishedAt(new DateTime("2024-11-13 14:00:12"));
        $this->assertEquals("13/11/2024", $formation->getPublishedAtString());
    }
}
