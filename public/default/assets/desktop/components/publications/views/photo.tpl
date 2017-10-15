<div class="photo pull-left" data-id="{{photo.id}}" style="position: relative; margin: 0 5px 5px 0;">

	<a href="/upload/{{photo.file}}" target="_blank" data-fancybox="publication:{{publication.id}}:photo">
		<img
			class="img-thumbnail"
			src="/upload/160x90/{{photo.file}}"
			width="160"
			height="90"
			{{when photo.display is not true}}
				style="opacity: 0.25;"
			{{endwhen photo.display}}
		/>
	</a>

	<div style="position: absolute; top: 10px; right: 10px;">
		<div class="btn-group-vertical" role="group">
			<a class="btn btn-xs btn-default" href="/upload/{{photo.file}}" target="_blank">
				<i class="fa fa-link" aria-hidden="true"></i>
			</a>

			{{when photo.display is true}}
				<button class="btn btn-xs btn-default to-hide" type="button" data-id="{{photo.id}}">
					<i class="fa fa-eye-slash" aria-hidden="true"></i>
				</button>
			{{endwhen photo.display}}

			{{when photo.display is not true}}
				<button class="btn btn-xs btn-default to-show" type="button" data-id="{{photo.id}}">
					<i class="fa fa-eye" aria-hidden="true"></i>
				</button>
			{{endwhen photo.display}}

			<button class="btn btn-xs btn-danger delete" type="button" data-id="{{photo.id}}" data-toggle="confirmation" data-placement="bottom" data-title="Уверены?" data-btn-ok-label="Да" data-btn-cancel-label="Отмена">
				<i class="fa fa-times" aria-hidden="true"></i>
			</button>
		</div>
	</div>
</div>
