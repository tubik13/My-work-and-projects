# RegistrationForm
Форма регистрации и авторизации пользователя, MySQL, JS, PHP, AJAX.

<p>После копирования на сервер директории registration-form, форма будет доступна по ссылке <i><название сайта>/registration-form</i>. Также файлы с директории registration-form можно положить куда угодно на сервер, и форма будет доступна по соответствующей ссылке. Т.е. форма не завязана по абсолютному пути.</p>

<br/><b>db.sql</b> - дамп базы данных mysql.<br/>

<h3>Структура файлов:</h3>
<b>css/</b> - файлы стилей <br/>
  <i>reset.css</i> - сбрасывает все стандартные стили элементов <br/>
  <i>style.css</i> - главный файл стилей формы и страницы пользователя <br/>
<b>img/ico</b> - используемые пиктограммы <br/>
<b>js/</b> - java script файлы <br/>
  <i>main.js</i> - содержит javascript управления регистрационной формой <br/>
<b>php/language/</b> - файлы содержащие языковые конфиги <br/>
<i>en.php</i>, <i>ru.php</i> - английский и русский конфиги, соотвтетственно, состоят из ассоциативного массива, описывающего выводимые надписи на странице. <br/>
<b>model/</b> - файлы обработки данных<br/>
  <i>validation.php</i> - файл содержит класс, который проверяет введенные пользователем данные в регистрационной форме, и взводит флаги ошибок, в случае если что-то введено неверно, также, здесь же происходит обработка введенных данных.</br>
  <i>Database.php</i> - абстрактный класс для работы с базой данных.</br>
  <i>MyDatabase.php</i> - класс, наследуемый от Database, содержит методы для работы с базой данных mydb<br/>
<b>view/</b> - файлы отображения<br/>
  <i>header.php</i> - заголовочный файл, содержит доктайп, тайтл, подключение стилей.<br/>
  <i>lang-switch.php</i> - файл содержит переключатель языка.<br/>
  <i>registration-form.php</i> - формы регистрации и авторизации.<br/>
  <i>user.php</i> - страница пользователя.<br/>
  <i>footer.php</i> - подвал сайта.<br/>
<b>uploads/img</b> - файлы с изображениями пользователей.<br/>
<hr/>
<i>index.php</i> - главный файл, который выводит на страницу необходиымую информацию.<br/>
<i>register.php</i> - скрипт обработки регистрации.<br/>
<i>auth.php</i> - скрипт авторизации.<br/>
<i>city.php</i> - скрипт вывода списка городов из базы данных.<br/>
