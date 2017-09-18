<form>
	<div class="form-group">
		<label>Ширина изображения</label>
		<input class="form-control" type="number" name="width" value="0" required />
		<p class="help-block"></p>
	</div>
	<div class="form-group">
		<label>Высота изображения</label>
		<input class="form-control" type="number" name="height" value="0" required />
		<p class="help-block"></p>
	</div>
	<div class="form-group">
		<div class="checkbox">
			<label>
				<input type="checkbox" name="linkable" /> Создать ссылку на оригинал
			</label>
		</div>
		<p class="help-block"></p>
	</div>
	<div class="form-group">
		<label>Выберите изображение на вашем устройстве</label>
		<input class="form-control" type="file" name="files" accept="image/*" multiple required />
		<p class="help-block"></p>
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-sm btn-primary">
			<span>Загрузить</span>
		</button>
	</div>
</form>
