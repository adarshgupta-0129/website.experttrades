<?php

namespace AppBundle\Repository\Visit;

use Doctrine\ORM\EntityRepository;

/**
 * SiteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VisitRepository extends EntityRepository{

  public function getChart(){

       $dateOffset = new \DateTime();
       $dateOffset->modify('-1 month');
       $dateOffset->modify('midnight');
       $dateOffset->modify('+1 day');

       $data = $this->getEntityManager()->createQueryBuilder();
       $data->select('v')->from('AppBundle\Entity\Visit\Visit', 'v');
       $data->where('v.created >= :dateOffset');
       $data->setParameters(['dateOffset' => $dateOffset->format('Y-m-d H:i:s')]);

       $countPeriod = $this->getEntityManager()->createQueryBuilder();
       $countPeriod->select('count(v)')->from('AppBundle\Entity\Visit\Visit', 'v');
       $countPeriod->where('v.created >= :dateOffset');
       $countPeriod->setParameters(['dateOffset' => $dateOffset->format('Y-m-d H:i:s')]);

       $tpvs = $data->getQuery()->getArrayResult();
       $totalPeriod = $countPeriod->getQuery()->getSingleScalarResult();

       $datetimeNextDay = new \DateTime();
       $datetimeNextDay->modify('-1 month');
       $datetimeNextDay->modify('midnight');

       $now = new \DateTime();
       $now->modify('midnight');

       $nowNotMidnight = new \DateTime();

       $nowMinusOneDay = new \DateTime();
       $nowMinusOneDay->modify('midnight');
       $nowMinusOneDay->modify('-1 day');

       $chart = array();

       /* Today */
       if(!isset($chart[$now->format('Y-m-d')])){
         $chart[$now->format('Y-m-d')] = 0;
       }

       foreach($tpvs as $created){
           if($created['created']->format('Y-m-d H:i') >= $now->format('Y-m-d H:i') && $created['created']->format('Y-m-d H:i') <= $nowNotMidnight->format('Y-m-d H:i')){
               $chart[$now->format('Y-m-d')] = $chart[$now->format('Y-m-d')] + 1;
           }
       }

       for ($i = 28; $i > 2; $i--) {

         if(!isset($chart[$nowMinusOneDay->format('Y-m-d')])){
            $chart[$nowMinusOneDay->format('Y-m-d')] = 0;
         }

         foreach($tpvs as $created){

           if($created['created'] >= $nowMinusOneDay && $created['created'] <= $now){

             $chart[$nowMinusOneDay->format('Y-m-d')] = $chart[$nowMinusOneDay->format('Y-m-d')] + 1;
           }
         }

         $now = $now->modify('-1 day');
         $nowMinusOneDay = $nowMinusOneDay->modify('-1 day');

       }

       return array('total_period' => $totalPeriod, 'data' => array_reverse($chart));

     }
}
