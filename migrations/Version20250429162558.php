<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250429162558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE activite DROP FOREIGN KEY FK_B8755515C18272
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE activite DROP FOREIGN KEY FK_B8755515FB88E14F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE activite ADD tache_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE activite ADD CONSTRAINT FK_B8755515D2235D39 FOREIGN KEY (tache_id) REFERENCES tache (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE activite ADD CONSTRAINT FK_B8755515C18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE activite ADD CONSTRAINT FK_B8755515FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_B8755515D2235D39 ON activite (tache_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE activite DROP FOREIGN KEY FK_B8755515D2235D39
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE activite DROP FOREIGN KEY FK_B8755515FB88E14F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE activite DROP FOREIGN KEY FK_B8755515C18272
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_B8755515D2235D39 ON activite
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE activite DROP tache_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE activite ADD CONSTRAINT FK_B8755515FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE activite ADD CONSTRAINT FK_B8755515C18272 FOREIGN KEY (projet_id) REFERENCES projet (id)
        SQL);
    }
}
