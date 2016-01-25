<?php

namespace AppBundle\Form;

use AppBundle\Entity\JobType as JobTypeEntity;
use AppBundle\Entity\Job;
use AppBundle\Form\DataTransformer\TagsArrayDataTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class JobType
 */
class JobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('employer')
            ->add('description', TextareaType::class)
            ->add('type', EntityType::class, [
                'class' => JobTypeEntity::class,
                'choice_label' => 'name'
            ])
            ->add('attachment', FileType::class)
            ->add('attachmentName')
            ->add('tags');

        $builder
            ->get('tags')
            ->addModelTransformer(new TagsArrayDataTransformer());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Job::class
        ]);
    }
}
