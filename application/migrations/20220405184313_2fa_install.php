<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Migration_2fa_install extends MY_Migration 
	{

	    public function up() 
			{
				$this->execute_sql(realpath(dirname(__FILE__).'/'.'20220405184313_2fa_install.sql'));
	    }

	    public function down() 
			{
	    }

	}