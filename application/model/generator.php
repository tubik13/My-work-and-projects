<?php
	require_once "GBModel.php";

	$count = 70;
	$min_len = 20;
	$max_len = 200;
	$post = "Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit, amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt, ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit, qui in ea voluptate velit esse, quam nihil molestiae consequatur, vel illum, qui dolorem eum fugiat, quo voluptas nulla pariatur? At vero eos et accusamus et iusto odio dignissimos ducimus, qui blanditiis praesentium voluptatum deleniti atque corrupti, quos dolores et quas molestias excepturi sint, obcaecati cupiditate non provident, similique sunt in culpa, qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.";
	$users = Array('Jacob','Emily','Michael','Emma','Joshua','Madison','Matthew', 'Olivia','Ethan','Hannah','Andrew','Abigail','Daniel','Isabella','William','Ashley','Joseph','Samantha','Christopher','Elizabeth','Anthony','Alexis','Ryan','Sarah','Nicholas','Grace','David','Alyssa','Alexander','Sophia','Tyler','Lauren','James','Brianna','John','Kayla','Dylan','Natalie');
	$hosts = Array('example.com','website.net','somewhere.com','google.com','php.net');

	$model = new GBModel();

	for($i=0 ; $i<$count; $i++){
		$num = rand(0,count($users)-1);
		$name = $users[$num];
		$email = $name . '@' . $hosts[$num % count($hosts)];
		$homepage = ($num % 3 === 0) ? $hosts[$num % count($hosts)] : '';
		$text = substr($post,rand(0,strlen($post)- $max_len-1), rand($min_len,$max_len));
		$model->post($name,$email,$text,$homepage);
		usleep(100); //задержка 0.1 сек
	}
	header("Location: /guestbook.php");
?>