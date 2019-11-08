<?php


namespace App\Form;



use App\Entity\Branch;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ManagerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('code', TextType::class, ['mapped' => false, ''])
            ->add('photo', FileType::class, ['label' => 'Фотография', 'mapped' => false])
            ->add('name', TextType::class, ['label' => 'Имя менеджера'])
            ->add('middleName', TextType::class, ['label' => 'Отчество менеджера'])
            ->add('surname',TextType::class, ['label' => 'Фамилия менеджера'])
            ->add('email', TextType::class,['label' => 'E-mail'])
            ->add('branch', EntityType::class, ['choice_label' => 'name', 'label'  => 'Отделы', 'class' => Branch::class])
            ->add('save', SubmitType::class,['label' => 'Сохранить']);
    }

}