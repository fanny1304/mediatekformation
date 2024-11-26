<?php


namespace App\Form;

use App\Entity\Formation;
use App\Entity\Playlist;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of PlaylistType
 *
 * @author fanny
 */
class PlaylistType extends AbstractType {
    
    /**
     * Construction du formulaire 
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
                ->add('name', TextType::class, [
                    'label' => "Nom de la playlist", 
                    'required' => true
                ])
                ->add('description', TextareaType::class, [
                    'label' => "Description", 
                    'required' => false
                ])
                ->add('formations', EntityType::class, [
                    'class' => Formation::class, 
                    'choice_label' => 'title', 
                    'multiple' => true, 
                    'required' => false
                ])
                ->add('submit', SubmitType::class, [
                    'label' => 'Valider'
                ]);
    }
   
    /**
     * Configurer les options
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver):void{
        $resolver->setDefaults([
            'data_class' => Playlist::class,
        ]);
    }
    
}
