<div class="form-group" data-name="field:{{field.parent.name}}" data-field-id="{{field.id}}">

	{{when field.parent.type is equal | flag}}
		<label>
			<input
				type="checkbox"
				name="field_{{field.parent.name}}"
				value="1"

				{{when field.parent.is_required is true}}
					data-unchecked-value="0"
				{{endwhen field.parent.is_required}}

				{{when field.value is true}}
					checked
				{{endwhen field.value}}

			/> {{field.parent.label}}
		</label>
	{{endwhen field.parent.type}}

	{{when field.parent.type is equal | number}}
		<label>{{field.parent.label}}</label>
		<input
			class="form-control"
			type="text"
			name="field_{{field.parent.name}}"
			value="{{field.value}}"
		/>
	{{endwhen field.parent.type}}

	{{when field.parent.type is equal | string}}
		<label>{{field.parent.label}}</label>
		<input
			class="form-control"
			type="text"
			name="field_{{field.parent.name}}"
			value="{{field.value}}"
		/>
	{{endwhen field.parent.type}}

	{{when field.parent.type is equal | text}}
		<label>{{field.parent.label}}</label>
		<textarea class="form-control" name="field_{{field.parent.name}}" rows="5">{{field.value}}</textarea>
	{{endwhen field.parent.type}}

	{{when field.parent.type is equal | html}}
		<label>{{field.parent.label}}</label>
		<textarea class="form-control field-ckeditor" name="field_{{field.parent.name}}" rows="5">{{field.value}}</textarea>
	{{endwhen field.parent.type}}

	{{when field.parent.type is equal | year}}
		<label>{{field.parent.label}}</label>
		<input
			class="form-control field-year-picker"
			type="text"
			name="field_{{field.parent.name}}"
			value="{{field.value:datetime(Y)}}"
		/>
	{{endwhen field.parent.type}}

	{{when field.parent.type is equal | date}}
		<label>{{field.parent.label}}</label>
		<input
			class="form-control field-date-picker"
			type="text"
			name="field_{{field.parent.name}}"
			value="{{field.value:datetime(Y-m-d)}}"
		/>
	{{endwhen field.parent.type}}

	{{when field.parent.type is equal | datetime}}
		<label>{{field.parent.label}}</label>
		<input
			class="form-control field-date-time-picker"
			type="text"
			name="field_{{field.parent.name}}"
			value="{{field.value:datetime(Y-m-d H:i)}}"
		/>
	{{endwhen field.parent.type}}

	{{when field.parent.type is equal | time}}
		<label>{{field.parent.label}}</label>
		<input
			class="form-control field-time-picker"
			type="text"
			name="field_{{field.parent.name}}"
			value="{{field.value:datetime(H:i)}}"
		/>
	{{endwhen field.parent.type}}

	{{when field.parent.type is equal | ip}}
		<label>{{field.parent.label}}</label>
		<input
			class="form-control"
			type="text"
			name="field_{{field.parent.name}}"
			value="{{field.value}}"
		/>
	{{endwhen field.parent.type}}

	{{when field.parent.type is equal | url}}
		<label>{{field.parent.label}}</label>
		<input
			class="form-control"
			type="text"
			name="field_{{field.parent.name}}"
			value="{{field.value}}"
		/>
	{{endwhen field.parent.type}}

	{{when field.parent.type is equal | email}}
		<label>{{field.parent.label}}</label>
		<input
			class="form-control"
			type="text"
			name="field_{{field.parent.name}}"
			value="{{field.value}}"
		/>
	{{endwhen field.parent.type}}

	{{when field.parent.type is equal | image}}
		<label>{{field.parent.label}}</label>

		<input
			class="form-control field-image-attach"
			type="file"
			accept="image/*"
			data-field-id="{{field.id}}"
			data-field-name="field_{{field.parent.name}}"
		/>

		<div class="field-image-container" style="margin-top: 10px; margin-bottom: 10px;" data-field-id="{{field.id}}">
			{{when field.value is not empty}}
				<img class="img-thumbnail" src="/upload/150x0/{{field.value}}" />
				<input type="hidden" name="field_{{field.parent.name}}" value="{{field.value}}" />
			{{endwhen field.value}}
		</div>

		<button type="button" class="btn btn-sm btn-danger field-image-detach" data-field-id="{{field.id}}">
			<i class="fa fa-trash-o" aria-hidden="true"></i> Удалить изображение
		</button>

		<div class="help-block error"></div>
	{{endwhen field.parent.type}}

	<div class="help-block">{{field.parent.tooltip}}</div>
	<div class="help-block error"></div>
</div>
