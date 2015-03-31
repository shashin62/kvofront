<?php

App::uses('AppModel', 'Model');

class Article extends AppModel {
    
     var $name = 'Article';
     
     public $useTable = 'articles';
     
     /**
     * Function to check if name exists in table
     * 
     * @param type $name
     * 
     * @return boolean 
     */
    public function checkArticleExists($name) {
        $this->recursive = -1;
        $options['conditions'] = array('Article.title' => $name);
        $options['fields'] = array('Article.id');
        try {
            $data = $this->find('all', $options);
            if ($data && isset($data[0]['Article']) && $data[0]['Article'] != "") {
                return $data[0]['Article'];
            } else {
                return array();
            }
        } catch (Exception $e) {
            CakeLog::write('db', __FUNCTION__ . " in " . __CLASS__ . " at " . __LINE__ . $e->getMessage());
            return false;
        }
    }
    
    public function getAllArticles($start, $length) {
       $aColumns = array('id', 'title', 'author', 'created', 'body', 'image' );

        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = "id";

        /* DB table to use */
        $sTable = "articles";

        /*
         * Paging
         */
        $sLimit = "";
        if (isset($start) && $length != '-1') {
            $sLimit = "LIMIT " . $start . ", " .
                    intval($length);
        }

        

        /*
         * SQL queries
         * Get data to display
         */


        $sQuery = "
    SELECT SQL_CALC_FOUND_ROWS `" . str_replace(" , ", " ", implode("`, `", $aColumns)) . "`
            FROM   $sTable           
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
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );

        foreach ($rResult as $key => $value) {

            $row = array();
            for ($i = 0; $i < count($aColumns); $i++) {
                    
                /* General output */
                
                if ($aColumns[$i] == 'body') {
                    $row[] = wordwrap($value['articles'][$aColumns[$i]], 200);
                } else {
                    $row[] = $value['articles'][$aColumns[$i]];
                }
                
            }
            
            //$row[] = is_file(WWW_ROOT . 'files' . DS . 'article' . DS . 'thumb' . DS . $value['articles']['image']) ? 1 : 0;
            $output['aaData'][] = $row;
        }
        return $output;
    }
    
}

