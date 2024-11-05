<?php


namespace App\Form;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of CategorieType
 *
 * @author fanny
 */
class CategorieType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options): void 
    {     
        $builder 
                ->add('name', TextType::class, [
                    'label' => "Nom de la catégorie",
                    'required' => true
                ])
                -> add('submit', SubmitType::class, [
                    'label' => 'Valider'
                ]);
    }
    
    public function configureOptions(OptionsResolver $resolver):void{
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
