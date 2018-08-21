<?php

/**
 * @author: Emil Skrzypczyński <emilskrzypczynski09 at gmail.com>
 */

declare(strict_types=1);

namespace App\Form\Type;

use App\Form\DataTransformer\CompetitorsTransformer;
use App\Form\Model\BenchmarkRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BenchmarkType extends AbstractType
{
    /** @var CompetitorsTransformer */
    private $competitorsTransformer;


    public function __construct(CompetitorsTransformer $competitorsTransformer)
    {
        $this->competitorsTransformer = $competitorsTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('website', TextType::class)
            ->add('competitors', TextareaType::class)
            ->add('submit', SubmitType::class, [
                'label' => 'Check'
            ])
        ;

        $builder->get('competitors')
            ->addModelTransformer($this->competitorsTransformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BenchmarkRequest::class
        ]);
    }
}
