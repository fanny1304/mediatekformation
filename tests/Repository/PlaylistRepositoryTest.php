<?php
namespace App\Tests\Repository;

use App\Entity\Playlist;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of PlaylistRepositoryTest
 *
 * @author fanny
 */
class PlaylistRepositoryTest extends KernelTestCase {
   
    /**
     * Recupère le repository de Playlist 
     * @return PlaylistRepository
     */
    public function recupRepository(): PlaylistRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(PlaylistRepository::class);
        return $repository;
    }
  
    /**
     * Test sur le nombre d'enregistrement dans la table playlist
     */
    public function testNbPlaylists(){
        $repository = $this->recupRepository();
        $nbPlaylists = $repository->count([]);
        $this->assertEquals(27, $nbPlaylists);
    }
    
    /**
     * Création d'une instance de Playlist
     * @return Playlist
     */
    public function newPlaylist(): Playlist{
        $playlist = (new Playlist())
                    ->setName("Playlist Test")
                    ->setDescription("Description de la playlist de tests");
        return $playlist;
    }
    
    /**
     * Test sur l'ajout d'une playlist dans la table 
     */
    public function testAddPlaylist(){
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $nbPlaylists = $repository->count([]);
        $repository->add($playlist, true);
        $this->assertEquals($nbPlaylists + 1, $repository->count([]), "erreur lors de l'ajout d'une playlist");        
    }
    
    /**
     * Test sur la suppression d'une playlist dans la table 
     */
    public function testRemovePlaylist(){
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $repository->add($playlist, true);
        $nbPlaylists = $repository->count([]);
        $repository->remove($playlist, true);
        $this->assertEquals($nbPlaylists - 1, $repository->count([]), "erreur lors de la suppression d'une playlist");       
    }
    
    
    /**
     * Test sur la fonction de tri d'un champ par son nom
     */
    public function testFindAllOrderByName(){
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $repository->add($playlist, true);
        $playlists = $repository->findAllOrderByName("ASC");
        $nbPlaylists = count($playlists);
        $this->assertEquals(28,$nbPlaylists);
        $this->assertEquals("Bases de la programmation (C#)", $playlists[0]->getName(), 
                "erreur lors du tri d'un champ par le nom");
    }
    
    /**
     * Test sur la fonction de filtrage des playlists 
     */
    public function testFindByContainValue(){
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $repository->add($playlist, true);
        $playlists = $repository->findByContainValue("name", "POO");
        $nbPlaylists = count($playlists);
        $this->assertEquals(1, $nbPlaylists);
        $this->assertEquals("POO TP Java", $playlists[0]->getName(), 
                "erreur lors de la fonction de filtrage");
    }
    
    /**
     * Test sur le tri en fonction du nombre de formations
     */
    public function testFindAllOrderByNbFormations(){
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $repository->add($playlist, true);
        $playlists = $repository->findAllOrderByNbFormations("ASC");
        $nbPlaylists = count($playlists);
        $this->assertEquals(28, $nbPlaylists);
        $this->assertEquals("Playlist Test", $playlists[0]->getName(), 
                "erreur lors du tri en fonction du nombre de formation");
    }
    
}
