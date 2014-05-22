<?php
/**
 * Interfaces Controller
 *
 * An interface contains information about the name of the interface and class definition. Ifaces is used to prevent
 * using the reserved PHP keyword interface.
 *
 * @author		Russell Toris - rctoris@wpi.edu
 * @copyright	2014 Worcester Polytechnic Institute
 * @link		https://github.com/WPI-RAIL/rms
 * @since		RMS v 2.0.0
 * @version		2.0.0
 * @package		app.Controller
 */
class IfacesController extends AppController {

	/**
	 * The used helpers for the controller.
	 *
	 * @var array
	 */
	public $helpers = array('Html', 'Form');

	/**
	 * The used components for the controller.
	 *
	 * @var array
	 */
	public $components = array('Session', 'Auth' => array('authorize' => 'Controller'));

	/**
	 * The admin index action lists information about all interfaces. This allows the admin to add, edit, or delete
	 * entries.
	 */
	public function admin_index() {
		// grab all the entries
		$this->set('ifaces', $this->Iface->find('all'));
		$this->set('title_for_layout', 'Interfaces');
	}

	/**
	 * The admin add action. This will allow the admin to create a new entry.
	 */
	public function admin_add() {
		// only work for POST requests
		if ($this->request->is('post')) {
			// create a new entry
			$this->Iface->create();
			// set the current timestamp for creation and modification
			$this->Iface->data['Iface']['created'] = date('Y-m-d H:i:s');
			$this->Iface->data['Iface']['modified'] = date('Y-m-d H:i:s');
			// attempt to save the entry
			if ($this->Iface->save($this->request->data)) {
				$this->Session->setFlash('The interface has been saved.');
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash('Unable to add the interface.');
		}

		$this->set('title_for_layout', 'Add Interface');
	}

	/**
	 * The admin edit action. This allows the admin to edit an existing entry.
	 *
	 * @param int $id The ID of the entry to edit.
	 * @throws NotFoundException Thrown if an entry with the given ID is not found.
	 */
	public function admin_edit($id = null) {
		if (!$id) {
			// no ID provided
			throw new NotFoundException('Invalid interface.');
		}

		$iface = $this->Iface->findById($id);
		if (!$iface) {
			// no valid entry found for the given ID
			throw new NotFoundException('Invalid interface.');
		}

		// only work for PUT requests
		if ($this->request->is(array('iface', 'put'))) {
			// set the ID
			$this->Iface->id = $id;
			// set the current timestamp for modification
			$this->Iface->data['Iface']['modified'] = date('Y-m-d H:i:s');
			// attempt to save the entry
			if ($this->Iface->save($this->request->data)) {
				$this->Session->setFlash('The interface has been updated.');
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash('Unable to update the interface.');
		}

		// store the entry data if it was not a PUT request
		if (!$this->request->data) {
			$this->request->data = $iface;
		}

		$this->set('title_for_layout', __('Edit Interface - %s', $iface['Iface']['name']));
	}

	/**
	 * The admin delete action. This allows the admin to delete an existing entry.
	 *
	 * @param int $id The ID of the entry to delete.
	 * @throws MethodNotAllowedException Thrown if a GET request is made.
	 */
	public function admin_delete($id = null) {
		// do not allow GET requests
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}

		// attempt to delete the entry
		if ($this->Iface->delete($id)) {
			$this->Session->setFlash('The interface has been deleted.');
			return $this->redirect(array('action' => 'index'));
		}
	}
}