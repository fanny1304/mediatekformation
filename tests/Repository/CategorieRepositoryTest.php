<?php
namespace App\Tests\Repository;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of CategorieRepositoryTest
 *
 * @author fanny
 */
class CategorieRepositoryTest extends KernelTestCase {
    
    /**
     * Récupère le repository de Categorie
     * @return CategorieRepository
     */
    public function recupRepository(): CategorieRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(CategorieRepository::class);
        return $repository;
    }
    
    /**
     * Test sur le nombre d'enregistrement contenus dans la table Categorie
     */
    public function testNbCategories(){
        $repository = $this->recupRepository();
        $nbCategories = $repository->count([]);
        $this->assertEquals(10, $nbCategories);
    }
    
    /**
     * Création d'une instance de Categorie
     * @return type
     */
    public function newCategorie(){
        $categorie = (new Categorie())
                    ->setName("Categorie Test");
        return $categorie;
    }
    
    /**
     * Test sur l'ajout d'une catégorie dans la table 
     */
    public function testAddCategorie(){
        $repository = $this->recupRepository();
        $categorie = $this->newCategorie();
        $nbCategories = $repository->count([]);
        $repository->add($categorie, true);
        $this->assertEquals($nbCategories + 1, $repository->count([]), 
                "erreur lors de l'ajout d'une catégorie");
    }
    
    /**
     * Test sur la suppression d'une catégorie dans la table 
     */
    public function testRemoveCategorie(){
        $repository = $this->recupRepository();
        $categorie = $this->newCategorie();
        $repository->add($categorie, true);
        $nbCategories = $repository->count([]);
        $repository->remove($categorie, true);
        $this->assertEquals($nbCategories - 1, $repository->count([]), 
                "erreur lors de la suppression d'une catégorie");
    }
    
    /**
     * Test sur la fonction récupérant les catégories des formations pour une playlist
     */
    public function testFindAllForOnePlaylist(){
        $repository = $this->recupRepository();
        $categorie = $this->newCategorie();
        $repository->add($categorie, true);
        $categories = $repository->findAllForOnePlaylist(3);
        $nbCategories = count($categories);
        $this->assertEquals(2, $nbCategories);
        $this->assertEquals("POO", $categories[0]->getName(), 
                "erreur lors de la récupération des catégories de formations d'une playlist");
    }
    
}
