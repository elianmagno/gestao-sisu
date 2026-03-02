<?php

namespace App\Controllers;

use App\Models\Curso;
use App\Models\Edicao;
use App\Requests\EdicaoRequest;
use App\Services\EdicaoService;

/**
 * Handles CRUD operations for editions.
 *
 * @package App\Controllers
 */
class EdicaoController extends Controller
{
    /** @var EdicaoService Business-logic layer for edition operations. */
    protected EdicaoService $service;

    public function __construct()
    {
        parent::__construct();
        $this->service = new EdicaoService();
    }

    /**
     * Display a listing of all editions.
     */
    public function index(): void
    {
        $editions = Edicao::all();
        $message  = $this->getFlash();

        $this->view('edicao.index', compact('editions', 'message'));
    }

    /**
     * Show the form for creating a new edition.
     */
    public function create(): void
    {
        $edition = new Edicao();
        $courses = Curso::all()->keyBy('id')->sortKeys();
        $message = $this->getFlash();

        $this->view('edicao.create', compact('edition', 'courses', 'message'));
    }

    /**
     * Validate and store a newly created edition.
     */
    public function store(): void
    {
        $request = new EdicaoRequest($_POST);

        if (!$request->validate()) {
            $edition = new Edicao();
            $edition->nome = $request->getData('nome');
            $edition->setRelation('cursos', $request->getData('cursos', []));

            $courses = Curso::all()->keyBy('id')->sortKeys();
            $message = 'Error: ' . $request->getErrorMessage();

            $this->view('edicao.create', compact('edition', 'courses', 'message'));
            return;
        }

        try {
            $edition = $this->service->store($request->validated());
            $this->setFlash('Edition created successfully!');
            $this->redirect('show', ['id' => $edition->id]);
        } catch (\Exception $e) {
            $this->setFlash('Error: ' . $e->getMessage());
            $this->redirect('create');
        }
    }

    /**
     * Display the specified edition.
     *
     * @param int $id Edition ID.
     */
    public function show($id): void
    {
        $edition = Edicao::find($id);

        if (!$edition) {
            $this->abort();
        }

        $message = $this->getFlash();

        $this->view('edicao.show', compact('edition', 'message'));
    }

    /**
     * Show the form for editing the specified edition.
     *
     * @param int $id Edition ID.
     */
    public function edit($id): void
    {
        $edition = Edicao::find($id);

        if (!$edition) {
            $this->abort();
        }

        $courses = $edition->cursos->keyBy('id')->sortKeys();
        $message = $this->getFlash();

        $this->view('edicao.create', compact('edition', 'courses', 'message'));
    }

    /**
     * Validate and update the specified edition.
     *
     * @param int $id Edition ID.
     */
    public function update($id): void
    {
        $edition = Edicao::find($id);

        if (!$edition) {
            $this->abort();
        }

        $courses = $edition->cursos->keyBy('id')->sortKeys();

        $request = new EdicaoRequest($_POST);

        if (!$request->validate()) {
            $edition->nome = $request->getData('nome');
            $edition->setRelation('cursos', $request->getData('cursos', []));

            $message = 'Error: ' . $request->getErrorMessage();

            $this->view('edicao.create', compact('edition', 'courses', 'message'));
            return;
        }

        try {
            $this->service->update($edition, $request->validated());
            $this->setFlash('Edition updated successfully!');
            $this->redirect('show', ['id' => $id]);
        } catch (\Exception $e) {
            $this->setFlash('Error: ' . $e->getMessage());
            $this->redirect('edit', ['id' => $id]);
        }
    }

    /**
     * Delete the specified edition.
     *
     * @param int $id Edition ID.
     */
    public function destroy($id): void
    {
        $edition = Edicao::find($id);

        if (!$edition) {
            $this->abort();
        }

        try {
            $this->service->destroy($edition);
            $this->setFlash('Edition deleted successfully!');
        } catch (\Exception $e) {
            $this->setFlash('Error: ' . $e->getMessage());
        }

        $this->redirect('index');
    }
}
