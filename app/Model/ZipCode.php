<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');

Class ZipCode extends AppModel
{
      public $name = 'ZipCode';
     
     public $useTable = 'zip_codes';
     
      public function getZipCodesData($term, $data = false) {
         $this->recursive = -1;
        
        $options['conditions'] = array('ZipCode.zip_code like' => '%'.$term.'%');
        $options['fields'] = array('ZipCode.zip_code','ZipCode.id');
        if ($data) {
           $options['conditions'] = array('ZipCode.zip_code' => $term);  
           $options['fields'] = array('ZipCode.zip_code','ZipCode.id','ZipCode.state',
               'ZipCode.city','ZipCode.suburb','ZipCode.zone','ZipCode.std');
        } else {
            $options['group']  = array('ZipCode.zip_code');
        }
        
        
        try {
            $userData = $this->find('all', $options);
            if ($userData && isset($userData[0])) {
                return $userData;
            } else {
                return array();
            }
        } catch (Exception $e) {
            CakeLog::write('db', __FUNCTION__ . " in " . __CLASS__ . " at " . __LINE__ . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Function to check if name exists in table
     * 
     * @param type $name
     * 
     * @return boolean 
     */
    public function checkZipCodeExists($zip_code) {
        $this->recursive = -1;
        $options['conditions'] = array('ZipCode.zip_code' => $zip_code);
        $options['fields'] = array('ZipCode.id');
        try {
            $translationData = $this->find('all', $options);
            if ($translationData && isset($translationData[0]['ZipCode']) && $translationData[0]['ZipCode'] != "") {
                return $translationData[0]['ZipCode'];
            } else {
                return array();
            }
        } catch (Exception $e) {
            CakeLog::write('db', __FUNCTION__ . " in " . __CLASS__ . " at " . __LINE__ . $e->getMessage());
            return false;
        }
    }
    
    public function getAllZipCodes($missing = false) {
        if ($missing) {
            $aColumns = array('id', 'zip_code', 'created');
        } else {
            $aColumns = array('id', 'zip_code', 'suburb', 'zone', 'city', 'state', 'std');
        }

        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = "id";

        /* DB table to use */
        $sTable = "zip_codes";

        /*
         * Paging
         */
        $sLimit = "";
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = "LIMIT " . intval($_GET['iDisplayStart']) . ", " .
                    intval($_GET['iDisplayLength']);
        }


        /*
         * Ordering
         */
        $sOrder = "";
        if (isset($_GET['iSortCol_0'])) {
            $sOrder = "ORDER BY  ";
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $sOrder .= "`" . $aColumns[intval($_GET['iSortCol_' . $i])] . "` " .
                            ($_GET['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc') . ", ";
                }
            }

            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == "ORDER BY") {
                $sOrder = "";
            }
        }
        /*
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        $sWhere = "";
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $sWhere = "WHERE (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= "`" . $aColumns[$i] . "` LIKE '%" . ($_GET['sSearch']) . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')';
        }
        /* Individual column filtering */
        for ($i = 0; $i < count($aColumns); $i++) {
            if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
                if ($sWhere == "") {
                    $sWhere = "WHERE ";
                } else {
                    $sWhere .= " AND ";
                }
                $sWhere .= "`" . $aColumns[$i] . "` LIKE '%" . ($_GET['sSearch_' . $i]) . "%' ";
            }
        }
        
       

        /*
         * SQL queries
         * Get data to display
         */


        $sQuery = "
    SELECT SQL_CALC_FOUND_ROWS `" . str_replace(" , ", " ", implode("`, `", $aColumns)) . "`
            FROM   $sTable
            $sWhere
            $sOrder
            $sLimit
            ";

        $rResult = $this->query($sQuery);

        /* Data set length after filtering */
        $sQuery = "
    SELECT FOUND_ROWS() as total
";
        $rResultFilterTotal = $this->query($sQuery);

        $iFilteredTotal = $rResultFilterTotal[0][0]['total'];

        /* Total data set length */
        $sQuery = "
    SELECT COUNT(`" . $sIndexColumn . "`) as countid
            FROM   $sTable
            ";
        $rResultTotal = $this->query($sQuery);

        $iTotal = $rResultTotal[0][0]['countid'];


        /*
         * Output
         */
        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );

        foreach ($rResult as $key => $value) {

            $row = array();
            for ($i = 0; $i < count($aColumns); $i++) {
               if ($aColumns[$i] == 'status') {
                    switch ($value['zip_codes'][$aColumns[$i]]) {
                        case 1:
                            $status = 'Active';

                            break;

                        default:
                            break;
                    }
                     $value['zip_codes'][$aColumns[$i]] = $status;
               }
                    
                /* General output */
                $row[] = $value['zip_codes'][$aColumns[$i]];
            }
            $row[] = '';
            $output['aaData'][] = $row;
        }
        return $output;
    }
   
}
    
   
     