<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230419124151 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14F920BBA2');
        $this->addSql('DROP INDEX IDX_CFBDFA14F920BBA2 ON note');
        $this->addSql('ALTER TABLE note ADD note DOUBLE PRECISION NOT NULL, CHANGE value_id matter_id INT NOT NULL');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14D614E59F FOREIGN KEY (matter_id) REFERENCES matter (id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA14D614E59F ON note (matter_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14D614E59F');
        $this->addSql('DROP INDEX IDX_CFBDFA14D614E59F ON note');
        $this->addSql('ALTER TABLE note DROP note, CHANGE matter_id value_id INT NOT NULL');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14F920BBA2 FOREIGN KEY (value_id) REFERENCES matter (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_CFBDFA14F920BBA2 ON note (value_id)');
    }
}
