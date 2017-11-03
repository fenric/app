<div class="h-100">
	<div style="z-index: 1; position: absolute; top: 30px; right: 30px;">
		<span class="label label-primary photo-size"></span>
	</div>
	<div class="clearfix" style="z-index: 1; position: absolute; bottom: 20px; left: 30px; right: 30px;">
		<div class="pull-left" style="margin: 0 10px 10px 0;">
			<div class="btn-group">
				<button type="button" class="btn btn-sm btn-default cropper-command" data-command="help">
					<i class="fa fa-question" aria-hidden="true"></i>
				</button>
			</div>
		</div>
		<div class="pull-left" style="margin: 0 10px 10px 0;">
			<div class="btn-group">
				<button type="button" class="btn btn-sm btn-default cropper-command" data-command="drag-mode" data-value="move">
					<i class="fa fa-arrows" aria-hidden="true"></i>
				</button>
				<button type="button" class="btn btn-sm btn-default cropper-command" data-command="drag-mode" data-value="crop">
					<i class="fa fa-crop" aria-hidden="true"></i>
				</button>
			</div>
		</div>
		<div class="pull-left" style="margin: 0 10px 10px 0;">
			<div class="btn-group">
				<button type="button" class="btn btn-sm btn-default cropper-command" data-command="zoom" data-value="-0.1">
					<i class="fa fa-minus" aria-hidden="true"></i>
				</button>
				<button type="button" class="btn btn-sm btn-default cropper-command" data-command="zoom" data-value="+0.1">
					<i class="fa fa-plus" aria-hidden="true"></i>
				</button>
			</div>
		</div>
		<div class="pull-left" style="margin: 0 10px 10px 0;">
			<div class="btn-group">
				<button type="button" class="btn btn-sm btn-default cropper-command" data-command="move-x" data-value="-10">
					<i class="fa fa-arrow-left" aria-hidden="true"></i>
				</button>
				<button type="button" class="btn btn-sm btn-default cropper-command" data-command="move-x" data-value="+10">
					<i class="fa fa-arrow-right" aria-hidden="true"></i>
				</button>
				<button type="button" class="btn btn-sm btn-default cropper-command" data-command="move-y" data-value="-10">
					<i class="fa fa-arrow-up" aria-hidden="true"></i>
				</button>
				<button type="button" class="btn btn-sm btn-default cropper-command" data-command="move-y" data-value="+10">
					<i class="fa fa-arrow-down" aria-hidden="true"></i>
				</button>
			</div>
		</div>
		<div class="pull-left" style="margin: 0 10px 10px 0;">
			<div class="btn-group">
				<button type="button" class="btn btn-sm btn-default cropper-command" data-command="scale-x">
					<i class="fa fa-arrows-h" aria-hidden="true"></i>
				</button>
				<button type="button" class="btn btn-sm btn-default cropper-command" data-command="scale-y">
					<i class="fa fa-arrows-v" aria-hidden="true"></i>
				</button>
			</div>
		</div>
		<div class="pull-left" style="margin: 0 10px 10px 0;">
			<div class="btn-group">
				<button type="button" class="btn btn-sm btn-default cropper-command" data-command="rotate" data-value="-45">
					<i class="fa fa-undo" aria-hidden="true"></i>
				</button>
				<button type="button" class="btn btn-sm btn-default cropper-command" data-command="rotate" data-value="45">
					<i class="fa fa-repeat" aria-hidden="true"></i>
				</button>
			</div>
		</div>
		<div class="pull-left" style="margin: 0 10px 10px 0;">
			<div class="btn-group">
				<button type="button" class="btn btn-sm btn-default cropper-command" data-command="aspect-ratio" data-value="1/1">
					<span>1:1</span>
				</button>
				<button type="button" class="btn btn-sm btn-default cropper-command" data-command="aspect-ratio" data-value="16/9">
					<span>16:9</span>
				</button>
				<button type="button" class="btn btn-sm btn-default cropper-command" data-command="aspect-ratio" data-value="16/10">
					<span>16:10</span>
				</button>
				<button type="button" class="btn btn-sm btn-default cropper-command" data-command="aspect-ratio" data-value="21/9">
					<span>21:9</span>
				</button>
				<button type="button" class="btn btn-sm btn-default cropper-command" data-command="aspect-ratio" data-value="NaN">
					<span>OFF</span>
				</button>
			</div>
		</div>
		<div class="pull-left" style="margin: 0 10px 10px 0;">
			<div class="btn-group">
				<button type="button" class="btn btn-sm btn-default cropper-command" data-command="reset">
					<i class="fa fa-refresh" aria-hidden="true"></i>
				</button>
				<button type="button" class="btn btn-sm btn-default cropper-command" data-command="save">
					<i class="fa fa-floppy-o" aria-hidden="true"></i>
				</button>
			</div>
		</div>
	</div>
	<img class="photo w-100 h-100" src="/upload/{{photo}}" alt="" />
</div>
