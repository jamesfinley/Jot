<?php

class JotFormTestCase extends UnitTestCase
{
	public function __construct()
	{
		$this->load->model(array('blogs_model', 'articles_model', 'pages_model'));
	}
	
	public function test_form_open()
	{
		$blog = $this->blogs_model->build(array(
			'name' => 'Blog #2',
			'slug' => 'blog' 
		));
		
		$html = form_for($f, $blog, 'http://example.com');
		$expects = '<form action="http://example.com" accept-charset="utf-8" method="POST">';
		
		$this->assertEquals(htmlentities($expects), htmlentities($html), 'Form open tag');
	}
	
	public function test_checkbox()
	{
		$blog = $this->blogs_model->build(array(
			'name' => 'Blog #2',
			'slug' => 'blog' 
		));
		
		form_for($f, $blog, 'http://example.com');
		
		// Without Attributes
		$html = $f->check_box('name');	
		$expects = '<input type="checkbox" name="blog[name]" value="1" id="blog_name_field"  />'."\n".'<input type="hidden" name="blog[name]" value="0" />'."\n";
		
		$this->assertEquals(htmlentities($expects), htmlentities($html), 'Checkbox tag (no attributes)');

		// With Attributes
		$html = $f->check_box('name', array('class'=>'test'));	
		$expects = '<input type="checkbox" name="blog[name]" value="1" class="test" id="blog_name_field"  />'."\n".'<input type="hidden" name="blog[name]" value="0" />'."\n";
		
		$this->assertEquals(htmlentities($expects), htmlentities($html), 'Checkbox tag (attributes)');
	}
	
	public function test_file_field()
	{
		$blog = $this->blogs_model->build(array(
			'name' => 'Blog #2',
			'slug' => 'blog' 
		));
		
		form_for($f, $blog, 'http://example.com');
		
		$html = $f->file_field('name');
		$expects = '<input type="file" name="blog[name]" value="" id="blog_name_field"  />';
		
		$this->assertEquals(htmlentities($expects), htmlentities($html), 'File field');		
	}
	
	public function test_hidden_field()
	{	
		$blog = $this->blogs_model->build(array(
			'name' => 'Blog #2',
			'slug' => 'blog' 
		));
		
		form_for($f, $blog, 'http://example.com');
		
		$html = $f->hidden_field('name');
		$expects = '<input type="hidden" name="blog[name]" value="Blog #2" />';
		
		$this->assertEquals(htmlentities($expects), trim(htmlentities($html)), 'Hidden field');		
	}
}