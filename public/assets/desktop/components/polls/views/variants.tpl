{{when poll.variants is not empty}}
	<div class="list-group sortable">
		{{repeat poll.variants}}
			<form class="form list-group-item poll-variant" data-id="{{id}}" data-action="update">
				<div class="input-group" style="margin-bottom: 10px;">
					<span class="input-group-addon sortable-handle" style="cursor: move;">
						<i class="fa fa-arrows" aria-hidden="true"></i>
					</span>
					<input class="form-control" type="text" name="title" value="{{title}}" required="true" />
					<span class="input-group-btn">
						<button type="submit" class="btn btn-default">
							<i class="fa fa-floppy-o" aria-hidden="true"></i>
						</button>
						<button type="button" class="btn btn-danger delete" data-toggle="confirmation" data-placement="left" data-title="Уверены?" data-btn-ok-label="Да" data-btn-cancel-label="Отмена">
							<i class="fa fa-trash" aria-hidden="true"></i>
						</button>
					</span>
				</div>
				<div class="progress" style="margin-bottom: 0;">
					<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="{{progress|0}}" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: {{progress|0}}%;">
						<span>{{votes|0}}</span>
					</div>
				</div>
			</form>
		{{endrepeat poll.variants}}
	</div>
	<hr>
{{endwhen poll.variants}}

<div class="list-group">
	<form class="form list-group-item" data-id="{{poll.id}}" data-action="create">
		<div class="input-group">
			<input class="form-control" type="text" name="title" placeholder="Новый вариант ответа..." required="true" />
			<span class="input-group-btn">
				<button type="submit" class="btn btn-success">
					<i class="fa fa-floppy-o" aria-hidden="true"></i>
				</button>
			</span>
		</div>
	</form>
</div>
