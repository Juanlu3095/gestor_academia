<?php

namespace interfaces;

interface Controller {
    
    public function index(array $vars);

    public function show(array $vars);

    public function create();

    public function update(array $vars);

    public function delete(array $vars);
}

?>