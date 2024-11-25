<?php

namespace App\Tests\Repository;

use App\Entity\Formation;
use App\Repository\FormationRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of FormationRepositoryTest
 *
 * @author fanny
 */
class FormationRepositoryTest extends KernelTestCase {
    
    /**
     * Récupère le repository de Formation 
     * @return FormationRepository
     */
    public function recupRepository(): FormationRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(FormationRepository::class);
        return $repository;
    }
    
    /**
     * Test sur le nombre d'enregistrements contenus dans la table 
     */
    public function testNbFormations(){
        $repository = $this->recupRepository();
        $nbFormations = $repository->count([]);
        $this->assertEquals(237, $nbFormations);
    }
    
    /**
     * Création d'une instance de Formation 
     * @return Formation
     */
    public function newFormation(): Formation{
        $formation = (new Formation())
                        ->setTitle("Formation Test")
                        ->setPublishedAt(new DateTime("2014/11/14"));
        return $formation;
    }
    
    /**
     * Test sur l'ajout d'une formation dans la table 
     */
    public function testAddFormation(){
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $nbFormations = $repository->count([]);
        $repository->add($formation, true);
        $this->assertEquals($nbFormations + 1, $repository->count([]), "erreur lors de l'ajout");
    }
    
    /**
     * Test sur la suppression d'une formation dans la table 
     */
    public function testRemoveFormation(){
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $repository->add($formation, true);
        $nbFormations = $repository->count([]);
        $repository->remove($formation, true);
        $this->assertEquals($nbFormations - 1, $repository->count([]), "erreur lors de la suppression");
    }
    
    /**
     * Test sur la fonction de tri d'un champ. 
     */
    public function testFindAllOrderBy(){
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $repository->add($formation, true);
        $formations = $repository->findAllOrderBy("title", "ASC");
        $nbFormations = count($formations);
        $this->assertEquals(238, $nbFormations);
        $this->assertEquals("Android Studio (complément n°1) : Navigation Drawer et Fragment", $formations[0]->getTitle(), 
                "erreur lors du tri d'un champ");
    }
    
    /**
     * Test sur la fonction de filtrage des formations 
     */
    public function testFindByContainValue(){
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $repository->add($formation, true);
        $formations = $repository->findByContainValue("title", "Déploiement");
        $nbFormations = count($formations);
        $this->assertEquals(1, $nbFormations);
        $this->assertEquals("Eclipse n°8 : Déploiement", $formations[0]->getTitle(), "erreur lors du filtrage des formations");
    }

    /**
     * Test sur la fonction retournant les formations les plus récentes 
     */
    public function testFindAllLasted(){
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $repository->add($formation, true);
        $formations = $repository->findAllLasted(1);
        $nbFormations = count($formations);
        $this->assertEquals(1, $nbFormations);
        $this->assertEquals("Eclipse n°8 : Déploiement", $formations[0]->getTitle(), 
                "erreur lors du retour des formations les plus récentes");
    }
    
    /**
     * Test sur la fonction retournant la liste des formations d'une playlist
     */
    public function testFindAllForOnePlaylist(){
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $repository->add($formation, true);
        $formations = $repository->findAllForOnePlaylist(1);
        $nbFormations = count($formations);
        $this->assertEquals(8, $nbFormations);
        $this->assertEquals("Eclipse n°1 : installation de l'IDE", $formations[0]->getTitle(), "erreur lors du renvoi de la liste des formations d'une playlist");
    }
    
    
}
