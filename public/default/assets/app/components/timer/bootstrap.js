'use strict';

var $timer;

$timer = function(delay, callback)
{
	this.id = null;
	this.delay = delay;
	this.callback = callback;

	this.continue();
};

$timer.prototype.pause = function()
{
	this.break();

	this.delay -= new Date() - this.start;
};

$timer.prototype.continue = function()
{
	this.break();

	this.start = new Date();

	this.id = setTimeout(this.callback, this.delay);
};

$timer.prototype.break = function()
{
	clearTimeout(this.id);
};
