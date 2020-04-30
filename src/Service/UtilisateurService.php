<?php

namespace App\Service;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UtilisateurService
{
    protected $em;
    protected $repository;
    protected $passwordEncoder;

    /**
     * UtilisateurService constructor.
     *
     * @param EntityManagerInterface $em by dependency injection
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(Utilisateur::class);
        $this->passwordEncoder = $passwordEncoder;
    }


    /**
     * Set a password encoded to a user
     *
     * @param Utilisateur $Utilisateur
     * @return Utilisateur
     */
    protected function encodePassword(Utilisateur $Utilisateur)
    {
        $plainPassword = $Utilisateur->getPlainPassword();

        if (!empty($plainPassword)) {
            $Utilisateur->setPassword($this->passwordEncoder->encodePassword(
                $Utilisateur,
                $plainPassword
            ));
        }

        return $Utilisateur;
    }


    /**
     * Delete a user object in bdd
     *
     * @param Utilisateur $Utilisateur
     */
    public function delete(Utilisateur $Utilisateur)
    {
        $this->em->remove($Utilisateur);
        $this->em->flush();
    }


    /**
     * Save a user object in bdd
     *
     * @param Utilisateur $Utilisateur
     */
    public function save(Utilisateur $Utilisateur)
    {
        $Utilisateur = $this->encodePassword($Utilisateur);
        $this->em->persist($Utilisateur);
        $this->em->flush();
    }
}
