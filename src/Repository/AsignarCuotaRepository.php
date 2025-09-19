<?php

namespace App\Repository;

use App\Entity\AsignarCuota;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use App\Entity\Cuota;
/**
 * @extends ServiceEntityRepository<AsignarCuota>
 */
class AsignarCuotaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AsignarCuota::class);
    }

    public function asignarCuotas($socioIterator, $object): void
    {
        foreach($socioIterator as $socio)
        {
            $categoria = $socio->getCategoria();
            $importe = $categoria->getImporte();

            $cuota = new Cuota;
            $cuota->setSocio($socio); //
            //$cuota->setFecha($object->getFecha()); //
            //$cuota->setPeriodo($object->getPeriodo()); //
            $cuota->setAsignarcuota($object);
            $cuota->setEstado('PENDIENTE'); //
            $cuota->setImporte($importe); //
            $cuota->setImporteAbonado('0.00'); //
            $cuota->setSaldo('0.00');//
            $cuota->setFechaUpdate(new \DateTime('now'));//

            if ($cuota)
            {
                
                $persist = $this->getEntityManager(Cuota::class)
                                ->persist($cuota)               
                ;
            }
            
            //dump($cuota);
        }

        //$socios = $socioRepository;
        
        //dump($socios);

        //dump($object);

        //dump($this);

        //dd("asignar cuotas respository");
    }

    //    /**
    //     * @return AsignarCuota[] Returns an array of AsignarCuota objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?AsignarCuota
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
