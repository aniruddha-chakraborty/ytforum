<?php

/**
* 
*/
class ForumThread extends Eloquent {
	
	protected $table = 'forum_threads';


	public function group(){

		return $this->belongsTo('ForumGroup');
	}

	public function category(){

		return $this->belongsTo('ForumCategory');
	}
	

	public function comments(){

			return $this->hasMany('ForumComment','thread_id');
	}
	
	public function author(){

			return $this->hasOne('User','id' , 'author_id');
	}
}