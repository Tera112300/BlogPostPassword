<?php
class BlogPostPasswordsSchema extends CakeSchema {

	public $name = 'BlogPostPasswords';
	public $file = 'blog_post_passwords.php';

	public $connection = 'default';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $blog_post_passwords = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => 'ID'),
		'blog_post_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => 'ブログ記事ID'),
		'blog_content_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => 'ブログコンテンツID'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'comment' => 'パスワード名'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '更新日'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '作成日'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'blog_post_id' => array('column' => 'blog_post_id', 'unique' => 0),
			'blog_content_id' => array('column' => 'blog_content_id', 'unique' => 0)
		),
	);
}
