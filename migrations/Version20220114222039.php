<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220114222039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comics DROP INDEX IDX_2D56FB586995AC4C, ADD UNIQUE INDEX UNIQ_2D56FB586995AC4C (editor_id)');
        $this->addSql('ALTER TABLE comics DROP INDEX IDX_2D56FB58CFC54FAB, ADD UNIQUE INDEX UNIQ_2D56FB58CFC54FAB (designer_id)');
        $this->addSql('ALTER TABLE comics DROP INDEX IDX_2D56FB5826EF07C9, ADD UNIQUE INDEX UNIQ_2D56FB5826EF07C9 (licence_id)');
        $this->addSql('ALTER TABLE comics DROP INDEX IDX_2D56FB581BC7E6B6, ADD UNIQUE INDEX UNIQ_2D56FB581BC7E6B6 (writer_id)');
        $this->addSql('ALTER TABLE comics CHANGE licence_id licence_id INT NOT NULL, CHANGE editor_id editor_id INT NOT NULL, CHANGE writer_id writer_id INT NOT NULL, CHANGE designer_id designer_id INT NOT NULL');
        $this->addSql('ALTER TABLE image CHANGE comics_id comics_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comics DROP INDEX UNIQ_2D56FB58CFC54FAB, ADD INDEX IDX_2D56FB58CFC54FAB (designer_id)');
        $this->addSql('ALTER TABLE comics DROP INDEX UNIQ_2D56FB586995AC4C, ADD INDEX IDX_2D56FB586995AC4C (editor_id)');
        $this->addSql('ALTER TABLE comics DROP INDEX UNIQ_2D56FB5826EF07C9, ADD INDEX IDX_2D56FB5826EF07C9 (licence_id)');
        $this->addSql('ALTER TABLE comics DROP INDEX UNIQ_2D56FB581BC7E6B6, ADD INDEX IDX_2D56FB581BC7E6B6 (writer_id)');
        $this->addSql('ALTER TABLE comics CHANGE designer_id designer_id INT DEFAULT NULL, CHANGE editor_id editor_id INT DEFAULT NULL, CHANGE licence_id licence_id INT DEFAULT NULL, CHANGE writer_id writer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image CHANGE comics_id comics_id INT DEFAULT NULL');
    }
}
