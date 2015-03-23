```php

$form = new PHPForms();
$row = new PHPForms::Row();
$password_field = new PHPForms::PasswordField();

$row->addInput($password_field);
$form->addRow($row);

$form->to_s();
//<form method='GET'><input type='password'></form>

$form->to_p();
//<form method='GET'><p><input type='password'></p></form>

$form->to_ul();
//<form method='GET'><ul><li><input type='password'></li></ul></form>
```