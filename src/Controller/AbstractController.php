<?php

declare( strict_types = 1 );

namespace App\Controller;

use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;
use App\Request;
use App\View;
use App\Exception\StorageException;
use App\Model\NoteModel;

abstract class AbstractController 
 {
    protected const DEFAULT_ACTION = 'list';
    private static array $configuration = [];

    public static function initConfiguration( array $configuration ): void {
        self::$configuration = $configuration;
    }

    protected NoteModel $noteModel;
    protected Request $request;
    protected View $view;

    public function __construct( Request $request ) {
        if ( empty( self::$configuration[ 'db' ] ) ) {
            throw new ConfigurationException( 'Databse error' );
        }
        $this->request = $request;
        $this->view = new View();
        $this->noteModel = new NoteModel( self::$configuration[ 'db' ] );
    }

    final public function run() : void {
        try{
            $action = $this->action().'Action';
            if (method_exists($this,$action)) {
                $this->$action();
            }
            else {
                $this->redirection('/',['error'=>'appException']);
            }
        } catch(StorageException $e){
            $this->view->redner('error',['message'=>$e->getMessage()]);
        } catch ( NotFoundException $e ) {
            $this->redirection( '/', [ 'error'=>'notFoundException' ] );
        }
    }

    public function action() {
        return $this->request->getParam('action',self::DEFAULT_ACTION);
    }

    protected function redirection( string $to, array $params ) : void {
        $location = $to;
        
        if(count($params)){
            $queryParams = [];
            foreach ($params as $key => $value) {
                $queryParams[] = urlencode($key).'='.urlencode($value);
            }
            $queryParams = implode('&',$queryParams);
            $location .= "?$queryParams";
        }

        header("Location:$location");
        exit();
    }
}
