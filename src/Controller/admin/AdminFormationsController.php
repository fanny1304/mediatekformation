<?php

namespace App\Controller\admin;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Description of AdminFormationsController 
 *
 * @author fanny
 */
class AdminFormationsController extends AbstractController {
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
     * Chemin de la page de gestion des formations
     */
    private const CHEMIN_ADMIN_FORMATION = "admin/admin.formations.html.twig";
    
    /**
     * Constructeur 
     * @param type $formationRepository
     */
    public function __construct(FormationRepository $formationRepository, CategorieRepository $categorieRepository) {
        $this->formationRepository = $formationRepository;
        $this->categorieRepository = $categorieRepository;
    }

    /**
     * Route redirigeant vers la page d'administration des formations
     * @return Response
     */
    #[Route('/admin', name: 'admin.formations')]
    public function index():Response {
        $formations = $this->formationRepository->findAll();
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::CHEMIN_ADMIN_FORMATION, [
            'formations' => $formations, 
            'categories' => $categories
        ]);   
    }
    
    /**
     * Route permettant de trier le tableau
     * @param type $champ
     * @param type $ordre
     * @param type $table
     * @return Response
     */
    #[Route('/admin/formations/tri/{champ}/{ordre}/{table}', name: 'admin.formations.sort')]
    public function sort($champ, $ordre, $table=""):Response{
        $formations = $this->formationRepository->findAllOrderBy($champ, $ordre, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::CHEMIN_ADMIN_FORMATION, [
            'formations' => $formations, 
            'categories' => $categories
        ]);
    }
    
    /**
     * Route permettant de trouver les formations recherchées
     * @param type $champ
     * @param Request $request
     * @param type $table
     * @return Response
     */
    #[Route('/admin/formations/recherche/{champ}/{table}', name: 'admin.formations.findallcontain')]
    public function findAllContain($champ, Request $request, $table=""): Response{
        $valeur=$request->get("recherche");
        $formations = $this->formationRepository->findByContainValue($champ, $valeur, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::CHEMIN_ADMIN_FORMATION, [
            'formations' => $formations,
            'categories' => $categories,
            'valeur' => $valeur,
            'table' => $table
        ]); 
    }
    
    /**
     * Route permettant de supprimer une formation
     * @param int $id
     * @return Response
     */
    #[Route('/admin/formations/suppr/{id}', name: 'admin.formations.suppr')]
    public function suppr(int $id): Response{
        $formation = $this->formationRepository->find($id);
        $this->formationRepository->remove($formation);
        return $this->redirectToRoute('admin.formations');
    }
    
    /**
     * Route permettant d'éditer une formation
     * @param int $id
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/formations/edit/{id}', name: 'admin.formations.edit')]
    public function edit(int $id, Request $request): Response{
        $formation = $this->formationRepository->find($id);
        $formFormation = $this->createForm(FormationType::class, $formation);
        
        $formFormation->handleRequest($request);
        if ($formFormation->isSubmitted() && $formFormation->isValid()){
            $this->formationRepository->add($formation);
            return $this->redirectToRoute('admin.formations');
        }
        
        return $this->render("admin/admin.formation.edit.html.twig", [
            'formation' => $formation, 
            'formformation' => $formFormation->createView()
        ]);
    }
    
    /**
     * Route permettatn d'ajouter une formation
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/formations/ajout', name: 'admin.formations.ajout')]
    public function ajout(Request $request): Response{
       $formation = new Formation();
       $formFormation = $this->createForm(FormationType::class, $formation);
       
       $formFormation->handleRequest($request);
       if ($formFormation->isSubmitted() && $formFormation->isValid()){
           $this->formationRepository->add($formation);
           return $this->redirectToRoute('admin.formations');
       }
       
       return $this->render("admin/admin.formation.ajout.html.twig", [
           'formation' => $formation, 
           'formformation' => $formFormation->createView()
       ]);
    }
}
