<?php
/**
 * Copyright 2014 Hendrik Schmeer on behalf of DARIAH-EU, VCC2 and DARIAH-DE,
 * Credits to Erasmus University Rotterdam, University of Cologne, PIREH / University Paris 1
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array(
	    'Course');


	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow('display');
	}

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
    public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));

		if($page == 'downloads') $this->setOptionLists();

		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug') > 1) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}


	private function setOptionLists() {
        $countries = $this->Course->Country->find('list');
        $cities = $this->Course->City->find('list', array(
            'contain' => array('Country'),
            'fields' => array('City.id','City.name','Country.name')));
        ksort($cities);
        $institutions = $this->Course->Institution->find('list', array(
            'contain' => array('Country'),
            'fields' => array('Institution.id','Institution.name','Country.name')));
        ksort($institutions);
        $course_types = $this->Course->CourseType->find('list', array('contain' => array()));
        $disciplines = $this->Course->Discipline->find('list', array('contain' => array()));
        $objects = $this->Course->TadirahObject->find('list', array('contain' => array()));
        $techniques = $this->Course->TadirahTechnique->find('list', array('contain' => array()));

        $this->set(compact('countries','cities',
            'institutions','course_types','disciplines',
            'objects','techniques'));
    }

}
