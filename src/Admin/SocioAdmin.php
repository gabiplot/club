<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\Type\ChoiceFieldMaskType;

final class SocioAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('estado')
            ->add('observacion')
            ->add('fecha_ingreso')
            ->add('fecha_egreso')
            ->add('fecha_update',null,['format' => 'd-m-Y','label'=>'Fecha Actualización'])
            ->add('user')            
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('estado')
            ->add('observacion')
            ->add('fecha_ingreso',null,['format' => 'd-m-Y'])
            ->add('fecha_egreso',null,['format' => 'd-m-Y'])
            ->add('fecha_update',null,['format' => 'd-m-Y', 'label'=>'Fecha Actualización'])
            ->add('user')
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
            ->add('estado', ChoiceFieldMaskType::class, [
                'choices' => [
                    'ACTIVO' => true,
                    'SUSPENDIDO' => false,                    
                ],
                'map' => [
                    false => ['fecha_ingreso', 'fecha_egreso'],
                    true => ['fecha_ingreso'],
                ],
                'placeholder' => 'Choose an option',
                'required' => true
            ])
            ->add('observacion')
            ->add('fecha_ingreso',null,['widget'=>'single_text'])
            ->add('fecha_egreso',null,['widget'=>'single_text'])
            ->add('user')
            ->add('fecha_update',null,['widget'=>'single_text','label'=>'Fecha Actualización'])       
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('estado')
            ->add('observacion')
            ->add('fecha_ingreso')
            ->add('fecha_egreso')
            ->add('user')
            ->add('fecha_update',null,['label'=>'Fecha Actualización'])
        ;
    }
}
