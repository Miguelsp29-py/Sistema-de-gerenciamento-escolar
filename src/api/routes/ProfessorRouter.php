<?php

namespace Api\Routes;

use Slim\App;
use Api\Controllers\ProfessorController;
use Api\Middlewares\Professor\ValidateProfessorBody;
use Api\Middlewares\Professor\ValidateProfessorId;
use Api\Middlewares\Professor\ValidateProfessorToken;

class ProfessorRouter
{
    private App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function setupRoutes(): void
    {
        $this->app->post(
        '/professores/login',
        [ProfessorController::class, 'loginController']
        );

        $this->app->post(
            '/professores',
            [ProfessorController::class, 'createController']
        )
            ->add(ValidateProfessorBody::class);

        $this->app->get(
            '/professores',
            [ProfessorController::class, 'findAllController']
        )
            ->add(ValidateProfessorToken::class);

        $this->app->get(
            '/professores/count',
            [ProfessorController::class, 'countController']
        )
            ->add(ValidateProfessorToken::class);
        $this->app->get(
            '/professores/{id_professor}',
            [ProfessorController::class, 'findByIdController']
        )
            ->add(ValidateProfessorToken::class)
            ->add(ValidateProfessorId::class);

        $this->app->put(
            '/professores/{id_professor}',
            [ProfessorController::class, 'updateController']
        )
            ->add(ValidateProfessorBody::class)
            ->add(ValidateProfessorToken::class)
            ->add(ValidateProfessorId::class);

        $this->app->delete(
            '/professores/{id_professor}',
            [ProfessorController::class, 'deleteController']
        )
            ->add(ValidateProfessorToken::class)
            ->add(ValidateProfessorId::class);
    }
}