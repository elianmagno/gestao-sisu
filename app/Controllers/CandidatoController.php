<?php

namespace App\Controllers;

use App\Models\Candidato;
use App\Models\Curso;
use App\Models\Edicao;
use App\Requests\CandidatoRequest;
use App\Services\CandidatoService;

/**
 * Handles CRUD operations for candidates.
 *
 * @package App\Controllers
 */
class CandidatoController extends Controller
{
    /** @var CandidatoService Business-logic layer for candidate operations. */
    protected CandidatoService $service;

    public function __construct()
    {
        parent::__construct();
        $this->service = new CandidatoService();
    }

    /**
     * Display a listing of all candidates.
     */
    public function index(): void
    {
        $candidates = Candidato::all();
        $message    = $this->getFlash();

        $this->view('candidato.index', compact('candidates', 'message'));
    }

    /**
     * Show the form for creating a new candidate.
     */
    public function create(): void
    {
        $candidate = new Candidato();
        $courses   = Curso::all();
        $editions  = Edicao::all();
        $message   = $this->getFlash();

        $this->view('candidato.create', compact('candidate', 'courses', 'editions', 'message'));
    }

    /**
     * Validate and store a newly created candidate.
     */
    public function store(): void
    {
        $request = new CandidatoRequest($_POST);

        if (!$request->validate()) {
            $candidate = new Candidato();
            $candidate->fill($request->getData());

            $courses = Curso::all();
            $editions = Edicao::all();
            $message = 'Error: ' . $request->getErrorMessage();

            $this->view('candidato.create', compact('candidate', 'courses', 'editions', 'message'));
            return;
        }

        try {
            $candidate = $this->service->store($request->validated());
            $this->setFlash('Candidate created successfully!');
            $this->redirect('show', ['id' => $candidate->id]);
        } catch (\Exception $e) {
            $this->setFlash('Error: ' . $e->getMessage());
            $this->redirect('create');
        }
    }

    /**
     * Display the specified candidate.
     *
     * @param int $id Candidate ID.
     */
    public function show($id): void
    {
        $candidate = Candidato::find($id);

        if (!$candidate) {
            $this->abort();
        }

        $message = $this->getFlash();

        $this->view('candidato.show', compact('candidate', 'message'));
    }

    /**
     * Show the form for editing the specified candidate.
     *
     * @param int $id Candidate ID.
     */
    public function edit($id): void
    {
        $candidate = Candidato::find($id);

        if (!$candidate) {
            $this->abort();
        }

        $courses  = Curso::all();
        $editions = Edicao::all();
        $message  = $this->getFlash();

        $this->view('candidato.create', compact('candidate', 'courses', 'editions', 'message'));
    }

    /**
     * Validate and update the specified candidate.
     *
     * @param int $id Candidate ID.
     */
    public function update($id): void
    {
        $candidate = Candidato::find($id);

        if (!$candidate) {
            $this->abort();
        }

        $request = new CandidatoRequest(array_merge($_POST, ['id' => $id]));

        if (!$request->validate()) {
            $candidate->fill($request->getData());

            $courses  = Curso::all();
            $editions = Edicao::all();
            $message  = 'Error: ' . $request->getErrorMessage();

            $this->view('candidato.create', compact('candidate', 'courses', 'editions', 'message'));
            return;
        }

        try {
            $this->service->update($candidate, $request->validated());
            $this->setFlash('Candidate updated successfully!');
            $this->redirect('show', ['id' => $id]);
        } catch (\Exception $e) {
            $this->setFlash('Error: ' . $e->getMessage());
            $this->redirect('edit', ['id' => $id]);
        }
    }

    /**
     * Delete the specified candidate.
     *
     * @param int $id Candidate ID.
     */
    public function destroy($id): void
    {
        $candidate = Candidato::find($id);

        if (!$candidate) {
            $this->abort();
        }

        try {
            $this->service->destroy($candidate);
            $this->setFlash('Candidate deleted successfully!');
        } catch (\Exception $e) {
            $this->setFlash('Error: ' . $e->getMessage());
        }

        $this->redirect('index');
    }
}
