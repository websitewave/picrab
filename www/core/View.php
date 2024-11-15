<?php
// core/View.php

class View
{

    public static function render($template, $data = [], $module = false): void
    {
        PageRenderer::render($template, $data, $module);
    }
}