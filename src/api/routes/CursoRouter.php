<?php

namespace Api\Routes;

use Slim\App;
use Api\Controllers\CursoController;
use Api\Middlewares\Curso\ValidateCursoBody;
use Api\Middlewares\Curso\ValidateCursoId;

class CursoRouter
{
    private App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function setupRoutes(): void
    {
      
        $this->app->post(
            '/cursos',
            [CursoController::class, 'createController']
        )
            ->add(ValidateCursoBody::class);

        
        $this->app->get(
            '/cursos',
            [CursoController::class, 'findAllController']
        );

       
        $this->app->get(
            '/cursos/count',
            [CursoController::class, 'countController']
        );

       
        $this->app->get(
            '/cursos/{id_curso}',
            [CursoController::class, 'findByIdController']
        )
            ->add(ValidateCursoId::class);

        
        $this->app->put(
            '/cursos/{id_curso}',
            [CursoController::class, 'updateController']
        )
            ->add(ValidateCursoBody::class)
            ->add(ValidateCursoId::class);

       
        $this->app->delete(
            '/cursos/{id_curso}',
            [CursoController::class, 'deleteController']
        )
            ->add(ValidateCursoId::class);
    }
}