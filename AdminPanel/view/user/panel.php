<?php
$userID = (int)core::$module['smarty']->smarty->tpl_vars['userData_ID']->value;
if(!core::$module['account']->checkPermission('otherUser') and $userID <> (int)core::$module['account']->userData['id']){
	$userID = (int)core::$module['account']->userData['id'];
    core::$model['gui']->alert('Nie posiadasz uprawnień do przeglądania profili użytkowników, wyświetlony zostanie aktualny profil użytkownika.');
}
$userAcc = (int)$userID === (int)core::$module['account']->userData['id'];
$userData = core::$module['account']->getData($userID);
core::$module['smarty']->smarty->assign('userData_userAcc', $userAcc);
core::$module['smarty']->smarty->assign('userData_data', $userData);
core::$module['smarty']->smarty->assign('userData_avatar', core::$model['adminPanel/user']->getAvatar($userID));
core::$model['template']->display('template/user/panel.tpl');
?>