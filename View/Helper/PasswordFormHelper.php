<?php
App::uses('AppHelper', 'View/Helper');
App::uses('BcFormHelper', 'View/Helper');
App::uses('HtmlHelper', 'View/Helper');

class PasswordFormHelper extends AppHelper {
    public function createForm($blogContentId = 0, $blogPostId = 0)
	{
        $form = new BcFormHelper(new View());
        $html = new HtmlHelper(new View());

        $form_html = "<div class='blog-password-form'>";
        $form_html .= $html->para('password-title','このコンテンツはパスワードで保護されています。閲覧するには以下のパスワードを入力してください。');
        $form_html .= $form->create('BlogPostPassword', ['url' => '/blog_post_password/blog_post_passwords/password_check/' . $blogContentId . '/' . $blogPostId,'novalidate' => false]);
        $form_html .= $html->div('blog-password-box',
        $html->div('blog-password-input',$form->input('BlogPostPassword.name', ['type' => 'text', 'size' => 30])).
        $form->submit('送信する',['div' => ['class' => 'blog-password-send']])
        );
   
        $form_html .= $form->end();
        $form_html .= "</div>";
        $form_html .= $html->css('BlogPostPassword.front/blog_post_password');
        $form_html .= $html->script('BlogPostPassword.front/blog_post_password');
    
        return $form_html;
    }
}