<?php

/* 
 * @package JasonPrendergast-plugin
 */
/*
 * Plugin Name: JasonPrendergast-plugin
 * Plugin URI: https://github.com/JasonPrendergast
 * Description: This is my first attempt at writing a  plugin for Wordpress  
 * Version: 0.0.1
 * Author: Jason Prendergast
 * Author URI: https://github.com/JasonPrendergast
 * Text Domain: JasonPrendergast-plugin
 */
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('ABSPATH'))
{
    die;
}

if (! function_exists('add_action'))
{
    die;
}


class JasonPrendergastPlugin
{
    public function __construct() 
    {
        add_action('init',array($this,'custom_post_type'));
    }
    
    //methods
    function activate()
    {
        //generate a custom post type
        $this->custom_post_type();
        //Flush rewrite rules
        flush_rewrite_rules();
        
    }
    function deactivate()
    {
        //flush rewrite rules
        flush_rewrite_rules();
    }
    function uninstall()
    {
        //delete custom post type
        //delete all plugin data from DB
    }
    
    
    function custom_post_type()
    {
        register_post_type('book',['public' =>true, 'label' => 'Books']);
    }
}

if (class_exists('JasonPrendergastPlugin'))
{
    $jasonPrendergastPlugin = new JasonPrendergastPlugin();
}

//activation
register_activation_hook(__FILE__,array($jasonPrendergastPlugin,'activate'));
//deactivation
register_deactivation_hook(__FILE__,array($jasonPrendergastPlugin,'activate'));
//uninstall
