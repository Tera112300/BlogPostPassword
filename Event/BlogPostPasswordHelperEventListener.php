<?php

class BlogPostPasswordHelperEventListener extends BcHelperEventListener
{
    public $events = [
		'BcFormTable.before'
	];
	
    public function bcFormTableBefore(CakeEvent $event)
	{	
        //管理システム以外なら出力なし
		if (!BcUtil::isAdminSystem()) {
			return true;
		}
		$View = $event->subject();
		if ($View->request->params['controller'] !== 'blog_posts') {
			return true;
		}

        //新規追加編集以外
		if (!in_array($View->request->params['action'], ['admin_edit', 'admin_add'])) {
			return true;
		}

		if ($event->data['id'] !== 'BlogPostForm') {
			return true;
		}
		

		if(empty(Configure::read("PostPassword_settings")["blogContentIds"]) || in_array($View->request->params["Content"]["entity_id"],Configure::read("PostPassword_settings")["blogContentIds"],true)){
			//なければ、どのコンテンツタイプでも表示
			$event->data['out'] .= $View->element('BlogPostPassword.admin/blog_post_password_form', ['model' => 'BlogPost']);
		}
		
		return true;
	}
}