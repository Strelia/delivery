<?php

namespace App\Controller\Admin;

use App\Admin\Filter\ChoiceJSONBFilter;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\EA;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;


class UserCrudController extends AbstractCrudController
{
    protected array $status;

    /**
     * UserCrudController constructor.
     */
    public function __construct()
    {
        $this->status = array_combine(User::STATUS_CHOICE, User::STATUS_CHOICE);
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto,
                                            FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        return parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters)
            ->andWhere('JSONB_AG(entity.roles, :role) = TRUE')
            ->setParameter('role', json_encode([User::ROLE_USER]))
            ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('User')
            ->setEntityLabelInPlural('Users')
            ->setSearchFields(['id', 'name', 'surname', 'username', 'email', 'price', 'name', 'phone']);
    }


    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('username');
        yield TextField::new('plainPassword', 'Password')->hideOnIndex();
        yield EmailField::new('email');
        yield TextField::new('name');
        yield TextField::new('surname');
        yield TelephoneField::new('phone');
        yield ChoiceField::new('status') ->setChoices($this->status);
        yield ChoiceField::new('roles')->hideOnIndex()
            ->allowMultipleChoices(true)->setChoices([User::ROLE_USER => User::ROLE_USER]);
        yield AssociationField::new('company');
    }

    public function configureFilters(Filters $filters): Filters
    {
        $filters
            ->add(
                ChoiceJSONBFilter::new('roles')
                    ->setChoices(array_combine(User::ROLE_CHOICE, User::ROLE_CHOICE))
            )
            ->add(
                ChoiceFilter::new('status')
                    ->setChoices($this->status)
            )
            ->add(EntityFilter::new('company'));
        return parent::configureFilters($filters);
    }


    public function delete(AdminContext $context): KeyValueStore|RedirectResponse|Response
    {
        $entityInstance = $context->getEntity()->getInstance()->setStatus(User::STATUS_DELETE);
        $this->updateEntity(
            $this->get('doctrine')->getManagerForClass($context->getEntity()->getFqcn()), $entityInstance
        );
        return $this->redirect($this->get(AdminUrlGenerator::class)->setAction(Action::INDEX)->unset(EA::ENTITY_ID)->generateUrl());
    }
}
