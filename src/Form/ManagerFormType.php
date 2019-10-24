<?php


namespace App\Form;



use App\Entity\Branch;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ManagerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', TextType::class, ['label' => 'Имя менеджера'])
            ->add('surname',TextType::class, ['label' => 'Фамилия менеджера'])
            ->add('branch', EntityType::class, ['choice_label' => 'name', 'label'  => 'Отделы', 'class' => Branch::class])
            ->add('save', SubmitType::class,['label' => 'Сохранить']);
    }

}