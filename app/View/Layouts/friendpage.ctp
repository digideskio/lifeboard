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
	/*
	if($this->request->controller == "facebook" && $this->request->action == "display"){
		echo $this->Html->css("style.css");
	}
	if($this->request->controller == "facebook" && $this->request->action == "myPage"){
		echo $this->Html->css("style.css");
	}
	*/

	echo $this->Html->css("style.css");
	?>
	<?php echo $this->Html->script("jquery-1.10.2.min.js"); ?>
	<?php echo $this->Html->script("suggest.js"); ?>
	<?php echo $this->Html->script("app.js"); ?>
</head>
<body>
	<div id="container">
		<header>
			<div id="header_logo">
				<?php echo $this->Html->link($this->Html->image("logo.png"), array("controller" => "facebook", "action" => "myPage"), array("escape" => false)); ?>
			</div>

			<?php if(isset($friend_id) && !empty($friend_id)): ?>
	        	<div id="follower_info">
	        		<li>
	        			<a href="#">
	        				<img src="https://graph.facebook.com/<?php echo $friend_id; ?>/picture">
	        				<p id="follower_name">
	        					<span id="page-name">
	        						<?php echo $friendName; ?>
	        					</span>
	        				</p>
	        			</a>
	        		</li>
	        	</div>
	        <?php endif; ?>

	        <?php if(isset($me) && !empty($me)): ?>
	        	<div id="user_info">
		        	<img src="https://graph.facebook.com/<?php echo $me['id']; ?>/picture" id="user_icon">
		        	<ul id="user_list">
		        		<li id="user_list1">
		        			<?php echo $this->Html->link("自分のLifeboard", array("controller" => "facebook", "action" => "myPage")); ?>
		        		</li>
		        		<li id="user_list2">
		        			<?php echo $this->Html->link("アカウント設定", array("controller" => "segments", "action" => "index")); ?>
		        		</li>
		        		<li id="user_list3"><a href="#">ログアウト</a></li>
		        	</ul>
		        	<?php echo $this->Html->image("triangle.png", array("id" => "triangle")); ?>
		        </div>
	        <?php endif; ?>

	        <div class="header_searchbox">
    			<?php echo $this->Form->input("dammy", array("id" => "header-search", "placeholder" => "友人を検索...", "class" => "searchbox", "label" => false)); ?>
    			<div id="header-suggest"></div>
    		</div>

			<div id="header_friends">
				<?php echo $this->Html->image("header_icon_friends.png"); ?>
			</div>
			<div id="header_friends_box">
				<!--
				<?php if(isset($friends_data["data"]) && !empty($friends_data["data"])): ?>
        			<?php foreach($friends_data["data"] as $friendData): ?>
        				<div class="friend_box">
        					<img src="https://graph.facebook.com/<?php echo $friendData['id']; ?>/picture" />
        					<span><?php echo $friendData["name"]; ?></span>
        				</div>
        			<?php endforeach; ?>
				<?php endif; ?>
				-->
			</div>
			<div id="post">
				<?php echo $this->Html->image("post.png", array("class" => "post-modal")); ?>
			</div>
		</header>
		<div id="content">
			<?php echo $this->Session->flash(); ?>

			<?php echo $content_for_layout; ?>
		</div>
		<div id="footer">

		</div>
	</div>
	<?php //echo $this->element('sql_dump'); ?>

	<?php
	/*
	if(isset($friends_data) && !empty($friends_data["data"])){
		foreach($friends_data["data"] as $friend){
			$friendsList[] = $friend["id"] . ":" . $friend["name"];
		}
	}

	$dammyList = array();
	foreach($friends_data["data"] as $data){
		$dammyList += array($data["name"] => $data["id"]);
		$nameList[] = $data["name"];
	}
	*/

	foreach($friends_data["data"] as $data){
		if(isset($data["birthday"])){
			$dammyList[] = array($data["name"], $data["id"], $data["birthday"]);
		}
		else{
			$dammyList[] = array($data["name"], $data["id"], null);
		}
		$nameList[] = $data["name"];
	}
	?>

	<!--友達検索処理用script-->
	<script>
		var friendList = <?php echo json_encode($dammyList); ?>;
		var nameList = <?php echo json_encode($nameList); ?>;

		new Suggest.Local("header-search", "header-suggest", nameList);

		$("#header-search").keydown(function(e){
			if(e.keyCode == 13){
				for(var i = 0; i < friendList.length; i++){
					if($(this).val() == friendList[i][0]){
						var friendID = friendList[i][1];
						var friendBirthday = friendList[i][2];

						window.location = 'http://lifeboard.jp/facebook/friendPage/?friendID=' + friendID + '&friendName=' + $(this).val() + '&friendBirthday=' + friendBirthday;

						/*
						window.location = 'http://www16078ui.sakura.ne.jp/history/facebook/friendPage/?friendID=' + friendID + '&friendName=' + $(this).val() + '&friendBirthday=' + friendBirthday;
						*/
					}
				}
			}
		})


		/*
		$("#header-search").keydown(function(e){
			console.log($(this).val());
			if(e.keyCode == 13){
				for(var key in friendList){
					if($(this).val() == key){
						console.log(friendList[key]);
						var friendID = friendList[key];

						window.location = 'http://lifeboard.jp/facebook/friendPage/?friendID=' + friendID + '&friendName=' + $(this).val();

						window.location = 'http://www16078ui.sakura.ne.jp/history/facebook/friendPage/?friendID=' + friendID + '&friendName=' + $(this).val();
					}
				}
			}
		})
		*/
	</script>

	<div class="header_overlay"></div>
	<div id="layer"></div>
</body>
</html>
