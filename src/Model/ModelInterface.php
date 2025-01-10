<?php

declare( strict_types = 1 );

namespace App\Model;

interface ModelInterface
{
    public function list( string $sortBy, string $sortOrder, int $pageNumber, int $pageSize ) : array;

    public function search( string $phrase, string $sortBy, string $sortOrder, int $pageNumber, int $pageSize ) : array;

    public function searchCount( string $phrase ) : int;

    public function delete( int $noteId ) : void;

    public function edit ( int $noteId, array $note ) : void;

    public function get( int $id ) : array;

    public function count() : int;

    public function create( array $data ):void;
}