<?php
defined('BASEPATH') or exit('No direct script access allowed');
class MY_Controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->driver('cache', array('adapter' => 'file', 'backup' => 'file'));
        $this->load->model('main_model');
    }

    function head()
    {
        $this->load->view('_include/head');
    }

    function top()
    {
        $this->load->view('_include/top');
    }

    function bottom()
    {
        $this->load->view('_include/bottom');
    }

    function footer()
    {
        $this->load->view('_include/footer');
    }

    function _head()
    {
        $this->load->view('_include/head');
        $this->_blank('<div class="d-flex" id="wrapper">');
        $this->load->view('_include/side');
        $this->_blank('<div id="page-content-wrapper">');
        $this->load->view('_include/nav');
        $this->_blank('<div class="container-fluid">');
    }

    function _footer()
    {
        $this->_blank('</div><div class="footer">');
        $this->load->view('_include/footer2');
        $this->_blank('</div></div></div>');
        $this->load->view('_include/bottom');
        $this->load->view('_include/footer');
    }

    function _blank($html = null, $data = false)
    {
        if ($data) {
            return $this->load->view('_include/blank', array(
                'html' => $html,
            ), true);
        } else {
            $this->load->view('_include/blank', array(
                'html' => $html,
            ), false);
        }
    }

    function getCache($table, $data = array(), $primary_key = false)
    {
        ksort($data); //키값으로 정렬
        $filename = $table . '_' . json_encode($data);
        if (!$items = $this->cache->get($filename)) {
            $items = $this->main_model->get($table, $data, $primary_key);
            $this->cache->save($filename, $items, 3600 * 24 * 7);
        }
        return $items;
    }

    function getsCache($table, $data = array(), $primary_key = false)
    {
        ksort($data); //키값으로 정렬
        $filename = $table . '_' . json_encode($data) . '_' . $primary_key;
        if (!$items = $this->cache->get($filename)) {
            $items = $this->main_model->gets($table, $data, $primary_key);
            $this->cache->save($filename, $items, 3600 * 24 * 7);
        }
        return $items;
    }
}
