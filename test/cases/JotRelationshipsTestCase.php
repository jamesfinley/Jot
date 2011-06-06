<?php

class JotRelationshipsTestCase extends UnitTestCase
{
	public function __construct()
	{
		$this->load->database();
		$this->load->dbutil();
		
		$this->load->model(array('blog_model', 'article_model', 'page_model'));
	}
	
	public function setup()
	{
		$this->db->truncate('blogs');
		$this->db->truncate('articles');	
		$this->db->truncate('pages');	
	}
	
	public function test_has_one_relationship()
	{
		$blog = $this->blog_model->create(array(
			'name' => 'Blog',
			'slug' => 'blog'
		));
		
		$page = new Page_Model(array(
			'name' => 'Page Name',
			'description' => 'Lorem ipsum dolor sit amet...'
		));
						
		$blog->page = $page;
		
		$page->save();

		$this->assertTrue(@$blog->page, 'Association exists');
		$this->assertEquals('Lorem ipsum dolor sit amet...', @$blog->page->description, 'Contents should be correct');
	}

	public function test_belongs_to_relationship()
	{
		$page = $this->page_model->create(array(
			'name' => 'Page',
			'slug' => 'page' 
		));
				
		$blog = new Blog_Model(array(
			'name' => 'blog',
			'slug' => 'blog'
		));	
		$blog->save();

		$blog2 = new Blog_Model(array(
			'name' => 'blog2',
			'slug' => 'blog2'
		));	
		$blog2->save();

		$page->blog = $blog2;

		$this->assertEquals('blog2', $page->blog->name, 'Names should be the same');
		$this->assertEquals('blog2', $page->blog->slug, 'Slugs should be the same');	
		
	}
	
	public function test_chained_relationships()
	{
		$page = $this->page_model->create(array(
			'name' => 'Page',
			'slug' => 'Slug'
		));

		$this->assertTrue($page, 'Page should exist');
		
		$blog = $page->create_blog(array(
			'name' => 'Blog',
			'slug' => 'blog'
		));
		
		$this->assertTrue($blog, 'Blog should exist');

		// $article = $blog->articles->create(array(
		// 	'title' => 'test',
		// 	'contents' => 'testing the article'
		// ));	
		// 				
		// $this->assertTrue($article, 'Article should exist');
		// 
		// $this->assertEquals('Page', $article->blog->page->name, 'Page name is correct');	
	}

	// 	
	// 	public function test_has_many_relationship()
	// 	{	
	// 		$blog = $this->blog_model->create(array(
	// 			'name' => 'Blog #2',
	// 			'slug' => 'blog' 
	// 		));
	// 		
	// 		$article = $blog->articles->create(array(
	// 			'title' => 'Article Title',
	// 			'contents' => 'Testing'
	// 		));
	// 		
	// 		$this->assertEquals('blog', $article->blog->slug, 'Slugs should be the same');
	// 		$this->assertEquals('Blog #2', $article->blog->name, 'Names should be the same');
	// 		
	// 		$article = $this->articles_model->first();
	// 		$this->assertEquals('blog', $article->blog->slug, 'Slug should be the correct');
	// 		
	// 		$article2 = $blog->articles->create(array(
	// 			'title' => 'Article Title 2',
	// 			'contents' => 'Testing'
	// 		));
	// 		
	// 		$this->assertEquals(2, count($blog->articles->all()), 'Correct number of articles returned');
	// 	}
	// 	
}