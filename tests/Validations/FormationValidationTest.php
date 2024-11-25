<?php

namespace App\Tests\Validations;

use App\Entity\Formation;
use App\Entity\Playlist;
use DateInterval;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Description of FormationValidationTest
 *
 * @author fanny
 */
class FormationValidationTest extends KernelTestCase{
    public function getFormation(): Formation{
        return (new Formation())
                ->setTitle("Formation Test")
                ->setPlaylist(New Playlist());
    }
    
    public function assertErrors(Formation $formation, int $nbErreursAttendues, string $message=""){
        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $error = $validator->validate($formation);
        $this->assertCount($nbErreursAttendues, $error, $message);
    }
    
    public function testValidDateFormation(){
        $aujourdhui = new \DateTime();
        $this->assertErrors($this->getFormation()->setPublishedAt($aujourdhui), 0, "aujourd'hui devrait réussir");
        $plustot = (new \DateTime())->sub(new DateInterval("P5D"));
        $this->assertErrors($this->getFormation()->setPublishedAt($plustot), 0, "plus tôt devrait réussir");
    }
    
    public function testNonValidDateFormation(){
        $demain = (new \DateTime())->add(new DateInterval("P1D"));
        $this->assertErrors($this->getFormation()->setPublishedAt($demain), 1, "demain devrait échouer");
        $plustard = (new \DateTime())->add(new DateInterval("P5D"));
        $this->assertErrors($this->getFormation()->setPublishedAt($plustard), 1, "plus tard devrait échouer");
    }
    
}
