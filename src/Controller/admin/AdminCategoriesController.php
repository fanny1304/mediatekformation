<?php


namespace App\Controller\admin;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AdminCategoriesController
 *
 * @author fanny
 */
class AdminCategoriesController extends AbstractController{
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
     * Constante du chemin menant à la page de gestion des formations
     */
    private const CHEMIN_ADMIN_CATEGORIES = "admin/admin.categories.html.twig";
    
    /**
     * Constructeur
     * @param FormationRepository $formationRepository
     * @param CategorieRepository $categorieRepository
     */
    public function __construct(FormationRepository $formationRepository, CategorieRepository $categorieRepository) {
        $this->formationRepository = $formationRepository;
        $this->categorieRepository = $categorieRepository;
    }

    #[Route('/admin/categories', name: 'admin.categories')]
    public function index(): Response{
        $formations = $this->formationRepository->findAll();
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::CHEMIN_ADMIN_CATEGORIES, [
            'formations' => $formations, 
            'categories' => $categories
        ]);
    }   
    
    
    #[Route('/admin/categories/suppr/{id}', name: 'admin.categories.suppr')]
    public function suppr(int $id): Response{
        $categorie = $this->categorieRepository->find($id);
        
        if (count($categorie->getFormations()) > 0){
            return $this->redirectToRoute('admin.categories');
        }else{
            $this->categorieRepository->remove($categorie);
            return $this->redirectToRoute('admin.categories');
        }
    }
    
    

    
#[Route('/admin/categories/ajout', name: 'admin.categories.ajout')]
public function ajout(Request $request): Response {
    $categorie = new Categorie();
    $formCategorie = $this->createForm(CategorieType::class, $categorie);
    $formCategorie->handleRequest($request);

    if ($formCategorie->isSubmitted() && $formCategorie->isValid()) {
        $nomCategorie = $categorie->getName();
        $double = $this->categorieRepository->findOneBy(['name' => $nomCategorie]);

        if ($double) {
            echo "<script type='text/javascript'>
                alert('Ce nom de catégorie existe déjà dans la base de données.');
                window.location.href = '" . $this->generateUrl("admin.categories.ajout") . "';
            </script>";
            exit;
        } else {
            $this->categorieRepository->add($categorie);
            return $this->redirectToRoute("admin.categories");
        }
    }

    return $this->render("admin/admin.categorie.ajout.html.twig", [
        'formcategorie' => $formCategorie->createView()
    ]);
}

    
    
    
}
