<form>
	<div class="form-group">
		<label>Ширина изображения обложки</label>
		<input class="form-control" type="number" name="width" value="0" required />
		<p class="help-block"></p>
	</div>
	<div class="form-group">
		<label>Высота изображения обложки</label>
		<input class="form-control" type="number" name="height" value="0" required />
		<p class="help-block"></p>
	</div>
	<div class="form-group">
		<label>Выберите PDF файл на вашем устройстве</label>
		<input class="form-control" type="file" name="files" accept="application/pdf" required />
		<p class="help-block"></p>
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-sm btn-primary">
			<span>Загрузить</span>
		</button>
	</div>
</form>
