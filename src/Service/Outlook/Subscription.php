<?php

interface Message {

    public function list();

    public function get();

    public function create();

    public function update();

    public function trash();

    public function delete();
}