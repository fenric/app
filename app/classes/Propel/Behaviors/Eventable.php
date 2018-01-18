<?php

namespace Fenric\Propel\Behaviors;

/**
* Import classes
*/
use Propel\Generator\Model\Behavior;

/**
* Eventable
*/
class Eventable extends Behavior
{
	public function getEventNameSegment()
	{
		return str_replace([$this->getTable()->getDatabase()->getTablePrefix(), '_'], ['', '.'], $this->getTable()->getName());
	}

	public function getStringConnection()
	{
		return "\Propel\Runtime\Propel::getServiceContainer()->getWriteConnection({$this->getTable()->getPhpName()}TableMap::DATABASE_NAME)";
	}

	public function preSave($builder)
	{
		return "if (! fenric('event::model.{$this->getEventNameSegment()}.pre.save')->run([\$this, {$this->getStringConnection()}])) {
	return 0;
}";
	}

	public function preInsert($builder)
	{
		return "if (! fenric('event::model.{$this->getEventNameSegment()}.pre.insert')->run([\$this, {$this->getStringConnection()}])) {
	return 0;
}";
	}

	public function preUpdate($builder)
	{
		return "if (! fenric('event::model.{$this->getEventNameSegment()}.pre.update')->run([\$this, {$this->getStringConnection()}])) {
	return 0;
}";
	}

	public function preDelete($builder)
	{
		return "if (! fenric('event::model.{$this->getEventNameSegment()}.pre.delete')->run([\$this, {$this->getStringConnection()}])) {
	return 0;
}";
	}

	public function postSave($builder)
	{
		return "fenric('event::model.{$this->getEventNameSegment()}.post.save')->run([\$this, {$this->getStringConnection()}]);";
	}

	public function postInsert($builder)
	{
		return "fenric('event::model.{$this->getEventNameSegment()}.post.insert')->run([\$this, {$this->getStringConnection()}]);";
	}

	public function postUpdate($builder)
	{
		return "fenric('event::model.{$this->getEventNameSegment()}.post.update')->run([\$this, {$this->getStringConnection()}]);";
	}

	public function postDelete($builder)
	{
		return "fenric('event::model.{$this->getEventNameSegment()}.post.delete')->run([\$this, {$this->getStringConnection()}]);";
	}

	public function objectFilter(& $script, $builder)
	{
		$code = "\n" . str_repeat(' ', 8) . "fenric('event::model.{$this->getEventNameSegment()}.validate')->run([func_get_arg(0), {$this->getStringConnection()}]);\n";

		$script = preg_replace('/(function\s+loadValidatorMetadata\s*\([^\(\)]+\)\s*{)/si', "$1{$code}", $script);
	}
}
