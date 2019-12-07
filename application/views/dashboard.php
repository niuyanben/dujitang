<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link href="<?= base_url('assets/bootstrap.min.css') ?>" rel="stylesheet">
	<title>毒鸡汤 - 免费续杯</title>
	<style>
		ul.list-inline {
			margin-top: .5rem;
			margin-bottom: .1rem;
		}
	</style>
</head>

<body>
	<?php $this->load->view('header') ?>
	<div class="container wrapper">

		<div class="row">

			<table class="table">
				<tbody>
					<?php foreach ($archiveList as $key => $archive) { ?>
						<tr>
							<td><?= $archive->content ?><br />
								<ul class="list-inline">
									<li class="list-inline-item badge badge-primary"><?= date('Y-m-d H:i:s', $archive->createTime) ?></li>
									<li class="list-inline-item badge badge badge-info"><?= $archive->author ?></li>
									<li class="list-inline-item badge badge-success"><?= $archive->likes ?> / <?= $archive->unlikes ?> / <?= $archive->favorites ?></li>
								</ul>
							</td>
							<td><button data-id="<?= $archive->id ?>" class="btn btn-link btn-delete">x</button></td>
						</tr>
					<?php } ?>

				</tbody>
			</table>


		</div>
		<div class="row">
			<?= $pager ?>
		</div>
	</div>

	<script type="text/javascript">
		$(function() {
			// body...
			$('.btn-delete').click(function() {

			});
		});
	</script>
</body>

</html>