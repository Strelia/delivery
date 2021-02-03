<?php


namespace App\Admin\Filter;


use App\Form\Admin\ChoiceJSONBFilterType;
use Doctrine\ORM\Query\Expr\Orx;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Filter\FilterInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FilterDataDto;
use EasyCorp\Bundle\EasyAdminBundle\Filter\FilterTrait;

final class ChoiceJSONBFilter  implements FilterInterface
{
    use FilterTrait;

    public static function new(string $propertyName, $label = null): self
    {
        return (new self())
            ->setFilterFqcn(__CLASS__)
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(ChoiceJSONBFilterType::class)
            ->setFormTypeOption('translation_domain', 'EasyAdminBundle')
            ->setFormTypeOption('value_type_options.multiple', true)
            ;
    }

    public function setChoices(array $choices): self
    {
        $this->dto->setFormTypeOption('value_type_options.choices', $choices);

        return $this;
    }

    public function renderExpanded(bool $isExpanded = true): self
    {
        $this->dto->setFormTypeOption('value_type_options.expanded', $isExpanded);

        return $this;
    }

    public function apply(QueryBuilder $queryBuilder, FilterDataDto $filterDataDto, ?FieldDto $fieldDto, EntityDto $entityDto): void
    {
        $alias = $filterDataDto->getEntityAlias();
        $property = $filterDataDto->getProperty();
        $comparison = explode('-', $filterDataDto->getComparison())[0];
        $parameterName = $filterDataDto->getParameterName();
        $values = $filterDataDto->getValue();
        $isStrict = (bool)explode('-', $filterDataDto->getComparison())[1];

        if (0 !== count($values)) {
            foreach ($values as $key => $value) {
                $orX = new Orx();
                $orX->add(sprintf("JSONB_AG(%s.%s, :%s) = %s", $alias, $property, $parameterName.$key, $comparison));
                if($isStrict) {
                    $queryBuilder->andWhere($orX);
                } else {
                    $queryBuilder->orWhere($orX);
                }

                $queryBuilder->setParameter($parameterName.$key, json_encode([$value]));
            }
        }
    }
}