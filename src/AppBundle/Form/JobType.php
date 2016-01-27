<?php

namespace AppBundle\Form;

use AppBundle\Entity\JobType as JobTypeEntity;
use AppBundle\Entity\Job;
use AppBundle\Form\DataTransformer\TagsArrayDataTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class JobType
 */
class JobType extends AbstractType
{
    /** @var  TagsArrayDataTransformer */
    private $tagsDataTransformer;

    /**
     * @param TagsArrayDataTransformer $tagsDataTransformer
     */
    public function __construct(TagsArrayDataTransformer $tagsDataTransformer)
    {
        $this->tagsDataTransformer = $tagsDataTransformer;
    }


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
            ->add('attachment', AttachmentType::class)
            ->add('tags', TextType::class);

        $builder
            ->get('tags')
            ->addModelTransformer($this->tagsDataTransformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Job::class
        ]);
    }
}
