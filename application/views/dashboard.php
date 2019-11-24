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
						<th scope="col">First</th>
						<th scope="col">Last</th>
						<th scope="col">Handle</th>
						<th scope="col">Last</th>
						<th scope="col">Handle</th>
						<th scope="col">#</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($archiveList as $key => $archive) { ?>
						<tr>
							<th><?=$archive->id?></th>
							<td><?=$archive->content?></td>
							<td><?=$archive->author?></td>
							<td><?=$archive->likes?> / <?=$archive->unlikes?></td>
							<td><?=$archive->favorites?></td>
							<td><?=date('y-m-d H:i:s', $archive->createTime)?></td>
							<td><button data-id="<?=$archive->id?>" class="btn btn-link btn-delete">删除</button></td>
						</tr>
					<?php } ?>

				</tbody>
			</table>


		</div>
		<div class="row text-right">
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