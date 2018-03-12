<?php
//класс модели "Гостевая книга"
//обеспечивает доступ к списку сообщений
//и возможность добавлять новые сообщения
class GBModel {

	//поля для подключения к базе данных
	private static $host = "localhost";
	private static $user = "root"; 
	private static $password = "";
	private static $db_name = "test";
	//имя рабочей таблицы
	private static $table_name = "guest_book";
	//объект для внутреннего управление подключением
	private $connection = null;
	//ошибка в последней операции
	private $error = "";

	//обработка ошибки (для отладки и администрирования)
	private function error($etext){
		$error = $etext;
		//die($error);
		//TODO запись ошибки в лог
	}
	
	//подключение к БД, возвращает TRUE если нет ошибок
	private function connect() {
		$this->connection = new mysqli(self::$host, self::$user, self::$password, self::$db_name);
		if($this->connection->connect_error){
			$this->error("Ошибка подключения к базе данных: " . $this->connection->connect_error);
			return false;
		}
		return true;
	}
	
	//выполнить SQL запрос, возвращает результат или FALSE при ошибке
	private function sql($query) {
		if($this->connection and !$this->connection->connect_error){
			$result = $this->connection->query($query);
			if(!$result){
				$this->error("Ошибка выполнения запроса: " . $this->connection->error);
				return false;
			}
			return $result;
		}
		else {
			$this->error( ($this->connection) ? 
				"Запрос не возможен : " . $this->connection->connect_error : 
				"Нет соединения с базой данных" );
			return false;
		}
	}
	
	//закрыть соединение с БД
	private function disconnect() {
		if($this->connection)
			$this->connection->close();
	}

	function __construct(){
		$this->connection = new mysqli(self::$host, self::$user, self::$password);
		$query = 'CREATE DATABASE IF NOT EXISTS '. 
				self::$db_name .' CHARACTER SET utf8 COLLATE utf8_general_ci';
		if(!$this->sql($query)){
				$this->error("Ошибка инициализации таблицы.");
				return;
			}
		$this->connection->select_db(self::$db_name);
		$query = 
'CREATE TABLE IF NOT EXISTS '. self::$table_name .' (
id INT(11) NOT NULL AUTO_INCREMENT,
user_name VARCHAR(25) NOT NULL,
email VARCHAR(100) NOT NULL,
homepage VARCHAR(100) NOT NULL,
post_text TEXT NOT NULL,
ip INT(11) NOT NULL,
user_agent VARCHAR(255) NOT NULL,
post_time DATETIME NOT NULL,
PRIMARY KEY(id)
) ENGINE = InnoDB';
		if(!$this->sql($query)){
			$this->error("Ошибка инициализации таблицы.");
		}
		$this->disconnect();
		
	}

//ИНТЕРФЕЙС МОДЕЛИ

	//получить список из $count сообщений начиная после $offset
	//сортировка по $sort_by (NAME | EMAIL | TIME) в направлении $dir (ASC | DESC)
	//если $count==0 вывод всего списка
	public function get_list($sort_by = "time", $dir = "desc", $offset = 0, $count = 0){
		if($this->connect()) {
			//проверка сортировки
			$sort_by = strtolower($sort_by);
			switch($sort_by){
				case "name": $sort_by = "user_name"; break;
				case "email": break;
				case "time": $sort_by = "post_time"; break;
				default: 
					$sort_by = "post_time";
			}
			$dir = strtoupper($dir);
			//проверка направления сортировки
			if($dir!="ASC" and $dir!="DESC"){
				$dir = "DESC";
			}
			
			$query = "SELECT * FROM ".self::$table_name." ORDER BY $sort_by $dir";
			if($count > 0){
				$query .= " LIMIT $offset, $count";
			}
			$result = $this->sql($query);
			$this->disconnect();
			return $result;
		}
	}
	
	//новое сообщение от пользователя
	public function post($name,$email,$text,$homepage = "") {
		if($this->connect()){
			//экранирование возможных опасных символов
			$name = $this->connection->real_escape_string($name);
			$email = $this->connection->real_escape_string($email);
			$text = $this->connection->real_escape_string($text);
			$homepage = $this->connection->real_escape_string($homepage);
			//текущие время и дата
			$dateTime = new DateTime('now',new DateTimeZone('Europe/Moscow'));
			$time = $dateTime->format("Y-m-d H-i-s");
			//IP адрес клиента
			$ip = ip2long($_SERVER['REMOTE_ADDR']);
			//информация о браузере
			$user_agent = $this->connection->real_escape_string($_SERVER['HTTP_USER_AGENT']);
			$query = "INSERT INTO ". self::$table_name .
				" (user_name,email,homepage,post_text,ip,user_agent,post_time) VALUES " .
				"('$name','$email','$homepage','$text',$ip,'$user_agent','$time')";
			$result = $this->sql($query);
			$this->disconnect();
			//вернуть TRUE при успешной вставке
			return $result;
		}
		return false;
	}
	//количество сообщений в базе
	public function count(){
		if($this->connect()){
			$result = $this->sql("SELECT COUNT(*) AS num FROM ".self::$table_name);
			$this->disconnect();
			if($result)
				return intval($result->fetch_assoc()['num']);
		}
		return 0;
	}
}
?>