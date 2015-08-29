<?php


Class ForumTableSeeder Extends Seeder{

		public function run(){

				ForumGroup::create([

						'title' 	=> 'General Discussion',
						'author_id' => 1

					]);
				ForumCategory::create([

						'group_id'  => 1,
						'title' 	=> 'Test Category 1',
						'author_id' => 1

					]);
				ForumCategory::create([
						'group_id'  => 1,
						'title' 	=> 'Test Category 2',
						'author_id' => 1

					]);

		}

}