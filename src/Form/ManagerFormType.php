<?php


namespace App\Form;



use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ManagerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Имя менеджера'])
            ->add('surname',TextType::class, ['label' => 'Фамилия менеджера'])
            ->add('branch');
    }

}