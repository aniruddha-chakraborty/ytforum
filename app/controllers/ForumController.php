<?php

/**
* 
*/
Class ForumController extends BaseController{
	
		public function index(){
			$groups 	= ForumGroup::all();
			$categories = ForumCategory::all();
			return View::make('forum.index')->with('groups',$groups)->with('categories',$categories);

		}

		public function category($id){



		}

		public function thread($id){


		}

		public function storeGroup(){

			$validator = Validator::make(Input::all(),[

					'group_name'  => 'required|unique:forum_groups,title'
				
				]);

			if ($validator->fails()) {
				# code...
					return Redirect::route('forum-home')->withInput()->withErrors($validator)->with('modal','#group_form');

			} else {

				$group = new ForumGroup;
				$group->title = Input::get('group_name');
				$group->author_id = Auth::user()->id;

					if ($group->save()) {
						# code...
						return Redirect::route('forum-home')->with('success' , 'The Group was Created.');

					  } else {

					  	return Redirect::route('forum-home')->with('fail','An Error occured while saving the new group');
					}
			}
		}


		public function deleteGroup($id){

			$group = ForumGroup::find($id);

				if ($group == null) {
					# code...
						Redirect::route('forum-home')->with('fail','That Group Doesn\'t exists');
				} else {

					$categories = ForumCategory::where('group_id',$id);
					$threads    = ForumThread::where('group_id',$id);
					$comments   = ForumComment::where('group_id',$id);
						
						$delCa  = true;
						$delT   = true;
						$delCo  = true;
						

						if ($categories->count() > 0) {
							# code...
								$categories->delete();
						}

						if ($threads->count() > 0) {
							# code...
								$threads->delete();
						}

						if ($comments->count() > 0) {
							# code...
								$comments->delete();
						}
						

						if ($delCa && $delT && $delCo && $group->delete()) {
							# code...
							return Redirect::route('forum-home')->with('success' , 'The Group was deleted ');

						} else {

							return Redirect::route('forum-home')->with('fail','An error occured while the group');
						}
				}

		}
}