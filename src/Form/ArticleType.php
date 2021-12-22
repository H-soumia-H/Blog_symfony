<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class, [
                'label' => 'Titre',
                'required' => true,
                'attr' => ['placeholder' => 'Entrez un titre']
            ])
            ->add('subtitle',TextType::class, [
                'label' => 'Soustitre',
                'required' => true,
                'attr' => ['placeholder' => 'Entrez un soustitre'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut etre vide'
                    ]),
                    new Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => 'Le sous titre doit comporter {{ limit }} caractères au minimum.'
                    ])
                ]
            ])
            ->add('description',TextareaType::class, [
                'label' => 'Description',
                'required' => true,
                'attr' => ['placeholder' => 'Entrez unse description']
            ])
            ->add('category', EntityType::class,[
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Choisissez la catégorie de l\'article'
            ])
            ->add('picture',FileType::class, [
                'label' => 'Photo',
                'required' => true,
                'attr' => ['placeholder' => 'Entrez une illustration'],
                'constraints' => [
                    new Image([
                        'mimeTypes' => ['image/jpeg', 'image/png'],
                        'mimeTypesMessage' => 'Les type de fichiers autorisés sont : .jpeg /.png'
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter',
                'attr' => ['class' => 'btn btn-warning d-block mx-auto my-3 col-4']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            /**
             * On rajoute 'allow_file_upload' (une cléf d'un paire dans un array) qui est un parametre symfony, 
             * qu'on définit à true
             * Cela permet d'autoriser notre formulaire à importer des fichiers.
             */
           'allow_file_upload' => true,
//            'picture' => null,
        ]);
    }
}
