<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210701085757 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `group` (id VARCHAR(255) NOT NULL, owner_id VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_6DC044C57E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_photo (group_id VARCHAR(255) NOT NULL, photo_id VARCHAR(255) NOT NULL, INDEX IDX_449BAF7FFE54D947 (group_id), INDEX IDX_449BAF7F7E9E4C8C (photo_id), PRIMARY KEY(group_id, photo_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `group` ADD CONSTRAINT FK_6DC044C57E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE group_photo ADD CONSTRAINT FK_449BAF7FFE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE group_photo ADD CONSTRAINT FK_449BAF7F7E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418A76ED395');
        $this->addSql('DROP INDEX IDX_14B78418A76ED395 ON photo');
        $this->addSql('ALTER TABLE photo CHANGE user_id owner_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784187E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_14B784187E3C61F9 ON photo (owner_id)');
        $this->addSql('ALTER TABLE `group` ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE group_photo DROP FOREIGN KEY FK_449BAF7FFE54D947');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE group_photo');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784187E3C61F9');
        $this->addSql('DROP INDEX IDX_14B784187E3C61F9 ON photo');
        $this->addSql('ALTER TABLE photo CHANGE owner_id user_id VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_14B78418A76ED395 ON photo (user_id)');
        $this->addSql('ALTER TABLE `group` DROP created_at, DROP updated_at');
    }
}
