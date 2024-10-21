<?php

namespace App\Form;

use DateTime;
use App\Entity\Categorie;
use App\Entity\Formation;
use App\Entity\Playlist;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of FormationType
 *
 * @author fanny
 */
class FormationType extends AbstractType
{
    /**
     * Construction du formulaire
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void 
    {     
        $builder 
                ->add('title', TextType::class, [
                    'label' => "Titre de la formation",
                    'required' => true
                ])
                ->add('publishedAt', DateType::class, [
                    'widget' => 'single_text', 
                    'data' => isset($options['data']) &&
                        $options['data']->getPublishedAt() != null ? $options['data']->getPublishedAt() : new DateTime('now'), 
                    'label' => "Date de publication",
                    'required' => true
                ]) 
                ->add('description', TextareaType::class, [
                    'label' => "Description", 
                    'required' => false
                ])
                ->add('playlist', EntityType::class, [
                    'class' => Playlist::class, 
                    'label' => "Playlist",
                    'choice_label' => 'name',
                    'multiple' => false, 
                    'required' => true                    
                ])
                ->add('categories', EntityType::class, [
                    'class' => Categorie::class, 
                    'label' => "Catégorie", 
                    'choice_label' => 'name', 
                    'multiple' => true, 
                    'required' => false
                ])
                -> add('submit', SubmitType::class, [
                    'label' => 'Valider'
                ]);
    }
    
    public function configureOptions(OptionsResolver $resolver):void{
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
    
}
