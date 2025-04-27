<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250427212653 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE projet ADD statut VARCHAR(100) DEFAULT NULL, ADD deadline DATETIME DEFAULT NULL, DROP titre, DROP date_debut, DROP date_fin, DROP date_creation
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tache CHANGE projet_id projet_id INT NOT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE deadline deadline DATETIME DEFAULT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE projet ADD titre VARCHAR(255) NOT NULL, ADD date_debut DATE DEFAULT NULL, ADD date_fin DATE DEFAULT NULL, ADD date_creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, DROP statut, DROP deadline
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tache CHANGE projet_id projet_id INT DEFAULT NULL, CHANGE description description LONGTEXT NOT NULL, CHANGE deadline deadline DATETIME NOT NULL
        SQL);
    }
}
