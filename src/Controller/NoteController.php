<?php

declare( strict_types = 1 );

namespace App\Controller;

use App\Controller\AbstractController;

class NoteController extends AbstractController
 {

    public const PAGE_SIZE = 10;

    public function listAction() {

        $phrase = $this->request->getParam( 'phrase' );
        $pageNumber = ( int ) $this->request->getParam( 'page', 1 );
        $sortBy = $this->request->getParam( 'sort_by', 'created' );
        $sortOrder = $this->request->getParam( 'sort_order', 'desc' );

        if ( $phrase ) {
            $noteList = $this->noteModel->search( $phrase, $sortBy, $sortOrder, $pageNumber, self::PAGE_SIZE );
            $notes = $this->noteModel->searchCount( $phrase );
        } else {
            $noteList = $this->noteModel->list( $sortBy, $sortOrder, $pageNumber, self::PAGE_SIZE );
            $notes = $this->noteModel->count();
        }

        $this->view->redner( self::DEFAULT_ACTION, [
            'page' => [ 
                'pageNumber' => $pageNumber,
                'pageSize' => self::PAGE_SIZE,
                'pages' => ( int )ceil( $notes/self::PAGE_SIZE ) 
            ],
            'sort' => [ 'by' => $sortBy, 'order' => $sortOrder ],
            'notes' => $noteList,
            'phrase' => $phrase,
            'before' => $this->request->getParam( 'before' ),
            'error' => $this->request->getParam( 'error' )
        ] );
    }

    public function deleteAction() : void {
        if ( $this->request->isPost() ) {
            $noteId = ( int ) $this->request->postParam( 'id' );
            $this->noteModel->delete( $noteId );
            $this->redirection( '/', [ 'before'=>'deleted' ] );
        } else {
            $this->view->redner( 'delete', [ 'note' => $this->getNote() ] );
        }
    }

    public function editAction(): void {
        if ( $this->request->isPost() ) {
            $noteId = ( int ) $this->request->postParam( 'id' );
            $note = [
                'title'=> $this->request->postParam( 'title' ),
                'description'=> $this->request->postParam( 'description' )
            ];
            $this->noteModel->edit( $noteId, $note );
            $this->redirection( '/', [ 'before'=>'edited' ] );
        } else {
            $note = $this->getNote();
        }
        $this->view->redner( 'edit', [ 'note'=>$note ] );
    }

    public function createAction() {
        if ( $this->request->hasPost() ) {
            $this->noteModel->create(
                [
                    'title'=> $this->request->postParam( 'title' ),
                    'description'=> $this->request->postParam( 'description' )
                ]
            );

            $this->redirection( '/', [ 'before'=>'created' ] );
        }

        $this->view->redner( 'create' );
    }

    public function showAction() {
        $this->view->redner( 'show',
        [ 'note' => $this->getNote() ] );
    }

    private function getNote(): array {
        $noteId = ( int )$this->request->getParam( 'id' );
        return $note = $this->noteModel->get( $noteId );
    }
}