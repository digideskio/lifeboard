<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>LifeBoard</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<?php
		echo $this->Html->css("loginpage-pc.css");
	?>
	<?php echo $this->Html->script("jquery-1.10.2.min.js"); ?>
	<?php echo $this->Html->script("suggest.js"); ?>
	<?php echo $this->Html->script("app.js"); ?>
</head>
<body>
	<div id="container">
		<header id="welcome">
			<div id="header_inner">
				<div id="header_logo">
					<?php echo $this->Html->link($this->Html->image("logo.png"), array("controller" => "facebook", "action" => "myPage"), array("escape" => false)); ?>
				</div>
			</div>
		</header>
		<div id="content">
			<?php echo $this->Session->flash(); ?>

			<?php echo $content_for_layout; ?>
		</div>
		<footer>
			&copy; 大江戸ハッカソンCグループ All Right reserved.
		</footer>
		<div id="welcome_contents">
		<div class="welcome_content">
			<h2>
				<big>友</big>だちがどんな人だったか、書き込もう。
			</h2>
			<div class="welcome_des1_left">
				<p>
					あなたが知っている時代の友だちは、どんな人でしたか？<br>あなたとはどんな関係でしたか？<br>どんな思い出がありますか？<br><br>
					Lifeboardでは友だちの人生を、あなた自身の印象や思い出で記録することができます。<br><br>
					当時の写真を貼って懐かしんだり、あのとき言えなかったことを書いてみたり。<br><br>
					逆に、あなたの友人は、<br>あなたのことをどんな風に見ていたでしょうか？
				</p>
			</div>
			<div class="welcome_des1_right">
				<?php echo $this->Html->image("welcome_des1.png"); ?>
			</div>
		</div>
		<div class="welcome_content">
			<h2>
				<big>使</big>い方
			</h2>
			<div class="welcome_des2_wrapper">
				<div class="welcome_des2_left">
					<h3>1. facebookIDでログイン</h3>
					<p>
						Lifeboardはfacebookの「友人」の人生に書き込むことができます。<br>まず、このページの上部から、facebookIDでログインします。<br><br>
						友人宛に投稿するため、代わりに投稿する認証をOKにしてください。
					</p>
					<div class="welcome_arrow"></div>
				</div>
				<div class="welcome_des2_right">
					<?php echo $this->Html->image("welcome_des2_1.png"); ?>
				</div>
			</div>
			<div class="welcome_des2_wrapper">
				<div class="welcome_des2_left">
					<h3>2. 人生の履歴を追加</h3>
					<p>
						小学校、中学校、高校、大学、会社……今まで歩んできた人生の履歴を、ここで追加しましょう。<br><br>
						この情報は「アカウント設定」からいつでも編集できます。
					</p>
					<div class="welcome_arrow"></div>
				</div>
				<div class="welcome_des2_right">
					<?php echo $this->Html->image("welcome_des2_2.png"); ?>
				</div>
			</div>
			<div class="welcome_des2_wrapper">
				<div class="welcome_des2_left">
					<h3>3. 友だちを検索</h3>
					<p>
						facebookの「友人」を検索して、その人のLifeboardに行きましょう。<br><br>
						トップページからも、上部のヘッダーからも「友人」を検索することができます。
					</p>
					<div class="welcome_arrow"></div>
				</div>
				<div class="welcome_des2_right">
					<?php echo $this->Html->image("welcome_des2_3.png"); ?>
				</div>
			</div>
			<div class="welcome_des2_wrapper">
				<div class="welcome_des2_left">
					<h3>4. 友だちのLifeboardに投稿する</h3>
					<p>
						友だちのLifeboardで他の人の投稿を見ながら、自分からも投稿してみましょう。その友だちとの関係、思い出、ずっと言いたかったこと、当時の写真、なんでも構いません。<br><br>
						その友だちは現在どんな人なのか、紹介するのもいいでしょう。
					</p>
				</div>
				<div class="welcome_des2_right">
					<?php echo $this->Html->image("welcome_des2_4.png"); ?>
				</div>
			</div>
		</div>
		<div class="welcome_content" id="creators">
			<h2 class="eng"><big>C</big>reators</h2>
			<div class="welcome_creators_wrapper">
				<?php echo $this->Html->image("welcome_creator_akiho.png"); ?>
				<?php echo $this->Html->image("welcome_creator_hajime.png"); ?>
				<?php echo $this->Html->image("welcome_creator_takeshi.png"); ?>
			</div>
		</div>
	</div>

    <footer>&copy; 大江戸ハッカソンCグループ All Right reserved.</footer>
	</div>
	<?php //echo $this->element('sql_dump'); ?>

</body>
</html>
