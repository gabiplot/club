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
        ->tab('Cuota')
        ->with('Cuota',['class'=>'col-md-4'])
        ->add('socio')
        ;

        if ($this->isCurrentRoute('edit')) 
        {
            $form
            ->add('fecha',null,[
                'widget'=>'single_text',
                'required'=>true,
            ]);
        } 
        else if ($this->isCurrentRoute('create'))
        {
            $form
            ->add('fecha',null,[
                'widget'=>'single_text',
                'data'=>(new \DateTime('now')),
                'required'=>true,
            ]);
        }

        $form   
            ->add('periodo')            
            ->end()
            ->with('Estado',['class'=>'col-md-4'])        
            ->add('estado')           
            ->end()//estado
            ->with('Saldo',['class'=>'col-md-4'])        
            ->add('importe',null,['label'=>'Importe Cuota'])
            ->add('importe_abonado')             
            ->add('saldo')            
            ->end()//saldo
            ->end()
            ->tab('Usuario')
            ->with('Usuario')
            ->add('user')
            ->add('fecha_update',null,[
                'data'=>(new \DateTime('now')),
                'widget'=>'single_text',
                'required'=>true,
               ])
            ->end()
            ->end()
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
