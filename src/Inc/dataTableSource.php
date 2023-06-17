<?php
    $sLimit = "";
    if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ){
        $sLimit = "LIMIT ".$control->getText($_GET['iDisplayStart']).", ".$control->getText($_GET['iDisplayLength'] );
    }
    
    /* Ordering */
    if (!(isset($sOrder))){
        if ( isset( $_GET['iSortCol_0'] ) ){
            $sOrder = "ORDER BY  ";
            for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ){
                if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ){
                    $sOrder .= $aColumns[ (intval( $_GET['iSortCol_'.$i] ))+1 ]." ". $control->getText($_GET['sSortDir_'.$i] ) .", ";
                }
            }

            $sOrder = substr_replace( $sOrder, "", -2 );
            if ( $sOrder == "ORDER BY" ){
                $sOrder = "";
            }
        }
    }
    
    /* Filtering */
    if (!(isset($sWhere))){
        $sWhere = "";
        $tWhere = "";
    }else{
        $tWhere = $sWhere;
    }
    if ( $_GET['sSearch'] != "" ){
        if ($sWhere=="")
            $sWhere = "WHERE (";
        else $sWhere .= " AND (";
        for ( $i=0 ; $i<count($aColumns)-1 ; $i++ ){
            $sWhere .= $aColumns[$i+1]." LIKE '%".$control->getText($_GET['sSearch'] )."%' OR ";
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ')';
    }
	
    /* Individual column filtering */
    for ( $i=0 ; $i<count($aColumns)-1 ; $i++ ){
        if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' ){
            if ( $sWhere == "" ){
		$sWhere = "WHERE ";
            }else{
                $sWhere .= " AND ";
            }
            $sWhere .= $aColumns[$i+1]." LIKE '%".$control->getText($_GET['sSearch_'.$i])."%' ";
        }
    }
	
    /* SQL queries Get data to display */
    $sQuery = "SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
               FROM  ".$sTable." ".
               $sJoin." ".
               $sWhere." ".
               $sOrder." ".
               $sLimit;
    //echo $sQuery;
    $aRow = $control->model->getListQuery($sQuery, $arrColumns);
	
    /* Data set length after filtering */
    $aResultFilterTotal = $control->model->getListQuery("SELECT FOUND_ROWS()",array('c'));
    $iFilteredTotal = $aResultFilterTotal[0]->c;
	
    /* Total data set length */
    $aResultTotal = $control->model->getListQuery("SELECT COUNT(".$sIndexColumn.")
                                                   FROM ".$sTable." ".
                                                   $sJoin." ".
                                                   $tWhere,
                                                   array('c'));
    $iTotal = $aResultTotal[0]->c;
	
    /* Output */
    $output = array("sEcho" => intval($_GET['sEcho']),
                    "iTotalRecords" => intval($iTotal),
                    "iTotalDisplayRecords" => intval($iFilteredTotal),
                    "aaData" => array());
?>
