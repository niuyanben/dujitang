<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>毒鸡汤 - 免费续杯</title>
	<meta name="description" content="我们精心熬制了有屎以来最毒1000多条经典毒鸡汤,句句“治愈”人心! 只为了帮你更好的看清人生认识自己，直面现实,直面惨淡的人生,不给你励志,不给你慰藉,像一根鞭猛的抽你一下,使你清醒,知道这个世界和你自己最真实的一面,是青少年手机里的必备宝典。">
	<meta name="keywords" content="鸡汤,毒鸡汤,馊鸡汤">
	<meta http-equiv="Cache-Control" content="no-siteapp">
	<meta property="og:title" content="毒鸡汤 - 壮士可要来一碗！" />
	<meta property="og:site_name" content="毒鸡汤 - 壮士可要来一碗！" />
	<meta property="og:description" content="我们精心熬制了有屎以来最毒1000多条经典毒鸡汤,句句“治愈”人心! 只为了帮你更好的看清人生认识自己，直面现实,直面惨淡的人生,不给你励志,不给你慰藉,像一根鞭猛的抽你一下,使你清醒,知道这个世界和你自己最真实的一面,是青少年手机里的必备宝典。" />
	<link rel="icon" href="/favicon.ico" type="image/x-icon" id="page_favionc">
	<link href="<?= base_url('assets/bootstrap.min.css') ?>" rel="stylesheet">
	<link href="assets/main.css" rel="stylesheet">
	<link href="//at.alicdn.com/t/font_1526687_z9pvzlz648.css" rel="stylesheet">

	<link rel="alternate icon" type="image/png" href="icon.png">
	<style type="text/css">
		.main-wrapper {
			align-items: center;
		}

		.djt-block {
			padding-bottom: 20px;
		}

		.djt-block .social {
			display: none;
			text-align: center;
		}

		.djt-block #sentence {
			cursor: pointer;
		}

		.djt-block:hover .social {
			display: block;
		}

		.djt-block .social i {
			font-size: 28px;
			color: #dc3545;
			cursor: pointer;
			transition: all 0.6s ease-in;
			-webkit-transition: all 0.6s ease-in;
		}

		.djt-block .social i:hover {
			transform: scale(1.4);
		}
	</style>

</head>

<body>
	<?php $this->load->view('header') ?>
	<div class="djt-block justify-content-center text-center" data-id="1" style="position: fixed;top: 30%;width: 80%;margin-left: 10%;">
		<span id="sentence" style="font-size: 2rem;">不要放弃你的梦，继续睡！</span>
		<div class="social"><span onclick="like()" class="btn-like"><i class="iconfont icon-favorite"></i></span></div>
	</div>
	<div class="col text-center" style="position: fixed;bottom: 20%;width:100%">
		<button style="font-size: 18px;" class="btn btn-refresh btn-danger">好汤，再来一碗</button>
	</div>
	<div class="container wrapper"></div>
	<div class="modal fade" id="publishModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">添碗毒鸡汤</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="publishForm" action="<?= base_url('publish') ?>" method="post">
						<div class="form-row">
							<div class="form-group col-md-12">
								<textarea class="form-control" name="content" rows="3"></textarea>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-8">
								<input maxlength="60" type="text" class="form-control" name="author">
							</div>
							<div class="form-group col-md-4 text-right">
								<button onclick="publish()" type="button" class="btn btn-primary btn-publish">Save changes</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdn.bootcss.com/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/data.js"></script>
	<script type="text/javascript">
		var count = datas.length;

		$(function() {
			var djtList = [];

			function fetch() {
				$.get('api/random', function(res) {
					if (res.code == 200) {
						djtList = djtList.concat(res.data.archiveList);
						render();
						console.log(djtList.length);
					}
				}, 'json');
			}

			function render() {
				var djt = djtList.shift();
				$('.djt-block').data(djt.id);
				$('#sentence').text(djt.content);
				if (djtList.length < 5) {
					fetch();
				}
			}
			fetch();

			$('.btn-refresh').click(function() {
				render();
			});
		});

		function like() {
			var id = $('.djt-block').data('id');
			$.post('/like', {
				'id': id
			}, function(res) {
				if (res.code == 200) {
					alert('成功');
				} else {
					alert('失败');
				}
			}, 'json');
		}

		function publish() {
			var content = $('#publishForm textarea[name="content"]').val();
			content = $.trim(content);
			var author = $('#publishForm input[name="author"]').val();
			author = $.trim(author);
			if (content.length == 0 || content.length > 200 || author.length > 60) {
				alert('content invalid');
				return;
			}
			alert(content);
			$.post('/publish', {
				'content': content,
				'author': author
			}, function(res) {
				if (res.code == 200) {
					alert('成功');
					$('#publishModal').modal('hide');
				} else {
					alert('失败');
				}
			}, 'json');
		}
	</script>
</body>

</html>