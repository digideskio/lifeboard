<!--投稿フォーム-->
<div id="form-zone">
	<?php echo $this->Form->create("FbPost", array("controller" => "fb_posts", "action" => "add", "type" => "file", "enctype" => "multipart/form-data")); ?>
	<?php echo $this->Form->input("user_id", array("type" => "hidden", "value" => $me["id"])); ?>
	<?php echo $this->Form->input("friend_id", array("type" => "hidden", "value" => $friend_id)); ?>
	<?php echo $this->Form->input("user_name", array("type" => "hidden", "value" => $me["name"])); ?>
	<?php echo $this->Form->input("friend_name", array("type" => "hidden", "value" => $friendName)); ?>
	<?php echo $this->Form->input("friend_birthday", array("type" => "hidden", "value" => $friendBirthday)); ?>
	<p>
		<?php echo $this->Form->input("body", array("class" => "post-body", "label" => false, "div" => false, "placeholder" => "友達のことについて書いて下さい。")); ?>
	</p>
	<div id="sumbnail">

	</div>
	<p id="description">どの時期の友人か選択して下さい</p>
	<p>
		<?php
		if(isset($segmentList) && !empty($segmentList)){
			$segments = json_decode($segmentList["Segment"]["body"]);

			echo $this->Form->select("segment", $segments, array("class" => "select-segment"));
		}
		else{
			$default = array(0 => "小学校", 1 => "中学校", 2 => "高校", 3 => "大学");
			echo $this->Form->select("segment", $default, array("class" => "select-segment"));
		}
		?>
	</p>
	<span id="photo-zone">
		<?php echo $this->Form->file("photo_pass", array("class" => "photo-upload")); ?>
	</span>
	<span id="post-btn">
		<?php echo $this->Form->button("送信", array("class" => "post-btn")); ?>
	</span>
	<?php echo $this->Form->end(); ?>
</div>


<p class="birthday">
	<span>
		<?php
		if($friendBirthday == null){
			echo "誕生日が設定されていません。";
		}
		else{
			$date = date("Y年n月j日", strtotime($friendBirthday));
			if($date == "1970年1月1日"){
				echo "誕生日が設定されていません。";
			}
			else{
				echo $date;
			}
		}
		?>
	</span>
</p>
<?php if(isset($segmentList) && !empty($segmentList)): ?>
	<?php
	$segmentCount = 1;
	$segmentValue = 0;
	$dateList = json_decode($segmentList["Segment"]["date"]);
	?>
	<?php foreach(json_decode($segmentList["Segment"]["body"]) as $segment): ?>
		<!--自分に対する投稿データを全て取ってきて、各セグメント事にループを回す-->
		<div id="segment<?php echo $segmentCount; ?>">
			<div class="dammy">
				<?php if(!empty($dateList[$segmentValue])): ?>
					<span class="segment-year">
						<?php echo $dateList[$segmentValue]; ?>年
					</span>
				<?php endif; ?>
				<span class="segment-center"></span>
				<span class="segment-name"><?php echo $segment; ?></span>
			</div>
			<?php $boxCount = 0; ?>
			<?php foreach($friendData as $data): ?>
				<?php if($data["FbPost"]["segment"] == $segmentValue): ?>
					<div class="post-box <?php echo ($boxCount == 0)?'left':'right'; ?>">
						<div class="inner">
							<div class="post-header">
								<img src="https://graph.facebook.com/<?php echo $data['FbPost']['user_id']; ?>/picture" class="prof">
								<span class="name"><?php echo $data["FbPost"]["user_name"]; ?></span>
								<span class="date">
								<?php
									echo date("Y年n月j日 H:i:s", strtotime($data['FbPost']['created']));
								?>
								</sapn>
							</div>

							<div class="box-body">
								<?php if(isset($data["FbPost"]["photo_pass"]) && !empty($data["FbPost"]["photo_pass"])): ?>
									<?php echo $this->Html->image("post-photos/" . $data["FbPost"]["photo_pass"], array("class" => "post-img")); ?>
								<?php endif; ?>

								<?php echo nl2br($data["FbPost"]["body"]); ?>
							</div>
						</div>
					</div>
					<?php
					$boxCount++;
					if($boxCount == 2){
						$boxCount = 0;
					}
					?>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
		<?php $segmentValue++; ?>
		<?php $segmentCount++; ?>
	<?php endforeach; ?>
<?php else: ?>
	<?php
	$segmentCount = 1;
	$defaultSegment = array("小学校", "中学校", "高校", "大学");
	?>
	<?php for($i = 0; $i < count($defaultSegment); $i++): ?>
		<!--自分に対する投稿データを全て取ってきて、各セグメント事にループを回す-->
		<div id="segment<?php echo $segmentCount; ?>">
			<div class="dammy">
				<span class="segment-year"></span>
				<span class="segment-center"></span>
				<span class="segment-name"><?php echo $defaultSegment[$i]; ?></span>
			</div>
			<?php $boxCount = 0; ?>
			<?php foreach($friendData as $data): ?>
				<?php if($data["FbPost"]["segment"] == $i): ?>
					<div class="post-box <?php echo ($boxCount == 0)?'left':'right'; ?>">
						<div class="inner">
							<div class="post-header">
								<img src="https://graph.facebook.com/<?php echo $data['FbPost']['user_id']; ?>/picture" class="prof">
								<span class="name"><?php echo $data["FbPost"]["user_name"]; ?></span>
								<span class="date">
								<?php
									echo date("Y年n月j日 H:i:s", strtotime($data['FbPost']['created']));
								?>
								</sapn>
							</div>

							<div class="box-body">
								<?php if(isset($data["FbPost"]["photo_pass"]) && !empty($data["FbPost"]["photo_pass"])): ?>
									<?php echo $this->Html->image("post-photos/" . $data["FbPost"]["photo_pass"], array("class" => "post-img")); ?>
								<?php endif; ?>

								<?php echo nl2br($data["FbPost"]["body"]); ?>
							</div>
						</div>
					</div>
					<?php
					$boxCount++;
					if($boxCount == 2){
						$boxCount = 0;
					}
					?>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
		<?php $segmentCount++; ?>
	<?php endfor; ?>
<?php endif; ?>
