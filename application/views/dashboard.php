<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link href="<?= base_url('assets/bootstrap.min.css') ?>" rel="stylesheet">
	<title>毒鸡汤 - 免费续杯</title>
</head>
<body>
	<?php $this->load->view('header') ?>
	<div class="container wrapper">

		<div class="row">

			<table class="table">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">文本</th>
						<th scope="col">作者</th>
						<th scope="col">统计</th>
						<th scope="col">操作</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($archiveList as $key => $archive) { ?>
						<tr>
							<td title="<?=date('y-m-d H:i:s', $archive->createTime)?>"><?=date('y-m-d', $archive->createTime)?></td>
							<td><?=$archive->content?></td>
							<td><?=$archive->author?></td>
							<td><?=$archive->likes?> / <?=$archive->unlikes?> / <?=$archive->favorites?></td>
							<td><button data-id="<?=$archive->id?>" class="btn btn-link btn-delete">x</button></td>
						</tr>
					<?php } ?>

				</tbody>
			</table>


		</div>
		<div class="row">
		<?=$pager?>
		</div>
	</div>

	<script type="text/javascript">
		$(function () {
			// body...
			$('.btn-delete').click(function(){
				
			});
		});
	</script>
</body>
</html>