<?php

/**
 * Class Controller
 *
 * This class should be extended by all controllers.
 */
class Controller {
    /**
     * @var Model $model The model object used by the controller.
     */
    protected Model $model;

    /**
     * Class constructor.
     */
    public function __construct() {
        $this->model = new Model();
    }

    /**
     * Renders the view associated with the controller.
     */
    public function render() {
        echo 'This method should be overriden.';
    }
}
