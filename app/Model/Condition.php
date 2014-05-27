<?php
/**
 * Condition Model
 *
 * Conditions represent a user study condition. It contains information about the name and associated interface.
 *
 * @author		Russell Toris - rctoris@wpi.edu
 * @copyright	2014 Worcester Polytechnic Institute
 * @link		https://github.com/WPI-RAIL/rms
 * @since		RMS v 2.0.0
 * @version		2.0.0
 * @package		app.Model
 */
class Condition extends AppModel {

	/**
	 * The validation criteria for the model.
	 *
	 * @var array
	 */
	public $validate = array(
		'id' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter a valid ID.',
				'required' => 'update'
			),
			'gt' => array(
				'rule' => array('comparison', '>', 0),
				'message' => 'IDs must be greater than 0.',
				'required' => 'update'
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'This user ID already exists.',
				'required' => 'update'
			)
		),
		'name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter a valid name.',
				'required' => true
			),
			'maxLength' => array(
				'rule' => array('maxLength', 64),
				'message' => 'Names cannot be longer than 64 characters.',
				'required' => true
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'This name already exists.',
				'required' => true
			)
		),
		'study_id' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter a valid study ID.',
				'required' => true
			),
			'gt' => array(
				'rule' => array('comparison', '>', 0),
				'message' => 'Study IDs must be greater than 0.',
				'required' => true
			)
		),
		'iface_id' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter a valid interface ID.',
				'required' => true
			),
			'gt' => array(
				'rule' => array('comparison', '>', 0),
				'message' => 'Interface IDs must be greater than 0.',
				'required' => true
			)
		),
		'created' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter a valid creation time.',
				'required' => 'create'
			)
		),
		'modified' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter a valid modification time.',
				'required' => true
			)
		)
	);

	/**
	 * All conditions belong to a single study and interface.
	 *
	 * @var string
	 */
	public $belongsTo = array('Study' => array('className' => 'Study'), 'Iface' => array('className' => 'Iface'));

	/**
	 * Conditions can have many sessions.
	 *
	 * @var array
	 */
	public $hasMany = array('Session' => array('className' => 'Session', 'dependent' => true));
}