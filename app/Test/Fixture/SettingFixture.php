<?php
/**
 * SettingFixture
 *
 */
class SettingFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'site_name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_persian_ci', 'charset' => 'utf8'),
		'meta_tags' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_persian_ci', 'charset' => 'utf8'),
		'meta_descriptions' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_persian_ci', 'charset' => 'utf8'),
		'foot_note' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_persian_ci', 'charset' => 'utf8'),
		'admin_address' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_persian_ci', 'charset' => 'utf8'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_persian_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'site_name' => 'Lorem ipsum dolor sit amet',
			'meta_tags' => 'Lorem ipsum dolor sit amet',
			'meta_descriptions' => 'Lorem ipsum dolor sit amet',
			'foot_note' => 'Lorem ipsum dolor sit amet',
			'admin_address' => 'Lorem ipsum dolor sit amet',
			'modified' => '2012-08-15 11:36:15'
		),
	);

}
