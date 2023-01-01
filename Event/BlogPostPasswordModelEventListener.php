<?php

class BlogPostPasswordModelEventListener extends BcModelEventListener
{

	/* 登録イベント */
	public $events = [
		'Blog.BlogPost.beforeFind',
		'Blog.BlogPost.beforeValidate',
		'Blog.BlogPost.afterSave',
	];

	/**
	 * blogBlogPostBeforeFind
	 *
	 * @param CakeEvent $event
	 */
	public function blogBlogPostBeforeFind(CakeEvent $event)
	{
		$Model = $event->subject();
	
		// ブログ記事取得の際に情報も併せて取得する
		$Model->bindModel(['hasOne' => [
			'BlogPostPassword' => [
				'className' => 'BlogPostPassword.BlogPostPassword',
				'foreignKey' => 'blog_post_id'
			]
		]]);
	}

	/**
	 * blogBlogPostBeforeValidate
	 *
	 * @param CakeEvent $event
	 * @return boolean
	 */
	public function blogBlogPostBeforeValidate(CakeEvent $event)
	{
		$Model = $event->subject();
		$BlogPostPassword = ClassRegistry::init('BlogPostPassword.BlogPostPassword');
		// ブログ記事保存の手前で BlogPostPassword モデルのデータに対して validation を行う
		$BlogPostPassword->set($Model->data);
		if (!isset($Model->data['BlogPostPassword']) || !$Model->data['BlogPostPassword']['name']) {
			unset ($BlogPostPassword->validate["name"]);
		}
		return $BlogPostPassword->validates();
	}

	/**
	 * blogBlogPostAfterSave
	 * - ブログ記事保存時、BlogPostPasswordプラグインデータを保存する
	 *
	 * @param CakeEvent $event
	 */
	public function blogBlogPostAfterSave(CakeEvent $event)
	{
		$Model = $event->subject();
		// BlogPostPassword のデータがない場合は save 処理を実施しない
		if (!Hash::get($Model->data, 'BlogPostPassword')) {
			return;
		}

		$saveData = $this->generateSaveData($Model, $Model->id);
		
		$BlogPostPassword = ClassRegistry::init('BlogPostPassword.BlogPostPassword');
		if (!$BlogPostPassword->save($saveData)) {
			$this->log(sprintf('ID：%s のBlogPostPasswordプラグインデータの保存に失敗しました。', $Model->data['BlogPostPassword']['id']));
		}
	}

	/**
	 * 保存するデータの生成
	 *
	 * @param Object $Model
	 * @param int $contentId
	 * @return array
	 */
	private function generateSaveData($Model, $contentId = '')
	{
		$params = Router::getParams();
		if (!in_array($params['action'], ['admin_add', 'admin_edit'])) {
			return [];
		}
		$data = ['BlogPostPassword' => $Model->data['BlogPostPassword']];
		if($contentId) {
			$BlogPostPassword = ClassRegistry::init('BlogPostPassword.BlogPostPassword');
			$savedData = $BlogPostPassword->find('first', [
				'conditions' => ['BlogPostPassword.blog_post_id' => $contentId],
				'recursive' => -1
			]);
			if($savedData) {
				$data = ['BlogPostPassword' => array_merge($savedData['BlogPostPassword'], $data['BlogPostPassword'])];
			}
		}
		$data['BlogPostPassword']['blog_post_id'] = $contentId;
		$data['BlogPostPassword']['blog_content_id'] = $Model->data['BlogPost']['blog_content_id'];
		return $data;
	}
}
