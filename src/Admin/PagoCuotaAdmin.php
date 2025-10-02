<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Admin\AdminInterface;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

final class PagoCuotaAdmin extends AbstractAdmin
{



    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('fecha_pago')
            ->add('socio')
            ->add('estado')
            ->add('pagoCuotaDetalles.cuota.asignarcuota',null,['label'=>'Asignado En'])
            ->add('pagoCuotaDetalles.cuota.asignarcuota.periodo',null,['label'=>'Periodo'])            
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        dump($this);
        $list
            //->add('id',null, ['header_class' =>'col-md-2 text-center'])
            ->add('fecha_pago', null,['format' => 'd-m-Y', 'header_class' =>'col-md-2 text-center'])
            ->add('socio',null, ['header_class' =>'col-md-2 text-center'])
            ->add('TotalPagoCuota', null, ['label'=>'Total Abonado'])
            ->add('cuotas')

            //->add('total')
            //->add('estado',null, ['label'=>'Finalizado','header_class' =>'col-md-2 text-center'])
            ->add(ListMapper::NAME_ACTIONS, null, [
                'header_class' =>'col-md-4 text-center',
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
                $form->add('total',null,['data'=>'0.00', 'required'=>true]);
                $form->add('estado',null, ['data'=>false, 'label'=>'Finalizado']);
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
                $form->add('total',null,['disabled'=>true]);
                $form->add('estado',null, ['label'=>'Finalizado','disabled'=>true]);
            }
            
            
            
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('fecha_pago')
            ->add('socio')
            ->add('estado',null, ['label'=>'Finalizado']);
        ;
    }


    /*
    * MIS FUNCIONES
    **/
    //RUTA POR DEFECTO PARA USAR EN EL CONTROLLER
    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->add('finalizar', $this->getRouterIdParameter().'/finalizar');
    }


    protected function configureTabMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null) :void
    {

        if (!$childAdmin && !in_array($action, ['edit', 'show'])) {
            return;
        }

        $admin = $this->isChild() ? $this->getParent() : $this;
        
        $id = $admin->getRequest()->get('id');

        $menu->addChild('Listado', $admin->generateMenuUrl('show', ['id' => $id]));

        
        if ($this->isGranted('EDIT')) {
            $menu->addChild('Editar', $admin->generateMenuUrl('edit', ['id' => $id]));
        }

        if ($this->isGranted('LIST')) {
            //if ($this->getSubject()->getEstado()){
                $menu->addChild('Detalle', $admin->generateMenuUrl('admin.pago_cuota_detalle.list', ['id' => $id]));
            //}        
        }
        
    }


    
}
