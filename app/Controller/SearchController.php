<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

Class SearchController extends AppController {

    /**
     *
     * @var type 
     */
    public $name = 'Search';

    /**
     *
     * @var type 
     */
    public $uses = array('User', 'People', 'Group', 'PeopleGroup', 'Sister', 'Brother');

    /**
     *
     * @var type 
     */
    public $helpers = array('Session');

    /**
     *
     * @var type 
     */
    public $components = array('Session', 'Tree');
    public $peopleIds = [];
    public $translations = array();

    /**
     * 
     * @param type $needle
     * @param type $haystack
     * @param type $strict
     * @return boolean
     */
    private function __in_array_r($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->__in_array_r($needle, $item, $strict))) {
                return $item;
            }
        }
        return false;
    }

    /**
     * 
     */
    public function index() {
        $peopleId = $this->request->data['id'];

        //for profile
        if (!$peopleId) {
            $peopleId = $this->Session->read('User.user_id');
        }
        
        $data = $this->People->search($peopleId);

        $loggedUserData = $this->People->search($this->Session->read('User.user_id'));
        $sisters = $this->Sister->getSisters($this->Session->read('User.user_id'));
        $brothers = $this->Brother->getBrothers($this->Session->read('User.user_id'));

        foreach ($loggedUserData as $d1 => $d3) {
            $this->peopleIds[] = $d3['id'];
            $this->peopleIds[] = $d3['f_id'];
            $this->peopleIds[] = $d3['m_id'];
            $this->peopleIds[] = $d3['partner_id'];
            foreach ($sisters as $ks => $vs) {
                $this->peopleIds[] = $vs;
            }
            foreach ($brothers as $kb => $vb) {
                $this->peopleIds[] = $vb;
            }
            //$this->peopleIds[] = $d3['brother_id'];
        }
        $peopleData = $data['People'];
        $groupData = $data['Group'];
        $addressData = $data['Address'];
        $userID = $this->Session->read('User.user_id');
        $this->set('peopleData', $peopleData);
        $this->set('groupData', $groupData);
        $this->set('addressData', $addressData);
        
        
        $familyMembers = $this->People->getFamilyMembers($peopleId);
        $this->set('familyMembers', $familyMembers);
        
        
        //translations
        $names[0] = $peopleData['first_name'];
        $names[1] = $peopleData['last_name'];
        if ($familyMembers['partner_name']) {
            list($names[],$names[]) = explode(' ', $familyMembers['partner_name']);
        }
        $father = $peopleData['father'];
        if ($familyMembers['father_name']) {
            $father = $familyMembers['father_name'];
            list($names[],$names[]) = explode(' ', $familyMembers['father_name']);
        }
        $mother = $peopleData['mother'];
        if ($familyMembers['mother_name']) {
            $mother = $familyMembers['mother_name'];
            list($names[],$names[]) = explode(' ', $familyMembers['mother_name']);
        }
        if (count($familyMembers['children'])) {
            foreach ($familyMembers['children'] as $k => $v) {
                list($names[],$names[]) = explode(' ', $v[0]);
            }
        }
        if (count($familyMembers['brothers'])) {
            foreach ($familyMembers['brothers'] as $k => $v) {
                list($names[],$names[]) = explode(' ', $v[0]);
            }
        }
        if (count($familyMembers['sisters'])) {
            foreach ($familyMembers['sisters'] as $k => $v) {
                list($names[],$names[]) = explode(' ', $v[0]);
            }
        }
        
        $names = array_filter(array_unique($names));
        
        $selLanguage = 'english';
        $lang = 'english_text';
        if ($this->Session->check('Website.language')) {
            $selLanguage = $this->Session->read('Website.language');
            if ($selLanguage == 'hindi') {
                $lang = 'hindi_text';
            } elseif ($selLanguage == 'gujurati') {
                $lang = 'gujurathi_text';
            } else {
                $lang = 'english_text';
            }
        }        
      
        $getTranslations = $this->People->getTranslations($names, $lang);
        $this->set('translations', $getTranslations);
        
        $this->translations = $getTranslations;
        
        $treeData = $this->Tree->buildTreeJson($groupData['group_id']);
        
        foreach ( $treeData['tree'] as $tKey => $tValue) {
           // $this->peopleIds[] = $tValue['ai'];
        }
        $dataTree = $this->_buildLinkage($treeData['tree'], $this->request->data['id'], $userID, false);
        
        if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/people_images/' . $peopleData['id'] . '.' . $peopleData['ext']) === true) {
            $pic = '<img  src="' . $this->base . '/people_images/' . $peopleData['id'] . '.' . $peopleData['ext'] . '" width="35" height="35"><br />';
        } else {
            $pic = '';
        }
        
        $searchedName[] = '<td> 
                <a href="#" style="width:50px;">
                        <table>
                                <tbody>
                                        <tr>
                                                <td>'.$pic.(isset($getTranslations[$peopleData['first_name']]) ? $getTranslations[$peopleData['first_name']] :  $peopleData['first_name']) . '<br />' . (isset($getTranslations[$peopleData['last_name']]) ? $getTranslations[$peopleData['last_name']] :  $peopleData['last_name']).'</td>
                                        </tr>
                                </tbody>
                        </table>
                </a>
        </td>';
        
        //$searchedName[] = (isset($getTranslations[$peopleData['first_name']]) ? $getTranslations[$peopleData['first_name']] :  $peopleData['first_name']) . ' ' . (isset($getTranslations[$peopleData['last_name']]) ? $getTranslations[$peopleData['last_name']] :  $peopleData['last_name']);
        $tree = array_merge($searchedName, $dataTree);
        $this->set('treeLinkageData', $tree);
    }
    
    /**
     * 
     * @param type $data
     * @param type $searchedId
     * @param type $userId
     * @param type $flag
     * @return type
     */
    private function _buildLinkage($data, $searchedId, $userId, $flag) {
     
        
        $translations = $this->translations;
        if ($userId == $data[$searchedId]['f']) {
            
            if ($data[$searchedId]['g'] == 'f') {
                $text = '<td><span style="font-size:12px;">&nbsp;&nbsp;--<b>Daughter Of&nbsp;</b>-->&nbsp;&nbsp;</span></td>';
            } else {
                $text = '<td><span style="font-size:12px;">&nbsp;&nbsp;--<b>Son Of&nbsp;</b>-->&nbsp;&nbsp;</span></td>';
            }
            $array[] = $text;
            
            $ph = $data[$data[$searchedId]['f']]['r'];
            if ($ph != '') {
                $pic = '<img  src="' . $this->base . '/people_images/' . $ph . '" width="35" height="35"><br />';
            } else {
                $pic = '';
            }
            
            list($fnm, $lnm) = explode (' ', $data[$data[$searchedId]['f']]['n']);
            $array[] = '<td style="min-width:50px;"><a href="javascript: search('.$data[$data[$searchedId]['f']]['ai'].')" style="width:50px;">'.$pic.(isset($translations[$fnm]) ? $translations[$fnm] :  $fnm) . '<br />' . (isset($translations[$lnm]) ? $translations[$lnm] :  $lnm).'</a></td>';
        } else if (count($data[$searchedId]['c']) && in_array($userId, $data[$searchedId]['c'])) {
            $childId = array_search($userId, $data[$searchedId]['c']);
            if ($data[$searchedId]['g'] == 'f') {
                $text = '<td><span style="font-size:12px;">&nbsp;&nbsp;--<b>Mother Of&nbsp;</b>-->&nbsp;&nbsp;</span></td>';
            } else {
                $text = '<td><span style="font-size:12px;">&nbsp;&nbsp;--<b>Father Of&nbsp;</b>-->&nbsp;&nbsp;</span></td>';
            }
            $array[] = $text;
            
            $ph = $data[$data[$searchedId]['c'][$childId]]['r'];
            if ($ph != '') {
                $pic = '<img  src="' . $this->base . '/people_images/' . $ph . '" width="35" height="35"><br />';
            } else {
                $pic = '';
            }
            
            list($fnm, $lnm) = explode (' ', $data[$data[$searchedId]['c'][$childId]]['n']);
            $array[] = '<td style="min-width:50px;"><a href="javascript: search('.$data[$data[$searchedId]['c'][$childId]]['ai'].')" style="width:50px;">'.$pic.(isset($translations[$fnm]) ? $translations[$fnm] :  $fnm) . '<br />' . (isset($translations[$lnm]) ? $translations[$lnm] :  $lnm).'</a></td>';
        } else if (count($data[$searchedId]['bid']) & in_array($userId, $data[$searchedId]['bid'])) {

            $brotherId = array_search($userId, $data[$searchedId]['bid']);

            if ($data[$searchedId]['g'] == 'f') {
                $text = '<td><span style="font-size:12px;">&nbsp;&nbsp;--<b>Sister Of&nbsp;</b>-->&nbsp;&nbsp;</span></td>';
            } else {
                $text = '<td><span style="font-size:12px;">&nbsp;&nbsp;--<b>Brother Of&nbsp;</b>-->&nbsp;&nbsp;</span></td>';
            }
            $array[] = $text;
            
            if ($brotherId == 0) {
                if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/people_images/' . $this->Session->read('User.id') . '.' . $this->Session->read('User.ext')) === true) {
                    $pic = '<img  src="' . $this->base . '/people_images/' . $this->Session->read('User.id') . '.' . $this->Session->read('User.ext') . '" width="35" height="35"><br />';
                } else {
                    $pic = '';
                }
                $array[] = '<td style="min-width:50px;"><a href="javascript: search('.$this->Session->read('User.id').')" style="width:50px;">'.$pic.(isset($translations[$this->Session->read('User.first_name')]) ? $translations[$this->Session->read('User.first_name')] :  $this->Session->read('User.first_name')) . '<br />' . (isset($translations[$this->Session->read('User.last_name')]) ? $translations[$this->Session->read('User.last_name')] :  $this->Session->read('User.last_name')).'</a></td>';
              
            } else  {
                $ph = $data[$data[$searchedId]['bid'][$brotherId]]['r'];
                if ($ph != '') {
                    $pic = '<img  src="' . $this->base . '/people_images/' . $ph . '" width="35" height="35"><br />';
                } else {
                    $pic = '';
                }
                list($fnm, $lnm) = explode (' ', $data[$data[$searchedId]['bid'][$brotherId]]['n']);
                $array[] = '<td style="min-width:50px;"><a href="javascript: search('.$data[$data[$searchedId]['bid'][$brotherId]]['ai'].')" style="width:50px;">'.$pic.(isset($translations[$fnm]) ? $translations[$fnm] :  $fnm) . '<br />' . (isset($translations[$lnm]) ? $translations[$lnm] :  $lnm).'</a></td>';
            }
        } else if (count($data[$searchedId]['sid']) && in_array($userId, $data[$searchedId]['sid'])) {
            exit;
        } else if (count(array_intersect($data[$searchedId]['sid'], $this->peopleIds))) {

            $common = array_values(array_intersect($data[$searchedId]['sid'], $this->peopleIds));
            $textLabel = 'Sister of';
            if ($data[$searchedId]['g'] == 'm') {
                $textLabel = 'Brother of';
            }
            $text = '<td><span style="font-size:12px;">&nbsp;&nbsp;--<b>' . $textLabel . ' </b>-->&nbsp;&nbsp;</span></td>';
            $array[] = $text;
            
            $ph = $data[$common[0]]['r'];
            if ($ph != '') {
                $pic = '<img  src="' . $this->base . '/people_images/' . $ph . '" width="35" height="35"><br />';
            } else {
                $pic = '';
            }
            list($fnm, $lnm) = explode (' ', $data[$common[0]]['n']);
            $array[] = '<td style="min-width:50px;"><a href="javascript: search('.$data[$common[0]]['ai'].')" style="width:50px;">'.$pic.(isset($translations[$fnm]) ? $translations[$fnm] :  $fnm) . '<br />' . (isset($translations[$lnm]) ? $translations[$lnm] :  $lnm).'</a></td>';
            
            if ($common[0] != $this->Session->read('User.user_id')) {
                $array1 = $this->_buildLinkage($data, $common[0], $this->Session->read('User.user_id'));
                $array = array_merge($array, $array1);
            }
        } else if ($data[$searchedId]['es'] != '' && in_array($data[$searchedId]['es'], $this->peopleIds)) {
            
            if ($data[$searchedId]['g'] == 'f') {
                $text = '<td><span style="font-size:12px;">&nbsp;&nbsp;--<b>Wife Of&nbsp;</b>-->&nbsp;&nbsp;</span></td>';
            } else {
                $text = '<td><span style="font-size:12px;">&nbsp;&nbsp;--<b>Husband Of&nbsp;</b>-->&nbsp;&nbsp;</span></td>';
            }
            $array[] = $text;
            
            $ph = $data[$data[$searchedId]['es']]['r'];
            if ($ph != '') {
                $pic = '<img  src="' . $this->base . '/people_images/' . $ph . '" width="35" height="35"><br />';
            } else {
                $pic = '';
            }
            list($fnm, $lnm) = explode (' ', $data[$data[$searchedId]['es']]['n']);
            $array[] = '<td style="min-width:50px;"><a href="javascript: search('.$data[$data[$searchedId]['es']]['ai'].')" style="width:50px;">'.$pic.(isset($translations[$fnm]) ? $translations[$fnm] :  $fnm) . '<br />' . (isset($translations[$lnm]) ? $translations[$lnm] :  $lnm).'</a></td>';
            
            
            if ($data[$searchedId]['es'] != $this->Session->read('User.user_id')) {
                $array1 = $this->_buildLinkage($data, $data[$searchedId]['es'], $this->Session->read('User.user_id'));
                $array = array_merge($array, $array1);
            }
        } else if ($userId == $data[$searchedId]['m']) {
            
        } else if ( count(array_intersect($data[$searchedId]['c'], $this->peopleIds))) {
            $common = array_values(array_intersect($data[$searchedId]['c'], $this->peopleIds));
            $textLabel = 'Mother of';
            if ($data[$searchedId]['g'] == 'm') {
                $textLabel = 'Father of';
            }
            $text = '<td><span style="font-size:12px;">&nbsp;&nbsp;--<b>' . $textLabel . ' </b>-->&nbsp;&nbsp;</span></td>';
            $array[] = $text;
            
            $ph = $data[$common[0]]['r'];
            if ($ph != '') {
                $pic = '<img  src="' . $this->base . '/people_images/' . $ph . '" width="35" height="35"><br />';
            } else {
                $pic = '';
            }
            list($fnm, $lnm) = explode (' ', $data[$common[0]]['n']);
            $array[] = '<td style="min-width:50px;"><a href="javascript: search('.$data[$common[0]]['ai'].')" style="width:50px;">'.$pic.(isset($translations[$fnm]) ? $translations[$fnm] :  $fnm) . '<br />' . (isset($translations[$lnm]) ? $translations[$lnm] :  $lnm).'</a></td>';
            
            if ($common[0] != $this->Session->read('User.user_id')) {
                $array1 = $this->_buildLinkage($data, $common[0], $this->Session->read('User.user_id'));
                $array = array_merge($array, $array1);
            }
        } else if (count($data[$searchedId]['sid']) && is_array($data[$searchedId]['sid']) && $flag == false) {

            $textLabel = 'Sister of';
            if ($data[$searchedId]['g'] == 'm') {
                $textLabel = 'Brother of';
            }
            $text = '<td><span style="font-size:12px;">&nbsp;&nbsp;--<b>' . $textLabel . ' </b>-->&nbsp;&nbsp;</span></td>';
            $array[] = $text;
         
            $ph = $data[$data[$searchedId]['sid'][0]]['r'];
            if ($ph != '') {
                $pic = '<img  src="' . $this->base . '/people_images/' . $ph . '" width="35" height="35"><br />';
            } else {
                $pic = '';
            }
            list($fnm, $lnm) = explode (' ', $data[$data[$searchedId]['sid'][0]]['n']);
            $array[] = '<td style="min-width:50px;"><a href="javascript: search('.$data[$data[$searchedId]['sid'][0]]['ai'].')" style="width:50px;">'.$pic.(isset($translations[$fnm]) ? $translations[$fnm] :  $fnm) . '<br />' . (isset($translations[$lnm]) ? $translations[$lnm] :  $lnm).'</a></td>';

            if ($data[$searchedId]['sid'][0] != $this->Session->read('User.user_id')) {
                $array1 = $this->_buildLinkage($data, $data[$searchedId]['sid'][0], $this->Session->read('User.user_id'), true);
                $array = array_merge($array, $array1);
            }
        } else if (count($data[$searchedId]['bid']) && is_array($data[$searchedId]['bid']) && $flag == false) {

            $textLabel = 'Sister of';
            if ($data[$searchedId]['g'] == 'm') {
                $textLabel = 'Brother of';
            }
            $text = '<td><span style="font-size:12px;">&nbsp;&nbsp;--<b>' . $textLabel . ' </b>-->&nbsp;&nbsp;</span></td>';
            $array[] = $text;
         
            $ph = $data[$data[$searchedId]['bid'][0]]['r'];
            if ($ph != '') {
                $pic = '<img  src="' . $this->base . '/people_images/' . $ph . '" width="35" height="35">&nbsp;';
            } else {
                $pic = '';
            }
            list($fnm, $lnm) = explode (' ', $data[$data[$searchedId]['bid'][0]]['n']);
            $array[] = '<td style="min-width:50px;"><a href="javascript: search('.$data[$data[$searchedId]['bid'][0]]['ai'].')" style="width:50px;">'.$pic.(isset($translations[$fnm]) ? $translations[$fnm] :  $fnm) . ' ' . (isset($translations[$lnm]) ? $translations[$lnm] :  $lnm).'</a></td>';

            if ($data[$searchedId]['bid'][0] != $this->Session->read('User.user_id')) {
                $array1 = $this->_buildLinkage($data, $data[$searchedId]['bid'][0], $this->Session->read('User.user_id'), true);
                $array = array_merge($array, $array1);
            }
        } else if ($data[$searchedId]['f'] != '') {

            if ($data[$searchedId]['g'] == 'f') {
                $text = '<td><span style="font-size:12px;">&nbsp;&nbsp;--<b>Daughter Of&nbsp;</b>-->&nbsp;&nbsp;</span></td>';
            } else {
                $text = '<td><span style="font-size:12px;">&nbsp;&nbsp;--<b>Son Of&nbsp;</b>-->&nbsp;&nbsp;</span></td>';
            }
            $array[] = $text;
          
            $ph = $data[$data[$searchedId]['f']]['r'];
            if ($ph != '') {
                $pic = '<img  src="' . $this->base . '/people_images/' . $ph . '" width="35" height="35"><br />';
            } else {
                $pic = '';
            }
            list($fnm, $lnm) = explode (' ', $data[$data[$searchedId]['f']]['n']);
            $array[] = '<td style="min-width:50px;"><a href="javascript: search('.$data[$data[$searchedId]['f']]['ai'].')" style="width:50px;">'.$pic.(isset($translations[$fnm]) ? $translations[$fnm] :  $fnm) . '<br />' . (isset($translations[$lnm]) ? $translations[$lnm] :  $lnm).'</a></td>';
            
            if ($data[$searchedId]['f'] != $this->Session->read('User.user_id')) {
                $array1 = $this->_buildLinkage($data, $data[$searchedId]['f'], $this->Session->read('User.user_id'));
                $array = array_merge($array, $array1);
            }
        }
        return $array;
    }
}
