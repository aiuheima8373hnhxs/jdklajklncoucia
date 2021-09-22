<?php
return new class(){
	public function __construct(){
        if (isset($_GET['post'])) { //read post
            $id = core::$model['protect']->protectID($_GET['post']);
            $post = core::$model['post']->read($id);

            if ($post === false) {
                core::$module['smarty']->smarty->display('404.tpl');
                return;
            } elseif ($post['type'] == "post") {
                core::$module['smarty']->smarty->assign('post', $post);
                core::$module['smarty']->smarty->display('post.tpl');
            } else {
                core::$model['interpreter']->loadScript($post['type']);
            }
        } else { //read post list
            $posts = core::$model['post']->list();
            core::$module['smarty']->smarty->assign('blog_post', $posts);
            core::$module['smarty']->smarty->display('postList.tpl');
        }
    }
}
?>