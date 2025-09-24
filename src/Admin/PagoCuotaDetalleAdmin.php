<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class PagoCuotaDetalleAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('pagocuota')
            ->add('cuota')
            ->add('importe')
            ->add('recargo')
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
        if ($this->isCurrentRoute('create')) {
        $form
            ->add('pagocuota')
            ->add('cuota')
        ;
        } else if ($this->isCurrentRoute('edit'))
        {
            $form
            ->add('pagocuota')
            ->add('cuota')
            ->add('importe')
            ->add('recargo')
        ;            
        }
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('pagocuota')
            ->add('cuota')
            ->add('importe')
            ->add('recargo')
        ;
    }

    public function prePersist($object): void
    {
        $saldo = $object->getCuota()->getSaldo();
        $object->setImporte($saldo);
        $object->setRecargo('0.00');
        //dd();
    }

}
