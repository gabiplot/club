<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class ParticularAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            //->add('id')
            ->add('apellido')
            ->add('nombre')
            ->add('dni')
            ->add('direccion')
            ->add('telefono')
            ->add('email')
            ->add('fecha_nacimiento')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            //->add('id')
            ->add('apellido')
            ->add('nombre')
            ->add('dni')
            ->add('direccion')
            ->add('telefono')
            ->add('email')
            ->add('fecha_nacimiento')
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
            ->add('apellido')
            ->add('nombre')
            ->add('dni')
            ->add('direccion')
            ->add('telefono')
            ->add('email')
            ->add('fecha_nacimiento',null,['widget'=>'single_text']);

        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            //->add('id')
            ->add('apellido')
            ->add('nombre')
            ->add('dni')
            ->add('direccion')
            ->add('telefono')
            ->add('email')
            ->add('fecha_nacimiento')
        ;
    }
}
