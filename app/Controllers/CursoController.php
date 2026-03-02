<?php

namespace App\Controllers;

use App\Models\Curso;
use App\Requests\CursoRequest;
use App\Services\CursoService;

/**
 * Handles CRUD operations for courses.
 *
 * @package App\Controllers
 */
class CursoController extends Controller
{
    /** @var CursoService Business-logic layer for course operations. */
    protected CursoService $service;

    public function __construct()
    {
        parent::__construct();
        $this->service = new CursoService();
    }

    /**
     * Display a listing of all courses.
     */
    public function index(): void
    {
        $courses = Curso::all();
        $message = $this->getFlash();

        $this->view('curso.index', compact('courses', 'message'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create(): void
    {
        $course  = new Curso();
        $message = $this->getFlash();

        $this->view('curso.create', compact('course', 'message'));
    }

    /**
     * Validate and store a newly created course.
     */
    public function store(): void
    {
        $request = new CursoRequest($_POST);

        if (!$request->validate()) {
            $course = new Curso();
            $course->fill($request->getData());

            $message = 'Error: ' . $request->getErrorMessage();

            $this->view('curso.create', compact('course', 'message'));
            return;
        }

        try {
            $course = $this->service->store($request->validated());
            $this->setFlash('Course created successfully!');
            $this->redirect('show', ['id' => $course->id]);
        } catch (\Exception $e) {
            $this->setFlash('Error: ' . $e->getMessage());
            $this->redirect('create');
        }
    }

    /**
     * Display the specified course.
     *
     * @param int $id Course ID.
     */
    public function show($id): void
    {
        $course = Curso::find($id);

        if (!$course) {
            $this->abort();
        }

        $message = $this->getFlash();

        $this->view('curso.show', compact('course', 'message'));
    }

    /**
     * Show the form for editing the specified course.
     *
     * @param int $id Course ID.
     */
    public function edit($id): void
    {
        $course = Curso::find($id);

        if (!$course) {
            $this->abort();
        }

        $message = $this->getFlash();

        $this->view('curso.create', compact('course', 'message'));
    }

    /**
     * Validate and update the specified course.
     *
     * @param int $id Course ID.
     */
    public function update($id): void
    {
        $course = Curso::find($id);

        if (!$course) {
            $this->abort();
        }

        $request = new CursoRequest($_POST);

        if (!$request->validate()) {
            $course->fill($request->getData());

            $message = 'Error: ' . $request->getErrorMessage();

            $this->view('curso.create', compact('course', 'message'));
            return;
        }

        try {
            $this->service->update($course, $request->validated());
            $this->setFlash('Course updated successfully!');
            $this->redirect('show', ['id' => $id]);
        } catch (\Exception $e) {
            $this->setFlash('Error: ' . $e->getMessage());
            $this->redirect('edit', ['id' => $id]);
        }
    }

    /**
     * Delete the specified course.
     *
     * @param int $id Course ID.
     */
    public function destroy($id): void
    {
        $course = Curso::find($id);

        if (!$course) {
            $this->abort();
        }

        try {
            $this->service->destroy($course);
            $this->setFlash('Course deleted successfully!');
        } catch (\Exception $e) {
            $this->setFlash('Error: ' . $e->getMessage());
        }

        $this->redirect('index');
    }
}
