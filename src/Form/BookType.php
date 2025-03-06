<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Editor;
use App\Enum\BookStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label'=>'Titre:'
            ])
            ->add('isbn', TextType::class, [
                'label'=> 'Isbn'
            ])
            ->add('cover', UrlType::class, [
                'label'=>'Couverture:'
            ])
            ->add('editedAt', DateTimeType::class, [
                'label'=>'Publié le:',
                'widget' => 'single_text',
            ])
            ->add('plot', TextType::class, [
                'label'=>'Plot'
            ])
            ->add('pageNumber', NumberType::class, [
                'label'=>'Nombre de pages:'
            ])
             ->add('status', EnumType::class,[
                'class'=> BookStatus::class,
             ]
            )
            ->add('authors', EntityType::class, [
                'label'=> 'Auteur(s)',
                'class' => Author::class,
                'choice_label' => 'name',
                'multiple' => true,
            ])
            ->add('editor', EntityType::class, [
                'class' => Editor::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
