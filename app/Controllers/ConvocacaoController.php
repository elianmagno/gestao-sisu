<?php

namespace App\Controllers;

use App\Models\Curso;
use App\Models\Edicao;
use App\Requests\ConvocacaoRequest;
use App\Services\ConvocacaoService;

/**
 * Handles the generation and display of convocation lists.
 *
 * @package App\Controllers
 */
class ConvocacaoController extends Controller
{
    /** @var ConvocacaoService Business-logic layer for convocation operations. */
    protected ConvocacaoService $service;

    public function __construct()
    {
        parent::__construct();
        $this->service = new ConvocacaoService();
    }

    /**
     * Show the form for generating a new convocation list.
     */
    public function create(): void
    {
        $courses              = Curso::all();
        $editions             = Edicao::all();
        $multiplicationFactor = 1;
        $message              = $this->getFlash();

        $this->view('convocacao.create', compact('courses', 'editions', 'multiplicationFactor', 'message'));
    }

    /**
     * Validate input, generate the convocation list and display the results.
     */
    public function store(): void
    {
        $request = new ConvocacaoRequest($_POST);

        if (!$request->validate()) {
            $this->setFlash('Error: ' . $request->getErrorMessage());
            $this->redirect('create');
            return;
        }

        try {
            $result = $this->service->generate($request->validated());

            $this->view('convocacao.show', $result);
        } catch (\Exception $e) {
            $this->setFlash('Error: ' . $e->getMessage());
            $this->redirect('create');
        }
    }
}
