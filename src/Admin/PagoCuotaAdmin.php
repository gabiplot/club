<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class PagoCuotaAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('fecha_pago')
            ->add('socio')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('fecha_pago')
            ->add('socio')
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
        if ($this->isCurrentRoute('create')) 
            {
                $form
                    ->add('fecha_pago',null,[
                        'widget'=>'single_text',
                        'data'=>(new \DateTime('now')),
                        'required'=>true,
                    ]);
            } 
        else if ($this->isCurrentRoute('edit'))
            {
                $form
                    ->add('fecha_pago',null,[
                        'widget'=>'single_text',                        
                        'required'=>true,
                    ]);
            }

            $form->add('socio');
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
        ;
    }
}
