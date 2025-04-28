<?php

namespace App\Repository;

use App\Entity\Projet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Projet>
 *
 * @method Projet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Projet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Projet[]    findAll()
 * @method Projet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjetRepository extends ServiceEntityRepository
{
    /**
     * Constructeur pour injecter le gestionnaire de registre Doctrine.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Projet::class);
    }

    /**
     * Récupérer les projets où l'utilisateur est invité.
     * Cette méthode suppose que vous avez une relation 'invitations' sur l'entité Projet.
     *
     * @param User $user L'utilisateur pour lequel on veut récupérer les projets invités
     * 
     * @return Projet[] Liste des projets où l'utilisateur est invité.
     */
    public function findProjetsOuUtilisateurEstInvite($user)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.invitations', 'i') // Jointure avec l'entité 'Invitation' (ou similaire)
            ->where('i.utilisateur = :user') // L'utilisateur est invité dans ce projet
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}
