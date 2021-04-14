<?php
class controller_home{
    function list(){
        common::loadView(VIEW_PATH_HOME, 'inicio.html');
    }

    function slider(){
        echo common::accessModel('home_model', 'getSlider_home') -> getResolve();
    }

    function categories(){
        echo common::accessModel('home_model', 'getCategories_home') -> getResolve();
    }
}