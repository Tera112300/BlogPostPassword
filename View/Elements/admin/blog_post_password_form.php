<?php
$baseUrl = $this->BcBaser->getUri(urldecode($this->request->params['Content']['url']));
$this->BcBaser->css('BlogPostPassword.admin/blog_post_password', ['inline' => false]) .
    $this->BcBaser->js('BlogPostPassword.admin/blog_post_password', false, [
        'id' => 'BlogPostPasswordScript',
        'data-basePassword' => $baseUrl
    ]);
?>


<section class="bca-section">
    <table id="FormTable" class="form-table bca-form-table">
        <tr>
            <th class="col-head bca-form-table__label">投稿パスワード<?= $sample; ?></th>
            <td class="col-input bca-form-table__input">
                <?php $this->BcForm->input('BlogPostPassword.blog_post_id', ['type' => 'hidden']) ?>
                <?php if ($this->request->params['action'] === 'admin_edit') : ?>
                    <?= $this->BcForm->input('BlogPostPassword.id', ['type' => 'hidden']) ?>
                <?php endif ?>
                <?= $this->BcForm->input('BlogPostPassword.status', ['value'=> $blog_pass_status,'type' => 'radio', 'options' => $this->BcText->booleanDoList('パスワード保護')]) ?><br>
                <?= $this->BcForm->input('BlogPostPassword.name', ['type' => 'text', 'size' => 20, 'autofocus' => true, 'required' => null,'div' => "display-none pass-textbox"]) ?>
                <?= $this->BcForm->error('BlogPostPassword.name') ?>
            </td>
        </tr>
    </table>
</section>