<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Sonata\AdminBundle\Validator\ErrorElement;

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
            ->add('id',null, ['header_class' =>'col-md-3 text-center'])
            ->add('fecha_pago', null,['format' => 'd-m-Y', 'header_class' =>'col-md-3 text-center'])
            ->add('socio',null, ['header_class' =>'col-md-3 text-center'])
            ->add(ListMapper::NAME_ACTIONS, null, [
                'header_class' =>'col-md-3 text-center',
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
                $form->add('socio',null,['required'=>true]);
            } 
        else if ($this->isCurrentRoute('edit'))
            {
                $form
                    ->add('fecha_pago',null,[
                        'widget'=>'single_text',                        
                        'required'=>true,
                        'disabled'=>true,
                    ]);
                $form->add('socio',null,['disabled'=>true]);
            }

            
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('fecha_pago')
            ->add('socio')
        ;
    }
    
}
