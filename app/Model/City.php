<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class City extends Model {
    public $actsAs = array('Linkable','Containable');
    public $belongsTo = array('State');
    
    public function getCities()
    {
        $aColumns = array( 'id', 'name', 'state_id', 'population');
         
        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = "id";
         
        /* DB table to use */
        $sTable = "cities";
        
          /*
         * Paging
        */
        $sLimit = "";
        if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
        {
            $sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ".
                    intval( $_GET['iDisplayLength'] );
        }
         
         
        /*
         * Ordering
        */
        $sOrder = "";
        if ( isset( $_GET['iSortCol_0'] ) )
        {
            $sOrder = "ORDER BY  ";
            for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
            {
                if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
                {
                    $sOrder .= "`".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."` ".
                        ($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
                }
            }
         
            $sOrder = substr_replace( $sOrder, "", -2 );
            if ( $sOrder == "ORDER BY" )
            {
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
        if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
        {
            $sWhere = "WHERE (";
            for ( $i=0 ; $i<count($aColumns) ; $i++ )
            {
                $sWhere .= "`".$aColumns[$i]."` LIKE '%".( $_GET['sSearch'] )."%' OR ";
            }
            $sWhere = substr_replace( $sWhere, "", -3 );
            $sWhere .= ')';
        }
         /* Individual column filtering */
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
            {
                if ( $sWhere == "" )
                {
                    $sWhere = "WHERE ";
                }
                else
                {
                    $sWhere .= " AND ";
                }
                $sWhere .= "`".$aColumns[$i]."` LIKE '%".($_GET['sSearch_'.$i])."%' ";
            }
        }
        
         /*
         * SQL queries
        * Get data to display
        */
        
        
        $sQuery = "
    SELECT SQL_CALC_FOUND_ROWS `".str_replace(" , ", " ", implode("`, `", $aColumns))."`
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
    SELECT COUNT(`".$sIndexColumn."`) as countid
            FROM   $sTable
            ";
        $rResultTotal =$this->query($sQuery);
        
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
        
        foreach ( $rResult as $key => $value ) {
            
            $row = array();
            for ( $i=0 ; $i<count($aColumns) ; $i++ )
            {
                
                    /* General output */
                    $row[] = $value['cities'][ $aColumns[$i] ];

            }
            $row[] = '';
            $output['aaData'][] = $row;
        }
      
       
         
        return $output;
        
    }
}
