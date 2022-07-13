<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * @author "Emmanuel BALLERY" <emmanuel.ballery@gmail.com>
 */
final class Version20220713200936 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE billing_subscription (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL, subscription_id VARCHAR(255) NOT NULL, `key` VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, cost DOUBLE PRECISION DEFAULT NULL, start DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', end DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', periodicity VARCHAR(255) NOT NULL, `rows` JSON NOT NULL COMMENT \'(DC2Type:json_document)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
