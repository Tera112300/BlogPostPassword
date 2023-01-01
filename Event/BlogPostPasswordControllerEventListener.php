<?php

class BlogPostPasswordControllerEventListener extends BcControllerEventListener
{
	public $components = Array('Cookie');
	/**
	 * 登録イベント
	 *
	 * @var array
	 */
	public $events = [
		'Blog.Blog.beforeRender',
		'Blog.BlogPosts.beforeRender',
    ];
	public $PasswordFormHelper;

	public function blogBlogBeforeRender(CakeEvent $event) {
		$Controller = $event->subject();
		$PostPassword_settings = Configure::read("PostPassword_settings");
		
		$blog_content_id = $Controller->viewVars["post"]["BlogPost"]["blog_content_id"];
		if(
		$Controller->viewVars["single"] && !empty($Controller->viewVars["post"]["BlogPostPassword"]["name"]) &&
		(empty($PostPassword_settings["blogContentIds"]) || in_array($blog_content_id,$PostPassword_settings["blogContentIds"],true)) 
		 ){
			//詳細かつパスワードが設定されているとき
			$post_id = $Controller->viewVars["post"]["BlogPost"]["id"];
			
			App::uses('SimplePasswordHasher','Controller/Component/Auth');
			$passwordHasher = new SimplePasswordHasher();
			
			if($Controller->Cookie->read('bc-postpass_'.BCCOOKIEHASH) != $passwordHasher->hash($Controller->viewVars["post"]["BlogPostPassword"]["name"])){
				//ハッシュ化して確認
				App::uses('PasswordFormHelper', 'Plugin/BlogPostPassword/View/Helper');
	
				$this->PasswordFormHelper = new PasswordFormHelper(new View());
				$Controller->viewVars["post"]["BlogPost"]["detail"] = $this->PasswordFormHelper->createForm($blog_content_id,$post_id);
			}
		}
	}
	public function blogBlogPostsBeforeRender(CakeEvent $event) {
        // ビューに文字列を渡す
        $Controller = $event->subject();
        $Controller->set('blog_pass_status', !empty($Controller->data["BlogPostPassword"]["name"]) ? 1 : 0);
    }
}
