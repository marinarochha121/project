<?php

class Mvc
{
    /** $controller */
    private $controller;

    /** $action */
    private $action;

    /** $parameters */
    private $parameters;

    /** $not_found */
    private $not_found = '/includes/404.php';

    public function __construct()
    {
        $this->get_url_data();

        if (!$this->controller) {
            require_once ABSPATH . '/controllers/userController.php';

            $this->controller = new userController();

            $this->controller->index();
            return;
        }

        if (!file_exists(ABSPATH . '/controllers/' . $this->controller . '.php')) {
            require_once ABSPATH . $this->not_found;
            return;
        }

        require_once ABSPATH . '/controllers/' . $this->controller . '.php';

        $this->controller = preg_replace('/[^a-zA-Z]/i', '', $this->controller);

        if (!class_exists($this->controller)) {
            require_once ABSPATH . $this->not_found;
            return;
        }

        $this->controller = new $this->controller($this->parameters);

        if (method_exists($this->controller, $this->action)) {
            $this->controller->{$this->action}($this->parameters);
            return;
        }

        if (!$this->action && method_exists($this->controller, 'index')) {
            $this->controller->index($this->parameters);
            return;
        }
        require_once ABSPATH . $this->not_found;

        return;
    }

    public function get_url_data()
    {
        if (isset($_GET['path'])) {
            $path = $_GET['path'];

            $path = rtrim($path, '/');
            $path = filter_var($path, FILTER_SANITIZE_URL);

            $path = explode('/', $path);

            $this->controller  = chk_array($path, 0);
            $this->controller .= 'Controller';
            $this->action         = chk_array($path, 1);
            
            if (chk_array($path, 2)) {
                unset($path[0]);
                unset($path[1]);

                $this->parameters = array_values($path);
            }
        }
    }
}
