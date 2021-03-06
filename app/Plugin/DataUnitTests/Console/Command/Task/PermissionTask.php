<?php
/**
 * Insert Permission Task
 *
 * @copyright (c) 2015-present Bolt Softwares Pvt Ltd
 * @licence GNU Affero General Public License http://www.gnu.org/licenses/agpl-3.0.en.html
 * @package      app.plugins.DataUnitTests.Console.Command.Task.PermissionTask
 * @since        version 2.12.11
 */

require_once(ROOT . DS . APP_DIR . DS . 'Console' . DS . 'Command' . DS . 'Task' . DS . 'ModelTask.php');

App::uses('Permission', 'Model');

class PermissionTask extends ModelTask {

	public $model = 'Permission';

	protected function getData() {
		// Permission ids are automatically generated based on the following rule :
		// Common::uuid('permission.id.[aco_foreign_key]-[aro_foreign_key]')

		// User kathleen@passbolt.com as admin of the root unit test category
		// Sand box for unit tests
		$ps[] = array('Permission' => array(
			'aco' => 'Category',
			'aco_foreign_key' => Common::uuid('category.id.utest'),
			'aro' => 'User',
			'aro_foreign_key' => Common::uuid('user.id.kathleen'),
			'type' => PermissionType::OWNER,
			'created_by' => Common::uuid('user.id.admin'),
			'modified_by' => Common::uuid('user.id.admin')
		));
		// kathleen has admin right on everything
		$ps[] = array('Permission' => array(
			'aco' => 'Category',
			'aco_foreign_key' => Common::uuid('category.id.bolt'),
			'aro' => 'User',
			'aro_foreign_key' => Common::uuid('user.id.lynne'),
			'type' => PermissionType::OWNER,
			'created_by' => Common::uuid('user.id.admin'),
			'modified_by' => Common::uuid('user.id.admin')
		));
		// Group Management has admin rights on everything
		$ps[] = array('Permission' => array(
			'aco' => 'Category',
			'aco_foreign_key' => Common::uuid('category.id.bolt'),
			'aro' => 'Group',
			'aro_foreign_key' => Common::uuid('group.id.management'),
			'type' => PermissionType::OWNER,
			'created_by' => Common::uuid('user.id.admin'),
			'modified_by' => Common::uuid('user.id.admin')
		));
		// Group human resources have read only rights on administration
		$ps[] = array('Permission' => array(
			'aco' => 'Category',
			'aco_foreign_key' => Common::uuid('category.id.administration'),
			'aro' => 'Group',
			'aro_foreign_key' => Common::uuid('group.id.human'),
			'type' => PermissionType::READ,
			'created_by' => Common::uuid('user.id.admin'),
			'modified_by' => Common::uuid('user.id.admin')
		));
		// human resources have no rights on accounts
		// a permission cannot be applied for a group on a category, if there is already
		// a permission defined on a parent category for this same group.
		// See the sql view groups_categories_permissions description in app/Config/Schema/permission.php
		/*$ps[] = array('Permission' => array(
			'id' => '50e6b4af-6d20-4e4e-bbcf-23a4d7a10fce',
			'aco' => 'Category',
			'aco_foreign_key' => Common::uuid('category.id.accounts'),
			'aro' => 'Group',
			'aro_foreign_key' => Common::uuid('group.id.human'),
			'type' => PermissionType::DENY
		));*/
		// Group human resources can modify resource salesforce account
		$ps[] = array('Permission' => array(
			'aco' => 'Resource',
			'aco_foreign_key' => Common::uuid('resource.id.salesforce-account'),
			'aro' => 'Group',
			'aro_foreign_key' => Common::uuid('group.id.human'),
			'type' => PermissionType::UPDATE,
			'created_by' => Common::uuid('user.id.admin'),
			'modified_by' => Common::uuid('user.id.admin')
		));
		// Group human resources cannot access resource facebook account
		$ps[] = array('Permission' => array(
			'aco' => 'Resource',
			'aco_foreign_key' => Common::uuid('resource.id.facebook-account'),
			'aro' => 'Group',
			'aro_foreign_key' => Common::uuid('group.id.human'),
			'type' => PermissionType::DENY,
			'created_by' => Common::uuid('user.id.admin'),
			'modified_by' => Common::uuid('user.id.admin')
		));
		// accounting dpt can access administration>accounts in read only
		$ps[] = array('Permission' => array(
			'aco' => 'Category',
			'aco_foreign_key' => Common::uuid('category.id.accounts'),
			'aro' => 'Group',
			'aro_foreign_key' => Common::uuid('group.id.accounting'),
			'type' => PermissionType::READ,
			'created_by' => Common::uuid('user.id.admin'),
			'modified_by' => Common::uuid('user.id.admin')
		));
		// Group developers drupal have read only rights on Projects > Drupal
		$ps[] = array('Permission' => array(
			'aco' => 'Category',
			'aco_foreign_key' => Common::uuid('category.id.drupal'),
			'aro' => 'Group',
			'aro_foreign_key' => Common::uuid('group.id.developers_drupal'),
			'type' => PermissionType::READ,
			'created_by' => Common::uuid('user.id.admin'),
			'modified_by' => Common::uuid('user.id.admin')
		));
		// ...
		$ps[] = array('Permission' => array(
			'aco' => 'Resource',
			'aco_foreign_key' => Common::uuid('resource.id.dp2-pwd1'),
			'aro' => 'User',
			'aro_foreign_key' => Common::uuid('user.id.carol'),
			'type' => PermissionType::DENY,
			'created_by' => Common::uuid('user.id.admin'),
			'modified_by' => Common::uuid('user.id.admin')
		));
		// Group cakephp has access to category cakephp in readonly
		$ps[] = array('Permission' => array(
			'aco' => 'Category',
			'aco_foreign_key' => Common::uuid('category.id.cakephp'),
			'aro' => 'Group',
			'aro_foreign_key' => Common::uuid('group.id.developers_cakephp'),
			'type' => PermissionType::READ,
			'created_by' => Common::uuid('user.id.admin'),
			'modified_by' => Common::uuid('user.id.admin')
		));
		// Group developers team leads has access to projects in modify
		$ps[] = array('Permission' => array(
			'aco' => 'Category',
			'aco_foreign_key' => Common::uuid('category.id.projects'),
			'aro' => 'Group',
			'aro_foreign_key' => Common::uuid('group.id.developers_team_leads'),
			'type' => PermissionType::UPDATE,
			'created_by' => Common::uuid('user.id.admin'),
			'modified_by' => Common::uuid('user.id.admin')
		));
		// Ada has admin rights on cp-project1
		$ps[] = array('Permission' => array(
			'aco' => 'Category',
			'aco_foreign_key' => Common::uuid('category.id.cp-project1'),
			'aro' => 'User',
			'aro_foreign_key' => Common::uuid('user.id.ada'),
			'type' => PermissionType::OWNER,
			'created_by' => Common::uuid('user.id.admin'),
			'modified_by' => Common::uuid('user.id.admin')
		));
		// Frank has denied right on project
		$ps[] = array('Permission' => array(
			'aco' => 'Category',
			'aco_foreign_key' => Common::uuid('category.id.projects'),
			'aro' => 'User',
			'aro_foreign_key' => Common::uuid('user.id.frances'),
			'type' => PermissionType::DENY,
			'created_by' => Common::uuid('user.id.admin'),
			'modified_by' => Common::uuid('user.id.admin')
		));
		// // Group developers team leads junior has access to projects in modify
//		 $ps[] = array('Permission' => array(
//			 'id' => '50e6b4af-a491-43f5-9cc9-23a4d7a10fce',
//			 'aco' => 'Category',
//			 'aco_foreign_key' => $cat['pro'],
//			 'aro' => 'Group',
//			 'aro_foreign_key' => $groups['tlj'],
//			 'type' => PermissionType::UPDATE,
//		 ));
//		 // Group developers team leads has denied right on cakephp
//		 $ps[] = array('Permission' => array(
//			 'id' => '50e6b4af-a492-43f5-9cc9-23a4d7a10fce',
//			 'aco' => 'Category',
//			 'aco_foreign_key' => $cat['cak'],
//			 'aro' => 'Group',
//			 'aro_foreign_key' => $groups['tlj'],
//			 'type' => PermissionType::DENY,
//		 ));
		// Ada has admin rights on others
		$ps[] = array('Permission' => array(
			'aco' => 'Category',
			'aco_foreign_key' => Common::uuid('category.id.others'),
			'aro' => 'User',
			'aro_foreign_key' => Common::uuid('user.id.ada'),
			'type' => PermissionType::OWNER,
			'created_by' => Common::uuid('user.id.admin'),
			'modified_by' => Common::uuid('user.id.admin')
		));
		//  Freelancers have read only rights to projects others
		$ps[] = array('Permission' => array(
			'aco' => 'Category',
			'aco_foreign_key' => Common::uuid('category.id.others'),
			'aro' => 'Group',
			'aro_foreign_key' => Common::uuid('group.id.freelancers'),
			'type' => PermissionType::READ,
			'created_by' => Common::uuid('user.id.admin'),
			'modified_by' => Common::uuid('user.id.admin')
		));
		// Jean has readonly access rights on cp-project2
		$ps[] = array('Permission' => array(
			'aco' => 'Category',
			'aco_foreign_key' => Common::uuid('category.id.cp-project2'),
			'aro' => 'User',
			'aro_foreign_key' => Common::uuid('user.id.jean'),
			'type' => PermissionType::READ,
			'created_by' => Common::uuid('user.id.admin'),
			'modified_by' => Common::uuid('user.id.admin')
		));
		// Jean has create access rights on "Jean private"
		$ps[] = array('Permission' => array(
			'aco' => 'Category',
			'aco_foreign_key' => Common::uuid('category.id.pv-jean_bartik'),
			'aro' => 'User',
			'aro_foreign_key' => Common::uuid('user.id.jean'),
			'type' => PermissionType::CREATE,
			'created_by' => Common::uuid('user.id.admin'),
			'modified_by' => Common::uuid('user.id.admin')
		));
		// Jean has readonly access rights on cpp1-pwd1
		$ps[] = array('Permission' => array(
			'aco' => 'Resource',
			'aco_foreign_key' => Common::uuid('resource.id.cpp1-pwd1'),
			'aro' => 'User',
			'aro_foreign_key' => Common::uuid('user.id.jean'),
			'type' => PermissionType::READ,
			'created_by' => Common::uuid('user.id.admin'),
			'modified_by' => Common::uuid('user.id.admin')
		));
		//  company a has read only rights to o-project1
		$ps[] = array('Permission' => array(
			'aco' => 'Category',
			'aco_foreign_key' => Common::uuid('category.id.o-project1'),
			'aro' => 'Group',
			'aro_foreign_key' => Common::uuid('group.id.company_a'),
			'type' => PermissionType::READ,
			'created_by' => Common::uuid('user.id.admin'),
			'modified_by' => Common::uuid('user.id.admin')
		));
		//  company a has read only rights to o-project1
		$ps[] = array('Permission' => array(
			'aco' => 'Category',
			'aco_foreign_key' => Common::uuid('category.id.o-project2'),
			'aro' => 'Group',
			'aro_foreign_key' => Common::uuid('group.id.company_a'),
			'type' => PermissionType::UPDATE,
			'created_by' => Common::uuid('user.id.admin'),
			'modified_by' => Common::uuid('user.id.admin')
		));

		return $ps;
	}
}
