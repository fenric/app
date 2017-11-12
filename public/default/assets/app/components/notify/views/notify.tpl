{{when title is not empty}}
	<h6 class="fenric-notify-title">
		{{when icon is not empty}}
			<span class="fenric-notify-icon {{icon}}"></span>
		{{endwhen icon}}

		{{title}}
	</h6>
{{endwhen title}}

<div class="fenric-notify-message">
	{{when title is empty}}
		{{when icon is not empty}}
			<span class="fenric-notify-icon {{icon}}"></span>
		{{endwhen icon}}
	{{endwhen title}}

	{{when messageHtml is true}}
		{{@ this.message; }}
	{{endwhen messageHtml}}

	{{when messageHtml is not true}}
		{{message}}
	{{endwhen messageHtml}}
</div>

<a href="javascript:void(0)" class="fenric-notify-close" title="Закрыть">
	<span class="fa fa-times" aria-hidden="true"></span>
</a>
