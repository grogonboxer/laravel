<?php

namespace App\Dpjmodule;

interface iModule{
	public function resend($method,$header,$all,$url);
}
