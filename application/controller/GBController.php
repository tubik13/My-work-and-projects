<?php

class GBController {

	const POST_PER_PAGE = 25;
	
	private $model;
	private $view;
	
	function __construct(){
		$this->model = new GBModel();
		$this->view = new GBView();
	}

	//точка входа
	public function index(){
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$this->post();
		}
		else {
			$this->page();
		}
	}

	//вывод страницы
	public function page($error = Array(), $lastdata = Array() ){
		$page = isset($_GET['page'])? intval($_GET['page']) : 1;
		if($page<=0)
			$page = 1;
		$sort_by = isset($_GET['sort'])? $_GET['sort'] : 'time';
		if($sort_by!='name' and $sort_by!='email' and $sort_by!='time')
			$sort_by = 'time';
		$dir = isset($_GET['dir'])? $_GET['dir'] : 'desc';
		if($dir!='asc' and $dir!='desc')
			$dir = 'desc';
		$list = $this->model->get_list($sort_by,$dir,self::POST_PER_PAGE*($page-1),self::POST_PER_PAGE);
		$post_count = $this->model->count();
		//массив $nav содержит информацию есть ли предыдущая и следующая страницы и номер текущей страницы
		$nav = Array( 
			'prev'=>($page>1),
			'next'=>($post_count > self::POST_PER_PAGE*$page),
			'page'=>$page );
		$this->view->show($list,$sort_by,$dir,$error,$lastdata,$nav);
	}

	//обработка сообщения
	public function post(){
		//получение полей и их первичная обработка
		$name = trim(htmlspecialchars($_POST['name']));
		$email = trim(htmlspecialchars($_POST['email']));
		$homepage = trim(htmlspecialchars($_POST['homepage']));
		$text = trim(htmlspecialchars($_POST['text']));
		//проверка на пустые значения
		$lastdata = Array(
			'name'=>$name,
			'email'=>$email,
			'homepage'=>$homepage,
			'text'=>$text);
		if(!$name){
			$this->page(Array('name'=>'Поле "Имя" обязательное!'),$lastdata);
			return;
		}
		if(!$email){
			$this->page(Array('email'=>'Поле "E-mail" обязательное!'),$lastdata);
			return;
		}
		if(!$text){
			$this->page(Array('text'=>'Сообщение не может быть пустое!'),$lastdata);
			return;
		}
		//проверка длины
		if(mb_strlen($name,"utf8")>25){
			$this->page(Array('name'=>'Максилум 25 символов!'.mb_strlen($name,"utf8")),$lastdata);
			return;
		}
		if(mb_strlen($email,"utf8")>100){
			$this->page(Array('email'=>'Слишком длинный E-mail!'),$lastdata);
			return;
		}
		if(mb_strlen($homepage,"utf8")>100){
			$this->page(Array('homepage'=>'Слишком длинный URL страницы!'),$lastdata);
			return;
		}
		//проверка на допустимые значения
		if(!preg_match('/^[0-9a-zA-Z]+$/',$name)){
			$this->page(Array('name'=>'Имя может состоять только из латинских букв и цифр.'),$lastdata);
			return;
		}
		if($homepage and !preg_match('/^(https?:\/\/)?([\w\.]+)\.([a-z]{2,6})(\/[\w\.]*)*\/?$/',$homepage)){
			$this->page(Array('homepage'=>'Неправильный URL.'),$lastdata);
			return;
		}
		if(!preg_match('/^.+@.+\..+$/',$email)){
			$this->page(Array('email'=>'Проверьте правильность ввода E-mail.'),$lastdata);
			return;
		}
		
		if($this->model->post($name,$email,$text,$homepage)){
			$this->page();
		}
		else {
			$this->page(Array('post'=>'Не удалось опубликовать сообщение.'),$lastdata);
		}
	}
}
?>