<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of FormationsControllerTests
 *
 * @author fanny
 */
class FormationsControllerTests extends WebTestCase{
    
    /**
     * Test l'accès à la page d'affichage des formations
     */
    public function testAccesPageFormations(){
        $client = static::createClient();
        $client->request('GET', '/formations');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    
    /**
     * Test sur le tri ascendant du nom des formations
     */
    public function testTriFormationAsc(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/formations/tri/title/ASC');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $premierResultat = $crawler->filter('table tbody tr:first-child td:first-child')->text();
        $this->assertEquals($premierResultat, "Android Studio (complément n°1) : Navigation Drawer et Fragment");
    }
    
    /**
     * Test sur le tri descendant du nom des formations
     */
    public function testTriFormationDesc(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/formations/tri/title/DESC');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $premierResultat = $crawler->filter('table tbody tr:first-child td:first-child')->text();
        $this->assertEquals($premierResultat, "UML : Diagramme de paquetages");
    }
    
    /**
     * Test sur le tri ascendant du nom des playlist
     */
    public function testTriPlaylistAsc(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/formations/tri/name/ASC/playlist');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $premierResultat = $crawler->filter('table tbody tr:first-child td:first-child')->text();
        $this->assertEquals($premierResultat, "Bases de la programmation n°74 - POO : collections");
    }
    
    /**
     * Test sur le tri descendant du nom des playlist
     */
    public function testTriPlaylistDesc(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/formations/tri/name/DESC/playlist');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $premierResultat = $crawler->filter('table tbody tr:first-child td:first-child')->text();
        $this->assertEquals($premierResultat, "C# : ListBox en couleur");
    }
    
    /**
     * Test sur le tri ascendant de la date de publication
     */
    public function testTriDateAsc(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/formations/tri/publishedAt/ASC');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $premierResultat = $crawler->filter('table tbody tr:first-child td:first-child')->text();
        $this->assertEquals($premierResultat, "Cours UML (1 à 7 / 33) : introduction et cas d'utilisation");
    }
   
    /**
     * Test sur le tri descendant de la date de publication-
     */
    public function testTriDateDesc(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/formations/tri/publishedAt/DESC');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $premierResultat = $crawler->filter('table tbody tr:first-child td:first-child')->text();
        $this->assertEquals($premierResultat, "Eclipse n°8 : Déploiement");
    }
    
    /**
     * Test sur le filtre des formations
     */
    public function testFiltreFormation(){
        $client = static::createClient();
        $client->request('GET', '/formations/recherche/title');
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'test'
        ]);
        $this->assertCount(5, $crawler->filter('h5'));
        $premierResultat = $crawler->filter('table tbody tr:first-child td:first-child')->text();
        $this->assertEquals($premierResultat, "Eclipse n°7 : Tests unitaires");
    }
  
    /**
     * Test sur le filtre des playlists
     */
    public function testFiltrePlaylist(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/formations/recherche/name/playlist');
        $deuxForm = $crawler->filter('form')->eq(1)->form();
        $crawler = $client->submit($deuxForm, [
            'recherche' => 'UML'
        ]);
        $this->assertCount(10, $crawler->filter('h5'));
        $premierResultat = $crawler->filter('table tbody tr:first-child td:first-child')->text();
        $this->assertEquals($premierResultat, "UML : Diagramme de paquetages");
    }
    
    /**
     * Test sur le filtre des catégories
     */
    public function testFiltreCategorie(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/formations/recherche/id/categories');
        $troisiemeForm = $crawler->filter('form')->eq(2)->form();
        $crawler = $client->submit($troisiemeForm, [
            'recherche' => 1
        ]);
        $this->assertCount(15, $crawler->filter('h5'));
        $premierResultat = $crawler->filter('table tbody tr:first-child td:first-child')->text();
        $this->assertEquals($premierResultat, "Eclipse n°8 : Déploiement");
    }
    
    /**
     * Test sur le lien qui redirige vers la page de détail d'une formation
     */
    public function testLienFormation(){
        $client = static::createClient();
        $client->request('GET', '/formations');
        $client->clickLink('image miniature');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals('/formations/formation/1', $uri);
        $this->assertSelectorTextContains('h4', 'Eclipse n°8 : Déploiement');
    }
    
}
