<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240303233025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user1_article1 (user1_id INT NOT NULL, article1_id INT NOT NULL, INDEX IDX_C601ED9356AE248B (user1_id), INDEX IDX_C601ED932FA7667A (article1_id), PRIMARY KEY(user1_id, article1_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user1_article1 ADD CONSTRAINT FK_C601ED9356AE248B FOREIGN KEY (user1_id) REFERENCES user1 (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user1_article1 ADD CONSTRAINT FK_C601ED932FA7667A FOREIGN KEY (article1_id) REFERENCES article1 (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user1_article1 DROP FOREIGN KEY FK_C601ED9356AE248B');
        $this->addSql('ALTER TABLE user1_article1 DROP FOREIGN KEY FK_C601ED932FA7667A');
        $this->addSql('DROP TABLE user1_article1');
    }
}
