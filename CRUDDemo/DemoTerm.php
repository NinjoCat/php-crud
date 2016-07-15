<?php

namespace CRUDDemo;

class DemoTerm implements
	\OLOG\Model\InterfaceFactory,
	\OLOG\Model\InterfaceLoad,
	\OLOG\Model\InterfaceSave,
	\OLOG\Model\InterfaceDelete
{
	use \OLOG\Model\FactoryTrait;
	use \OLOG\Model\ActiveRecord;
	use \OLOG\Model\ProtectProperties;

	const DB_ID         = 'phpcrud';
	const DB_TABLE_NAME = 'term';

	protected $chooser = null;
	protected $options = null;
	protected $id;

	public function getOptions()
	{
		return $this->options;
	}

	public function setOptions($value)
	{
		$this->options = $value;
	}

	public function getChooser()
	{
		return $this->chooser;
	}

	public function setChooser($value)
	{
		$this->chooser = $value;
	}

	protected $title  = '';
	protected $gender = null;
	protected $parent_id;

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getGender()
	{
		return $this->gender;
	}

	/**
	 * @param string $gender
	 */
	public function setGender($gender)
	{
		$this->gender = $gender;
	}

	/**
	 * @return mixed
	 */
	public function getParentId()
	{
		return $this->parent_id;
	}

	/**
	 * @param mixed $parent_id
	 */
	public function setParentId($parent_id)
	{
		$this->parent_id = $parent_id;
	}
}