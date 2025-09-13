<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Sonata\Form\Validator\ErrorElement;

final class AsignarCuotaAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            //->add('id')
            ->add('fecha')
            ->add('periodo')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            //->add('id')
            ->add('fecha',null,['format' => 'd-m-Y','header_class' =>'col-md-2 text-center'])
            ->add('periodo',null,['header_class' =>'col-md-2 text-center'])
            ->add(ListMapper::NAME_ACTIONS, null, [
                'header_class' =>'col-md-8 text-center',
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $meses = [
            '01' => 'ENERO',
            '02' => 'FEBRERO',
            '03' => 'MARZO',
            '04' => 'ABRIL',
            '05' => 'MAYO',
            '06' => 'JUNIO',
            '07' => 'JULIO',
            '08' => 'AGOSTO',
            '09' => 'SEPTIEMBRE',
            '10' => 'OCTUBRE',
            '11' => 'NOVIEMBRE',
            '12' => 'DICIEMBRE'
        ];
        

        $form
            //->add('id')
            ->with('AsignarCuota Fecha',['class'=>'col-md-6'])            
        ;

        if ($this->isCurrentRoute('edit')) 
        {
            $form
            ->add('fecha',null,[
                'widget'=>'single_text',
                'required'=>true,
            ]);

            $form->end()
            ->with('AsignarCuota Periodo',['class'=>'col-md-6'])
            ->add('periodo',null,['required'=>false])
            ;            
        } 
        else if ($this->isCurrentRoute('create'))
        {
            $hoy = (new \DateTime('now'));
            $mes = $meses[$hoy->format('m')];
            $anio = $hoy->format('Y');

            $form
            ->add('fecha',null,[
                'widget'=>'single_text',
                'data'=>(new \DateTime('first day of this month'))->modify('+9 day'),
                'required'=>true,
            ]);

            $form->end()
            ->with('AsignarCuota Periodo',['class'=>'col-md-6'])
            ->add('periodo',null,['data'=>$mes . " " . $anio, 'required'=>false])
            ;            
        }


    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            //->add('id')
            ->add('fecha')
            ->add('periodo')
        ;
    }

    //FUNCIONES PARTICULARES
    //QUITAR BATCH DELETE
	public function configureBatchActions($actions): array
	{
    	if (isset($actions['delete'])) {
        	unset($actions['delete']);
    	}

    	return $actions;
	}
 
    public function preUpdate(Object $object): void
    {        
        $this->asignarCuotas($object);
        dd($object);
    }

    public function prePersist(Object $object): void
    {
        $this->asignarCuotas($object);
        dd($object);
    }

	public function asignarCuotas(Object $object): void
	{ 	 
    	$ea = $this->getModelManager()
               	->getEntityManager($this->getClass())
               	->getRepository($this->getClass())
               	->asignarCuotas($object)
                ;
    	//return $ea;
	}


}
