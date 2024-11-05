<?php

namespace App\Controller\admin;

use App\Entity\Playlist;
use App\Form\PlaylistType;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AdminPlaylistsController
 *
 * @author fanny
 */
class AdminPlaylistsController extends AbstractController{
    /**
     * 
     * @var FormationRepository
     */
    private $formationRepository;
    
    /**
     * 
     * @var CategorieRepository
     */
    private $categorieRepository;
    
    /**
     * 
     * @var PlaylistRepository
     */
    private $playlistRepository;
    
    /**
     * Constante du chemin menant à la page de gestion des playlists
     */
    private const CHEMIN_ADMIN_PLAYLISTS = "admin/admin.playlists.html.twig";
    
    /**
     * Constructeur
     * @param FormationRepository $formationRepository
     * @param CategorieRepository $categorieRepository
     * @param PlaylistRepository $playlistRepository
     */
    public function __construct(FormationRepository $formationRepository, CategorieRepository $categorieRepository, PlaylistRepository $playlistRepository) {
        $this->formationRepository = $formationRepository;
        $this->categorieRepository = $categorieRepository;
        $this->playlistRepository = $playlistRepository;
    }

    
    #[Route('/admin/playlists', name: 'admin.playlists')]
    public function index(): Response{
        $formations = $this->formationRepository->findAll();
        $categories = $this->categorieRepository->findAll();
        $playlists = $this->playlistRepository->findAll();
        return $this->render(self::CHEMIN_ADMIN_PLAYLISTS, [
            'formations' => $formations, 
            'categories' => $categories, 
            'playlists' => $playlists
        ]);
    }

    #[Route('/admin/playlists/tri/{champ}/{ordre}/{table}', name: 'admin.playlists.sort')]
    public function sort($champ, $ordre, $table=""): Response {
        switch($champ){
            case "name":
                $playlists = $this->playlistRepository->findAllOrderByName($ordre);
                break;
            case "nbformations":
                $playlists = $this->playlistRepository->findAllOrderByNbFormations($ordre);
                break;
            default:
                break;
        }
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::CHEMIN_ADMIN_PLAYLISTS, [
            'playlists' => $playlists,
            'categories' => $categories            
        ]);
    }
    
    #[Route('/admin/playlists/recherche/{champ}/{table}', name: 'admin.playlists.findallcontain')]
    public function findAllContain($champ, Request $request, $table=""): Response{
        $valeur = $request->get("recherche");
        $playlists = $this->playlistRepository->findByContainValue($champ, $valeur, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::CHEMIN_ADMIN_PLAYLISTS, [
            'playlists' => $playlists,
            'categories' => $categories,            
            'valeur' => $valeur,
            'table' => $table
        ]);
    }
    
    #[Route('/admin/playlists/suppr/{id}', name:'admin.playlists.suppr')]
    public function suppr(int $id): Response{
        $playlist = $this->playlistRepository->find($id);
        
        if(count($playlist->getFormations()) > 0){
            return $this->redirectToRoute('admin.playlists');
        }else{
            $this->playlistRepository->remove($playlist);
            return $this->redirectToRoute('admin.playlists');
        }
                
    }
          
    #[Route('/admin/playlists/edit/{id}', name:'admin.playlists.edit')]
    public function edit(int $id, Request $request): Response{
        $playlist = $this->playlistRepository->find($id);
        $formPlaylist= $this->createForm(PlaylistType::class, $playlist);
        
        $formPlaylist->handleRequest($request);
        if ($formPlaylist->isSubmitted() && $formPlaylist->isValid()){
            $this->playlistRepository->add($playlist);
            return $this->redirectToRoute("admin.playlists");
        }
        
        return $this->render("admin/admin.playlist.edit.html.twig", [
            'playlist' => $playlist, 
            'formplaylist' => $formPlaylist->createView()
        ]);
    }
    
    #[Route('/admin/playlists/ajout', name: 'admin.playlists.ajout')]
    public function ajout(Request $request): Response{
        $playlist = new Playlist();
        $formPlaylist = $this->createForm(PlaylistType::class, $playlist);
        $formPlaylist->remove('formations');
        
        $formPlaylist->handleRequest($request);
        if ($formPlaylist->isSubmitted() && $formPlaylist->isValid()){
            $this->playlistRepository->add($playlist);
            return $this->redirectToRoute("admin.playlists");
        }
        
        return $this->render("admin/admin.playlist.ajout.html.twig", [
            'playlist' => $playlist, 
            'formplaylist' => $formPlaylist->createView()
        ]);
    }
}

