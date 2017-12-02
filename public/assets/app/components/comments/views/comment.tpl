<div class="comment">
	<div class="clearfix">
		<div class="pull-left mr-2">
			<div class="comment-creator-photo">
				<a href="/users/{{comment.creator.id}}/" target="_blank">
					{{when comment.creator.photo is empty}}
						<img class="img-thumbnail" src="/assets/i/user.photo.default.png" alt="{{comment.creator.username}}" width="50" height="50" />
					{{endwhen comment.creator.photo}}

					{{when comment.creator.photo is not empty}}
						<img class="img-thumbnail" src="/upload/50x0/{{comment.creator.photo}}" alt="{{comment.creator.username}}" />
					{{endwhen comment.creator.photo}}
				</a>
			</div>
		</div>
		<div class="pull-left">
			<div class="mb-2" style="line-height: 1;">
				<div class="clearfix">
					<div class="pull-left mr-2">
						<a href="/users/{{comment.creator.id}}/" target="_blank">
							<small>{{comment.creator.name}}</small>
						</a>
					</div>
					<div class="pull-left mr-2">
						<small class="text-muted">{{comment.created_at}}</small>
					</div>
				</div>
			</div>

			<div class="comment-content mb-2">
				{{when comment.is_deleted is true}}
					<div style="line-height: 1;">
						{{when comment.deleter.id is equal | this.comment.creator.id}}
							<small class="text-danger">Комментарий удален {{comment.deleted_at}} самим автором.</small>
						{{endwhen comment.deleter.id}}

						{{when comment.deleter.id is not equal | this.comment.creator.id}}
							<small class="text-danger">Комментарий удален {{comment.deleted_at}} пользователем <a href="/users/{{comment.deleter.id}}/" target="_blank">{{comment.deleter.name}}</a>.</small>
						{{endwhen comment.deleter.id}}
					</div>
				{{endwhen comment.is_deleted}}

				{{when comment.is_deleted is not true}}
					{{comment.content}}
				{{endwhen comment.is_deleted}}
			</div>

			{{when comment.picture is not empty}}
				<div class="comment-picture mb-2">
					<a href="/upload/{{comment.picture}}" target="_blank">
						<img class="img-thumbnail" src="/upload/0x200/{{comment.picture}}" />
					</a>
				</div>
			{{endwhen comment.picture}}

			{{when comment.is_deleted is not true}}
				{{when comment.updated_at is not equal | this.comment.created_at}}
					<div class="mb-2" style="line-height: 1;">
						<small class="text-muted">Комментарий был изменен {{comment.updated_at}} пользователем <a href="/users/{{comment.updater.id}}/" target="_blank">{{comment.updater.name}}</a> по причине: <em>{{comment.updating_reason|причина не указана}}</em>.</small>
					</div>
				{{endwhen comment.updated_at}}
			{{endwhen comment.is_deleted}}

			<div class="comment-control" style="line-height: 1;">
				<div class="clearfix">
					{{when comment.is_deleted is not true}}
						<div class="pull-left mr-2">
							<small>
								<a class="comment-action-reply" href="javascript:void(0)" data-id="{{comment.id}}">Ответить</a>
							</small>
						</div>

						{{when comment.creator.id is equal | this.user_id}}
							<div class="pull-left mr-2">
								<small>
									<a class="comment-action-edit" href="javascript:void(0)" data-id="{{comment.id}}">Редактировать</a>
								</small>
							</div>
							<div class="pull-left mr-2">
								<small>
									<a class="comment-action-remove" href="javascript:void(0)" data-id="{{comment.id}}">Удалить</a>
								</small>
							</div>
						{{endwhen comment.creator.id}}

						{{when comment.creator.id is not equal | this.user_id}}
							{{when user_is_administrator is true}}
								<div class="pull-left mr-2">
									<small>
										<span class="text-success">
											<i class="fa fa-shield" aria-hidden="true"></i>
										</span>
										<a class="comment-action-remove" href="javascript:void(0)" data-id="{{comment.id}}">Удалить</a>
									</small>
								</div>
							{{endwhen user_is_administrator}}
						{{endwhen comment.creator.id}}
					{{endwhen comment.is_deleted}}
				</div>
			</div>
		</div>
	</div>
	<div class="comment-form-reply mt-2 d-none" data-id="{{comment.id}}"></div>
	<div class="comment-form-edit mt-2 d-none" data-id="{{comment.id}}"></div>
	<div class="comment-form-remove mt-2 d-none" data-id="{{comment.id}}"></div>
</div>
