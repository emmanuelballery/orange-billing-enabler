<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * @author "Emmanuel BALLERY" <emmanuel.ballery@gmail.com>
 */
final class Version20220713205101 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE billing_subscription (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created DATETIME NOT NULL, updated DATETIME DEFAULT NULL, subscription_id VARCHAR(255) NOT NULL, subscription_key VARCHAR(255) NOT NULL, subscription_value VARCHAR(255) NOT NULL, subscription_cost DOUBLE PRECISION DEFAULT NULL, subscription_start DATE NOT NULL, subscription_end DATE DEFAULT NULL, subscription_periodicity VARCHAR(255) NOT NULL, subscription_rows JSON NOT NULL COMMENT \'(DC2Type:json_document)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
