<?php

namespace App\Form;

use App\Entity\Classroom;
use App\Entity\Club;
use App\Entity\Student;
use Doctrine\DBAL\Types\FloatType;
use Doctrine\DBAL\Types\SmallIntType;
use IntlChar;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatableMessage;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nsc', TextType::class)
        ->add('email', TextType::class)
        ->add('moyenne', NumberType::class)
        ->add('classroom', EntityType::class, [
            'class' => Classroom::class,
            'choice_label' => 'name',
        ])
        ->add('club')
        ->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }

}

?>