<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends MY_Controller
{
	public function index()
	{
		$this->list();
	}

	public function list()
	{
		$requ = $this->input->get();
		$requ['page'] = $this->input->get('page');
		$requ['page'] = intval($requ['page']);
		if ($requ['page'] < 1) {
			$requ['page'] = 1;
		}
		$list = $this->lists_model;
		$list->set('limit_size', 2);
		$list->set('from', 'T_ARTICLE');
		$list->set('page', $requ['page']);
		$list->set('order_key', 'seq');
		$list->set('order_value', 'desc');
		$view['items'] = $list->items();
		$view['pages'] = $list->pages();
		$this->load->view('Main_list', $view);
	}

	public function add()
	{
		if ($this->input->method() !== 'post') {
			$this->load->view('Main_add');
		} else {
			$requ = $this->input->post();
			$requ['writer'] = 'jun';
			$created = date('Y-m-d H:i:s');
			$requ['updated'] = $created;
			$requ['date'] = date('Y-m-d');
			$requ['created'] = $created;
			$this->main_model->insert('T_ARTICLE', $requ);
			redirect('/');
		}
	}

	public function createArticleTable()
	{
		$this->load->model('article_model');
		if ($this->article_model->isExists() === false) {
			$this->article_model->create();
			echo 'T_ARTICLE 테이블 생성';
		} else {
			echo 'T_ARTICLE 테이블 이미 있음';
		}
	}

	public function createSessionTable()
	{
		$this->load->model('session_model');
		if ($this->session_model->isExists() === false) {
			$this->session_model->create();
			echo 'ci_sessions 테이블 생성';
		} else {
			echo 'ci_sessions 테이블 이미 있음';
		}
	}
}
