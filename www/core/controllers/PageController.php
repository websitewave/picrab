<?php
// core/controllers/PageController.php

class PageController
{
    public function viewPage($slug)
    {
        $page = Page::findBySlug($slug);

        if (!$page || $page->status != 'published') {
            $this->render404();
            exit;
        }

        $meta_title = $page->meta_title ?: $page->title;
        $meta_description = $page->meta_description ?: '';


        View::render('page', [
            'page' => $page,
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
        ]);
    }

    private function render404()
    {
        http_response_code(404);
        $page = Page::findByType('404');
        if ($page && $page->status == 'published') {
            View::render('page', ['page' => $page]);
        } else {
            echo 'Страница не найдена';
        }
    }
}