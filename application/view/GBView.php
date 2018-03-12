<?php

class GBView {
	
	public function show($post_list,$sort_by = 'time',$dir = 'desc',
						$error = Array(),$lastdata = Array(),
						$nav = Array('prev'=>false,'next'=>false,'page'=>1)) {
		
		$html = '<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Гостевая книга</title>
	<link rel="stylesheet" type="text/css" href="/css/gb.css">
</head>
<body>
	<div class="gb">
	<h1>Гостевая книга</h1>
	<div class="post-form">
		<form action="guestbook.php" method="post">';
		//форма ввода
		if(isset($error['post'])) 
			$html .= '<p><span class="error">'.$error['post'].'!</span></p>';
		$html .=  '<p><span class="label">Ваше имя </span><input type="text" name="name" placeholder="Как Вас представить" ';
		$html .=  isset($lastdata['name'])?('value="'.$lastdata['name'].'" >'):'>';
		if(isset($error['name'])) 
			$html .= '<span class="error">'.$error['name'].'!</span>';
		$html .= '</p><p><span class="label">E-mail </span><input type="email" name="email" placeholder="Введите Ваш email" ';
		$html .=  isset($lastdata['email'])?('value="'.$lastdata['email'].'" >'):'>';
		if(isset($error['email'])) 
			$html .= '<span class="error">'.$error['email'].'!</span>'; 
		$html .= '</p><p><span class="label">Личный сайт </span><input type="text" name="homepage" placeholder="необязательное поле" ';
		$html .=  isset($lastdata['homepage'])?('value="'.$lastdata['homepage'].'" >'):'>';
		if(isset($error['homepage'])) 
			$html .= '<span class="error">'.$error['homepage'].'!</span>'; 
		$html .= '</p><textarea name="text" placeholder="Введите текст сообщения." >';
		$html .=  isset($lastdata['text'])?$lastdata['text'].'</textarea>':'</textarea>';
		if(isset($error['text'])) 
			$html .= '<p><span class="error">'.$error['text'].'</span></p>'; 
		$html .= '<p><input type="submit" value="Отправить"></p></form>
	</div>
	<div class="menu">
		<div class="nav">';
		//навигация по страницам: предыдущая/следующая
		if($nav['prev']){
			$html .= '<a href="guestbook.php?page='.($nav['page']-1).
				'&sort='.$sort_by.'&dir='.$dir.'">&lt;</a>';
		}
		if($nav['next']){
			$html .= '<a href="guestbook.php?page='.($nav['page']+1).
				'&sort='.$sort_by.'&dir='.$dir.'">&gt;</a>';
		}

		$html .= '</div><div class="sort">Сортировать ';
		//$sort_by содержит текущую сортировку
		//$dir содержит текущее направление сортировки
		$sort_types = Array('name'=>'по имени','email'=>'по e-mail','time'=>'по дате');
		foreach($sort_types as $type => $text){
			$html .= '<a href="guestbook.php?page=1&sort='.$type.'&dir='.$dir.'" '.
				(($type==$sort_by)?'class="active">':'>').$text.'</a>';
		}
		$html .= '<a href="guestbook.php?page=1&sort='.$sort_by.'&dir=asc" '.
				(($dir=='asc')?'class="active dir">':'class="dir">').'по возростанию</a>';
		$html .= '<a href="guestbook.php?page=1&sort='.$sort_by.'&dir=desc" '.
				(($dir=='desc')?'class="active dir">':'class="dir">').'по убыванию</a>';
		$html .= 
		'</div>
	</div>
	<div class="list">';
		//$post_list содержит объект mysqli_result с текущей страницей
		//или FALSE если данные не были получены
		if($post_list){
			$html .= '<table>';
			while($row=$post_list->fetch_assoc()){
				$html .= '<tr><td><span class="date">'.$row['post_time'].'</span><br>'.
					'<span class="name">'.$row['user_name'].'</span><br>'.
					'<span class="email"><small>email:</small> '.$row['email'].'</span></td>';
				$html .= '<td>'.$row['post_text'].'</td></tr>';
				
			}
			$html .= '</table>';
		}
		$html .= 	
	'</div>
	</div>
	<a class ="footer" href="index.php">На главную</a>
</body>';
		
		echo $html;
	}
}
?>