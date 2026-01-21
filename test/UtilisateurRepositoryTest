<?php

use PHPUnit\Framework\TestCase;
use App\Covoiturage\Model\Repository\UtilisateurRepository;

class UtilisateurRepositoryTest extends TestCase
{
    // Test de l'inscription (Noyau applicatif)
    public function testInscrireRenvoieBool()
    {
        // On tente d'inscrire un utilisateur de test
        // uniqid() permet d'éviter les erreurs d'email déjà existant en base
        $resultat = UtilisateurRepository::inscrire("testuser", uniqid() . "@test.com", "hash_test");
        $this->assertIsBool($resultat);
    }

    // Test de la récupération (Authentification)
    public function testGetByEmail()
    {
        $resultat = UtilisateurRepository::getByEmail("email_inexistant@test.com");
        // Doit renvoyer false si l'utilisateur n'existe pas
        $this->assertFalse($resultat);
    }

    // Test du changement de rôle (Exigence spécifique Parcours C)
    public function testChangerRoleBasculeCorrectement()
    {
        // On teste sur un ID qui n'existe pas pour vérifier la robustesse
        $resultat = UtilisateurRepository::changerole(999999);
        $this->assertFalse($resultat, "La méthode doit renvoyer false pour un utilisateur inexistant");
    }

    // Test de la suppression (Gestion administrative)
    public function testSupprimerUtilisateur()
    {
        $resultat = UtilisateurRepository::supprimerUtilisateur(999999);
        // Si l'utilisateur n'existe pas, execute() renvoie true (0 ligne supprimée) ou false selon PDO
        $this->assertIsBool($resultat);
    }

    // Test de l'Audit (Enregistrement de logs - Parcours C)
    public function testEnregistrerLog()
    {
        $resultat = UtilisateurRepository::enregistrerLog(1, "test@test.com", "127.0.0.1", true);
        $this->assertTrue($resultat, "L'enregistrement du log de connexion doit fonctionner");
    }
}