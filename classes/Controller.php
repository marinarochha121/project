<?php
class Controller
{
    /** $db */
    public $db;

    /** $title */
    public $title;

    /** $parameters */
    public $parameters = array();

    public function __construct($parameters = array())
    {
        $this->db = new ProjectDB();
        $this->parameters = $parameters;
    }

    public function load_model($modelName = false)
    {
        if (!$modelName) return;
        $modelName =  strtolower($modelName);
        $modelPath = ABSPATH . '/models/' . $modelName . '.php';

        if (file_exists($modelPath)) {
            require_once $modelPath;
            $modelName = explode('/', $modelName);

            $modelName = end($modelName);
            $modelName = preg_replace('/[^a-zA-Z0-9]/is', '', $modelName);

            if (class_exists($modelName)) {
                return new $modelName($this->db, $this);
            }
            return;
        }
    }
}
