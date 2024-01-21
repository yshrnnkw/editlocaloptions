<?php
defined('ABSPATH') || exit;


return [
	// 管理ページ左のメニュー、設定ページの先頭に表示する文字列
	'title'	=> 'その他の設定',

	// 入力欄の設定
	// name: 半角英数字。他の設定値と被らないようにすること
	// subject: 管理画面で表示する見出し
	// description: 入力欄の下に表示する説明文
	// formtype: input, textarea, selectのいずれか
	// fromdata: formtypeで「select」を指定した場合に利用される
	// header: 直前に表示する見出し
	'form_list' => array(
		array(
			'name'			=> 'elo_message',
			'subject'		=> 'トップページのメッセージ',
			'description'	=> 'HTMLタグは利用できません',
			'formtype'		=> 'textarea',
			'header'		=> 'トップページ',
		),
		array(
			'name'			=> 'elo_picture',
			'subject'		=> 'トップページの画像',
			'description'	=> '',
			'formtype'		=> 'select',
			'formdata'		=> array(
				'p1'	=> '桜の花びら',
				'p2'	=> '夜桜',
				'p3'	=> '桜並木',
			),
			'header'		=> '',
		),
		array(
			'name'			=> 'elo_close1',
			'subject'		=> '今月の休業日',
			'description'	=> '例）1, 8, 21',
			'formtype'		=> 'input',
			'header'		=> 'スケジュール',
		),
	),
];
?>