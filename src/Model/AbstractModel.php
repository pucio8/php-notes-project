<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\ConfigurationException;
use App\Exception\StorageException;
use PDO;
use PDOException;

abstract class AbstractModel
{
    protected PDO $connection;

    public function __construct( array $configuration ) {
        try {
            $this->validateConfiguration( $configuration );
            $this->createConnection( $configuration );
        } catch ( PDOException $e ) {
            throw new StorageException( 'Problem z konfiguracją prosze skontaktuj się z adminstrcją strony' );
        }
    }

    private function createConnection( array $configuration ) : void {
        $dsn = "mysql:dbname={$configuration['database']};{$configuration['host']}";
        $this->connection = new PDO(
            $dsn,
            $configuration[ 'user' ],
            $configuration[ 'password' ],
            [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ]
        );
    }

    private function validateConfiguration( array $configuration ) : void {
        if (
            empty( $configuration[ 'user' ] )
            || empty( $configuration[ 'password' ] )
            || empty( $configuration[ 'host' ] )
            || empty( $configuration[ 'database' ] )
        ) {
            throw new ConfigurationException( 'Configuration error' );
        }
    }

}
