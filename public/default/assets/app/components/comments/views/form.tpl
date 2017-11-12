<form class="comments-form">
	<div class="comments-form-area">
		<textarea class="form-control" name="content" required="true">{{content}}</textarea>

		{{when editable is true}}
			<input class="form-control mt-2" type="text" name="updating_reason" required="true" placeholder="Причина редактирования..." />
		{{endwhen editable}}
	</div>
	<div class="comments-form-rules">
		<small class="text-muted">Публикуя комментарий, вы соглашаетесь с <a href="/rules/" target="_blank">правилами</a> настоящего ресурса.</small>
	</div>
	<hr>
	<div class="clearfix">
		<div class="pull-left">
			<div class="btn-group">
				<label class="btn btn-outline-primary mb-0">
					<span class="fa fa-picture-o" aria-hidden="true"></span>
					<input class="d-none" type="file" accept="image/gif,image/jpeg,image/png" />
				</label>
			</div>
		</div>
		<div class="pull-right">
			{{when replyable is true}}
				<button class="btn btn-outline-danger" type="reset">
					<span>Отмена</span>
				</button>
			{{endwhen replyable}}

			{{when editable is true}}
				<button class="btn btn-outline-danger" type="reset">
					<span>Отмена</span>
				</button>
			{{endwhen editable}}

			<button class="btn btn-outline-success" type="submit">
				<span>Отправить</span>
			</button>
		</div>
	</div>

	<div class="comments-form-picture-preview"></div>

	{{when parent_id is not empty}}
		<input type="hidden" name="parent_id" value="{{parent_id}}" />
	{{endwhen parent_id}}

	{{when publication_id is not empty}}
		<input type="hidden" name="publication_id" value="{{publication_id}}" />
	{{endwhen publication_id}}

	{{when picture is not empty}}
		<input type="hidden" name="picture" value="{{picture}}" />
	{{endwhen picture}}
</form>
