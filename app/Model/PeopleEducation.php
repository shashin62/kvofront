<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');

Class PeopleEducation extends AppModel
{
    
     public $name = 'People';
     
     public $useTable = 'people_educations';
     
         /**
     * Function to check if name exists in table
     * 
     * @param type $name
     * 
     * @return boolean 
     */
    public function checkPeopleEducationExists($name) {
        $this->recursive = -1;
        $options['conditions'] = array('PeopleEducation.name' => $name);
        $options['fields'] = array('PeopleEducation.id');
        try {
            $data = $this->find('all', $options);
            if ($data && isset($data[0]['PeopleEducation']) && $data[0]['PeopleEducation'] != "") {
                return $data[0]['PeopleEducation'];
            } else {
                return array();
            }
        } catch (Exception $e) {
            CakeLog::write('db', __FUNCTION__ . " in " . __CLASS__ . " at " . __LINE__ . $e->getMessage());
            return false;
        }
    }
     
     public function getPeopleEducations($peopleId) {
       $aColumns = array('id', 'name', 'institution_name', 'university_name', 'area_specialization', 'year_of_passing', 'percentage', 'part_full_time','people_id');

        /* DB table to use */
        $sTable = "people_educations";

       
        /*
         * Ordering
         */
        $sOrder = " ORDER BY year_of_passing DESC";
        
        /*
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        $sWhere = " WHERE people_id = '".$peopleId."'";
        

        /*
         * SQL queries
         * Get data to display
         */


        $sQuery = "
    SELECT  `" . str_replace(" , ", " ", implode("`, `", $aColumns)) . "`
            FROM   $sTable
            $sWhere
            $sOrder
            ";

        $rResult = $this->query($sQuery);

        return $rResult;
    }
    
    public function getHighestQualification($peopleId) {
        $sQry = "SELECT name FROM {$this->useTable} WHERE people_id = '".$peopleId."' ORDER BY year_of_passing DESC LIMIT 0,1";
        $rResult = $this->query($sQry);
        
        return $rResult[0]['people_educations']['name'];
    }
    
}