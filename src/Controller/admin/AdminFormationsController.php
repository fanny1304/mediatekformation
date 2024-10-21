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
   
    
    private const CHEMIN_ADMIN_FORMATION = "admin/admin.formations.html.twig";
    
    /**
     * Constructeur 
     * @param type $formationRepository
     */
    public function __construct(FormationRepository $formationRepository, CategorieRepository $categorieRepository) {
        $this->formationRepository = $formationRepository;
        $this->categorieRepository = $categorieRepository;
    }

    #[Route('/admin', name: 'admin.formations')]
    public function index():Response {
        $formations = $this->formationRepository->findAll();
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::CHEMIN_ADMIN_FORMATION, [
            'formations' => $formations, 
            'categories' => $categories
        ]);   
    }
    
    #[Route('/admin/formations/tri/{champ}/{ordre}/{table}', name: 'admin.formations.sort')]
    public function sort($champ, $ordre, $table=""):Response{
        $formations = $this->formationRepository->findAllOrderBy($champ, $ordre, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::CHEMIN_ADMIN_FORMATION, [
            'formations' => $formations, 
            'categories' => $categories
        ]);
    }
    
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
    
    #[Route('/admin/formations/suppr/{id}', name: 'admin.formations.suppr')]
    public function suppr(int $id): Response{
        $formation = $this->formationRepository->find($id);
        $this->formationRepository->remove($formation);
        return $this->redirectToRoute('admin.formations');
    }
    
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