<?php

namespace Api\Routes;

use Slim\App;
use Api\Controllers\DisciplinaController;
use Api\Middlewares\Disciplina\ValidateDisciplinaBody;
use Api\Middlewares\Disciplina\ValidateDisciplinaId;

class DisciplinaRouter
{
    private App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function setupRoutes(): void
    {
        
        $this->app->post(
            '/disciplinas',
            [DisciplinaController::class, 'createController']
        )
            ->add(ValidateDisciplinaBody::class);

        $this->app->get(
            '/disciplinas',
            [DisciplinaController::class, 'findAllController']
        );

        $this->app->get(
            '/disciplinas/count',
            [DisciplinaController::class, 'countController']
        );

        $this->app->get(
            '/disciplinas/{id_disciplina}',
            [DisciplinaController::class, 'findByIdController']
        )
            ->add(ValidateDisciplinaId::class);

       
        $this->app->put(
            '/disciplinas/{id_disciplina}',
            [DisciplinaController::class, 'updateController']
        )
            ->add(ValidateDisciplinaBody::class)
            ->add(ValidateDisciplinaId::class);


        $this->app->delete(
            '/disciplinas/{id_disciplina}',
            [DisciplinaController::class, 'deleteController']
        )
            ->add(ValidateDisciplinaId::class);
    }
}