<?php

App::uses('AppModel', 'Model');

class Translation extends AppModel {
    
     var $name = 'Translation';
     
     
    /**
     * Function to check if name exists in table
     * 
     * @param type $name
     * 
     * @return boolean 
     */
    public function checkTranslationExists($name) {
        $this->recursive = -1;
        $options['conditions'] = array('Translation.name' => $name);
        $options['fields'] = array('Translation.id');
        try {
            $translationData = $this->find('all', $options);
            if ($translationData && isset($translationData[0]['Translation']) && $translationData[0]['Translation'] != "") {
                return $translationData[0]['Translation'];
            } else {
                return array();
            }
        } catch (Exception $e) {
            CakeLog::write('db', __FUNCTION__ . " in " . __CLASS__ . " at " . __LINE__ . $e->getMessage());
            return false;
        }
    }
    
     
     public function getAllTranslations($missing = false) {
         if( $missing) {
             $aColumns = array('id', 'name','created');
         } else {
        $aColumns = array('id', 'name','gujurathi_text','hindi_text', 'status',);
         }

        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = "id";

        /* DB table to use */
        $sTable = "translations";

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
        
        if ($missing) {
            if ($sWhere == "") {
                $sWhere = "WHERE ";
            } else {
                $sWhere .= ' AND ';
            }
            $sWhere .= ' name != "" AND (gujurathi_text IS NULL OR  hindi_text IS NULL )';
        } else {
             if ($sWhere == "") {
                $sWhere = "WHERE ";
            } else {
                $sWhere .= ' AND ';
            }
            $sWhere .= ' name != "" ';
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
                    switch ($value['translations'][$aColumns[$i]]) {
                        case 1:
                            $status = 'Active';

                            break;

                        default:
                            break;
                    }
                     $value['translations'][$aColumns[$i]] = $status;
               }
                    
                /* General output */
                $row[] = $value['translations'][$aColumns[$i]];
            }
            $row[] = '';
            $output['aaData'][] = $row;
        }
        return $output;
    }
    
    public function getAllMissingData()
    {
        
    }
    
}

