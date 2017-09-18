<div class="photo pull-left" data-id="{{photo.id}}" style="position: relative; margin: 0 5px 5px 0;">

	<a href="/upload/{{photo.file}}" target="_blank" data-fancybox="5f2723c5-6da8-4eab-b760-8d351d70b147-{{publication.id}}">
		<img class="img-thumbnail" src="/upload/160x90/{{photo.file}}" {{when photo.display is not true}}style="opacity: 0.25;"{{endwhen photo.display}} />
	</a>

	<div style="position: absolute; bottom: 10px; right: 10px;">
		<div class="btn-group" role="group">
			<div class="btn-group" role="group">
				<div class="dropdown">
					<button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="fd218ec5-98b6-40d5-8beb-ee6bdde72bfd-{{photo.id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						<i class="fa fa-bars" aria-hidden="true"></i>
					</button>
					<ul class="dropdown-menu" aria-labelledby="fd218ec5-98b6-40d5-8beb-ee6bdde72bfd-{{photo.id}}">
						<li>
							<a href="/upload/{{photo.file}}" target="_blank">Открыть</a>
						</li>
						{{when photo.display is true}}
							<li>
								<a class="disable" href="javascript:void(0)" data-id="{{photo.id}}">Выключить</a>
							</li>
						{{endwhen photo.display}}

						{{when photo.display is false}}
							<li>
								<a class="enable" href="javascript:void(0)" data-id="{{photo.id}}">Включить</a>
							</li>
						{{endwhen photo.display}}
					</ul>
				</div>
			</div>
			<button class="btn btn-sm btn-danger delete" type="button" data-id="{{photo.id}}" data-toggle="confirmation" data-placement="top" data-title="Уверены?" data-btn-ok-label="Да" data-btn-cancel-label="Отмена">
				<i class="fa fa-times" aria-hidden="true"></i>
			</button>
		</div>
	</div>
</div>
