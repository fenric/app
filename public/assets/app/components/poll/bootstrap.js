'use strict';

var $poll;

/**
 * @description
 */
$poll = function()
{};

$poll.submit = function(form)
{
	var i, votes, containers;

	if (form instanceof HTMLFormElement)
	{
		if (form.hasAttribute('data-id'))
		{
			votes = [];

			for (i = 0; i < form.elements.length; i++)
			{
				if (form.elements[i] instanceof HTMLInputElement)
				{
					if (form.elements[i].checked)
					{
						votes.push(form.elements[i].value);
					}
				}
			}

			if (votes.length > 0)
			{
				$request.post('/api/poll/{id}/', {votes: votes}, {id: form.getAttribute('data-id'), success: function(response)
				{
					if (response.success)
					{
						containers = document.querySelectorAll('.poll[data-id="' + form.getAttribute('data-id') + '"]');

						for (i = 0; i < containers.length; i++)
						{
							containers[i].parentNode.replaceChild(
								$bugaboo.fragmentation(response.htmlChart),
							containers[i]);
						}

						return;
					}

					new $notify(function(notify)
					{
						notify.setType(notify.TYPE_ERROR);
						notify.setPosition(notify.POSITION_TOP_RIGHT);
						notify.setMessage(response.message);
						notify.display();
					});
				}});
			}
		}
	}

	return false;
};
