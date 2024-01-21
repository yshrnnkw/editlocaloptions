<?php
/*
Plugin Name:	Edit Local Options
Plugin URI:		https://sakuraworks.net/
Description:	サイトの設定を保存
Version:		1.0
Author:			SAKURA WORKS
Author URI:		https://sakuraworks.net/
License:		GPL2
*/


defined('ABSPATH') || exit;


// メニュー表示 ----------------------------------------------------------------
function elo_init() {
	// 設定読み込み
	$config_file = dirname( __FILE__ ).'/config.php';
	$config = include($config_file);

	add_submenu_page('options-general.php', $config['title'], $config['title'], 'edit_posts', 'editlocaloptions', 'elo_startpage');
}
add_action('admin_menu', 'elo_init');


// スタートページ --------------------------------------------------------------
function elo_startpage() {

	// 設定読み込み
	$opt = array(
		'title'	=> '',
		'form_list' => array(),
	);
	$config_file = dirname( __FILE__ ).'/config.php';
	$config = include($config_file);
	$opt = array_merge($opt, $config);


    // $_POSTがあれば設定を更新
    foreach ($opt['form_list'] as $_v) {
		if (isset($_POST[$_v['name']])) {
			update_option($_v['name'], $_POST[$_v['name']]);
		}
    }


	echo '<div class="wrap">'.PHP_EOL;
	echo '<h2>'.$opt['title'].'</h2>'.PHP_EOL;

	// 更新完了を通知
	if (isset($_POST['elo_attention'])) {
		echo '<div class="updated notice is-dismissible">'.PHP_EOL;
		echo '<p>設定を保存しました</p>'.PHP_EOL;
		echo '</div>'.PHP_EOL;
	}

	echo '<form method="post" action="">'.PHP_EOL;

	// 入力フォーム
	foreach ($opt['form_list'] as $_v) {
		if (!isset($_v['name']) or $_v['name'] == '') {
			continue;
		} else if (!isset($_v['subject']) or $_v['subject'] == '') {
			continue;
		} else if (!isset($_v['formtype']) or !in_array($_v['formtype'], array('input', 'textarea', 'select'))) {
			continue;
		} else if ($_v['formtype'] == 'select') {
			if (!isset($_v['formdata']) or !is_array($_v['formdata']) or sizeof($_v['formdata']) == 0) {
				continue;
			}
		}

		// 見出しがあれば表示
		if (isset($_v['header']) and $_v['header'] != '') {
			echo '<h2>'.$_v['header'] .'</h2>'.PHP_EOL;
		}

		echo '<table class="form-table">';
		echo '<tr>'.PHP_EOL;
		echo '<th>'.$_v['subject'].'</th>'.PHP_EOL;
		echo '<td>'.PHP_EOL;

		// テキストエリア
		if ($_v['formtype'] == 'textarea') {
			echo '<textarea class="large-text" name="'.$_v['name'].'">'.get_option($_v['name']).'</textarea>'.PHP_EOL;

		// プルダウンメニュー
		} else if ($_v['formtype'] == 'select') {
			echo '<select name="'.$_v['name'].'">'.PHP_EOL;
			echo '<option value="">未設定</option>'.PHP_EOL;
			foreach ($_v['formdata'] as $_k2 => $_v2) {
				$_selected = ( $_k2 == get_option($_v['name']) ? ' selected' : '' );

				echo '<option value="'.$_k2.'"'.$_selected.'>'.$_v2.'</option>'.PHP_EOL;
			}
			echo '</select>'.PHP_EOL;

		// テキストフィールド
		} else {
			echo '<input class="large-text" name="'.$_v['name'].'" type="text" value="'.get_option($_v['name']).'" />'.PHP_EOL;
		}

		if ($_v['description'] != '') {
			echo '<div class="description">'.$_v['description'].'</div>'.PHP_EOL;
		}

		echo '</td>'.PHP_EOL;
		echo '</tr>'.PHP_EOL;
		echo '</table>'.PHP_EOL;
	}


	submit_button();

	echo '</form>'.PHP_EOL;
	echo '</div>'.PHP_EOL;
}
?>
