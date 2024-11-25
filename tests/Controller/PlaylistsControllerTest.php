<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of PlaylistsControllerTest
 *
 * @author fanny
 */
class PlaylistsControllerTest extends WebTestCase{
    /**
     * Test l'accès à la page d'affichage des playlists
     */
    public function testAccesPagePlaylists(){
        $client = static::createClient();
        $client->request('GET', '/playlists');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    
    /**
     * Test sur le tri ascendant du nom des playlists
     */
    public function testTriPlaylistAsc(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/playlists/tri/name/ASC');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $premierResultat = $crawler->filter('table tbody tr:first-child td:first-child')->text();
        $this->assertEquals($premierResultat, "Bases de la programmation (C#)");
    }
    
    /**
     * Test sur le tri descendant du nom des playlists
     */
    public function testTriPlaylistDesc(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/playlists/tri/name/DESC');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $premierResultat = $crawler->filter('table tbody tr:first-child td:first-child')->text();
        $this->assertEquals($premierResultat, "Visual Studio 2019 et C#");
    }
    
    /**
     * Test sur le tri ascendant du nombre de formations associées à une playlist
     */
    public function testTriNbFormationsAsc(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/playlists/tri/nbformations/ASC');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $premierResultat = $crawler->filter('table tbody tr:first-child td:first-child')->text();
        $this->assertEquals($premierResultat, "Cours Informatique embarquée");
    }
    
    /**
     * Test sur le tri descendant du nombre de formations associées à une playlist
     */
    public function testTriNbFormationsDesc(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/playlists/tri/nbformations/DESC');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $premierResultat = $crawler->filter('table tbody tr:first-child td:first-child')->text();
        $this->assertEquals($premierResultat, "Bases de la programmation (C#)");
    }
    
    /**
     * Test sur le filtre des playlists
     */
    public function testFiltrePlaylist(){
        $client = static::createClient();
        $client->request('GET', '/playlists/recherche/name');
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'C#'
        ]);
        $this->assertCount(2, $crawler->filter('h5'));
        $premierResultat = $crawler->filter('table tbody tr:first-child td:first-child')->text();
        $this->assertEquals($premierResultat, "Bases de la programmation (C#)");
    }
    
    /**
     * Test sur le filtre des catégories
     */
    public function testFiltreCategorie(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/playlists/recherche/id/categories');
        $deuxForm = $crawler->filter('form')->eq(1)->form();
        $crawler = $client->submit($deuxForm, [
            'recherche' => 1
        ]);
        $this->assertCount(3, $crawler->filter('h5'));
        $premierResultat = $crawler->filter('table tbody tr:first-child td:first-child')->text();
        $this->assertEquals($premierResultat, "Eclipse et Java");
    }
    
    /**
     * Test sur le lien qui redirige vers la page de détail d'une playlist
     */
    public function testLienPlaylist(){
        $client = static::createClient();
        $client->request('GET', '/playlists');
        $client->clickLink('Voir détail');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals('/playlists/playlist/13', $uri);
        $this->assertSelectorTextContains('h4', 'Bases de la programmation (C#)');
    }
}
