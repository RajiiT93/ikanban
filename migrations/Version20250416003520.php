<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250416003520 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateur_groupe DROP FOREIGN KEY FK_6514B6AA7A45358C
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_6514b6aa7a45358c ON utilisateur_groupe
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6514B6AA7A45358C ON utilisateur_groupe (groupe_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateur_groupe ADD CONSTRAINT FK_6514B6AA7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateur_groupe DROP FOREIGN KEY FK_6514B6AA7A45358C
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_6514b6aa7a45358c ON utilisateur_groupe
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX FK_6514B6AA7A45358C ON utilisateur_groupe (groupe_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateur_groupe ADD CONSTRAINT FK_6514B6AA7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE
        SQL);
    }
}
