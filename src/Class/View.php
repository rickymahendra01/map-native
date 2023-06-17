<?php
    class View{
        public function getPanel($width, $type, $title, $content, $additionalClass){
            $return = "<div class=\"mb-3 col-lg-".$width."\">
                            <div class=\"card shadow-none".$additionalClass."\">";
            if ($title!="")
                $return .= "     <div class=\"card-header bg-primary text-white\"><h6>".$title."</h6></div>";
            $return .= "         <div class=\"card-body\">";
            $return .= $content."</div>
                            </div>
                        </div>";
            return $return;
        }
        public function getAccordion($id, $idTitle, $idParent, $title, $content){
            $return = "<div class='card accordion-item m-3'>
                            <h2 class='accordion-header'>
                                <button
                                  type='button'
                                  class='accordion-button collapsed'
                                  data-bs-toggle='collapse'
                                  data-bs-target='#".$id."'
                                  aria-expanded='false'
                                  aria-controls='".$id."'
                                >
                                  ".$title."
                                </button>
                            </h2>
                            <div
                                id='".$id."'
                                class='accordion-collapse collapse'
                                aria-labelledby='".$idTitle."'
                                data-bs-parent='#".$idParent."'
                                >
                                <div class='accordion-body'>
                                  ".$content."
                                </div>
                            </div> </div>";
            return $return;
        }
        public function getPanelNoWidth($type, $title, $content, $additionalClass){
            $return = "     <div class=\"card shadow-sm border-left-1 border-right-1 border-top-lg ".$additionalClass."\">";
            if ($title!="")
                $return .= "     <div class=\"card-header py-3 d-flex flex-row align-items-center justify-content-between\"><h6 class='m-0 font-weight-bold text-primary'>".$title."</h6></div>";
            $return .= "         <div class=\"card-body\">";
            $return .= $content."</div>
                            </div>";
            return $return;
        }
        public function getPanelDashboard($color, $contentText, $contentValue, $contentLink, $faIcon){
            $detail = ($contentLink!="") ? "<a href=\"javascript:void(0);\" onclick=\"".$contentLink."\">Detail <i class='fas fa-arrow-right'></i></a>" : "";
            $return = "     <div class=\"card border-top-0 border-bottom-0 border-right-0 border-left-lg border-".$color." h-100\">
                                <div class=\"card-body\">
                                    <div class=\"d-flex align-items-center\">
                                        <div class=\"flex-grow-1\">
                                            <div class=\"small font-weight-bold text-".$color." mb-1\">".$contentText."</div>
                                                <div class=\"h3\">".$contentValue."</div>
                                                <div class=\"text-xs font-weight-bold text-success d-inline-flex align-items-center\">
                                                    ".$detail."
                                                </div>
                                            </div>
                                            <div class=\"ml-2\"><i class=\"fas ".$faIcon." fa-2x text-gray-200\"></i></div>
                                        </div>
                                </div>
                            </div>";
            return $return;
        }
        public function getPanelDropDown($width, $title, $content, $additionalClass, $id, $dropdown){
            $return = "     <div class=\"card shadow-none border-left-1 border-right-1 border-top-lg ".$additionalClass."\" style='max-height: 350px;'>";
            if ($title!="")
                $return .= "     <div class=\"card-header py-3 d-flex flex-row align-items-center justify-content-between\">
                                 <h6 class='m-0 font-weight-bold text-primary'>".$title."</h6>
                                 <div class='dropdown no-arrow'>
                                        <a class='dropdown-toggle' href='#' role='button' id='dropdown".$id."'
                                           data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                            <i class='fas fa-ellipsis-v fa-sm fa-fw text-gray-400'></i>
                                        </a>
                                        <div class='dropdown-menu dropdown-menu-right shadow animated--fade-in'
                                             aria-labelledby='dropdown".$id."'>
                                            ".$dropdown."
                                        </div>
                                    </div>
                                 </div>";
            $return .= "         <div class=\"card-body\">";
            $return .= $content."</div>
                            </div>";
            return $return;
        }
        public function getButtonEdit($folder, $id, $title, $focus, $control){
            return "<a title=\"Ubah\" href='javascript:void(0);' onclick=\"".$control->getPageForm($title, "edit&id=".$id, $folder, $focus)."\" class='text-secondary mr-2'><i class='fas fa-pen'></i></a> ";
        }
        public function getButtonEditCal($folder, $id, $title, $focus, $control){
            return "<a title=\"Calculation\" href='javascript:void(0);' onclick=\"".$control->getPageForm($title, "edit&id=".$id, $folder, $focus)."\" class='text-primary pr-1'><i class='mdi mdi-calculator'></i></a> ";
        }
        public function getButtonEditUpload($folder, $id, $title, $focus, $control){
            return "<a title=\"Calculation\" href='javascript:void(0);' onclick=\"".$control->getPageForm($title, "edit&id=".$id, $folder, $focus)."\" class='text-primary pr-1'><i class='fas fa-upload'></i> Unggah</a> ";
        }
        public function getButtonEditEye($folder, $id, $title, $focus, $control){
            return "<a title=\"Lihat\" href='javascript:void(0);' onclick=\"".$control->getPageForm($title, "edit&id=".$id, $folder, $focus)."\" class='text-info pr-1'><i class='fa fa-file'></i></a> ";
        }
        public function getButtonEditModal($folder, $file, $id, $title){
            return "<a title=\"Ubah\" href='javascript:void(0);' 
                       onclick=\"callSingle2('".$folder."', '".$file."', 'id=".$id."', 'formModal_content',true);
                                $('#formModal_title').html('".$title."'); 
                                $('#formModal').modal('show');\" class='text-primary border-right pr-1'><i class='mdi mdi-pencil'  style='font-size: 1.5em;'></i></a> ";
        }
        public function getButtonLog($tableName, $id){
            return "<a title=\"Log\" href='javascript:void(0);' class='text-black'
                       onclick=\"$('#modalLog').modal('show');
                                 callSingle('log','log.php','table=".$tableName."&id=".$id."', 'contentLog');\"><i class=\"fas fa-history\"></i></a> ";
        }
        public function getLinkProses($title, $file, $data, $divMessage, $btnType, $icon){
            return "<a href='page/".$file.".php?".$data."' target='proses' 
                       onclick=\"if (confirm('Anda yakin ?')) { 
                                 $('#".$divMessage."').html('<div class=\'d-flex justify-content-center\'><div class=\'spinner-border spinner-border-md text-danger\' role=\'status\'><span class=\'visually-hidden\'>Loading...</span></div></div>');
                                 }else return false;\"  class=\"btn ".$btnType." btn-sm\"> <i class=\"".$icon." mr-1\"></i> ".$title."</a> ";
        }
        public function getLinkBack($backAction, $tag){
            return "<a href='#".$tag."' 
                       onclick=\"".$backAction."\" class=\"btn btn-light btn-sm\"><i data-feather=\"arrow-left\"></i> Kembali</a>";
        }
        public function getLinkModal($title, $idModal, $btnType, $icon, $tag, $eventOnClick){
            return "<a href='#".$tag."' data-toggle='modal' data-target='#".$idModal."' onclick=\"".$eventOnClick."\"
                       class=\"btn ".$btnType." btn-sm\"><i class=\"".$icon."  mr-1\"></i> ".$title."</a>";
        }
        public function getButtonDelete($folder, $id){
            return "<a title=\"Hapus\" href='./?m=menu&d=".$folder."&f=delete.php&id=".$id."' target='proses'  class='text-danger pr-1 '
                       onclick=\"if (confirm('Hapus Data ?')) { 
                                 $('#pesan').html('<div class=\'d-flex justify-content-center\'><div class=\'spinner-border spinner-border-md text-primary\' role=\'status\'><span class=\'visually-hidden\'>Loading...</span></div></div>');
                                 }else return false;\"> <i class=\"fas fa-trash\"></i></a> ";
        }
        public function getButtonVerifikasi($folder, $id){
            return "<a title=\"Verifikasi\" href='./?m=menu&d=".$folder."&f=verifikasi.php&id=".$id."' target='proses'  class='text-primary'
                       onclick=\"if (confirm('Verifikasi Akun ?')) { 
                                 $('#pesan').html('<div class=\'d-flex justify-content-center\'><div class=\'spinner-border spinner-border-md text-primary\' role=\'status\'><span class=\'visually-hidden\'>Loading...</span></div></div>');
                                 }else return false;\"> <i class=\"bx bx-check\"></i></a> ";
        }
        public function getButtonDeleteFile($folder, $file, $id, $loadDiv){
            return "<a title=\"Hapus\" href='./?m=menu&d=".$folder."&f=".$file."&id=".$id."' target='proses'  class='text-danger pr-1 border-right'
                       onclick=\"if (confirm('Hapus Data ?')) { 
                                 $('#".$loadDiv."').html('<div class=\'d-flex justify-content-center\'><div class=\'spinner-border spinner-border-md text-primary\' role=\'status\'><span class=\'visually-hidden\'>Loading...</span></div></div>');
                                 }else return false;\"> <i class=\"mdi mdi-delete\" style='font-size: 1.5em;'></i></a> ";
        }
        public function getButtonApprove($folder, $id){
            return "<a title=\"Setujui Pengajuan\" href='page/".$folder."/setuju.php?id=".$id."' target='proses' class='btn btn-sm btn-outline-success' 
                       onclick=\"if (confirm('Setujui Pengajuan ?')) { 
                                 $('#pesan').html('<div class=\'d-flex justify-content-center\'><div class=\'spinner-border spinner-border-md text-danger\' role=\'status\'><span class=\'visually-hidden\'>Loading...</span></div></div>');
                                 }else return false;\"> <i class=\"fas fa-check\"></i></a> ";
        }
        public function getButtonReject($folder, $id){
            return "<a title=\"Tolak Pengajuan\" href='page/".$folder."/tolak.php?id=".$id."' target='proses' class='btn btn-sm btn-outline-danger'
                       onclick=\"if (confirm('Tolak Pengajuan ?')) { 
                                 $('#pesan').html('<div class=\'d-flex justify-content-center\'><div class=\'spinner-border spinner-border-md text-danger\' role=\'status\'><span class=\'visually-hidden\'>Loading...</span></div></div>');
                                 }else return false;\"> <i class=\"fas fa-times\"></i></a> ";
        }
        public function getButtonBack($backAction, $labelWidth, $inputWidth){
            return "<div class=\"form-group\">
                        <a href=\"#\" onclick=\"".$backAction."\" class=\"btn btn-light btn-sm tooltips lift\"><i data-feather=\"arrow-left\"></i></a>
                    </div>";
        }
        public function getDivCenter($content){
            return  "<div class=\"text-center\">".$content."</div>";
        }
        public function getDivRow($content){
            return  "<div class=\"row\">".$content."</div>";
        }
        public function getDivRowClass($class,$content){
            return  "<div class=\"row ".$class."\">".$content."</div>";
        }
        public function getDivSub($width, $content){
            return  "<div class=\"col-lg-".$width."\">".$content."</div>";
        }
        public function getDivSubAttr($width, $content, $attr){
            return  "<div class=\"col-lg-".$width."\" ".$attr.">".$content."</div>";
        }
        public function getForm($input, $action){
            return "<form onsubmit=\"$('#pesan').html('<div class=\'d-flex justify-content-center\'><div class=\'spinner-border text-danger\' role=\'status\'><span class=\'visually-hidden\'>Loading...</span></div></div>');\" 
                          target=\"proses\" action=\"".$action."\" method=\"POST\" enctype=\"multipart/form-data\" id=\"form_data\">
                          ".$input."
                    </form>";
        }
        public function getDivCollapse($tag, $title, $content, $additionalClass){
            return "<div class='card card-collapsable ".$additionalClass."'>
                        <a class='card-header' href='#collapse".$tag."' data-toggle='collapse' role='button' aria-expanded='true' aria-controls='collapse".$tag."'><h6 class='text-danger font-weight-bold'>".$title."</h6>
                        </a>
                        <div class='collapse' id='collapse".$tag."'>
                            <div class='card-body'>
                                ".$content."
                            </div>
                        </div>
                    </div>";
        }
        public function getLinkCollapse($tag, $label, $content){
            return "<a class='card-collapsable' href='#collapse".$tag."' data-toggle='collapse' role='button' aria-expanded='true' aria-controls='collapse".$tag."'>".$label."</a>
                        <div class='collapse' id='collapse".$tag."'>
                            <div class='card card-body'>
                                ".$content."
                            </div>
                        </div>
                    </div>";
        }
        public function getFormCustomJs($input, $action, $actJs){
            return "<form class=\"form-horizontal\" onsubmit=\"".$actJs."\" target=\"proses\"
                          action=\"".$action."\" method=\"POST\" enctype=\"multipart/form-data\" id=\"form_data\">
                          ".$input."
                    </form>";
        }
        public function getFormNameTable($name, $input, $action){
            return "<form onsubmit=\"$('#pesan').html('<div class=\'d-flex justify-content-center\'><div class=\'spinner-border spinner-border-md text-danger\' role=\'status\'><span class=\'visually-hidden\'>Loading...</span></div></div>');\" 
                          target=\"proses\" action=\"".$action."\" method=\"POST\" enctype=\"multipart/form-data\" id=\"".$name."\">
                          ".$input."
                    </form>";
        }
        public function getFormName($name, $input, $action){
            return "<form onsubmit=\"$('#pesan').html('<div class=\'mr-2\'><div class=\'spinner-border spinner-border-sm text-danger\' role=\'status\'><span class=\'visually-hidden\'>Loading...</span></div></div>'); $('#pesan').focus();\" 
                          target=\"proses\" action=\"".$action."\" method=\"POST\" enctype=\"multipart/form-data\" id=\"".$name."\">
                          ".$input."
                    </form>";
        }
        public function getFormNameMessage($name, $input, $action, $idMessage){
            return "<form onsubmit=\"$('#".$idMessage."').html('<div class=\'mr-2\'><div class=\'spinner-border spinner-border-sm text-danger\' role=\'status\'><span class=\'visually-hidden\'>Loading...</span></div></div>'); \" 
                          target=\"proses\" action=\"".$action."\" method=\"POST\" enctype=\"multipart/form-data\" id=\"".$name."\">
                          ".$input."
                    </form>";
        }
        public function getFormNameMessageCustomJs($name, $input, $action, $idMessage, $actJs){
            return "<form onsubmit=\"$('#".$idMessage."').html('<div class=\'mr-2\'><div class=\'spinner-border spinner-border-sm text-danger\' role=\'status\'><span class=\'visually-hidden\'>Loading...</span></div></div>'); 
                                     ".$actJs."\" 
                          target=\"proses\" action=\"".$action."\" method=\"POST\" enctype=\"multipart/form-data\" id=\"".$name."\">
                          ".$input."
                    </form>";
        }
        public function getFormNameLoading($name, $input, $action, $loading){
            return "<form onsubmit=\"$('#".$loading."').html('<div class=\'mr-2\'><div class=\'spinner-border spinner-border-sm text-danger\' role=\'status\'><span class=\'visually-hidden\'>Loading...</span></div></div>');\" 
                          target=\"proses\" action=\"".$action."\" method=\"POST\" enctype=\"multipart/form-data\" id=\"".$name."\">
                          ".$input."
                    </form>";
        }
        public function getFormModal($input, $action, $pesan){
            return "<form onsubmit=\"$('#".$pesan."').html('<div class=\'center\'><div class=\'spinner-border text-danger\' role=\'status\'><span class=\'visually-hidden\'>Loading...</span></div></div>');\" 
                          target=\"proses\" action=\"".$action."\" method=\"POST\" enctype=\"multipart/form-data\" id=\"formModal_data\">
                          ".$input."
                    </form>";
        }
        public function getFormReport($formId, $input, $action){
            return "<form target=\"_BLANK\" action=\"".$action."\" id=\"".$formId."\" method=\"POST\" enctype=\"multipart/form-data\" id=\"form_data\">
                        ".$input."
                    </form>";
        }
        public function getDivInput($title, $input){
            return "<div class=\"form-group mb-3\"> 
                        <label>".$title."</label>
                        ".$input."
                    </div>";
        }
        public function getDivInputInline($label, $input, $widthLabel, $widthInput){
            return $this->getDivRow($this->getDivSub($widthLabel." bg-gray-200 ", $title).
                                    $this->getDivSub(strval(12 - intval($widthLabel)." .bg-gray-100 "), 
                                                     $this->getDivRow($this->getDivSub($widthInput, $input))));
        }
        public function getFormSelect($name, $additionalAttribut, $additionalClass, $option, $value){
            $return = "<select name=\"".$name."\" id=\"".$name."\" class=\"form-control ".$additionalClass."\" ".$additionalAttribut.">";
            for ($i=0;$i<count($option);$i++){
                $selected = ($option[$i]->value==$value) ? "selected" : "";
                $return .= "<option value=\"".$option[$i]->value."\" ".$selected.">".$option[$i]->title."</option>";
            }
            $return .= "</select>";
            return $return;
        }
        public function getFormSelectGroup($name, $additionalAttribut, $additionalClass, $optionGroup, $option, $value){
            $return = "<select name=\"".$name."\" id=\"".$name."\" class=\"form-control ".$additionalClass."\" ".$additionalAttribut." style=\'height: 40px;\'>";
            for ($i=0;$i<count($optionGroup);$i++){
                $return .= "<optgroup label='".$optionGroup[$i]->title."'>";
                for ($j=0;$j<count($option[$i]);$j++){
                    $selected = ($option[$i]->value==$value) ? "selected" : "";
                    $return .= "<option value=\"".$option[$i][$j]->value."\" ".$selected.">".$option[$i][$j]->title."</option>";
                }
                $return .= "</optgroup>";
            }
            $return .= "</select>";
            return $return;
        }
        public function getFormInputText($type, $name, $value, $maxLength, $placeholder, $additionalAttribut){
            $id = ($name!="pesan") ? $name : "id_".$name;
            if ($type=="hidden")
                return "<input type=\"".$type."\" class=\"form-control px-2 border\" name=\"".$name."\" id=\".$name.\"
                               value=\"".$value."\" maxlength=\"".$maxLength."\" ".$additionalAttribut.">";
            else
                return "<input type=\"".$type."\" class=\"form-control px-2 border\" name=\"".$name."\" id=\"".$id."\"
                               value=\"".$value."\" maxlength=\"".$maxLength."\" ".$additionalAttribut." placeholder=\"".$placeholder."\">";
        }
        public function getFormInputTextCustom($label, $type, $name, $value, $maxLength, $additionalAttribut, $additionalClass){
            return "<div class=\"input-group input-group-outline my-3\">
                        <label class=\"form-label\">".$label."</label>
                        <input type=\"".$type."\" name=\"".$name."\" id=\"".$name."\" class=\"form-control ".$additionalClass."\" ".$additionalAttribut." maxlength=\"".$maxLength."\">
                  </div>";
        }
        public function getFormInputTextButton($name, $value, $maxLength, $placeholder, $onclick){
            return "<div class=\"input-group\">
                        <input type=\"text\" class=\"form-control form-control-solid\" value=\"".$value."\" name=\"".$name."\" id=\"".$name."\" placeholder=\"".$placeholder."\" readonly>
                        <div class=\"input-group-append\">
                            <button class=\"btn btn-outline-primary\" type=\"button\" onclick=\"".$onclick."\"><i data-feather=\"search\"></i></button>
                        </div>
                      </div>";
        }
        public function getFormInputTextLabel($name, $idLabel, $value, $valueLabel, $maxLength, $placeholder){
            return "<div class=\"input-group mb-3\">
                        <div class=\"input-group-prepend\">
                          <span class=\"input-group-text\" id=\"".$idLabel."\">".$valueLabel."</span>
                        </div>
                        <input type=\"text\" class=\"form-control\" value=\"".$value."\" name=\"".$name."\" id=\"".$name."\" placeholder=\"".$placeholder."\">
                    </div>";
        }
        public function getFormInputFile($name){
            return "<div class=\"custom-file\">
                        <input type=\"file\" class=\"custom-file-input\" id=\"".$name."\" name=\"".$name."\" onchange=\"setBrowseFile('".$name."')\" >
                    </div>";
        }
        public function getFormInputFileLabel($name, $label){
            return "<div class=\"custom-file\">
                        <input type=\"file\" class=\"custom-file-input\" id=\"".$name."\" name=\"".$name."\" onchange=\"setBrowseFile('".$name."')\" >
                        <label class=\"custom-file-label\" for=\"".$name."\">".$label."</label>
                    </div>";
        }
        public function getFormInputFileSubmit($name, $formId){
            return "<div class=\"custom-file\">
                        <label class=\"custom-file-label\" for=\"".$name."\">Pilih file</label>
                        <input type=\"file\" class=\"custom-file-input\" id=\"".$name."\" name=\"".$name."\" onchange=\"$('#".$formId."').submit();setBrowseFile('".$name."');\" >
                        
                    </div>";
        }
        public function getFormInputFileSubmitCustom($id, $dir_, $file_){
            return "<div class=\"input-group\">
                        <input type='hidden' name='".$id."' id='".$id."'>
                        <input type=\"file\" class=\"form-control\" id=\"file_".$id."\" name=\"file_".$id."\" onchange=\"setUploadFile('file_".$id."','".$id."','pesan_".$id."','".$dir_."','".$file_."');\" >
                    </div><span id='pesan_".$id."'></span>";
        }

        public function getFormInputTextClass($type, $name, $value, $maxLength, $placeholder, $additionalAttribut, $additionalClass){
            if ($type=="hidden")
                return "<input type=\"".$type."\" class=\"form-control border p-2  ".$additionalClass."\" name=\"".$name."\" id=\".$name.\"
                               value=\"".$value."\" maxlength=\"".$maxLength."\" ".$additionalAttribut.">";
            else
                return "<input type=\"".$type."\" class=\"form-control border p-2 ".$additionalClass."\" name=\"".$name."\" id=\"".$name."\"
                               value=\"".$value."\" maxlength=\"".$maxLength."\" ".$additionalAttribut." placeholder=\"".$placeholder."\">";
        }
        public function getFormInputRadio($name, $id, $value, $check, $title, $additionalAttribut, $additonalClass){
            $checked = ($check) ? "checked" : "";
            return "<div class=\"form-check ml-5\">
                        <input class=\"form-check-input".$additonalClass."\" id=\"".$id."\" name=\"".$name."\" type=\"radio\" value=\"".$value."\" ".$additionalAttribut." ".$checked."/>
                        <label class=\"form-check-label\" for=\"".$id."\" style='font-size: 13px !important; margin-left: 0px !important;'>".$title."</label>
                    </div>";
        }
        public function getFormInputCheckbox($name, $value, $title, $additionalAttribut, $additonalClass){
            $checked = ($value) ? "checked" : "";
            return "<div class=\"custom-control custom-checkbox\">
                        <input class=\"custom-control-input ".$additonalClass."\" id=\"".$name."\" name=\"".$name."\" type=\"checkbox\" ".$additionalAttribut." ".$checked."/>
                        <label class=\"custom-control-label\" for=\"".$name."\">".$title."</label>
                    </div>";
        }
        public function getFormInputCheckboxCustom($name, $value, $valOn, $valOff, $additionalAttribute){
            $checked = ($value) ? "checked" : "";
            return "<input type='checkbox' ".$checked." name=\"".$name."\" id=\"".$name."\"  class='checkboxToggle' ".$additionalAttribute."
                     data-toggle='toggle' data-on='".$valOn."' data-off='".$valOff."' data-onstyle='success' data-offstyle='danger' data-width='80' data-height='20'>";
        }
        public function getFormInputTextArea($name, $value, $rows, $placeHolder, $additionalAttribut){
            return "<textarea class=\"form-control border p-3\" name=\"".$name."\" id=\"".$name."\" ".$additionalAttribut." rows=\"".$rows."\" placeholder=\"".$placeHolder."\">".$value."</textarea>";
        } 
        public function getFormInputTextAreaClass($name, $value, $rows,$additionalAttribut,$additionalClass){
            return "<textarea class=\"form-control ".$additionalClass." \" name=\"".$name."\" id=\"".$name."\" ".$additionalAttribut." rows=\"".$rows."\">".$value."</textarea>";
        } 
        public function getAttributNumberInput(){
            return "onkeypress=\"javascript: return numerik(event);\"";
        }
        public function getAttributNumberInputDecimal(){
            return "onkeypress=\"javascript: return numerik(event);\" 
                    onkeyup=\"javascript:angka(this);\"
                    onblur=\"javascript:angka(this);\"";
        }
        public function getAttributNumberInputDecimalAdd($f_){
            return "onkeypress=\"javascript: return numerik(event);\" 
                    onkeyup=\"javascript:angka(this); ".$f_."\"
                    onblur=\"javascript:angka(this); ".$f_."\"";
        }
        public function getFormInfoUpdated($info){
            return "<div class=\"form-group\">
                        <label class=\"col-md-12\">Terakhir diperbaharui: ".$info."</label>
                    </div>";
        }
        public function getFormButtonSubmit($formId, $title){
            return "<div class=\"form-group\">
                        <a href=\"#\" onclick=\"$('#".$formId."').submit();\" class=\"btn btn-success btn-block btn-sm\"> ".$title."</a>
                        <div id='pesan' style='display: inline-table; width: 100%;' class='mt-2'></div>
                    </div>";
        }
        public function getFormButtonSubmitIcon($formId, $title, $icon){
            return "<div class=\"form-group\">
                        <a href=\"#\" onclick=\"$('#".$formId."').submit();\" class=\"btn btn-success\"><i class='".$icon." mr-1'></i> ".$title."</a>
                        <div id='pesan' style='display: inline-table; width: 350px;' class='ml-2'></div>
                    </div>";
        }
        public function getFormButtonSubmitIconOutline($formId, $title, $icon, $type, $divMessage){
            return "<a href=\"#\" onclick=\"$('#".$formId."').submit();\" class=\"btn btn-".$type." btn-block btn-sm\"><i class='".$icon." mr-1'></i> ".$title."</a> ";
        }
        public function getFormButtonSubmitLog($formId, $title, $tableName, $idTable){
            return "<div class=\"form-group\">
                        <a href=\"#\" onclick=\"$('#".$formId."').submit();\" class=\"btn btn-outline-success btn-sm\"><i class='fas fa-save mr-1'></i> ".$title."</a>
                        ".$this->getButtonLog($tableName, $idTable)."
                        <div id='pesan' style='display: inline-table; width: 350px;' class='ml-2'></div>
                    </div>";
        }
        public function getFormButtonSubmitMessage($formId, $title, $idMessage){
            return "<div class=\"form-group\">
                        <a href=\"#\" onclick=\"$('#".$formId."').submit();\" class=\"btn btn-primary \"><i class='fas fa-save mr-1'></i> ".$title."</a>
                        <div id='".$idMessage."' style='display: inline-table; width: 350px;' class='ml-2'></div>
                    </div>";
        }
        public function getFormButtonSubmitBack($formId, $title, $backAction){
            return "<hr><div class=\"form-group\">
                        <a href=\"#\" onclick=\"$('#".$formId."').submit();\" class=\"btn btn-primary\"><i class=\"fas fa-save mr-1\"></i>  ".$title."</a>
                        <a href=\"#\" onclick=\"".$backAction."\" class=\"btn btn-secondary\"><i class='mr-1 fas fa-angle-left'></i> Kembali</a>
                        <div id='pesan' class='ml-2 pesan-form mt-2'></div>
                    </div>";
        }
        public function getFormButtonSubmitBackIcon($formId, $title, $icon, $backAction){
            return "<div class=\"form-group\">
                        <a href=\"#\" onclick=\"$('#".$formId."').submit();\" class=\"btn btn-sm btn-success\"><i class=\"".$icon." mr-1\"></i>  ".$title."</a>
                        <a href=\"#\" onclick=\"".$backAction."\" class=\"btn btn-sm btn-light\"><i data-feather=\"arrow-left\" class='mr-1'></i> Kembali</a>
                        <div id='pesan' style='display: inline-table; width: 350px;' class='ml-2 pesan-form'></div>
                    </div>";
        }
        public function getFormButtonSubmitBackIconMessage($formId, $typeButton, $title, $icon, $divMessage, $backAction){
            return "<div class=\"form-group\">
                        <a href=\"#\" onclick=\"$('#".$formId."').submit();\" class=\"btn btn-sm btn-".$typeButton."\"><i class=\"".$icon." mr-1\"></i>  ".$title."</a>
                        <a href=\"#\" onclick=\"".$backAction."\" class=\"btn btn-sm btn-light\"><i data-feather=\"arrow-left\" class='mr-1'></i> Kembali</a>
                        <div id='".$divMessage."' style='display: inline-table; width: 350px;' class='ml-2 pesan-form'></div>
                    </div>";
        }
        public function getFormButtonSubmitReport($formId, $title){
            return "<div class=\"form-group\">
                        <a href=\"#\" onclick=\"$('#".$formId."').submit();\" class=\"btn btn-sm btn-outline-info\"><i class=\"fas fa-file-pdf\" class=\"mr-2\"></i> ".$title."</a>
                    </div>";
        }
        public  function getTable($idTable, $arrColumn){
            $return = "<div class=\"datatable table-responsive\">
                        <table class=\"table table-bordered table-hover bulk_action\" id=\"".$idTable."\" width=\"100%\" cellspacing=\"0\">
                            <thead>
                                <tr>";
            for ($i=0;$i<count($arrColumn);$i++) 
                $return .= "<th style=\"width:".$arrColumn[$i]['width']." !important;\">".$arrColumn[$i]['title']."</th>";
            $return .= "        </tr>
                            </thead>
                            <tbody></tbody>
                         </table>
                        </div>";
            return $return;
        }
        public  function getTableNoWidth($idTable, $arrColumn){
            $return = "<div class=\"datatable table-responsive\">
                        <table class=\"table table-bordered table-hover bulk_action\" id=\"".$idTable."\" width=\"100%\" cellspacing=\"0\">
                            <thead>
                                <tr>";
            for ($i=0;$i<count($arrColumn);$i++) 
                $return .= "<th>".$arrColumn[$i]."</th>";
            $return .= "        </tr>
                            </thead>
                            <tbody></tbody>
                         </table>
                        </div>";
            return $return;
        }
        public  function getTableStatic($arrColumn, $arrData){
            $return = "<div class=\"datatable table-responsive\">
                        <table class=\"table table-static table-hover\" width=\"100%\" cellspacing=\"0\">
                            <thead>
                                <tr>";
            for ($i=0;$i<count($arrColumn);$i++) 
                $return .= "<th style=\"width:".$arrColumn[$i]['width']." !important;\">".$arrColumn[$i]['title']."</th>";
            $return .= "        </tr>
                            </thead>
                            <tbody>";
            for ($i=0;$i<count($arrData);$i++){
                $return .= "    <tr>";
                for ($j=0;$j<count($arrData[$i]);$j++){
                    $return .= "    <td>".$arrData[$i][$j]."</td>";
                }
                $return .= "    </tr>";
            }
            if (count($arrData)==0){
                $return .= "    <tr><td class='text-center' colspan='". count($arrColumn)."'>Data Kosong</td></tr>";
            }
            $return .=  "   </tbody>
                         </table>
                        </div>";
            return $return;
        }
        public function getEmptyDiv($div){
            return "$('#".$div."').html('');"; 
        }
        public function getNotificationFloat($type,$pesan){
            return "showNotificationFloat('".$type."','".$pesan."');"; 
        }
        public function getNotification($type, $content, $divPesan){
            return "showNotification('".$type."', '".$content."', '".$divPesan."');"; 
        }
        public function getTab($arrName, $arrTitle, $arrContent){
            $return = "<nav>
                        <div class=\"nav nav-tabs\" id=\"nav-tab\" role=\"tablist\">";
            for ($i=0;$i<count($arrName);$i++){
                $active = ($i==0) ? "active" : "";
                $true = ($i==0) ? "true" : "false";
                $return .= "<button class=\"nav-link ".$active."\" id=\"".$arrName[$i]."-tab\" data-bs-toggle=\"tab\" data-bs-target=\"#".$arrName[$i]."\" type=\"button\" role=\"tab\" aria-controls=\"".$arrName[$i]."\" aria-selected=\"".$true."\" style='font-size: 0.9em;'>".$arrTitle[$i]."</button>";
            }
            $return .= "</div>
                      </nav>
                      <div class=\"tab-content\" id=\"nav-tabContent\">";
            for ($i=0;$i<count($arrName);$i++){
                $active = ($i==0) ? "show active" : "";
                $return .= "<div class=\"tab-pane fade ".$active."\" id=\"".$arrName[$i]."\" role=\"tabpanel\" aria-labelledby=\"".$arrName[$i]."-tab\">".$arrContent[$i]."</div>";
            }
            $return .= "</div>";
            
            return $return;
        }
        public function getTabActive($arrName, $arrTitle, $active_, $arrContent){
            $return = "<nav>
                        <div class=\"nav nav-tabs\" id=\"nav-tab\" role=\"tablist\">";
            for ($i=0;$i<count($arrName);$i++){
                $active = ($i==$active_) ? "active" : "";
                $true = ($i==$active_) ? "true" : "false";
                $return .= "<button class=\"nav-link ".$active."\" id=\"".$arrName[$i]."-tab\" data-bs-toggle=\"tab\" data-bs-target=\"#".$arrName[$i]."\" type=\"button\" role=\"tab\" aria-controls=\"".$arrName[$i]."\" aria-selected=\"".$true."\" style='font-size: 0.9em;'>".$arrTitle[$i]."</button>";
            }
            $return .= "</div>
                      </nav>
                      <div class=\"tab-content\" id=\"nav-tabContent\">";
            for ($i=0;$i<count($arrName);$i++){
                $active = ($i==$active_) ? "show active" : "";
                $return .= "<div class=\"tab-pane fade ".$active."\" id=\"".$arrName[$i]."\" role=\"tabpanel\" aria-labelledby=\"".$arrName[$i]."-tab\">".$arrContent[$i]."</div>";
            }
            $return .= "</div>";
            
            return $return;
        }
        public function setJs($script){
            echo "<script type='text/javascript'>
                    ".$script."
                  </script>";
        }
        public function getJs($script){
            return "<script type='text/javascript'>
                    ".$script."
                  </script>";
        }
        public function getDivContentTable($data, $field, $control){
            $arrField = array();
            $arrField[] = array('title'=>"<div class='text-center'><input type='checkbox' id='check-all' class='flat'></div>", 'width'=>"3%");
            for ($i=0;$i<count($field);$i++) $arrField[] = array("title"=>$field[$i],"width"=>"");
            $arrField[] = array("title"=>"Aksi","width"=>"75px");
            return $this->getDivRow("<div class=\"col-lg-12\">
                                        <div class='mb-3'>
                                            <a href=\"javascript:void(0);\" class=\"btn btn-sm btn-outline-primary\" onclick=\"".$control->getPageForm($data['title'], 'add', $data['folder'], $data['focus'])."\"><i class='mr-1 fas fa-plus'></i> Tambah </a>
                                            <a href=\"javascript:void(0);\" class='btn btn-outline-danger btn-sm' onclick=\"if((confirm('Anda yakin akan menghapus data yang telah dipilih ?'))) $('#formTable').submit();\"><i class='mr-1 fas fa-trash'></i> Hapus</a>      
                                            <a href=\"javascript:void(0);\" class=\"btn btn-outline-dark btn-sm\" onclick=\"".$control->getSession($control->_PAGE)."\"><i class='mr-1 fas fa-sync'></i> Reload</a>
                                        </div>
                                      </div>")."<div id=\"pesan\"></div>".
                   $this->getFormNameTable('formTable',
                                           $this->getTable($data['table'], $arrField),
                                           './?m=menu&d='.$data['folder'].'&f=deleteAll.php');
        }
        public function getDivContentTableEksport($data, $field, $control){
            $arrField = array();
            $arrField[] = array('title'=>"<div class='text-center'><input type='checkbox' id='check-all' class='flat'></div>", 'width'=>"3%");
            for ($i=0;$i<count($field);$i++) $arrField[] = array("title"=>$field[$i],"width"=>"");
            $arrField[] = array("title"=>"Aksi","width"=>"75px");
            return $this->getDivRow("<div class=\"col-lg-12\">
                                        <div class='mb-3'>
                                            <a href=\"javascript:void(0);\" class=\"btn btn-sm btn-outline-primary\" onclick=\"".$control->getPageForm($data['title'], 'add', $data['folder'], $data['focus'])."\"><i class='mr-1 fas fa-plus'></i> Tambah </a>
                                            <a href=\"javascript:void(0);\" class='btn btn-outline-danger btn-sm' onclick=\"if((confirm('Anda yakin akan menghapus data yang telah dipilih ?'))) $('#formTable').submit();\"><i class='mr-1 fas fa-trash'></i> Hapus</a>      
                                            <a href=\"javascript:void(0);\" class=\"btn btn-outline-dark btn-sm\" onclick=\"".$control->getSession($control->_PAGE)."\"><i class='mr-1 fas fa-sync'></i> Reload</a>
                                            <a href=\"./?d=".$data['folder']."&f=xls.php\" class=\"btn btn-outline-success btn-sm\" target='_BLANK'><i class='mr-1 fas fa-file-excel'></i>Ekspor Excel</a>
                                        </div>
                                      </div>")."<div id=\"pesan\"></div>".
                   $this->getFormNameTable('formTable',
                                           $this->getTable($data['table'], $arrField),
                                           './?m=menu&d='.$data['folder'].'&f=deleteAll.php');
        }
        public function getDivContentTableAddDiv($data, $field, $div, $control){
            $arrField = array();
            $arrField[] = array('title'=>"<div class='text-center'><input type='checkbox' id='check-all' class='flat'></div>", 'width'=>"3%");
            for ($i=0;$i<count($field);$i++) $arrField[] = array("title"=>$field[$i],"width"=>"");
            $arrField[] = array("title"=>"Aksi","width"=>"75px");
            return $this->getDivRow("<div class=\"col-lg-6\">
                                        ".$div."
                                     </div>
                                     <div class=\"col-lg-6 text-right\">
                                        <div class='mb-3'>
                                            <a href=\"#".$data['folder']."\" class=\"btn btn-sm btn-success\" onclick=\"".$control->getPageForm($data['title'], 'add', $data['folder'], $data['focus'])."\"><i class='mr-1 fas fa-plus'></i> Tambah </a>
                                            <a href=\"#".$data['folder']."\" class='btn btn-danger btn-sm' onclick=\"if((confirm('Anda yakin akan menghapus data yang telah dipilih ?'))) $('#formTable').submit();\"><i class='mr-1 fas fa-trash'></i> Hapus</a>      
                                            <a href=\"#".$data['folder']."\" class=\"btn btn-light btn-sm\" onclick=\"".$control->getSession($control->_PAGE)."\"><i class='mr-1 fas fa-sync'></i> Reload</a>
                                        </div>
                                     </div>")."<hr/><div id=\"pesan\"></div>".
                   $this->getFormNameTable('formTable',
                                           $this->getTable($data['table'], $arrField),
                                           './?m=menu&d='.$data['folder'].'&f=deleteAll.php');
        }
        public function getDivContentTableImport($data, $field, $control, $titleImport, $fileFormatImport, $targetImport){
            $arrField = array();
            $arrField[] = array('title'=>"<div class='text-center'><input type='checkbox' id='check-all' class='flat'></div>", 'width'=>"2%");
            for ($i=0;$i<count($field);$i++) $arrField[] = array("title"=>$field[$i],"width"=>"");
            $arrField[] = array("title"=>"Aksi","width"=>"65px");
            return $this->getDivRow("<div class=\"col-lg-12\">
                                        <div class='mb-3'>
                                            <a href=\"javascript:void(0);\" class=\"btn btn-outline-primary btn-sm\" 
                                               onclick=\"$('#file_').val('');
                                                         $('#import_title').html('".$titleImport."');
                                                         $('#formatExcel').attr('href','".$fileFormatImport."');
                                                         $('#form_import').attr('action','".$targetImport."');\" data-toggle=\"modal\" data-target=\"#importModal\"><i class=\"fas fa-download mr-1\"></i> Import Excel (xls)
                                            </a>
                                            <a href=\"javascript:void(0);\" class=\"btn btn-sm btn-outline-primary\" onclick=\"".$control->getPageForm($data['title'], 'add', $data['folder'], $data['focus'])."\"><i class='mr-1 fas fa-plus'></i> Tambah </a>
                                            <a href=\"javascript:void(0);\" class='btn btn-outline-danger btn-sm' onclick=\"if((confirm('Anda yakin akan menghapus data yang telah dipilih ?'))) $('#formTable').submit();\"><i class='mr-1 fas fa-trash'></i> Hapus</a>      
                                            <a href=\"javascript:void(0);\" class=\"btn btn-outline-dark btn-sm\" onclick=\"".$control->getSession($control->_PAGE)."\"><i class='mr-1 fas fa-sync'></i> Reload</a>
                                        </div>
                                      </div>")."<div id=\"pesan\"></div>".
                   $this->getFormNameTable('formTable',
                                           $this->getTable($data['table'], $arrField),
                                           './?m=menu&d='.$data['folder'].'&f=deleteAll.php');
        }
        public function getDivContentTableCustomButton($data, $field, $control, $buttonCustomTitel){
            $arrField = array();
            for ($i=0;$i<count($field);$i++) $arrField[] = array("title"=>$field[$i],"width"=>"");
            $arrField[] = array("title"=>"Aksi","width"=>"65px");
            return $this->getDivRow("<div class=\"col-lg-12\">
                                        <div class='mb-3'>
                                            <a href=\"javascript:void(0);\" class=\"btn btn-sm btn-outline-primary\" onclick=\"".$control->getPageForm($data['title'], 'add', $data['folder'], $data['focus'])."\"><i class='mr-1 fas fa-map-signs'></i> ".$buttonCustomTitel." </a>
                                            <a href=\"javascript:void(0);\" class=\"btn btn-outline-dark btn-sm\" onclick=\"".$control->getSession($control->_PAGE)."\"><i class='mr-1 fas fa-sync'></i> Reload</a>
                                        </div>
                                      </div>")."<div id=\"pesan\"></div>".
                   $this->getFormNameTable('formTable',
                                           $this->getTable($data['table'], $arrField),
                                           './?m=menu&d='.$data['folder'].'&f=deleteAll.php');
        }
        public function getDivContentTableSimple($data, $field, $control){
            $arrField = array();
            $arrField[] = array('title'=>"<div class='text-center'><input type='checkbox' id='check-all' class='flat'></div>", 'width'=>"2%");
            for ($i=0;$i<count($field);$i++) $arrField[] = array("title"=>$field[$i],"width"=>"");
            $arrField[] = array("title"=>"Aksi","width"=>"65px");
            return $this->getDivRow("<div class=\"col-lg-12\">
                                        <div class='mb-3'>
                                            <a href=\"javascript:void(0);\" class=\"btn btn-info\" onclick=\"".$control->getPageForm($data['title'], 'add', $data['folder'], $data['focus'])."\"><i class='mr-1 fa fa-plus-circle'></i> Tambah </a>
                                            <a href=\"javascript:void(0);\" class='btn btn-danger ' onclick=\"if((confirm('Anda yakin akan menghapus data yang telah dipilih ?'))) $('#formTable').submit();\"><i class='mr-1 fa fa-trash'></i> Hapus</a>      
                                            <a href=\"javascript:void(0);\" class=\"btn btn-secondary \" onclick=\"".$control->getSession($control->_PAGE)."\"><i class='mr-1 fa fa-sync-alt'></i> Muat Ulang</a>
                                        </div>
                                      </div>")."<div id=\"pesan\"></div>".
                   $this->getFormNameTable('formTable',
                                           $this->getTable($data['table'], $arrField),
                                           './?m=menu&d='.$data['folder'].'&f=deleteAll.php');
        }
        public function getDivContentTableSimple2($data, $field, $control){
            $arrField = array();
            $arrField[] = array('title'=>"<div class='text-center'><input type='checkbox' id='check-all' class='flat'></div>", 'width'=>"2%");
            for ($i=0;$i<count($field);$i++) $arrField[] = array("title"=>$field[$i],"width"=>"");
            $arrField[] = array("title"=>"Aksi","width"=>"65px");
            return $this->getDivRow("<div class=\"col-lg-12\">
                                        <div class='mb-3'>
                                            <a href=\"javascript:void(0);\" class=\"btn btn-info\" onclick=\"".$control->getPageForm($data['title'], 'add', $data['folder'], $data['focus'])."\"><i class='mr-1 fa fa-plus-circle'></i> Tambah </a>
                                            <a href=\"javascript:void(0);\" class='btn btn-danger ' onclick=\"if((confirm('Anda yakin akan menghapus data yang telah dipilih ?'))) $('#formTable').submit();\"><i class='mr-1 fa fa-trash'></i> Hapus</a>      
                                            <a href=\"javascript:void(0);\" class=\"btn btn-secondary \" onclick=\"".$control->getSession($control->_PAGE)."\"><i class='mr-1 fa fa-chevron-left'></i> Kembali</a>
                                        </div>
                                      </div>")."<div id=\"pesan\"></div>".
                   $this->getFormNameTable('formTable',
                                           $this->getTable($data['table'], $arrField),
                                           './?m=menu&d='.$data['folder'].'&f=deleteAll.php');
        }
        public function getDivContentTableSimpleNoButton($data, $field, $control){
            $arrField = array();
            for ($i=0;$i<count($field);$i++) $arrField[] = array("title"=>$field[$i],"width"=>"");
            return $this->getDivRow("<div class=\"col-lg-12\">
                                        <div class='mb-3'>
                                            <a href=\"javascript:void(0);\" class=\"btn btn-secondary \" onclick=\"".$control->getSession($control->_PAGE)."\"><i class='mr-1 fa fa-sync-alt'></i> Muat Ulang</a>
                                        </div>
                                      </div>").
                                      $this->getTable($data['table'], $arrField);
        }
        public function getDivContentTableSimpleNoButton2($data, $field, $control){
            $arrField = array();
            for ($i=0;$i<count($field);$i++) $arrField[] = array("title"=>$field[$i],"width"=>"");
            return $this->getDivRow("<div class=\"col-lg-12\">
                                        <div class='mb-3'>
                                            <a href=\"javascript:void(0);\" class=\"btn btn-secondary \" onclick=\"".$control->getSession($control->_PAGE)."\"><i class='mr-1 fa fa-chevron-left'></i> Kembali</a>
                                        </div>
                                      </div>").
                                      $this->getTable($data['table'], $arrField);
        }
        public function getDivContentTableImportEksport($data, $field, $control, $titleImport, $fileFormatImport, $targetImport){
            $arrField = array();
            $arrField[] = array('title'=>"<div class='text-center'><input type='checkbox' id='check-all' class='flat'></div>", 'width'=>"2%");
            for ($i=0;$i<count($field);$i++) $arrField[] = array("title"=>$field[$i],"width"=>"");
            $arrField[] = array("title"=>"Aksi","width"=>"65px");
            return $this->getDivRow("<div class=\"col-lg-12\">
                                        <div class='mb-3'>
                                            <a href=\"javascript:void(0);\" class=\"btn btn-outline-primary btn-sm\" 
                                               onclick=\"$('#file_').val('');
                                                         $('#import_title').html('".$titleImport."');
                                                         $('#formatExcel').attr('href','".$fileFormatImport."');
                                                         $('#form_import').attr('action','".$targetImport."');\" data-toggle=\"modal\" data-target=\"#importModal\"><i class=\"fas fa-download mr-1\"></i> Import Excel (xls)
                                            </a>
                                            <a href=\"javascript:void(0);\" class=\"btn btn-sm btn-outline-primary\" onclick=\"".$control->getPageForm($data['title'], 'add', $data['folder'], $data['focus'])."\"><i class='mr-1 fas fa-plus'></i> Tambah </a>
                                            <a href=\"javascript:void(0);\" class='btn btn-outline-danger btn-sm' onclick=\"if((confirm('Anda yakin akan menghapus data yang telah dipilih ?'))) $('#formTable').submit();\"><i class='mr-1 fas fa-trash'></i> Hapus</a>      
                                            <a href=\"./?d=".$data['folder']."&f=xls.php\" class=\"btn btn-outline-success btn-sm\" target='_BLANK'><i class='mr-1 fas fa-file-excel'></i>Ekspor Excel</a>
                                            <a href=\"javascript:void(0);\" class=\"btn btn-outline-dark btn-sm\" onclick=\"".$control->getSession($control->_PAGE)."\"><i class='mr-1 fas fa-sync'></i> Reload</a>
                                        </div>
                                      </div>")."<div id=\"pesan\"></div>".
                   $this->getFormNameTable('formTable',
                                           $this->getTable($data['table'], $arrField),
                                           './?m=menu&d='.$data['folder'].'&f=deleteAll.php');
        }
        public function getDivContentTableImportAddDiv($data, $field, $control, $titleImport, $fileFormatImport, $targetImport, $div){
            $arrField = array();
            $arrField[] = array('title'=>"<div class='text-center'><input type='checkbox' id='check-all' class='flat'></div>", 'width'=>"3%");
            for ($i=0;$i<count($field);$i++) $arrField[] = array("title"=>$field[$i],"width"=>"");
            $arrField[] = array("title"=>"Aksi","width"=>"75px");
            return $this->getDivRow("<div class=\"col-lg-6\">
                                        <div class='mb-3'>
                                            <a href=\"javascript:void(0);\" class=\"btn btn-info btn-sm\" 
                                               onclick=\"$('#file_').val('');
                                                         $('#import_title').html('".$titleImport."');
                                                         $('#formatExcel').attr('href','".$fileFormatImport."');
                                                         $('#form_import').attr('action','".$targetImport."');\" data-toggle=\"modal\" data-target=\"#importModal\"><i class=\"fas fa-download mr-1\"></i> Import Excel (xls)
                                            </a>
                                            <a href=\"javascript:void(0);\" class=\"btn btn-sm btn-success\" onclick=\"".$control->getPageForm($data['title'], 'add', $data['folder'], $data['focus'])."\"><i class='mr-1 fas fa-plus'></i> Tambah </a>
                                            <a href=\"javascript:void(0);\" class='btn btn-danger btn-sm' onclick=\"if((confirm('Anda yakin akan menghapus data yang telah dipilih ?'))) $('#formTable').submit();\"><i class='mr-1 fas fa-trash'></i> Hapus</a>      
                                            <a href=\"javascript:void(0);\" class=\"btn btn-light btn-sm\" onclick=\"".$control->getSession($control->_PAGE)."\"><i class='mr-1 fas fa-sync'></i> Reload</a>
                                        </div>
                                      </div>
                                      <div class=\"col-lg-6\">
                                        ".$div."
                                     </div>")."<div id=\"pesan\"></div>".
                   $this->getFormNameTable('formTable',
                                           $this->getTable($data['table'], $arrField),
                                           './?m=menu&d='.$data['folder'].'&f=deleteAll.php');
        }
        public function getDivContentTable2($data, $field, $control){
            $arrField = array();
            for ($i=0;$i<count($field);$i++) $arrField[] = array("title"=>$field[$i],"width"=>"");
            return $this->getDivRow("<div class=\"col-lg-12\">
                                        <div class='mb-3'>
                                            <a href=\"#".$data['folder']."\" class=\"btn btn-light btn-sm\" onclick=\"".$control->getSession($control->PAGE_)."\"><i data-feather='refresh-cw' class='mr-1'></i> Reload</a>
                                        </div>
                                      </div>")."<div id=\"pesan\"></div>".
                                      $this->getTable($data['table'], $arrField);
        }
        public function getDivContentTableSingle($data, $field, $control){
            $arrField = array();
            for ($i=0;$i<count($field);$i++) $arrField[] = array("title"=>$field[$i],"width"=>"");
            return $this->getDivRow("<div class=\"col-lg-12\">
                                        <div class='mb-3'>
                                            <a href=\"javascript:void(0);\" class=\"btn btn-outline-dark btn-sm\" onclick=\"".$control->getSession($control->_PAGE)."\"><i class='mr-1 fas fa-sync'></i> Reload</a>
                                        </div>
                                      </div><div id='pesan'></div>").
                                      $this->getTable($data['table'], $arrField);
        }
        public function getDivContentTableSingle2($data, $field, $control){
            $arrField = array();
            for ($i=0;$i<count($field);$i++) $arrField[] = array("title"=>$field[$i],"width"=>"");
            return $this->getDivRow($this->getTable($data['table'], $arrField));
        }
        public function getDivContentTableSingleAddDiv($data, $field, $control, $div){
            $arrField = array();
            for ($i=0;$i<count($field);$i++) $arrField[] = array("title"=>$field[$i],"width"=>"");
            return $this->getDivRow("<div class=\"col-lg-4\">
                                        <div class='mb-3'>
                                            <a href=\"javascript:void(0);\" class=\"btn btn-light btn-sm\" onclick=\"".$control->getSession($control->_PAGE)."\"><i class='mr-1 fas fa-sync'></i> Reload</a>
                                        </div>
                                     </div>
                                     <div class=\"col-lg-8\">".$div."</div>").
                                      $this->getTable($data['table'], $arrField);
        }
        public function getDivContentTableSingleAddDivReport($data, $field, $control, $div, $folder){
            $arrField = array();
            for ($i=0;$i<count($field);$i++) $arrField[] = array("title"=>$field[$i],"width"=>"");
            return $this->getDivRow("<div class=\"col-lg-4\">
                                        <div class='mb-3'>
                                            <a href=\"javascript:void(0);\" class=\"btn btn-light btn-sm\" onclick=\"".$control->getSession($control->_PAGE)."\"><i class='mr-1 fas fa-sync'></i> Reload</a>
                                            <a href=\"?d=".$folder."&f=report.php&t=pdf\" target=\"_BLANK\" class=\"btn btn-danger btn-sm\"><i class='mr-1 fas fa-file-pdf'></i> Ekspor PDF</a>
                                            <!--<a href=\"?d=".$folder."&f=report.php&t=xls\" target=\"_BLANK\" class=\"btn btn-success btn-sm\"\"><i class='mr-1 fas fa-file-excel'></i> Ekspor XLS</a>-->
                                        </div>
                                     </div>
                                     <div class=\"col-lg-8 mb-3\">".$div."</div>").
                                      $this->getTable($data['table'], $arrField);
        }
        public function getCheckBoxTable($id, $name, $value){
            return "<div class='text-center'><input type='checkbox' class='flat' name='".$name."' id='".$id."' value='".$value."'></div>";
        }
        public function getListTitle($list){
            $n = "";
            for ($i=0;$i<count($list);$i++){
                $a_ =  ($i == (count($list)-1)) ? "active" : "";
                $n .= "<li class=\'breadcrumb-item ".$a_."\'>".$list[$i]."</li>";
            }
            return $n;
        }
        public function getModalLinkConfirm($file, $data, $modalId, $divMessage, $confirmMessage){
            return "<div class='modal' id='".$modalId."' tabindex='-1' role='dialog' aria-labelledby='".$modalId."Label' aria-hidden='true'>
                        <div class='modal-dialog' role='document'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='exampleModalLabel'>Konfirmasi</h5>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>
                                <div class='modal-body'>
                                    ".$confirmMessage."<br/>
                                    <small>* Data yang telah disimpan tidak dapat diubah.</small>
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-light' data-dismiss='modal'>Tidak</button>
                                    <a href='page/".$file.".php?".$data."' target='proses' class='btn btn-primary' data-dismiss='modal'
                                       onclick=\" $('#".$divMessage."').html('<div class=\'d-flex justify-content-center\'><div class=\'spinner-border spinner-border-md text-danger\' role=\'status\'><span class=\'visually-hidden\'>Loading...</span></div></div>');"
                    . "                           $('#".$modalId."').modal('hide'); 
                                                  $('body').removeClass('modal-open');
                                                  $('.modal-backdrop').remove();\">Ya</a>
                                </div>
                            </div>
                        </div>
                    </div>";
        }
        public function getModalConfirm($formId, $modalId, $confirmMessage){
            return "<div class='modal' id='".$modalId."' tabindex='-1' role='dialog' aria-labelledby='".$modalId."Label' aria-hidden='true'>
                        <div class='modal-dialog' role='document'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='exampleModalLabel'>Konfirmasi</h5>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>
                                <div class='modal-body'>
                                    ".$confirmMessage."<br/>
                                    <small>* Data yang telah disimpan tidak dapat diubah.</small>
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-light' data-dismiss='modal'>Tidak</button>
                                    <button type='button' class='btn btn-primary' data-dismiss='modal'
                                            onclick=\" $('#".$modalId."').modal('hide'); 
                                                       $('body').removeClass('modal-open');
                                                       $('.modal-backdrop').remove();
                                                       $('#".$formId."').submit();\">Ya</button>
                                </div>
                            </div>
                        </div>
                    </div>";
        }
        public function getButtonConfirm($modalId, $title, $icon){
            return "<div class=\"form-group\">
                        <a href=\"#\" data-toggle='modal' data-target='#".$modalId."' class=\"btn btn-primary btn-sm\"><i class='".$icon." mr-1'></i> ".$title."</a>
                        <div id='pesan' style='display: inline-table; width: 400px;' class='ml-2'></div>
                    </div>";
        }
        public function getLinkConfirm($modalId, $title, $btnStyle, $icon, $tag){
            return "<a href=\"#".$tag."\" data-toggle='modal' data-target='#".$modalId."' class=\"btn ".$btnStyle." btn-sm\"><i class='".$icon." mr-1'></i> ".$title."</a>";
        }
        public function getAlert($type, $title){
            return "<div class='alert alert-".$type." mt-3 mb-3 text-center'>".$title."</div>";
        }
        public function getDivUploadFileLabel($label,$idInput,$idLinkEdit,$idLinkCancel,$file,$name){
            if (is_file("assets/dokumen/".$file)){
                return $this->getDivInput(
                            "<div class='uploadFile'>
                                <a href='./assets/dokumen/".$file."' target='_BLANK' class='btn btn-sm btn-outline-primary mr-2'><i class='fas fa-download'></i> Unduh Berkas</a>
                                <a href='javascript:void(0)' class='btn btn-sm btn-outline-primary' id='".$idLinkEdit."'
                                   onclick=\"$('#".$idInput."').css({'display':'block'});
                                             $('#".$idLinkEdit."').css({'display':'none'});
                                             $('#".$idLinkCancel."').css({'display': 'inline'});\"><i class='fas fa-edit'></i> Ubah Berkas</a>
                                <a href='javascript:void(0)' class='btn btn-sm btn-outline-primary' id='".$idLinkCancel."' style='display: none;'
                                   onclick=\"$('#".$idInput."').css({'display':'none'});
                                             $('#".$idLinkEdit."').css({'display': 'inline'})
                                             $('#".$idLinkCancel."').css({'display': 'none'});\"><i class='fas fa-times'></i> Batal</a>
                            </div>",
                            "<div class='_hide' id='".$idInput."' style='display:none;'>".
                                $this->getFormInputFileLabel($name, $label).
                            "</div>","12","12");
            }else{
                return $this->getFormInputFileLabel($name, $label);
            }
        }
        public function getDivUploadImage($file,$name){
            if (is_file("assets/img/".$file)){
                return $this->getDivInput(
                            "<div class='uploadFile'>
                                <a href='./assets/img/".$file."' target='_BLANK'>
                                    <img src='./assets/img/".$file."' style='height: 196px; width: auto;'>    
                                </a>
                            </div>",
                            $this->getFormInputFileLabel($name,""),
                            "12","12");
            }else{
                return $this->getFormInputFileLabel($name,"");
            }
        }
        public function getDivUploadFile($idInput,$idLinkEdit,$idLinkCancel,$file,$name){
            if (is_file("assets/img/".$file)){
                return      "<div class='uploadFile'>
                                <a href='./assets/img/".$file."' target='_BLANK' class=' '><i class='fas fa-download'></i> Unduh Berkas</a>
                                <a href='javascript:void(0)' class='' id='".$idLinkEdit."'
                                   onclick=\"$('#".$idInput."').css({'display':'block'});
                                             $('#".$idLinkEdit."').css({'display':'none'});
                                             $('#".$idLinkCancel."').css({'display': 'inline'});\"><i class='fas fa-edit'></i> Ubah Berkas</a>
                                <a href='javascript:void(0)' class=' ' id='".$idLinkCancel."' style='display: none;'
                                   onclick=\"$('#".$idInput."').css({'display':'none'});
                                             $('#".$idLinkEdit."').css({'display': 'inline'})
                                             $('#".$idLinkCancel."').css({'display': 'none'});\"><i class='fas fa-times'></i> Batal</a>
                            </div>".
                            "<div class='_hide' id='".$idInput."' style='display:none;'>".
                                $this->getFormInputFile($name).
                            "</div>";
            }else{
                return $this->getFormInputFile($name);
            }
        }
        public function getDivUploadFileNoLabel($idInput,$idLinkEdit,$idLinkCancel,$file,$name){
            if (is_file("assets/dokumen/".$file)){
                return "<div class='uploadFile'>
                            <a href='assets/dokumen/".$file."' target='_BLANK' class='link-uploadFile mr-2'><i class='fas fa-download'></i> Unduh</a>
                            <a href='javascript:void(0)' class='link-uploadFile' id='".$idLinkEdit."'
                               onclick=\"$('#".$idInput."').css({'display':'block'});
                                         $('#".$idLinkEdit."').css({'display':'none'});
                                         $('#".$idLinkCancel."').css({'display': 'inline'});\"><i class='fas fa-edit'></i> Ubah</a>
                            <a href='javascript:void(0)' class='link-uploadFile' id='".$idLinkCancel."' style='display: none;'
                               onclick=\"$('#".$idInput."').css({'display':'none'});
                                         $('#".$idLinkEdit."').css({'display': 'inline'})
                                         $('#".$idLinkCancel."').css({'display': 'none'});\"><i class='fas fa-times'></i> Batal</a>
                        </div>".
                        "<div class='_hide' id='".$idInput."'>".
                                $this->getFormInputFile($name).
                        "</div>";
            }else{
                return $this->getFormInputFile($name);
            }
        }
        
        public function getDivUploadFileNoLabelSubmit($idInput,$idLinkEdit,$idLinkCancel,$file,$name,$formid){
            if (is_file("assets/dokumen/".$file)){
                return "<div class='uploadFile'>
                            <a href='assets/dokumen/".$file."' target='_BLANK' class='link-uploadFile mr-2 text-danger'><i class='fas fa-download'></i> Unduh</a>
                            <a href='javascript:void(0)' class='link-uploadFile text-danger' id='".$idLinkEdit."'
                               onclick=\"$('#".$idInput."').css({'display':'block'});
                                         $('#".$idLinkEdit."').css({'display':'none'});
                                         $('#".$idLinkCancel."').css({'display': 'inline'});\"><i class='fas fa-edit'></i> Ubah</a>
                            <a href='javascript:void(0)' class='link-uploadFile text-danger' id='".$idLinkCancel."' style='display: none;'
                               onclick=\"$('#".$idInput."').css({'display':'none'});
                                         $('#".$idLinkEdit."').css({'display': 'inline'})
                                         $('#".$idLinkCancel."').css({'display': 'none'});\"><i class='fas fa-times'></i> Batal</a>
                        </div>".
                        "<div class='_hide' id='".$idInput."'>".
                                $this->getFormInputFileSubmit($name,$formid).
                        "</div>";
            }else{
                return $this->getFormInputFileSubmit($name, $formid);
            }
        }
        
        public function getCardDashboard($type, $title, $subTitle, $icon){
            return "<div class=\"col-xl-12 col-md-12 mb-4\">
                        <div class=\"card border-left-".$type." shadow h-100 py-2\">
                            <div class=\"card-body\">
                                <div class=\"row no-gutters align-items-center\">
                                    <div class=\"col mr-2\">
                                        <div class=\"text-lg text-dark text-uppercase font-weight-light mb-1\">
                                            ".$title."
                                        </div>
                                        <div class=\"h5 mb-0 text-dark-800\">".$subTitle."</div>
                                    </div>
                                    <div class=\"col-auto\">
                                        <i class=\"".$icon." fa-3x text-".$type."\"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>";
        } 
    }
?>
