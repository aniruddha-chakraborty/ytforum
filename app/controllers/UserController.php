<?php


/**
* 
*/
Class UserController extends BaseController {
	
		//get the view page for register

		public function getCreate(){
			
				return View::make('user.register');
				//echo 'asdasd';
		}

		//get the view page for login

		public function getLogin(){

				echo "asd";

		}

		public function postCreate(){

			$validate = Validator::make(Input::all(),array(

						'username' => 'required|unique:users|min:4',
						'pass1'    => 'required|min:6',
						'pass2'    => 'required|same:pass1'

				));

			if ($validate->fails()) {
				# code...
					return Redirect::route('getCreate')->withErrors($validate)->withInput();
			}
		}

		public function postLogin(){


		}
	
}


?>