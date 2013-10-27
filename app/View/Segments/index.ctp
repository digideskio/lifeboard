<div id="segment-form">
	<?php echo $this->Form->create("Segment", array("controller" => "segments", "action" => "add"), array("label" => false)); ?>
	<?php echo $this->Form->input("user_id", array("type" => "hidden", "value" => $me["id"])); ?>

	<?php if(isset($segmentList["Segment"]["body"]) && !empty($segmentList["Segment"]["body"])): ?>
		<div id="input-zone">
		<?php
		$bodyList = json_decode($segmentList["Segment"]["body"]);
		$dateList = json_decode($segmentList["Segment"]["date"]);
		?>
		<table>
			<tr>
				<td>
					<?php echo $this->Html->image("segument_h_1.png"); ?>
				</td>
				<td>
					<?php echo $this->Html->image("segument_h_2.png"); ?>
				</td>
			</tr>
		<?php for($i = 0; $i < 4; $i++): ?>
			<tr>
				<td>
					<?php echo $this->Form->year("segment-date." . $i, "1970", "2020", array("empty" => "", "value" => $dateList[$i])); ?>
				</td>
				<td>
					<?php echo $this->Form->input("segment-body." . $i, array("placeholder" => "セグメントの名称を入力して下さい。", "label" => false, "value" => $bodyList[$i])); ?>
				</td>
			</tr>
		<?php endfor; ?>
		</table>
		</div>
	<?php else: ?>
		<div id="input-zone">
			<table>
				<tr>
					<td>
						<?php echo $this->Html->image("segument_h_1.png"); ?>
					</td>
					<td>
						<?php echo $this->Html->image("segument_h_2.png"); ?>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo $this->Form->year("segment-date.0", "1970", "2020"); ?>
					</td>
					<td>
						<?php echo $this->Form->input("segment-body.0", array("placeholder" => "あなたの小学校を入力してください。", "label" => false)); ?>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo $this->Form->year("segment-date.1", "1970", "2020"); ?>
					</td>
					<td>
						<?php echo $this->Form->input("segment-body.1", array("placeholder" => "あなたの中学校を入力してください。", "label" => false)); ?>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo $this->Form->year("segment-date.2", "1970", "2020"); ?>
					</td>
					<td>
						<?php echo $this->Form->input("segment-body.2", array("placeholder" => "あなたの高校を入力してください。", "label" => false)); ?>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo $this->Form->year("segment-date.3", "1970", "2020"); ?>
					</td>
					<td>
						<?php echo $this->Form->input("segment-body.3", array("placeholder" => "あなたの大学を入力してください。", "label" => false)); ?>
					</td>
				</tr>
			</table>
		</div>
	<?php endif; ?>

	<?php echo $this->Form->submit("登録する", array("class" => "segment-btn")); ?>
	<?php echo $this->Form->end(); ?>
</div>
<?php
	//pr(json_decode($segmentList["Segment"]["body"]));
?>

