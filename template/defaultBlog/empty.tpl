<!doctype html>
<html lang="pl">
	<head>
		{include file='page_head.tpl'}
	</head>
	<body>
		<div class="container">
			<header class="py-3">
				{include file='header.tpl'}
			</header>
			<div class="nav-scroller py-1 mb-2">
				<nav class="nav d-flex justify-content-between">
					{foreach from=$menu key=name item=link}
						<a class="p-2 text-muted" href="{$link}">{$name}</a>
					{/foreach}
				</nav>
			</div>
			{if isset($jumbotron)}
			<div class="jumbotron p-4 p-md-5 text-white rounded bg-dark">
				<div class="col-md-12 px-0">
					<h1 class="display-4 font-italic">{$jumbotron['header']}</h1>
					<p class="lead my-3">{$jumbotron['text']}</p>
					{if isset($jumbotron['url'])}
						<p class="lead mb-0"><a href="{$jumbotron['url']}" class="text-white font-weight-bold">Kontynuuj czytanie...</a></p>
					{/if}
				</div>
			</div>
			{/if}
			<main role="main" class="container">
				{$conteinerData}
			</main>
			<footer class="blog-footer">
				<p>FourCMS Stworzony przez <a href='https://krzysztofzylka.pl/'>krzysztofzylka.pl</a></p>
			</footer>
		</div>
	</body>
</html>

