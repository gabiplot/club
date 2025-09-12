<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Form\Type\ChoiceFieldMaskType;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;

final class SocioAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            //->add('id')
            ->add('particular',null, ['show_filter' => true, 'advanced_filter' => false])
            ->add('particular.dni',null,['show_filter' => true, 'advanced_filter' => false])
            ->add('estado',null,['advanced_filter' => false])    
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            //->add('id')
            ->add('particular', null,['label'=>'Apellido y Nombre', 'header_class' =>'col-md-2 text-center'])
            ->add('particular.dni', null,['label'=>'DNI', 'header_class' =>'col-md-2 text-center'])
            ->add('estado',null,['header_class' =>'col-md-2 text-center'])
            //->add('observacion')
            ->add('fecha_ingreso',null,['format' => 'd-m-Y', null,'header_class' =>'col-md-2 text-center'])
            //->add('fecha_egreso',null,['format' => 'd-m-Y'])
            //->add('fecha_update',null,['format' => 'd-m-Y', 'label'=>'Fecha Actualización'])
            //->add('user')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'header_class' =>'col-md-2 text-center',
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form): void
    {

        $nombre = "";
        $dni = "";
        $email = "";
        if ($this->isCurrentRoute('edit')) {
            $object = $this->getSubject();
            if($object->getParticular()){
                $nombre = $object->getParticular()->getNombre();
                $dni = $object->getParticular()->getDni();
                $email = $object->getParticular()->getEmail();
            }
        }    

$string = <<<TXT
Nombre: {$nombre} DNI: {$dni} EMAIL: {$email}
TXT;
        $form
            //->add('id')
            //FILTRAR PARTICULAR Y AGREGAR BOTON AGREGAR
            ->add('particular',ModelListType::class,['label'=>'Datos Particulares', 'help'=>$string])
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
            ->with('Datos Particulares', ['class'=>'col-md-6'])
            ->add('id',null,['label'=>'Nro de Socio','template' =>'Socio/base_show_field.html.twig'])
            ->add('estado',null,['label'=>'Activo','template' =>'Socio/show_boolean.html.twig'])
            ->add('particular', null,['label'=>'Apellido y Nombre','template' =>'Socio/base_show_field.html.twig'])
            ->add('particular.dni', null,['label'=>'DNI','template' =>'Socio/base_show_field.html.twig'])
            ->add('particular.email', null,['label'=>'E-Mail','template' =>'Socio/base_show_field.html.twig'])
            ->add('particular.direccion', null,['label'=>'E-Mail','template' =>'Socio/base_show_field.html.twig'])
            ->add('particular.telefono', null,['label'=>'E-Mail','label'=>'Teléfono','template' =>'Socio/base_show_field.html.twig'])
            ->add('particular.fecha_nacimiento', null, ['format'=>'d/m/Y', 'label'=>'Fecha Nacimiento', 'template' =>'Socio/show_date.html.twig'])
            ->end()
            ->with('Datos Socio', ['class'=>'col-md-6'])            
            ->add('fecha_ingreso',null,['format'=>'d/m/Y', 'template' =>'Socio/show_date.html.twig'])
            ->add('fecha_egreso',null, ['format'=>'d/m/Y', 'label'=>'Fecha Suspendido','template' =>'Socio/show_date.html.twig'])
            ->add('user',null,['template' =>'Socio/base_show_field.html.twig'])
            ->add('fecha_update',null, ['format'=>'d/m/Y', 'label'=>'Ultima Actualización', 'template' =>'Socio/show_date.html.twig'])
            ->end()
            ->with('Observaciones')
            ->add('observacion',null, ['row_attr'=>['c1'=>'col-md-1','c2'=>'col-md-11'],'template' =>'Socio/base_show_field.html.twig'])
            ->end()
        ;
    }
}
