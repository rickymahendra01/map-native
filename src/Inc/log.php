<?php
    $id = TextValidation::getText($_POST['id']);
    $log = $model->getListQuery("SELECT b.nama, a.aksi, a.waktu 
                                 FROM log a
                                 LEFT JOIN (SELECT id, nama FROM akun) AS b
                                 ON (a.fkAkun=b.id)
                                 WHERE (fkTable='".$id."') AND (table_='".$_table_."') 
                                 ORDER BY a.waktu DESC",
                                array('nama','aksi','waktu'));
    $content = "";
    for ($i=0;$i<count($log);$i++){
        $waktu = explode(" ", $log[$i]['waktu']);
        $content .= "<div class='col-md-12'>
                        <div class='alert alert-secondary'>
                            <ul style='font-size: 0.9em; list-style: none; line-height:20px;'>
                                <li>Waktu : ".TanggalIndo::getTanggalIndo($waktu[0])." ".$waktu[1]."</li>
                                <li>Aksi : ".$log[$i]['aksi']."</li>
                                <li>Akun : ".$log[$i]['nama']."</li>
                            </ul>
                        </div>
                    </div>";
    }
    if ($content=="") $content = "Tidak Ada Log";
    echo $content;
?>