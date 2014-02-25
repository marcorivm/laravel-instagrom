<?php

class Grom extends Eloquent {
	protected $table = 'groms';
	protected $fillable = array('user_id', 'content', 'content_type');
	protected $softDelete = true;

	protected static $storage_path = 'groms/images';

	private static function getName(array $options = array())
	{
		return $options['user_id'] . '_' . time() . '_' . Str::random(4);
	}

	public static function moveAndSave($file, array $options = array())
	{
		$name = static::getName($options) . '.' . $file->getClientOriginalExtension();
		$file->move(public_path(static::$storage_path), $name);
		$image = new self();
		$image->user_id = isset($options['user_id'])?$options['user_id'] : 0;
		$image->content = $name;
		$image->content_type = isset($options['content_type'])? $options['content_type'] : 0;
		$image->save();

		return $image;
	}

	public function getPublicPathAttribute()
	{
		return '/' . static::$storage_path . '/' . $this->content;
	}

	public function delete()
	{
		unlink(public_path(static::$storage_path) . $this->content);
		parent::delete();
	}


}