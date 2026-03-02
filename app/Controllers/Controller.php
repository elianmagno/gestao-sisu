<?php

namespace App\Controllers;

use ReflectionClass;

/**
 * Base controller providing view rendering, redirection, flash messaging, and error handling.
 *
 * All resource controllers extend this class to inherit shared HTTP response utilities.
 *
 * @package App\Controllers
 */
class Controller
{
    /** @var string The lowercase controller name derived from the class name, used for URL building. */
    protected string $controllerName = '';

    /**
     * Initialize the controller: start the session and resolve the controller name.
     */
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $reflection = new ReflectionClass($this);
        $className = $reflection->getShortName();
        $lowerClassName = strtolower($className);
        $this->controllerName = str_replace('controller', '', $lowerClassName);
    }

    /**
     * Render a view file with the given data extracted as local variables.
     *
     * Accepts dot notation for the view path (e.g. 'candidato.index' resolves to 'views/candidato/index.php').
     *
     * @param  string $viewPath Dot-notated view path relative to the views directory.
     * @param  array  $data     Associative array of variables to make available in the view.
     * @return void
     */
    protected function view(string $viewPath, array $data = []): void
    {
        $__viewFile = getcwd() . '/views/' . str_replace('.', '/', $viewPath) . '.php';

        if (!file_exists($__viewFile)) {
            $this->abort();
        }

        extract($data);
        include $__viewFile;
    }

    /**
     * Redirect the client to a controller action via HTTP 303 See Other.
     *
     * @param  string     $method The action method name to redirect to.
     * @param  array|null $params Optional query string parameters.
     * @return void
     */
    protected function redirect(string $method, ?array $params = null): void
    {
        http_response_code(303);

        $url = '/' . $this->controllerName . '/' . $method;

        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        header('Location: ' . $url);
        exit;
    }

    /**
     * Abort the request by sending an HTTP error code and rendering the corresponding error page.
     *
     * @param  int  $code HTTP status code (default: 404).
     * @return void
     */
    protected function abort(int $code = 404): void
    {
        http_response_code($code);

        $errorPagePath = getcwd() . '/views/errors/' . $code . '.php';

        if (file_exists($errorPagePath)) {
            include $errorPagePath;
        }

        exit;
    }

    /**
     * Store a one-time flash message in the session.
     *
     * @param  string $message The message to display on the next request.
     * @return void
     */
    protected function setFlash(string $message): void
    {
        $_SESSION['flash'] = $message;
    }

    /**
     * Retrieve and clear the flash message from the session.
     *
     * @return string The stored message, or an empty string if none exists.
     */
    protected function getFlash(): string
    {
        $message = $_SESSION['flash'] ?? '';
        unset($_SESSION['flash']);

        return $message;
    }
}
