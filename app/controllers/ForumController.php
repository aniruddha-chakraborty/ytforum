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

			$category = ForumCategory::find($id);

				if ($category == null) {
					# code...
					Redirect::route('forum-home')->with('fail',"that category doesn't exists");;
				
				}

			$threads = $category->threads();
			return View::make('forum.category')->with('category',$category)->with('threads',$threads);

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

					$categories = $group->categories();
					$threads    = $group->threads();
					$comments   = $group->comments();
						
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

		public function deleteCategory(){

			$category = ForumCategory::find($id);

				if ($category == null) {
					# code...
						Redirect::route('forum-home')->with('fail','That category Doesn\'t exists');
				} else {

					$threads    = $category->threads();
					$comments   = $category->comments();
						
						$delT   = true;
						$delCo  = true;
						

						if ($threads->count() > 0) {
							# code...
								$threads->delete();
						}

						if ($comments->count() > 0) {
							# code...
								$comments->delete();
						}
						

						if ($delT && $delCo && $category->delete()) {
							# code...
							return Redirect::route('forum-home')->with('success' , 'The category was deleted ');

						} else {

							return Redirect::route('forum-home')->with('fail','An error occured while the category');
						}
				}

		}

		public function storeCategory($id){

			$validator = Validator::make(Input::all(),[

					'category_name'  => 'required|unique:forum_groups,title'
				]);

			if ($validator->fails()) {
				# code...
					return Redirect::route('forum-home')->withInput()->withErrors($validator)->with('modal','#group_form');

			} else {

				$group = ForumGroup::find($id);

					if ($group == null) {
						# code...
						return Redirect::route('forum-home')->with('fail',"That Group Doesn't exists");;

							} else {


				$category = new ForumCategory;
				$category->title = Input::get('category_name');
				$category->author_id = Auth::user()->id;
				$category->group_id = $id;

					if ($category->save()) {
						# code...
						return Redirect::route('forum-home')->with('success' , 'The category was Created.');

					  } else {

					  	return Redirect::route('forum-home')->with('fail','An Error occured while saving the new category');
					}

						}
			}

		}

		
}