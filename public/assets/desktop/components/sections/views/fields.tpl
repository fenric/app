<form class="form">
	<h4>Прикрепленные дополнительные поля</h4>
	<p class="help-block">Будьте предельно внимательны, при откреплении дополнительного поля от настоящего раздела, будут удалены все связанные с ним данные в публикациях.</p>

	{{when section.fields is empty}}
		<div class="alert alert-info">Прикрепленных дополнительных полей не найдено.</div>
	{{endwhen section.fields}}

	{{when section.fields is not empty}}
		<div class="list-group sortable" style="position: relative;">
			{{repeat section.fields}}
				<div class="list-group-item sortable-item" data-id="{{id}}">
					<div class="container-fluid">
						<div class="row">
							<div class="pull-left">
								<p><strong>Тип</strong>
								<br><span>{{parent.type}}</span></p>

								<p><strong>Заголовок</strong>
								<br><span>{{parent.label}}</span></p>
							</div>
							<div class="pull-right">
								<div class="btn-group">
									<button class="btn btn-sm btn-warning" type="button" onclick="$desktop.component('fields').edit({{parent.id}})">
										<i class="fa fa-pencil" aria-hidden="true"></i>
									</button>
									<button class="btn btn-sm btn-danger detach" type="button" data-id="{{id}}" data-toggle="confirmation" data-placement="left" data-title="Вы&nbsp;точно&nbsp;этого&nbsp;хотите?" data-content="" data-btn-ok-label="Да, открепить" data-btn-cancel-label="Отмена">
										<i class="fa fa-chain-broken" aria-hidden="true"></i>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			{{endrepeat section.fields}}
		</div>
	{{endwhen section.fields}}

	<p>&nbsp;</p>

	<h4>Открепленные дополнительные поля</h4>
	<p class="help-block">Нажмите на открепленное дополнительное поле, чтобы прикрепить его к настоящему разделу.</p>

	{{when fields is empty}}
		<div class="alert alert-info">Открепленных дополнительных полей не найдено.</div>
	{{endwhen fields}}

	{{when fields is not empty}}
		<div class="list-group">
			{{repeat fields}}
				<a href="javascript:void(0)" class="list-group-item list-group-item-action attach" data-id="{{id}}">
					<p>{{label}}</p>
				</a>
			{{endrepeat fields}}
		</div>
	{{endwhen fields}}
</form>
