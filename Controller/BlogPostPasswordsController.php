<?php
App::uses('SimplePasswordHasher','Controller/Component/Auth');

class BlogPostPasswordsController extends AppController
{
	public $components = Array('Cookie');
	// public $autoRender = false;

	public function password_check($blogContentId = 0, $blogPostId = 0)
	{
		$blog_data = $this->BlogPostPassword->find('first',[
		'conditions' => [
		'BlogPostPassword.blog_content_id' => $blogContentId,
		'BlogPostPassword.blog_post_id' => $blogPostId,
		]
		]);
	

		$PostPassword_settings = Configure::read("PostPassword_settings");
		

		//blogContentIdsが空もしくは指定のidのときは何もしない
		empty($PostPassword_settings["blogContentIds"]) || in_array($blogContentId,$PostPassword_settings["blogContentIds"],true) ? "" : $this->notFound();



		if(empty($this->request->data["BlogPostPassword"]["name"]) || empty($blog_data["BlogPostPassword"]["name"])){
			$this->notFound();
		}else{
			if($this->request->data["BlogPostPassword"]["name"] === $blog_data["BlogPostPassword"]["name"]){
				//記事データのパスワードと一致しているときはパスワードをハッシュ化してクッキーに保存
				$passwordHasher = new SimplePasswordHasher();
				$this->Cookie->write('bc-postpass_'.BCCOOKIEHASH, $passwordHasher->hash($blog_data["BlogPostPassword"]["name"]), false,$PostPassword_settings["expiration"]);
			}else{
				$this->ajaxError(403,'パスワードが一致していません。再度ご入力ください。');
				// throw new ForbiddenException('パスワードが一致していません');
			}
		}
	}
	
}