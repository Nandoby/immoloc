<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceType extends AbstractType
{
    /**
     * Permet d'avoir la configuration de base d'un champ
     *
     * @param $label
     * @param $placeholder
     * @param array $options
     * @return array
     */
    private function getConfiguration($label, $placeholder, $options=[])
    {
        return array_merge_recursive([
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ], $options);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'attr' => [
                    'placeholder' => 'titre de votre annonce'
                ]
            ])
            ->add('slug', TextType::class, $this->getConfiguration('Slug', 'Adresse web (automatique)', [
                'required' => false
            ]))
            ->add('coverImage', UrlType::class, $this->getConfiguration("Url de l'image", "Donnez l'adresse de votre image"))
            ->add('introduction', TextType::class, $this->getConfiguration("Introduction", "Donnez une description globale de votre annonce"))
            ->add('content', TextType::class, $this->getConfiguration("Description détaillée", "Donnez une description de votre bien"))
            ->add('rooms', IntegerType::class, $this->getConfiguration("Nombre de chambre", "Donnez le nombre de chambres disponsibles"))
            ->add('price', MoneyType::class, $this->getConfiguration("Prix par nuit", "Indiquer le prix que vous voulez pour une nuit"))
            ->add('images', CollectionType::class, [
                'entry_type' => ImageType::class,
                'allow_add' => true, // permet d'ajouter des éléments et surtout avoir le data_prototype
                'allow_delete' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
