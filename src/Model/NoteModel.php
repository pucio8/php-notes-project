<?php

declare( strict_types = 1 );

namespace App\Model;

use PDO;
use App\Exception\StorageException;
use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;
use PDOException;
use Throwable;

class NoteModel extends AbstractModel implements ModelInterface{

    public function search( string $phrase, string $sortBy, string $sortOrder, int $pageNumber, int $pageSize ) : array {
        return $this->findBy( $phrase,  $sortBy,  $sortOrder,  $pageNumber,  $pageSize );
    }

    public function searchCount( string $phrase ) : int {
        try {
            $phrase = $this->connection->quote( "%$phrase%", PDO::PARAM_STR );
            $query = "SELECT count(*) AS cn FROM notes WHERE title LIKE $phrase";
            $result = $this->connection->query( $query );
            $result = $result->fetch( PDO::FETCH_ASSOC );
            if ( $result === false ) {
                throw new StorageException( 'Błąd pobrania liczby notatek po wyszkouwaniu', 400 );
            }
            return $result[ 'cn' ];
        } catch ( Throwable $e ) {
            throw new StorageException( 'Błąd pobrania liczby notatek po wyszukiwaniu', 400, $e );
        }
    }

    public function delete( int $noteId ) : void {
        try {
            $query = "DELETE FROM notes WHERE id = $noteId";
            $this->connection->exec( $query );
        } catch ( Throwable $e ) {
            throw new StorageException( 'Nie udało usunąć notatki', 400, $e );
        }
    }

    public function edit ( int $noteId, array $note ) : void {
        $title = $this->connection->quote( $note[ 'title' ] );
        $description = $this->connection->quote( $note[ 'description' ] );

        try {
            $query = "UPDATE notes SET title = $title, description = $description WHERE id = $noteId";
            $this->connection->query( $query );
        } catch ( Throwable $e ) {
            throw new StorageException( 'Nie udało edytować notatki', 400, $e );
        }
    }

    public function get( int $id ) : array {
        try {
            $query = "SELECT * FROM notes WHERE id=$id";
            $result = $this->connection->query( $query );
            $note =  $result->fetch( PDO::FETCH_ASSOC );
        } catch ( Throwable $e ) {
            throw new StorageException( 'Nie udało się pobrać notatki', 400, $e );
        }
        if ( !$note ) {
            throw new NotFoundException( 'Nie znaleziono notatki' );
        }
        return $note;
    }

    public function list(
        string $sortBy,
        string $sortOrder,
        int $pageNumber,
        int $pageSize
    ) : array {
        return $this->findBy( null,  $sortBy,  $sortOrder,  $pageNumber,  $pageSize );
    }

    public function count() : int {
        try {
            $query = 'SELECT count(*) AS cn FROM notes ';
            $result = $this->connection->query( $query );
            $result = $result->fetch( PDO::FETCH_ASSOC );
            if ( $result === false ) {
                throw new StorageException( 'Błąd pobrania liczby notatek', 400 );
            }
            return $result[ 'cn' ];

        } catch ( Throwable $e ) {
            throw new StorageException( 'Błąd pobrania liczby notatek', 400, $e );
        }
    }

    public function create( array $data ):void {
        $title = $this->connection->quote( $data[ 'title' ] );
        $description = $this->connection->quote( $data[ 'description' ] );
        $time = $this->connection->quote( date( 'Y-m-d H:i:s' ) );

        $note =
        "INSERT INTO notes(title, description, created)
          VALUES ($title,$description,$time) 
         ";

        try {
            $this->connection->query( $note );

        } catch ( PDOException $e ) {
            throw new StorageException( 'Problem z serwerem proszę skontaktuj się z administratorem, badź napisz mail na adres example@gmial.com', 400 );
        }
    }

    private function findBy(
        ?string $phrase,
        string $sortBy,
        string $sortOrder,
        int $pageNumber,
        int $pageSize
    ): array {

        $offSet = ( $pageNumber - 1 ) * $pageSize;
        if ( !in_array( $sortBy, [ 'title', 'created' ] ) ) {
            $sortBy = 'created';
        }
        if ( !in_array( $sortOrder, [ 'asc', 'desc' ] ) ) {
            $sortOrder = 'desc';
        }
        $wherePart = '';
        if ( $phrase ) {
            $phrase = $this->connection->quote( "%$phrase%", PDO::PARAM_STR );
            $wherePart = "WHERE title LIKE $phrase";
        }

        try {
            $query =
            "
            SELECT
             id,title,created 
            FROM notes
             $wherePart
            ORDER BY
            $sortBy $sortOrder 
            LIMIT $offSet,$pageSize";

            $result = $this->connection->query( $query );
            return $result->fetchAll( PDO::FETCH_ASSOC );
        } catch ( Throwable $e ) {
            throw new StorageException( 'Błąd wczytania listy notatek', 400, $e );
        }
    }
}