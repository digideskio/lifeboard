
<p class="birthday">
	<span>
		<?php
		if(isset($me["birthday"]) && !empty($me["birthday"])){
			echo date('Y年n月j日', strtotime($me["birthday"]));
		}
		else{
			echo "誕生日が設定されていません。";
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
			<?php foreach($posts as $data): ?>
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
			<?php foreach($posts as $data): ?>
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