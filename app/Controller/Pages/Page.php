<?php

namespace App\Controller\Pages;

use \App\Utils\View;

class Page{

    /**
     * Método responsavel por renderizar o Topo da página
     * @return string
     */
    private static function getHeader() {
        return View::render('pages/header');
    }
    /**
     * Método responsavel por renderizar o Rodapé da página
     * @return string
     */
    private static function getFooter() {
        return View::render('pages/footer');
    }


    /**
     * Método responsável por retornar o conteudo da pagina genérica
     * @return string 
     */
    public static function getPage($title, $content) {
        return View::render('pages/page', [
            'title'   => $title,
            'header'  => self::getHeader(),
            'content' => $content,
            'footer'  => self::getFooter()
        ]);
    }

}