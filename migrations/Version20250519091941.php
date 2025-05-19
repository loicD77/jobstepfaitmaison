<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250519091941 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE ressources (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(255) NOT NULL, presentation LONGTEXT DEFAULT NULL, support VARCHAR(255) NOT NULL, nature VARCHAR(255) NOT NULL, url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE etape CHANGE descriptif descriptif LONGTEXT NOT NULL, CHANGE consignes consignes LONGTEXT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE etape RENAME INDEX fk_etape_parcours TO IDX_285F75DD6E38C0DB
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_message_user ON message
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message DROP sender_id, CHANGE contenu contenu LONGTEXT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_parcours_user ON parcours
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE parcours CHANGE description description LONGTEXT NOT NULL, CHANGE candidate_id user_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_99B1DEE3A76ED395 ON parcours (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_rendu_user ON rendu
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_rendu_etape ON rendu
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_rendu_message ON rendu
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE rendu DROP user_id, DROP etape_id, DROP message_id
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_ressource_etape ON ressource
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ressource DROP etape_id, CHANGE presentation presentation LONGTEXT NOT NULL, CHANGE url url VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user RENAME INDEX email TO UNIQ_8D93D649E7927C74
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE ressources
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE etape DROP FOREIGN KEY FK_285F75DD6E38C0DB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE etape CHANGE descriptif descriptif TEXT NOT NULL, CHANGE consignes consignes TEXT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE etape RENAME INDEX idx_285f75dd6e38c0db TO fk_etape_parcours
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message ADD sender_id INT DEFAULT NULL, CHANGE contenu contenu TEXT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_message_user ON message (sender_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE parcours DROP FOREIGN KEY FK_99B1DEE3A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_99B1DEE3A76ED395 ON parcours
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE parcours CHANGE description description TEXT DEFAULT NULL, CHANGE user_id candidate_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_parcours_user ON parcours (candidate_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE rendu ADD user_id INT DEFAULT NULL, ADD etape_id INT DEFAULT NULL, ADD message_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_rendu_user ON rendu (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_rendu_etape ON rendu (etape_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_rendu_message ON rendu (message_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ressource ADD etape_id INT DEFAULT NULL, CHANGE presentation presentation TEXT DEFAULT NULL, CHANGE url url VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_ressource_etape ON ressource (etape_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` RENAME INDEX uniq_8d93d649e7927c74 TO email
        SQL);
    }
}
