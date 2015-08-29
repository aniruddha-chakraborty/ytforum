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

			$threads = $category->threads()->get();
			return View::make('forum.category')->with('category',$category)->with('threads',$threads);

		}

		public function thread($id){

			$thread = ForumThread::find($id);

				if ($thread == null) {
					# code...
					return Redirect::route('forum-home')->with('fail',"the thread doesn't exists");
				}

			$author = $thread->author()->first()->username;

			return View::make('forum.thread')->with('thread',$thread)->with('author',$author);
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

		public function deleteCategory($id){

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

					'category_name'  => 'required|unique:forum_categories,title'
				]);

			if ($validator->fails()) {
				# code...
					return Redirect::route('forum-home')->withInput()->withErrors($validator)->with('category-modal','#category_modal')->with('group-id',$id);

			} else {

				$group = ForumGroup::find($id);

					if ($group == null) {
						# code...
						return Redirect::route('forum-home')->with('fail',"That Group Doesn't exists");;

							} else {

						$category 			 = new ForumCategory;
						$category->title 	 = Input::get('category_name');
						$category->author_id = Auth::user()->id;
						$category->group_id  = $id;

					if ($category->save()) {
						# code...
						return Redirect::route('forum-home')->with('success' , 'The category was Created.');

					  } else {

					  	return Redirect::route('forum-home')->with('fail','An Error occured while saving the new category');
					}

				}
			}

		}

		public function newThread($id){

				return View::make('forum.newthread')->with('id',$id);
		}


		public function storeThread($id){

			$category = ForumCategory::find($id);

				if ($category == null) {
					# code...
					Redirect::route('forum-get-new-thread')->with('fail',"You posted to an invalid category");
					
					}
				$validator = Validator::make(Input::all() , [

						'title' => 'required|min:3|max:255',
						'body'  => 'required|min:10|max:65000'

					]);

				if ($validator->fails()) {
					# code...
					return Redirect::route('forum-get-new-thread' , $id)->withInput()->withErrors($validator)->with('fail','Your input doesnt match requirement');
					
					} else {

					$thread 			 = new ForumThread;
					$thread->title 		 = Input::get('title');
					$thread->body  		 = Input::get('body');
					$thread->category_id = $id;
					$thread->group_id  	 = $category->group_id;
					$thread->author_id   = Auth::user()->id;

						if ($thread->save()) {
							# code...
								return Redirect::route('forum-thread',$thread->id)->with('success','Your Thread has been save');

							} else {

								return Redirect::route('forum-get-new-thread',$id)->with('fail','An error occured while saving your thread')->withInput();

						}
				}
		}

		public function deleteThread($id){

			$thread = ForumThread::find($id);

				if ($thread == null) {
					# code...
					return Redirect::route('forum-home')->with('fail',"That Thread Doesn't exists");
				}

			$category_id = $thread->category_id;
			$comments    = $thread->comments;

				if ($comments->count() > 0) {
					# code...
						if ($comments->delete() && $thread->delete()) {
							# code...
								return Redirect::route('forum-category',$category_id)->with('success'," Thread is now deleted ");
						} else {

								return Redirect::route('forum-category',$category_id)->with('fail'," there was a problem while deleting");
						}

				} else {

						if ($thread->delete()) {
							# code...
								return Redirect::route('forum-category',$category_id)->with('success'," Thread is now deleted ");
						} else {

								return Redirect::route('forum-category',$category_id)->with('fail'," there was a problem while deleting");
						}

				}
		}

		public function storeComment($id){

			$thread = ForumThread::find($id);

			if ($thread == null) {
				# code...
				return Redirect::route('forum-thread',$id)->with('fail',"There is nothing to do with this");
			}

			$validator = Validator::make(Input::all(),[

						'comment' => 'required|min:4|max:65000'
				]);

			if ($validator->fails()) {
				# code...
					return Redirect::route('forum-thread',$id)->withInput()->withErrors($validator)->with('fail',"please fix these errors");

			} else {

					$comment = new ForumComment();
					$comment->body = Input::get('comment');
					$comment->author_id = Auth::user()->id;
					$comment->thread_id = $id;
					$comment->category_id = $thread->category_id;
					$comment->group_id = $thread->group->id;

						if ($comment->save()) {
							# code...
								return Redirect::route('forum-thread',$id)->with('success',"The comment is saved");
						} else {

								return Redirect::route('forum-thread',$id)->with('fail',"An error occured while saving");
						}
			}
		}

		public function deleteComment($id){

				$comment = ForumComment::find($id);
				$threadId = $comment->thread_id;

					if ($comment == null) {
							# code...
						Redirect::route('forum-home')->with('fail',"The comment is not Available anymore");
					}

				if ($comment->delete()) {
					# code...
						return Redirect::route('forum-thread',$threadId)->with('success',"Comment has been successfully deleted");
					
					} else {

						return Redirect::route('forum-thread',$threadId)->with('fail',"Something went wrong while deleting");
				}

		}

}