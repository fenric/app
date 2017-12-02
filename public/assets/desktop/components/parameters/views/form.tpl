<form class="form">
	<nav class="top">
		<div class="btn-group">
			<button type="submit" class="btn btn-sm btn-success">
				<i class="fa fa-floppy-o" aria-hidden="true"></i> Сохранить
			</button>
		</div>
	</nav>

	<div class="form-group" data-name="*">
		<div class="help-block error"></div>
	</div>

	<div class="form-group" data-name="home_page_meta_title">
		<label>Мета-тег &lt;title&gt; для главной страницы</label>
		<input class="form-control" type="text" name="home_page_meta_title" value="{{home_page_meta_title.value}}" />
		<div class="help-block error"></div>
	</div>

	<div class="form-group" data-name="home_page_meta_author">
		<label>Мета-тег &lt;meta name=author&gt; для главной страницы</label>
		<input class="form-control" type="text" name="home_page_meta_author" value="{{home_page_meta_author.value}}" />
		<div class="help-block error"></div>
	</div>

	<div class="form-group" data-name="home_page_meta_keywords">
		<label>Мета-тег &lt;meta name=keywords&gt; для главной страницы</label>
		<input class="form-control" type="text" name="home_page_meta_keywords" value="{{home_page_meta_keywords.value}}" />
		<div class="help-block error"></div>
	</div>

	<div class="form-group" data-name="home_page_meta_description">
		<label>Мета-тег &lt;meta name=description&gt; для главной страницы</label>
		<input class="form-control" type="text" name="home_page_meta_description" value="{{home_page_meta_description.value}}" />
		<div class="help-block error"></div>
	</div>

	<div class="form-group" data-name="home_page_meta_robots">
		<label>Мета-тег &lt;meta name=robots&gt; для главной страницы</label>
		<input class="form-control" type="text" name="home_page_meta_robots" value="{{home_page_meta_robots.value}}" />
		<div class="help-block error"></div>
	</div>

	<div class="form-group" data-name="home_page_meta_generator">
		<label>Мета-тег &lt;meta name=generator&gt; для главной страницы</label>
		<input class="form-control" type="text" name="home_page_meta_generator" value="{{home_page_meta_generator.value}}" />
		<div class="help-block error"></div>
	</div>

	<div class="form-group" data-name="robots_txt">
		<label>Содержимое файла robots.txt</label>
		<textarea class="form-control" name="robots_txt" rows="5">{{robots_txt.value}}</textarea>
		<div class="help-block error"></div>
	</div>
</form>
