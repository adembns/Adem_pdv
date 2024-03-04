<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240303103151 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article1_user1 DROP FOREIGN KEY FK_B727C9F12FA7667A');
        $this->addSql('ALTER TABLE article1_user1 DROP FOREIGN KEY FK_B727C9F156AE248B');
        $this->addSql('DROP TABLE article1_user1');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article1_user1 (article1_id INT NOT NULL, user1_id INT NOT NULL, INDEX IDX_B727C9F12FA7667A (article1_id), INDEX IDX_B727C9F156AE248B (user1_id), PRIMARY KEY(article1_id, user1_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE article1_user1 ADD CONSTRAINT FK_B727C9F12FA7667A FOREIGN KEY (article1_id) REFERENCES article1 (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article1_user1 ADD CONSTRAINT FK_B727C9F156AE248B FOREIGN KEY (user1_id) REFERENCES user1 (id) ON DELETE CASCADE');
    }
}
