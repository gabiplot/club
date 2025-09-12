<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class CuotaAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('fecha')
            ->add('importe')
            ->add('importe_abonado')
            ->add('estado')
            ->add('saldo')
            ->add('periodo')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('fecha')
            ->add('importe')
            ->add('importe_abonado')
            ->add('estado')
            ->add('saldo')
            ->add('periodo')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            //->add('id')
            ->add('socio')
            ->add('fecha')
            ->add('importe')
            ->add('importe_abonado')
            ->add('estado')
            ->add('saldo')
            ->add('periodo')
            ->add('user')
            ->add('fecha_update')
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            //->add('id')
            ->add('fecha')
            ->add('importe')
            ->add('importe_abonado')
            ->add('estado')
            ->add('saldo')
            ->add('periodo')
        ;
    }
}
