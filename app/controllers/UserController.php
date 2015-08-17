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

				return View::make('user.login');

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
				
				} else {

				$user = new User();
				$user->username = Input::get('username');
				$user->password = Hash::make(Input::get('pass1'));

				if ($user->save()) {
					# code...
					return Redirect::route('home')->with('success','You Register');

				} else {

					return Redirect::route('home')->with('fail' , 'A Error Occured'	);
				}
			}
		}

		public function postLogin(){

				$validate = Validator::make(Input::all(),array(

						'username' => 'required',
						'password' => 'required'

					));

				if ($validate->fails()) {
					# code...
						return 
				}
		}
	
}


?>