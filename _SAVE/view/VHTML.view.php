<?php
class VHTML {
    
    public function __construct() {}
    
    public function __destruct() {}
    
    public function showHtml($_filename) {
        if (file_exists('../html/'. $_filename .'.html')) {
            include('../html/'. $_filename .'.html');
        }
    }
}