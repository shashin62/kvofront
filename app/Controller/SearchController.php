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
        $loggedInId = $this->Session->read('User.user_id');
        //for profile
        if (!$peopleId) {
            $peopleId = $this->Session->read('User.user_id');
        }

        $data = $this->People->search($peopleId);
        
        $getParentsIds = $this->People->getParentsId($peopleId);
        $pIds = array();
        foreach ($getParentsIds as $pKey => $pValue) {
            $pIds[] = $pValue['p']['treelevel'];
        }

        $datas = $this->People->getAllMembersByGroup($loggedInId, $peopleId, $pIds);

        $getParents = $this->People->getParents($loggedInId);
        $getParentsArray = $this->__getParentsArray($getParents);
        $getRelationshipsIds = $this->People->getRelationshipIds($loggedInId);
        $getR = $this->_getGroupIds($getRelationshipsIds);
        $finalArray = implode(',', $getR);
        $getGroupIds = $this->People->getGroupIds($finalArray);

        foreach ($getGroupIds as $gKey => $gValue) {
            $gIds[] = $gValue['people_search']['group_id'];
        }

        $assocIds = array();
        $lists = $this->_getLists($datas, $gIds, $loggedInId);
        $rebuildTreeLevels = $this->__reBuildTreeLevels($lists['lists'], $lists['asscoIds'], $loggedInId, $getParentsArray);
        $getTreeLevels = $this->__getTreeLevels($peopleId, $rebuildTreeLevels, $loggedInId);
        $firstName = $rebuildTreeLevels[$peopleId]['first_name'] . '<br/> ' . $rebuildTreeLevels[$peopleId]['last_name'];
        $text = array();
        
        
        if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/people_images/' . $peopleId . '.' . $data['People']['ext']) === true) {
            $imageUrl = $peopleId . '.' . $data['People']['ext'];
            $pic = '<img  src="' . $this->base . '/people_images/' . $peopleId . '.' . $data['People']['ext'] . '" width="35" height="35"><br />';
        } else {
            $imageUrl = '';
            $pic = "";
        }
        
        $text[] = '<td style="min-width:50px;"><a href="javascript: search(' . $id . ')" style="width:50px;">'. $pic. $firstName . '</a></td>';
        $getLinkage = $this->__getRelationShipText($rebuildTreeLevels, $getTreeLevels, $peopleId);
        $getLinkage = array_merge($text, $getLinkage);

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
            list($names[], $names[]) = explode(' ', $familyMembers['partner_name']);
        }
        $father = $peopleData['father'];
        if ($familyMembers['father_name']) {
            $father = $familyMembers['father_name'];
            list($names[], $names[]) = explode(' ', $familyMembers['father_name']);
        }

        $mother = $peopleData['mother'];
        if ($familyMembers['mother_name']) {
            $mother = $familyMembers['mother_name'];
            list($names[], $names[]) = explode(' ', $familyMembers['mother_name']);
        }
        if (count($familyMembers['children'])) {
            foreach ($familyMembers['children'] as $k => $v) {
                list($names[], $names[]) = explode(' ', $v[0]);
            }
        }
        if (count($familyMembers['brothers'])) {
            foreach ($familyMembers['brothers'] as $k => $v) {
                list($names[], $names[]) = explode(' ', $v[0]);
            }
        }
        if (count($familyMembers['sisters'])) {
            foreach ($familyMembers['sisters'] as $k => $v) {
                list($names[], $names[]) = explode(' ', $v[0]);
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

        foreach ($treeData['tree'] as $tKey => $tValue) {
            $this->peopleIds[] = $tValue['ai'];
        }

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
                                                <td>' . $pic . (isset($getTranslations[$peopleData['first_name']]) ? $getTranslations[$peopleData['first_name']] : $peopleData['first_name']) . '<br />' . (isset($getTranslations[$peopleData['last_name']]) ? $getTranslations[$peopleData['last_name']] : $peopleData['last_name']) . '</td>
                                        </tr>
                                </tbody>
                        </table>
                </a>
        </td>';
        $tree = array_merge($searchedName, $dataTree);
        $this->set('treeLinkageData', $getLinkage);
    }

    private function __getTreeLevels($id, $treeData, $loggedinId) {
        $searchid = $treeData[$id]['tree_level'];
        $key = array_search($searchid, $treeData[$id]);
        $ids[] = $searchid;
        if ($searchid != '' && $searchid != $loggedinId) {
            $array1 = $this->__getTreeLevels($searchid, $treeData, $loggedinId);
            $ids = array_merge($ids, $array1);
        }
        return $ids;
    }

    /**
     * Function to rebuild Tree levels
     * @param $tmpArray1 - Array
     */
    private function __reBuildTreeLevels($tmpArray1, $asscoIds, $loggedinId, $getParentsArray) {
        foreach ($tmpArray1 as $keyPerson => $keyValue) {
            if ($keyValue['tree_level'] == " ") {
                if (in_array($keyValue['m_id'], $asscoIds)) {
                    $tmpArray1[$keyPerson]['tree_level'] = $keyValue['m_id'];
                } else if (in_array($keyValue['f_id'], $asscoIds)) {
                    $tmpArray1[$keyPerson]['tree_level'] = $keyValue['f_id'];
                } else if (in_array($keyValue['partner_id'], $asscoIds)) {
                    $tmpArray1[$keyPerson]['tree_level'] = $keyValue['partner_id'];
                } else if (count(array_intersect($keyValue['sisters'], $asscoIds))) {
                    $mathced = array_values(array_intersect($keyValue['sisters'], $asscoIds));
                    $tmpArray1[$keyPerson]['tree_level'] = $mathced[0];
                } else if (count(array_intersect($keyValue['brothers'], $asscoIds))) {
                    $mathced = array_values(array_intersect($keyValue['brothers'], $asscoIds));
                    $tmpArray1[$keyPerson]['tree_level'] = $mathced[0];
                }
            }

            if (!in_array($keyValue['id'], $asscoIds)) {

                if (in_array($keyValue['m_id'], $asscoIds)) {
                    $tmpArray1[$keyPerson]['tree_level'] = $keyValue['m_id'];
                } else if (in_array($keyValue['f_id'], $asscoIds)) {
                    $tmpArray1[$keyPerson]['tree_level'] = $keyValue['f_id'];
                } else if (in_array($keyValue['partner_id'], $asscoIds)) {
                    $tmpArray1[$keyPerson]['tree_level'] = $keyValue['partner_id'];
                } else if (count(array_intersect($keyValue['sisters'], $asscoIds))) {
                    $mathced = array_values(array_intersect($keyValue['sisters'], $asscoIds));
                    $tmpArray1[$keyPerson]['tree_level'] = $mathced[0];
                } else if (count(array_intersect($keyValue['brothers'], $asscoIds))) {
                    $mathced = array_values(array_intersect($keyValue['brothers'], $asscoIds));
                    $tmpArray1[$keyPerson]['tree_level'] = $mathced[0];
                }
            }

            if ($keyValue['id'] == $keyValue['tree_level']) {
                if (in_array($keyValue['m_id'], $asscoIds)) {
                    $tmpArray1[$keyPerson]['tree_level'] = $keyValue['m_id'];
                } else if (in_array($keyValue['f_id'], $asscoIds)) {
                    $tmpArray1[$keyPerson]['tree_level'] = $keyValue['f_id'];
                } else if (in_array($keyValue['partner_id'], $asscoIds)) {
                    $tmpArray1[$keyPerson]['tree_level'] = $keyValue['partner_id'];
                } else if (count(array_intersect($keyValue['sisters'], $asscoIds))) {
                    $mathced = array_values(array_intersect($keyValue['sisters'], $asscoIds));
                    $tmpArray1[$keyPerson]['tree_level'] = $mathced[0];
                } else if (count(array_intersect($keyValue['brothers'], $asscoIds))) {
                    $mathced = array_values(array_intersect($keyValue['brothers'], $asscoIds));
                    $tmpArray1[$keyPerson]['tree_level'] = $mathced[0];
                } else if (in_array($loggedinId, $keyValue['brothers'])) {
                    $key = array_search($loggedinId, $keyValue['brothers']);
                    $tmpArray1[$keyPerson]['tree_level'] = $keyValue['brothers'][$key];
                }
            }

            if (in_array($loggedinId, $keyValue['childs_f'])) {
                $mathced = array_values(array_intersect($keyValue['childs_f'], (array) $loggedinId));
                $tmpArray1[$keyPerson]['tree_level'] = $mathced[0];
            } else if (in_array($loggedinId, $keyValue['sisters'])) {
                $mathced = array_values(array_intersect($keyValue['sisters'], (array) $loggedinId));
                $tmpArray1[$keyPerson]['tree_level'] = $mathced[0];
            } else if (in_array($loggedinId, $keyValue['brothers'])) {
                $mathced = array_values(array_intersect($keyValue['brothers'], (array) $loggedinId));
                $tmpArray1[$keyPerson]['tree_level'] = $mathced[0];
            } if (count(array_intersect($keyValue['brothers'], $getParentsArray))) {
                $mathced = array_values(array_intersect($keyValue['brothers'], $getParentsArray));
                $tmpArray1[$keyPerson]['tree_level'] = $mathced[0];
            } if (count(array_intersect($keyValue['childs_f'], $getParentsArray))) {
                $mathced = array_values(array_intersect($keyValue['childs_f'], $getParentsArray));
                $tmpArray1[$keyPerson]['tree_level'] = $mathced[0];
            }

            if ($keyValue['id'] == $loggedinId) {
                $tmpArray1[$keyPerson]['tree_level'] = '';
            }
        }
        return $tmpArray1;
    }

    /**
     * Private function get Lists
     */
    private function _getLists($datas, $groupIds, $loggedInId) {
        $lists = array();
        $data = array();
        $loggedinId = $loggedInId;

        foreach ($datas as $dataKey => $result) {
            if (in_array($result['p']['group_id'], $groupIds)) {
                $asscoIds[] = $result['p']['id'];
            }

            $lists[$result['p']['id']]['id'] = $result['p']['id'];

            if ($loggedinId != $result['p']['id'] && $result['p']['tree_level'] == '') {
                if ($loggedinId == $result['p']['f_id'] || $loggedinId == $result['p']['m_id'] || $loggedinId == $result['p']['partner_id'] || in_array($loggedinId, explode(',', $result[0]['brothers'])) || in_array($loggedinId, explode(',', $result[0]['sisters'])) || in_array($loggedinId, explode(',', $result[0]['childrens']))) {
                    $lists[$result['p']['id']]['tree_level'] = $loggedinId;
                } else {
                    $lists[$result['p']['id']]['tree_level'] = $result['p']['tree_level'];
                }
            } else {
                $lists[$result['p']['id']]['tree_level'] = $result['p']['tree_level'];
            }

            $lists[$result['p']['id']]['first_name'] = $result['p']['first_name'];
            $lists[$result['p']['id']]['last_name'] = $result['p']['last_name'];
            if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/people_images/' . $result['p']['id'] . '.' . $result['image']['ext']) === true) {
                $lists[$result['p']['id']]['r'] = $result['p']['id'] . '.' . $result['image']['ext'];
            } else {
                $lists[$result['p']['id']]['r'] = '';
            }
            
            $lists[$result['p']['id']]['partner_name'] = $result['p']['partner_name'];
            $lists[$result['p']['id']]['f_id'] = $result['p']['f_id'];
            $lists[$result['p']['id']]['m_id'] = $result['p']['m_id'];
            $lists[$result['p']['id']]['partner_id'] = $result['p']['partner_id'];
            $lists[$result['p']['id']]['group_id'] = $result['p']['group_id'];
            $lists[$result['p']['id']]['gender'] = $result['p']['gender'];
            $lists[$result['p']['id']]['sisters'] = explode(',', $result[0]['sisters']);
            $lists[$result['p']['id']]['brothers'] = explode(',', $result[0]['brothers']);
            $lists[$result['p']['id']]['childs_f'] = explode(',', $result[0]['childrens']);
            $lists[$result['p']['id']]['childs_m'] = explode(',', $result[0]['childrens2']);
        }

        $data['lists'] = $lists;
        $data['asscoIds'] = $asscoIds;
        return $data;
    }

    /**
     * Function get All Groups Ids
     * @param getRelationshipIds - Array
     */
    private function _getGroupIds($getRelationshipIds) {
        foreach ($getRelationshipIds as $k => $v) {
            $m_id = $v['p']['m_id'];
            $f_id = $v['p']['f_id'];
            $partner_id = $v['p']['partner_id'];
            $brothers = explode(',', $v[0]['brothers']);
            $sisters = explode(',', $v[0]['sisters']);
            $sisters1 = explode(',', $v[0]['sisters_s']);
            $brothers1 = explode(',', $v[0]['brothers_f']);
        }
        $array1 = array($m_id, $f_id, $partner_id);
        $finalArray = array_filter(array_merge($array1, $brothers, $sisters, $brothers1, $sisters1));
        return $finalArray;
    }

    /**
     * Function get All Groups Ids

     * @param getParents- Array
     */
    private function __getParentsArray($getParents) {
        foreach ($getParents as $k => $v) {
            $pmid = $v['p']['m_id'];
            $pfid = $v['p']['f_id'];
            $pPid = $v['p']['partner_id'];
            $pSids = explode(',', $v[0]['sisters']);
        }

        $array2 = array($pmid, $pfid, $pPid);
        $finalArray1 = array_filter(array_merge($array2, $pSids));
        return $finalArray1;
    }

    private function __getLevels($id, $tmpArray1) {

        $searchid = $tmpArray1[$id]['tree_level'];
        $key = array_search($searchid, $tmpArray1[$id]);
        $ids[] = $searchid;

        if ($searchid != '') {
            $array1 = $this->__getLevels($searchid, $tmpArray1);
            $ids = array_merge($ids, $array1);
        }
        return $ids;
    }

    private function __getRelationShipText($tmpArray1, $levels, $searchedId) 
    {
        $id = $searchedId;
        
        foreach (array_filter($levels) as $k => $c) {
            unset($tmpArray1[$id]['tree_level']);


            if (in_array($c, $tmpArray1[$id]) || in_array($c, $tmpArray1[$id]['sisters']) || in_array($c, $tmpArray1[$id]['brothers']) || in_array($c, $tmpArray1[$id]['childs_f']) || in_array($c, $tmpArray1[$id]['childs_m'])
            ) {

                $key = array_search($c, $tmpArray1[$id]);
                if ($key == '') {
                    if (in_array($c, $tmpArray1[$id]['childs_f'])) {
                        $key = 'child';
                    }
                    if (in_array($c, $tmpArray1[$id]['childs_m'])) {
                        $key = 'child';
                    }

                    if (in_array($c, $tmpArray1[$id]['brothers'])) {
                        $key = 'brother';
                    }
                    if (in_array($c, $tmpArray1[$id]['sisters'])) {
                        $key = 'sister';
                    }
                }
                if($id != $searchedId) {
                if ($tmpArray1[$id]['r'] != "") {
                    $pic = '<img  src="' . $this->base . '/people_images/' . $tmpArray1[$id]['r'] . '" width="35" height="35"><br />';
                } else {
                    $pic = "";
                }
                }
                switch ($key) {
                    case 'f_id' :

                        if ($tmpArray1[$id]['gender'] == 'Male') {
                            $text[] = '<td><span style="font-size:12px;">&nbsp;&nbsp;--<b>Son of &nbsp;</b>-->&nbsp;&nbsp;</span></td>';
                        } else {
                            $text[] = '<td><span style="font-size:12px;">&nbsp;&nbsp;--<b>Daughter of &nbsp;</b>-->&nbsp;&nbsp;</span></td>';
                        }
                        $text[] = '<td style="min-width:50px;"><a href="javascript: search(' . $tmpArray1[$id]['id'] . ')" style="width:50px;">' . $pic . $tmpArray1[$c]['first_name'] . '<br />' . $tmpArray1[$c]['last_name'] . '</a></td>';
                        break;
                    case 'm_id':
                        if ($tmpArray1[$id]['gender'] == 'Male') {
                            $text[] = '<td><span style="font-size:12px;">&nbsp;&nbsp;--<b>Son of &nbsp;</b>-->&nbsp;&nbsp;</span></td>';
                        } else {
                            $text[] = '<td><span style="font-size:12px;">&nbsp;&nbsp;--<b>Daughter of &nbsp;</b>-->&nbsp;&nbsp;</span></td>';
                        }
                        $text[] = '<td style="min-width:50px;"><a href="javascript: search(' . $tmpArray1[$id]['id'] . ')" style="width:50px;">' . $pic . $tmpArray1[$c]['first_name']. '<br />' . $tmpArray1[$c]['last_name'] . '</a></td>';
                        break;
                    case 'partner_id' :
                        if ($tmpArray1[$id]['gender'] == 'Male') {
                            $text[] = '<td><span style="font-size:12px;">&nbsp;&nbsp;--<b>Husband of &nbsp;</b>-->&nbsp;&nbsp;</span></td>';
                        } else {
                            $text[] = '<td><span style="font-size:12px;">&nbsp;&nbsp;--<b>Wife of &nbsp;</b>-->&nbsp;&nbsp;</span></td>';
                        }
                        $text[] = '<td style="min-width:50px;"><a href="javascript: search(' . $tmpArray1[$id]['id'] . ')" style="width:50px;">' . $pic . $tmpArray1[$c]['first_name'] . '<br />' . $tmpArray1[$c]['last_name'] . '</a></td>';
                        break;
                    case 'child' :
                        if ($tmpArray1[$id]['gender'] == 'Male') {
                            $text[] = '<td><span style="font-size:12px;">&nbsp;&nbsp;--<b>Father of &nbsp;</b>-->&nbsp;&nbsp;</span></td>';
                        } else {
                            $text[] = '<td><span style="font-size:12px;">&nbsp;&nbsp;--<b>Mother of &nbsp;</b>-->&nbsp;&nbsp;</span></td>';
                        }
                        $text[] = '<td style="min-width:50px;"><a href="javascript: search(' . $tmpArray1[$id]['id'] . ')" style="width:50px;">' . $pic . $tmpArray1[$c]['first_name'] . '<br />' . $tmpArray1[$c]['last_name'] . '</a></td>';
                        break;
                    case 'brother' :
                        if ($tmpArray1[$id]['gender'] == 'Male') {
                            $text[] = '<td><span style="font-size:12px;">&nbsp;&nbsp;--<b>Brother of &nbsp;</b>-->&nbsp;&nbsp;</span></td>';
                        } else {
                            $text[] = '<td><span style="font-size:12px;">&nbsp;&nbsp;--<b>Sister of  &nbsp;</b>-->&nbsp;&nbsp;</span></td>';
                        }
                        $text[] = '<td style="min-width:50px;"><a href="javascript: search(' . $tmpArray1[$id]['id'] . ')" style="width:50px;">' . $pic . $tmpArray1[$c]['first_name'] . '<br />' . $tmpArray1[$c]['last_name'] . '</a></td>';

                        break;
                    case 'sister' :
                        if ($tmpArray1[$id]['gender'] == 'male') {
                            $text[] = '<td><span style="font-size:12px;">&nbsp;&nbsp;--<b>Brother of  &nbsp;</b>-->&nbsp;&nbsp;</span></td>';
                        } else {
                            $text[] = '<td><span style="font-size:12px;">&nbsp;&nbsp;--<b>Sister of  &nbsp;</b>-->&nbsp;&nbsp;</span></td>';
                        }
                        $text[] = '<td style="min-width:50px;"><a href="javascript: search(' . $tmpArray1[$id]['id'] . ')" style="width:50px;">' . $pic . $tmpArray1[$c]['first_name'] . '<br />' . $tmpArray1[$c]['last_name'] . '</a></td>';

                        break;
                }
                //$text[] = $tmpArray1[$id]['first_name'] . ' ' . $tmpArray1[$id]['last_name'];
            }
            $id = $c;
        }
        return $text;
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

            list($fnm, $lnm) = explode(' ', $data[$data[$searchedId]['f']]['n']);
            $array[] = '<td style="min-width:50px;"><a href="javascript: search(' . $data[$data[$searchedId]['f']]['ai'] . ')" style="width:50px;">' . $pic . (isset($translations[$fnm]) ? $translations[$fnm] : $fnm) . '<br />' . (isset($translations[$lnm]) ? $translations[$lnm] : $lnm) . '</a></td>';
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

            list($fnm, $lnm) = explode(' ', $data[$data[$searchedId]['c'][$childId]]['n']);
            $array[] = '<td style="min-width:50px;"><a href="javascript: search(' . $data[$data[$searchedId]['c'][$childId]]['ai'] . ')" style="width:50px;">' . $pic . (isset($translations[$fnm]) ? $translations[$fnm] : $fnm) . '<br />' . (isset($translations[$lnm]) ? $translations[$lnm] : $lnm) . '</a></td>';
        } else if (count($data[$searchedId]['bid']) && in_array($userId, $data[$searchedId]['bid'])) {

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
                $array[] = '<td style="min-width:50px;"><a href="javascript: search(' . $this->Session->read('User.id') . ')" style="width:50px;">' . $pic . (isset($translations[$this->Session->read('User.first_name')]) ? $translations[$this->Session->read('User.first_name')] : $this->Session->read('User.first_name')) . '<br />' . (isset($translations[$this->Session->read('User.last_name')]) ? $translations[$this->Session->read('User.last_name')] : $this->Session->read('User.last_name')) . '</a></td>';
            } else {
                $ph = $data[$data[$searchedId]['bid'][$brotherId]]['r'];
                if ($ph != '') {
                    $pic = '<img  src="' . $this->base . '/people_images/' . $ph . '" width="35" height="35"><br />';
                } else {
                    $pic = '';
                }
                list($fnm, $lnm) = explode(' ', $data[$data[$searchedId]['bid'][$brotherId]]['n']);
                $array[] = '<td style="min-width:50px;"><a href="javascript: search(' . $data[$data[$searchedId]['bid'][$brotherId]]['ai'] . ')" style="width:50px;">' . $pic . (isset($translations[$fnm]) ? $translations[$fnm] : $fnm) . '<br />' . (isset($translations[$lnm]) ? $translations[$lnm] : $lnm) . '</a></td>';
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
            list($fnm, $lnm) = explode(' ', $data[$common[0]]['n']);
            $array[] = '<td style="min-width:50px;"><a href="javascript: search(' . $data[$common[0]]['ai'] . ')" style="width:50px;">' . $pic . (isset($translations[$fnm]) ? $translations[$fnm] : $fnm) . '<br />' . (isset($translations[$lnm]) ? $translations[$lnm] : $lnm) . '</a></td>';

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
            list($fnm, $lnm) = explode(' ', $data[$data[$searchedId]['es']]['n']);
            $array[] = '<td style="min-width:50px;"><a href="javascript: search(' . $data[$data[$searchedId]['es']]['ai'] . ')" style="width:50px;">' . $pic . (isset($translations[$fnm]) ? $translations[$fnm] : $fnm) . '<br />' . (isset($translations[$lnm]) ? $translations[$lnm] : $lnm) . '</a></td>';


            if ($data[$searchedId]['es'] != $this->Session->read('User.user_id')) {
                $array1 = $this->_buildLinkage($data, $data[$searchedId]['es'], $this->Session->read('User.user_id'));
                $array = array_merge($array, $array1);
            }
        } else if ($userId == $data[$searchedId]['m']) {
            
        } else if (count(array_intersect($data[$searchedId]['c'], $this->peopleIds))) {
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
            list($fnm, $lnm) = explode(' ', $data[$common[0]]['n']);
            $array[] = '<td style="min-width:50px;"><a href="javascript: search(' . $data[$common[0]]['ai'] . ')" style="width:50px;">' . $pic . (isset($translations[$fnm]) ? $translations[$fnm] : $fnm) . '<br />' . (isset($translations[$lnm]) ? $translations[$lnm] : $lnm) . '</a></td>';

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
            list($fnm, $lnm) = explode(' ', $data[$data[$searchedId]['sid'][0]]['n']);
            $array[] = '<td style="min-width:50px;"><a href="javascript: search(' . $data[$data[$searchedId]['sid'][0]]['ai'] . ')" style="width:50px;">' . $pic . (isset($translations[$fnm]) ? $translations[$fnm] : $fnm) . '<br />' . (isset($translations[$lnm]) ? $translations[$lnm] : $lnm) . '</a></td>';

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
            list($fnm, $lnm) = explode(' ', $data[$data[$searchedId]['bid'][0]]['n']);
            $array[] = '<td style="min-width:50px;"><a href="javascript: search(' . $data[$data[$searchedId]['bid'][0]]['ai'] . ')" style="width:50px;">' . $pic . (isset($translations[$fnm]) ? $translations[$fnm] : $fnm) . ' ' . (isset($translations[$lnm]) ? $translations[$lnm] : $lnm) . '</a></td>';

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
            list($fnm, $lnm) = explode(' ', $data[$data[$searchedId]['f']]['n']);
            $array[] = '<td style="min-width:50px;"><a href="javascript: search(' . $data[$data[$searchedId]['f']]['ai'] . ')" style="width:50px;">' . $pic . (isset($translations[$fnm]) ? $translations[$fnm] : $fnm) . '<br />' . (isset($translations[$lnm]) ? $translations[$lnm] : $lnm) . '</a></td>';

            if ($data[$searchedId]['f'] != $this->Session->read('User.user_id')) {
                $array1 = $this->_buildLinkage($data, $data[$searchedId]['f'], $this->Session->read('User.user_id'));
                $array = array_merge($array, $array1);
            }
        }
        return $array;
    }

}
