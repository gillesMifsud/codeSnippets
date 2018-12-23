<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181223103135 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE snippet (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE snippet_language (snippet_id INT NOT NULL, language_id INT NOT NULL, INDEX IDX_CB5EA3D26E34B975 (snippet_id), INDEX IDX_CB5EA3D282F1BAF4 (language_id), PRIMARY KEY(snippet_id, language_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE snippet_language ADD CONSTRAINT FK_CB5EA3D26E34B975 FOREIGN KEY (snippet_id) REFERENCES snippet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE snippet_language ADD CONSTRAINT FK_CB5EA3D282F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE snippet_language DROP FOREIGN KEY FK_CB5EA3D282F1BAF4');
        $this->addSql('ALTER TABLE snippet_language DROP FOREIGN KEY FK_CB5EA3D26E34B975');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE snippet');
        $this->addSql('DROP TABLE snippet_language');
    }
}
