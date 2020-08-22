<?php

declare(strict_types = 1);

// phpcs:ignoreFile
/** @noinspection PhpIllegalPsrClassPathInspection */
namespace DoctrineMigrations;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200822115127 extends AbstractMigration
{
    /** @noinspection PhpMissingParentCallCommonInspection */
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return '';
    }

    /**
     * @param Schema $schema
     *
     * @throws DBALException
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE java_article ADD status TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE java_article ADD CONSTRAINT FK_8BF55BB412469DE2 FOREIGN KEY (category_id) REFERENCES java_article_category (id)');
        $this->addSql('CREATE INDEX IDX_8BF55BB412469DE2 ON java_article (category_id)');
        $this->addSql('ALTER TABLE java_article_category ADD status TINYINT(1) NOT NULL');
    }

    /**
     * @param Schema $schema
     *
     * @throws DBALException
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE java_article DROP FOREIGN KEY FK_8BF55BB412469DE2');
        $this->addSql('DROP INDEX IDX_8BF55BB412469DE2 ON java_article');
        $this->addSql('ALTER TABLE java_article DROP status');
        $this->addSql('ALTER TABLE java_article_category DROP status');
    }
}
