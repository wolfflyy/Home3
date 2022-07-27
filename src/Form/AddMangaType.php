<?php

namespace App\Form;

use App\Entity\Artist;
use App\Entity\Genre;
use App\Entity\Manga;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddMangaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
//            ->add('artist', EntityType::class,array('class'=>'App\Entity\Artist','choice_label'=>"artist_name"))
//            ->add('genre', EntityType::class,array('class'=>'App\Entity\Genre','choice_label'=>"genre_name"))
//            ->add('artist', TextType::class)
//            ->add('genre', TextType::class)
//            ->add('artist', EntityType::class, [
//                'class'=>Artist::class,
//                'choice_label'=>'artist_name',
//                'mapped'=>false,
//            ])
//            ->add('genre', EntityType::class, [
//                'class'=>Genre::class,
//                'choice_label'=>'genre_name',
//                'mapped'=>false,
//            ])

            ->add('artist',EntityType::class,array('class'=>'App\Entity\Artist','choice_label'=>'artist_name'))
            ->add('genre',EntityType::class,array('class'=>'App\Entity\Genre','choice_label'=>'genre_name'))
            ->add('description', TextareaType::class)
            ->add('price', TextType::class)
            ->add('create_date', DateType::class,['widget' => 'single_text'])
            ->add('image', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
//                    new File([
//                        'maxSize' => '1024k',
////                        'mimeTypes' => [
////                            '/public/uploads/manga_image/jpg',
////                            '/public/uploads/manga_image/x-jpg',
////                        ],
//                        'mimesTypesMessage' => 'Please upload a valid image',
//                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => Manga::class,
        ]);
    }
}
