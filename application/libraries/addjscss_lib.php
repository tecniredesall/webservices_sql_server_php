<?php if(!defined('BASEPATH'))         exit('No direct script access allowed');

class addjscss_lib{

    public $obj;
    public $js=array();
    public $css=array();
    public $script_text="";
    public $css_text="";

    
    function  __construct()
    {
            $this->obj=& get_instance();
    }

    function agregarcss($html_css)
    {
        $this->css=array_merge($this->css, array($html_css));
    }

    function agregarjs($html_js)
    {
        $this->js=array_merge($this->js, array($html_js));
    }


    function insertarcss_html()
    {
        foreach ($this->css as $value)
        {
            echo "\t".$value."\n";
        }
    }
    
    function insertarjs_html()
    {
        foreach ($this->js as $value)
        {
            echo "\t".$value."\n";
        }
    }

    
    function agregar_script($script)
    {
        $this->script_text.=$script;
    }
    
    function insertar_script()
    {

    $script="$(document).ready(function(){".$this->script_text."});";
    echo $script;
    }


    function agregar_css($css)
    {
        $this->css_text.=$css;
    }

    function insertar_css()
    {
        echo $this->css_text;
    }



    
}