<?php
namespace areas\admin\validate;
use Dfer\DfPhpCore\Modules\Validate;

class LoginValidate extends Validate
{
		protected $rule = [
									'nm'    => 'require',
									'pw' => 'require'
					];
					protected $message = [
									'nm.require'    => 'Account cannot be empty',
									'pw.require' => 'Password cannot be empty'
					];

					protected $scene = [];
}
