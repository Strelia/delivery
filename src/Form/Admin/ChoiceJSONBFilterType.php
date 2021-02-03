<?php


namespace App\Form\Admin;


use EasyCorp\Bundle\EasyAdminBundle\Form\Filter\Type\ChoiceFilterType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

class ChoiceJSONBFilterType extends ChoiceFilterType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder->add('strict_comparison', CheckboxType::class, [
            'label'    => 'Strict comparison?',
            'required' => false,
        ]);

        $builder->addModelTransformer(new CallbackTransformer(
            static function ($data) { return $data; },
            static function ($data) {
                dump($data);
                switch (strtolower($data['comparison'])) {
                    case 'in':
                        $data['comparison'] = 'TRUE';
                        break;
                    default:
                        $data['comparison'] = 'FALSE';
                        break;
                }

                $data['comparison'] .= '-' . $data['strict_comparison'];

                return $data;
            }
        ));
    }
}