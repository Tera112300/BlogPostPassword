<?php
class BlogPostPassword extends AppModel
{
    public $name = 'BlogPostPassword';
    public $plugin = 'BlogPostPassword';
    public $belongsTo = [
        'BlogPost' => [
			'className' => 'Blog.BlogPost',
			'foreignKey' => 'blog_post_id'
		]
    ];
    public $validate = [
		'name' => [
			['rule' => ['alphaNumericPlus'],'message' => 'パスワードは半角英数字、ハイフン、アンダースコアのみが利用可能です。'],
			['rule' => ['minLength', 5],'message' => 'パスワードは5文字以上で入力してください。'],
			['rule' => ['maxLength', 230],'message' => 'パスワードは230文字以内で入力してください。'],
		]
	];
}