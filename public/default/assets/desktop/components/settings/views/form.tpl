<form class="form">
	<div class="form-group">
		<label>Цветовая схема</label>
		<div class="desktop-palettes">
			<div class="desktop-palette blue" data-value="blue"></div>
			<div class="desktop-palette red" data-value="red"></div>
			<div class="desktop-palette pink" data-value="pink"></div>
			<div class="desktop-palette purple" data-value="purple"></div>
			<div class="desktop-palette violet" data-value="violet"></div>
			<div class="desktop-palette cyan" data-value="cyan"></div>
			<div class="desktop-palette green" data-value="green"></div>
			<div class="desktop-palette lime" data-value="lime"></div>
			<div class="desktop-palette orange" data-value="orange"></div>
			<div class="desktop-palette brown" data-value="brown"></div>
			<div class="desktop-palette jeans" data-value="jeans"></div>
			<div class="desktop-palette black" data-value="black"></div>
		</div>
		<small class="help-block">Выбранная вами цветовая схема будет применена к модальным окнам<br/>и ряду других элементов связанных с рабочим столом…</small>
	</div>

	<div class="form-group">
		<label>Фоновое изображение</label>
		<div>
			<input class="desktop-wallpaper" type="file" accept="image/*" />
		</div>
		<small class="help-block">Выберите на вашем устройстве изображение, для того, чтобы сделать<br/>его фоновым изображением вашего рабочего стола…</small>
	</div>

	<div class="form-group">
		<label>Сортировка иконок</label>
		<div>
			<button class="btn btn-sm btn-danger sort-desktop-icons">Применить</button>
		</div>
		<small class="help-block">Иконки по ряду причин могут оказываться за пределами видимой части<br/>рабочего стола, например когда у вас сменилось разрешение экрана…</small>
	</div>

	<div class="form-group">
		<label>Увеличенный размер шрифта в окнах</label>
		<select class="form-control input-sm desktop-modal-font-size">
			<option value="x05" {{when modalContentFontSize is equal | x05}}selected{{endwhen modalContentFontSize}}>50%</option>
			<option value="x06" {{when modalContentFontSize is equal | x06}}selected{{endwhen modalContentFontSize}}>60%</option>
			<option value="x07" {{when modalContentFontSize is equal | x07}}selected{{endwhen modalContentFontSize}}>70%</option>
			<option value="x08" {{when modalContentFontSize is equal | x08}}selected{{endwhen modalContentFontSize}}>80%</option>
			<option value="x09" {{when modalContentFontSize is equal | x09}}selected{{endwhen modalContentFontSize}}>90%</option>
			<option value=""    {{when modalContentFontSize is empty}}      selected{{endwhen modalContentFontSize}}>По умолчанию</option>
			<option value="x11" {{when modalContentFontSize is equal | x11}}selected{{endwhen modalContentFontSize}}>110%</option>
			<option value="x12" {{when modalContentFontSize is equal | x12}}selected{{endwhen modalContentFontSize}}>120%</option>
			<option value="x13" {{when modalContentFontSize is equal | x13}}selected{{endwhen modalContentFontSize}}>130%</option>
			<option value="x14" {{when modalContentFontSize is equal | x14}}selected{{endwhen modalContentFontSize}}>140%</option>
			<option value="x15" {{when modalContentFontSize is equal | x15}}selected{{endwhen modalContentFontSize}}>150%</option>
			<option value="x16" {{when modalContentFontSize is equal | x16}}selected{{endwhen modalContentFontSize}}>160%</option>
			<option value="x17" {{when modalContentFontSize is equal | x17}}selected{{endwhen modalContentFontSize}}>170%</option>
			<option value="x18" {{when modalContentFontSize is equal | x18}}selected{{endwhen modalContentFontSize}}>180%</option>
			<option value="x19" {{when modalContentFontSize is equal | x19}}selected{{endwhen modalContentFontSize}}>190%</option>
			<option value="x20" {{when modalContentFontSize is equal | x20}}selected{{endwhen modalContentFontSize}}>200%</option>
		</select>
		<small class="help-block">Если вам приходится напрягать глаза во время работы с системой, увеличьте шрифт до комфортного для вас размера…</small>
	</div>
</form>
