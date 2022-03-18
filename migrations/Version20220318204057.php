<?php

declare(strict_types=1);

namespace DoctrineMigrations;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220318204057 extends AbstractMigration
{

    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

        $this->addSql(
            file_get_contents(__DIR__."/../scripts/script.sql")
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(
            file_get_contents(__DIR__."/../../scripts/script.sql")
        );
    }
}
