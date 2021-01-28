<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\Property;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            ->add('floor')
            ->add('price', MoneyType::class)
            ->add('heat', ChoiceType::class, [
                'choices' => $this->getChoices()
            ])
            // Dans le formulaire qui gère les biens on ajoute un nouveau champs
            ->add('options', EntityType::class, [
                'class' => Option::class, 
                'choice_label' => 'name',
                'multiple' => true
            ])
            ->add('city')
            ->add('address')
            ->add('postalCode')
            ->add('sold')
           // ->add('createdAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            'translation_domain' => 'forms'
        ]);
    }
    private function getChoices()
    {
        $choices = Property::HEAT;
        $output = [];

        foreach($choices as $k => $v){
            $output[$v] = $k;
        }
        return $output;
    }
}
