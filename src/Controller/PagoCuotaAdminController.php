<?php
namespace App\Controller;

//use App\Entity\DetalleVenta;
use App\Form\VentaAgregarProductoForm;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;

//use App\Entity\Producto;

class PagoCuotaAdminController extends CRUDController
{

    /**
     * Redirijo al detalle_venta, sino continuo.
     *
     */
    /*
    protected function redirectTo(Request $request, object $object): RedirectResponse
    {

        if (null !== $request->get('btn_create_and_edit')) {
            return new RedirectResponse($this->admin->generateUrl('detalle_venta', ['id' => $object->getId()]));
        }

        return parent::redirectTo($request, $object);
    }
    */

    public function finalizarAction($id): Response
    {

        //$this->getDoctrine()->getManager();

        //dd($this->admin->getProfile());

        $em =  $this->admin
                    ->getModelManager()
                    ->getEntityManager('App\Entity\PagoCuota');

        $pagocuota = $this->admin->getSubject();

        //dd($pagocuota);        
        $total = $pagocuota->getTotalPagoCuota();

        $pagocuota->setEstado(true);
        $pagocuota->setTotal($total);     

        foreach($pagocuota->getPagocuotaDetalles() as $pcd){
            //dump($pcd);
            $cuota = $pcd->getCuota();
            //dump($pcd->getCuota());          
            $cuota->setEstado('ABONADO');
            //$pcd->getCuota()->setEstado('ABONADO');
            //$cuota->setImporteAbonado('10.0');
            $cuota->setImporteAbonado($pcd->getImporte());
            //dump($pcd->getCuota());
            $em->persist($cuota);
        }
    
        //dd();

        $em->persist($pagocuota);

        $em->flush();
        
        //dd($pagocuota);
        //dd("fin");
        return new RedirectResponse($this->admin->generateUrl('edit', ['id' => $pagocuota->getId()]));
        //dd($venta);
        //return new Response('<html><body>Finalizado</body></html>');
    }

}