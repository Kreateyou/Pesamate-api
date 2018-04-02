<?php

return [

  'credentials'=>[
  	'login'                  =>env("PESAMATE_LOGIN",""),
  	'password'               =>env("PESAMATE_PASSWORD",""),
  ],
  'auth'=>[
   'token'                   =>env("PESAMATE_TOKEN",""),
   'secret'                  =>env("PESAMATE_SECRET",""),

  ],
  'token_session_model'      =>env("PESAMATE_TOKEN_SESSION_MODEL","Pesamate\Laravel\Models\Session"),
  'default_account'          =>env("PESAMATE_DEFAULT_ACCOUNT",""),
  'onReceivePayment'         =>env("PESAMATE_DEFAULT_CALLBACK_FN",""),

];