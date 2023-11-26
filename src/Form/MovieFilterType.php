<?php

namespace App\Form;

use App\Model\MovieFilter;
use App\Service\GenreRetrieval;
use App\Service\ListRetrieval;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class MovieFilterType extends AbstractType
{
    private GenreRetrieval $genreRetrieval;
    private ListRetrieval $listRetrieval;

    public function __construct(
        GenreRetrieval $genreRetrieval,
        ListRetrieval $listRetrieval,
    ) {
        $this->genreRetrieval = $genreRetrieval;
        $this->listRetrieval = $listRetrieval;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('genre', ChoiceType::class, [
                'label' => 'Genre',
                'choices' => $this->genreRetrieval->findAll(),
                'choice_label' => function ($choice, $key, $value) {
                    if (null !== $value) {
                        return $value;
                    }
                },
                'placeholder' => 'Tous',
                'required' => false,
            ])
            ->add('list', ChoiceType::class, [
                'label' => 'Liste',
                'choices' => $this->listRetrieval->findAll(),
                'choice_label' => function ($choice, $key, $value) {
                    if (null !== $value) {
                        return \ucfirst(\str_replace('_', ' ', $value));
                    }
                },
                'placeholder' => 'Toutes',
                'required' => false,
            ])
            ->add('year', ChoiceType::class, [
                'label' => 'Année',
                'choices' => [2019, 2020, 2021, 2022, 2023],
                'choice_label' => function ($choice, $key, $value) {
                    return $value;
                },
                'placeholder' => 'Toutes',
                'required' => false,
            ])
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'attr' => ['placeholder' => 'Entrez le titre du film'],
                'required' => false,
            ])
            ->add('keyword', TextType::class, [
                'label' => 'Mots-clé',
                'attr' => ['placeholder' => 'Entrez les mots-clé'],
                'required' => false,
            ])
            ->add('page', ChoiceType::class, [
                'label' => 'Page',
                'choices' => [1, 2, 3, 4, 5],
                'choice_label' => function ($choice, $key, $value) {
                    return $value;
                },
                 'required' => true,
            ])
            ->add('filter', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MovieFilter::class,
        ]);
    }
}
