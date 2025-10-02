<?php

declare(strict_types=1);

namespace App\Admin;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\Type\ModelHiddenType;

final class PagoCuotaDetalleAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        if ($this->ischild())
        {

        } 
        else 
        {
            $list
            ->add('pagocuota');
        }

       $list->add('cuota')
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

        //dump($this->getSubject());
        //dd();
        $pago_cuota = null;
        $socio = null;

        if($this->ischild()){
            $id = $this->getRequest()->get('id');
            $pago_cuota = $this->getSubject()->getPagoCuota();
            $socio = $this->getSubject()->getPagoCuota()->getSocio();
            $form
                ->add('pagocuota', ModelHiddenType::class,['attr'=>['value'=>$id]])
                ;
        } else {
            $form
                ->add('pagocuota',null)
                ;
        }
    
        
        if ($this->isCurrentRoute('create')) {
        $form
            //->add('pagocuota')
            ->add('cuota',null, [
                'query_builder' => function (EntityRepository $er) use ($socio) {
                    return $er->createQueryBuilder('c')
                              ->andWhere("c.socio = :socio")          
                              ->andWhere("c.estado = 'PENDIENTE'")   
                              //->andWhere('c.id NOT IN (
                              //  SELECT IDENTITY(pcd.cuota) 
                              //  FROM App\Entity\PagoCuotaDetalle pcd
                              //)')                                         
                              ->setParameter('socio', $socio->getId())
                        ;
                        //->orderBy('c.name', 'ASC');
                },
            ])
        ;
        } else if ($this->isCurrentRoute('edit'))
        {
            $form
            //->add('pagocuota')
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
        //guardar con el valor por defecto
        
        $cuota = $object->getCuota();        
        $saldo = $cuota->getSaldo();
        $object->setImporte('0.00');
        $object->setRecargo('0.00');
    }

    public function preUpdate($object): void
    {    
        $cuota = $object->getCuota();

        $iam = $cuota->getImporteAbonadoMagico();
        $esm = $cuota->getEstadoMagico();
        $sam = $cuota->getSaldoMagico();

        //$cuota->setImporteAbonadoTmp($iam);
        //$cuota->setEstadoTmp($esm);        
        //$cuota->setSaldoTmp($sam);
        $cuota->setImporteAbonado($iam);
        $cuota->setEstado($esm);        
        $cuota->setSaldo($sam);        

        $object->setCuota($cuota);
        //$object->setEstado(true);
    }

    public function postRemove($object): void
    {    
        $this->actualizarCuota($object);
    }

    public function actualizarCuota($object){
        
        $cuota = $object->getCuota();

        $iam = $cuota->getImporteAbonadoMagico();
        $esm = $cuota->getEstadoMagico();
        $sam = $cuota->getSaldoMagico();

        //$cuota->setImporteAbonadoTmp($iam);
        $cuota->setImporteAbonado($iam);
        //$cuota->setEstadoTmp($esm);
        $cuota->setEstado($esm);
        //$cuota->setSaldoTmp($sam);
        $cuota->setSaldo($sam);

        $em = $this->getModelManager()
                   ->getEntityManager($this->getClass());
        
        $em->persist($cuota);

        $em->flush();
    }
}
