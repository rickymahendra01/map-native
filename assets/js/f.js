var textArea_ = null;

var showNotification = function(notifType, pesan, divPesan){
    $('#'+divPesan).html("<div class='alert alert-"+notifType+" alert-dismissible show fade'>"+
                         "<button class='close' data-dismiss='alert'>"+
                         "  <span>&times;</span>"+
                         "</button>"+pesan+"</div>");
}

var showNotificationFloat = function(type_, pesan){
    $.notify({
        message: "<span class='text-white'>"+pesan+"</span>"
    },{
        type: type_,
        z_index: 999999999,
        timer: 3000,
        placement: {
            from: "top", align: "center"
        }
    });
}
var setImageInput = function(input, idImage) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#'+idImage)
                .attr('src', e.target.result);
            $('#link_'+idImage)
                .attr('href', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
var setVideoInput = function(input, idDiv) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#'+idDiv).html("<video width='320' height='240' controls>"+
                              " <source src='"+e.target.result+"' type='video/mp4'>"+
                              " <source src='"+e.target.result+"' type='video/ogg'>"+
                              "Your browser does not support the video tag."+
                              "</video>");
        };
        reader.readAsDataURL(input.files[0]);
    }
}
var call = function(title, directory, file, dataSend, table, focus){
    $('html, body').animate({ scrollTop: 0 }, 'slow');
    $('#titlePage1').html(title);
    //$('#titlePage2').html(title);
    $("#contentPage").html("<div class='text-center'>"+
                           "   <div class='spinner-border text-primary' role='status'><span class='visually-hidden'>Loading...</span></div>"+
                           "</div>");
    var param = "m=menu&d="+directory+"&f="+file+".php&"+dataSend;
    $.post('./',param,
           function(data, status){
               if (status=="404") $("#contentPage").html("Halaman tidak ditemukan.");
               else{
                    $("#contentPage").html(data);  
                    if (table != ""){
                        if ((table != null)&&(!(typeof($('#'+table))==="undefined"))){
                            $("#"+table).DataTable({"sPaginationType": "full_numbers",
                                                    "bServerSide": true,
                                                    "sAjaxSource": "./?m=menu&d="+directory+"&f=table.php",
                                                    "bSort": false,
                                                    "responsive": true,
                                                    "fnInitComplete": function (oSettings, json) {
                                                        setRunTable(); 
                                                     },
                                                    "fnDrawCallback":function (oSettings) {
                                                        setRunTable();
                                                     },
                                                     columnDefs: [{render: function (data, type, full, meta) {
                                                                        return "<div class='text-wrap'>" + data + "</div>";
                                                                   },
                                                                        targets: '_all'
                                                                    }
                                                                 ]
                                                  });
                        }        
                    }
                    setTinyMce();
                    $(".checkboxToggle").bootstrapToggle();
                    $('.select2').select2();
                    if ((focus != null)&&(focus != "")&&(!(typeof($('#'+focus))==="undefined")))
                        $("#"+focus).focus();
                    $(".datepicker").datepicker({ format: 'dd/mm/yyyy', autoclose: true });
                                        
                    if ((directory=="kawasan")&&(file=="form")){
                        if ($('#fileKml').val()!=""){
                            setShowKML($('#fileKml').val());
                        }
                    }
                    if (directory=="waypoint"){
                        setMapWaypoint();
                    }
                    if (directory=="shelter"){
                        setMapShelter();
                    }
                    
                }
           }
    );
}
var callTable = function(title, directory, file, dataSend, table, fileTable){
    $('html, body').animate({ scrollTop: 0 }, 'slow');
    $('#titlePage1').html(title);
    $("#contentPage").html("<div class='text-center'>"+
                           "   <div class='spinner-border text-primary' role='status'><span class='visually-hidden'>Loading...</span></div>"+
                           "</div>");
    var param = "m=menu&d="+directory+"&f="+file+".php&"+dataSend;
    $.post('./',param,
           function(data, status){
               if (status=="404") $("#contentPage").html("Halaman tidak ditemukan.");
               else{
                    $("#contentPage").html(data);  
                    if (table != ""){
                        if ((table != null)&&(!(typeof($('#'+table))==="undefined"))){
                            $("#"+table).DataTable({"sPaginationType": "full_numbers",
                                                    "bServerSide": true,
                                                    "sAjaxSource": "./?m=menu&d="+directory+"&f="+fileTable,
                                                    "bSort": false,
                                                    "responsive": true,
                                                    "fnInitComplete": function (oSettings, json) {
                                                        setRunTable(); 
                                                     },
                                                    "fnDrawCallback":function (oSettings) {
                                                        setRunTable();
                                                     },
                                                     columnDefs: [{render: function (data, type, full, meta) {
                                                                        return "<div class='text-wrap'>" + data + "</div>";
                                                                   },
                                                                        targets: '_all'
                                                                    }
                                                                 ]
                                                  });
                        }        
                    }
                }
           }
    );
}
var setTinyMce = function(){
    if (textArea_ != null){
        tinymce.remove();
    }
    textArea_ = tinymce.init({
                        selector: '.description',
                        plugins: 'print preview importcss  searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
                        mobile: {
                          plugins: 'print preview importcss  searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount textpattern noneditable help charmap quickbars emoticons'
                        },
                        menu: {
                          tc: {
                            title: 'TinyComments',
                            items: 'addcomment showcomments deleteallconversations'
                          }
                        },
                        menubar: 'file edit view insert format tools table tc help',
                        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media pageembed template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
                    });
}
var setCheckInputTable = function(){
    $('table input').on('ifChecked', function () {
        check_state = '';
        $(this).parent().parent().parent().addClass('selected');
        countChecked(check_state);
    });
    $('table input').on('ifUnchecked', function () {
        check_state = '';
        $(this).parent().parent().parent().removeClass('selected');
        countChecked(check_state);
    });

    var check_state = '';
    $('.bulk_action input').on('ifChecked', function () {
        check_state = '';
        $(this).parent().parent().parent().addClass('selected');
        countChecked(check_state);
    });
    $('.bulk_action input').on('ifUnchecked', function () {
        check_state = '';
        $(this).parent().parent().parent().removeClass('selected');
        countChecked(check_state);
    });
    $('.bulk_action input#check-all').on('ifChecked', function () {
        check_state = 'check_all';
        countChecked(check_state);
    });
    $('.bulk_action input#check-all').on('ifUnchecked', function () {
        check_state = 'uncheck_all';
        countChecked(check_state);
    }); 
}
var setRunTable = function(){
    $(".checkboxToggle").bootstrapToggle();
    $(".tooltips").tooltip();
    $(".datepicker").datepicker({ format: 'yyyy-mm-dd', autoclose: true });
    $('input.flat').iCheck({
        checkboxClass: 'icheckbox_flat-red',
        radioClass: 'iradio_flat-red'
    }); 
    setCheckInputTable();
}
var countChecked = function(c) {
    check_state = c;
    if (check_state == 'check_all') {
        $(".bulk_action input[type='checkbox']").iCheck('check');
    }
    if (check_state == 'uncheck_all') {  
        $(".bulk_action input[type='checkbox']").iCheck('uncheck');
    }
    var n = $(".bulk_action input[name='checkbox']:checked").length;
    if (n > 0) {
        $('.column-title').hide();
        $('.bulk-actions').show();
        $('.action-cnt').html(n + ' Records Selected');
    } else {
        $('.column-title').show();
        $('.bulk-actions').hide();
    }
}
var callSingle = function(directory, file, dataSend, destination){
    $("#"+destination).html("<div class='text-center'>"+
                            "   <div class='spinner-border text-primary' role='status'><span class='visually-hidden'>Loading...</span></div>"+
                            "</div>");
    var param = "d="+directory+"&f="+file+"&"+dataSend;
    if ($("#"+destination) != undefined){
        $.post('./',param,
           function(data, status){
               if (status=="404"){ $("#"+destination).html("Halaman tidak ditemukan.");
               }else{
                    $("#"+destination).html(data);   
                    
                    $(".datepicker").datepicker({ format: 'dd/mm/yyyy', autoclose: true });
                    $('.select2').select2();
                    
                    if (directory=="menu"){
                        var sidebar_nicescroll;
                            var update_sidebar_nicescroll = function() {
                              let a = setInterval(function() {
                                if(sidebar_nicescroll != null)
                                  sidebar_nicescroll.resize();
                              }, 10);

                              setTimeout(function() {
                                clearInterval(a);
                              }, 600);
                            }
                        let sidebar_nicescroll_opts = {
                            cursoropacitymin: 0,
                            cursoropacitymax: .8,
                            zindex: 892
                          }, now_layout_class = null;
                        var sidebar_dropdown = function() {
                            if($(".main-sidebar").length) {
                              $(".main-sidebar").niceScroll(sidebar_nicescroll_opts);
                              sidebar_nicescroll = $(".main-sidebar").getNiceScroll();

                              $(".main-sidebar .sidebar-menu li a.has-dropdown").off('click').on('click', function() {
                                var me = $(this);

                                me.parent().find('> .dropdown-menu').slideToggle(500, function() {
                                  update_sidebar_nicescroll();
                                  return false;
                                });
                                return false;
                              });
                            }
                          }
                          sidebar_dropdown();
                    }
               }
           });
    }
}
var callSingle2 = function(directory, file, dataSend, destination, activeSelect2){
    $("#"+destination).html("<div class='text-center'>"+
                            "   <div class='spinner-border text-primary' role='status'><span class='sr-only'>Loading...</span></div>"+
                            "</div>");
    var param = "d="+directory+"&f="+file+"&"+dataSend;
    if ($("#"+destination) != undefined){
        $.post('./',param,
           function(data, status){
               if (status=="404"){ $("#"+destination).html("Halaman tidak ditemukan.");
               }else{
                    $("#"+destination).html(data);   
                    //$(".select2").select2();
                    if (activeSelect2)
                        select2Ajax("parameter", "anggota", "fkAnggotaModal");
                    $(".datepickerModal").datepicker({ format: 'dd/mm/yyyy', autoclose: true });
               }
           });
    }
}
var setFormModal = function(directory, file, dataSend){
    $("#formModal_content").html("<div class='text-center'>"+
                            "   <div class='spinner-border text-primary' role='status'><span class='sr-only'>Loading...</span></div>"+
                            "</div>");
    $('#formModal').modal("show");
    var param = "d="+directory+"&f="+file+"&"+dataSend;
    $.post('./',param,
           function(data, status){
               if (status=="404"){ $("#formModal_content").html("Halaman tidak ditemukan.");
               }else{
                    $("#formModal_content").html(data);   
                    $(".select2Single").select2({width: '100%'});
                    $('input.flat').iCheck({
                        checkboxClass: 'icheckbox_flat-red',
                        radioClass: 'iradio_flat-red'
                    });
               }
           });
}
var callSelect = function(file, datas, destination){
    var _file = getPath(file);
    if ($("#"+destination) != undefined){
        $.post(_file,datas,
           function(data, status){ 
               if (status=="404"){ $("#"+destination).html("Halaman tidak ditemukan.");
               }else{
                    var n = JSON.parse(data);
                    var list = "";
                    for (i=0; i<n.length; i++){
                        list += "<option value='"+n[i].value+"'>"+n[i].title+"</option>";
                    }
                    $("#"+destination).html(list);
               }
           });
    }
}
var callProses = function(file, datas){
    var _file = getPath(file);
    $.post(_file,datas,
           function(data, status){
               if (data=="success"){
                    showNotificationFloat("success","Tersimpan");
               }else{
                    showNotificationFloat("danger","Gagal Tersimpan");
               }
           });
    
}
var callNotif = function(notifData){
    var param = "d="+notifData[0]+"&f="+notifData[1]+".php";
    $.post('./',param,
           function(data, status){
               var n = parseInt(data);
               if (n>0){
                   $('#'+notifData[2]).html('<span class="badge badge-light">'+data+'</span>');
                   $('#'+notifData[2]+'Header').html('<span class="badge badge-danger">'+data+'</span>');
               }else{
                   $('#'+notifData[2]).html('');
                   $('#'+notifData[2]+'Header').html('');
               }
           });
}
var setHorBarChart = function(inData, idGrafik, color){
    var data = JSON.parse(inData);
    var label_ = [];
    var value_ = [];
    for (var i=0; i<data.length; i++){
        label_[i] = data[i].label;
        value_[i] = parseInt(data[i].value);
    }
    var horizontalBarChartData = {
	labels: label_,
		datasets: [{
                    backgroundColor: color,
                    borderColor: color,
                    borderWidth: 1,
                    data: value_
		}]};
    var ctx = document.getElementById(idGrafik).getContext('2d');
                window.myHorizontalBar = new Chart(ctx, {
                    type: 'bar',
                    data: horizontalBarChartData,
                    options: {
                        elements: { rectangle: { borderWidth: 1 } },
                        responsive: true,
                        legend: { display: false  },
			title: { display: true },
                        scales: {
                                yAxes: [{
                                  ticks: {
                                      beginAtZero: true
                                  }
                                }]
                        }
                    }
    });
}

var setPieChart = function(inData, idGrafik){
    var data = JSON.parse(inData);
    var label_ = [];
    var value_ = [];
    var color_ = [];
    for (var i=0; i<data.length; i++){
        label_[i] = data[i].label;
        color_[i] = '#'+Math.floor(Math.random()*16777215).toString(16);
        value_[i] = parseInt(data[i].value);
    }
    var ctx = document.getElementById(idGrafik);
    var myPieChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: label_,
        datasets: [{
          data: value_,
          backgroundColor: color_,
          hoverBorderColor: "rgba(234, 236, 244, 1)"
        }],
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 1,
          yPadding: 1,
          displayColors: false,
          caretPadding: 1,
        },
        legend: {
          display: true,
          position: "right"
        },
        cutoutPercentage: 25,
      },
    });
}
var setPrintChart = function(idCanvas){
    var canvas = document.getElementById(idCanvas);
    var win = window.open();
    win.document.write("<br><img src='" + canvas.toDataURL() + "'/>");
    sleep(3000);
    win.print();
}

var sleep = function(milliseconds) {
  const date = Date.now();
  let currentDate = null;
  do {
    currentDate = Date.now();
  } while (currentDate - date < milliseconds);
}
var callProsesNoNotif = function(file, datas){
    var _file = getPath(file);
    $.post(_file,datas,
           function(data, status){});
    
}
var callProsesLoad = function(file, datas, divLoad){
    var _file = getPath(file);
    $("#"+divLoad).css({'visibility':'visible'});
    $.post(_file,datas,
           function(data, status){
               if (data=="sukses"){
                    showNotification("success","Tersimpan");
               }else{
                    showNotification("danger","Gagal Tersimpan");
               }
               $("#"+divLoad).css({'visibility':'hidden'});
           });
    
}
var setSelectAjax = function(file, datas, destination){
    var _file = getPath(file);
    if ($("#"+destination) != undefined){
        $.post(_file,datas,
           function(data, status){
               if (status=="404"){ 
               }else{
                   var option = "";
                   var r = JSON.parse(data);
                   for (i=0;i<r.length;i++){
                       option += "<option value='"+r[i].value+"'>"+r[i].title+"</option>";
                   }
                   $('#'+destination).html(option);
               }
           });
    }
}
var getKey = function(e){  
   if (window.event)  
     return window.event.keyCode;  
   else if (e)  
     return e.which;  
   else  
     return null;  
}  
var numerik = function(e){  
   var key, keyChar,valid;  
   key = getKey(e);  
   valid ="0123456789,";
   if (key == null) return true;  
   keyChar = String.fromCharCode(key).toLowerCase();  
   if (valid.toLowerCase().indexOf(keyChar) != -1)  
     return true;  
   if ( key==0 || key==8 || key==9 || key==13 || key==27 || key==46)  
     return true;  
   return false;  
} 
var angka2 = function(x){
    x = x.replace('.',',');
    return angka3(x);
}
var angka3 = function(objek) {
    var b = unangka2(objek);
    var c = "";
    var posisidesimal = b.indexOf(',');
    var x = b.length - posisidesimal;
    var desimal = b.substr(posisidesimal,x);
    if (posisidesimal > 0){
        panjang = b.length-desimal.length;
        bulat = b.substr(0,panjang);
    }else{
	panjang = b.length;
	bulat = b;
    }
    var j = 0;
    for (var i = panjang; i > 0; i--) {
        j = j + 1;
        if (((j % 3) == 1) && (j != 1)) {
        c = bulat.substr(i-1,1) + "." + c;
        } else {
            c = bulat.substr(i-1,1) + c;
        }
    }
    if (posisidesimal > 0)
        return  c+desimal;
    else
	return  c;
}
var angka = function(objek) {
    objek = typeof(objek) != 'undefined' ? objek : 0;
    var a = objek.value;
    var b = unangka2(a);
    var c = "";
    var posisidesimal = b.indexOf(',');
    var x = b.length - posisidesimal;
    var desimal = b.substr(posisidesimal,x);
    if (posisidesimal > 0){
        panjang = b.length-desimal.length;
        bulat = b.substr(0,panjang);
    }else{
        panjang = b.length;
        bulat = b;
    }
    var j = 0;
    for (var i = panjang; i > 0; i--) {
        j = j + 1;
        if (((j % 3) == 1) && (j != 1)) {
        c = bulat.substr(i-1,1) + "." + c;
        }else{
            c = bulat.substr(i-1,1) + c;
        }
    }
    if (posisidesimal > 0)
        objek.value = c+desimal;
    else
	objek.value = c;
}
var unangka2 = function(objek){
    var i = objek.length;
    var temp = '';
    for (var j=0;j<=i;j++){
        var pos = objek.charAt(j);
        if (pos == '.'){
            temp = temp + objek.substr(j+1,1);
            j++;
        }else{	
            temp = temp + objek.substr(j,1);
	}
    }	
    return temp;
}
var unangka = function(objek){
    var i = objek.length;
    var temp = '';
    for (var j=0;j<=i;j++){
        var pos = objek.charAt(j);
        if (pos == '.'){
            temp = temp + objek.substr(j+1,1);
            j++;
        }else{	
            if (pos == ','){
                temp = temp + '.';
            }else temp = temp + objek.substr(j,1);
        }
    }
    return temp;
}
var thousand_separator = function(input) {
    try{
        var number = input.split('.');
        num = number[0];
        num = num.split("").reverse().join("");
        var numpoint = '';
        for (var i = 0; i < num.length; i++) {
            numpoint += num.substr(i,1);    
            if (((i+1)%3 == 0) && i != num.length-1) {
                numpoint += '.';
            }   
        }
        num = numpoint.split("").reverse().join("");
        if (number[1] != undefined) {
            num = num+','+number[1];
        }
        return num;
    }catch (exception) {
    }

}
var angkaNObjek = function(str) {
    var a = str;
    var b = a+'';
    var c = "";
    var posisidesimal = b.indexOf(',');
    var x = b.length - posisidesimal;
    var desimal = b.substr(posisidesimal,x);
    if (posisidesimal > 0){
        panjang = b.length-desimal.length;
        bulat = b.substr(0,panjang);
    }else{
        panjang = b.length;
        bulat = b;
    }
    var j = 0;
    for (var i = panjang; i > 0; i--) {
        j = j + 1;
        if (((j % 3) == 1) && (j != 1)) {
        c = bulat.substr(i-1,1) + "." + c;
        }else{
            c = bulat.substr(i-1,1) + c;
        }
    }
    if (posisidesimal > 0)
        return c+desimal;
    else
	return c;
}
var setBrowseFile = function(idTag){
    var fileName = $("#"+idTag).val().split("\\").pop();
    $("#"+idTag).siblings(".custom-file-label").addClass("selected").html(fileName);
}
var setTagsInput = function(dir_, file_, idInput){
    var lists = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    remote: {
                        url: './?d='+dir_+'&f='+file_+'.php&q=%QUERY%',
                        wildcard: '%QUERY%'    
                    }
                });
    lists.initialize();
    var inputTags = $('#'+idInput);
    inputTags.tagsinput({
        itemValue : 'value',
        itemText  : 'text',
        trimValue: true,
        allowDuplicates : false,   
        freeInput: false,
        focusClass: 'form-control',
        tagClass: function(item) {
            if(item.display) return 'badge badge-danger ' + item.display;
            else return 'badge badge-danger ';
        },
        onTagExists: function(item, $tag) { $tag.hide().fadeIn(); },
        typeaheadjs: [{ hint: false, highlight: true },
                      { name: idInput, itemValue: 'value',
                        displayKey: 'text', source: lists.ttAdapter(),
                        templates: {
                            empty: [ '<ul class="list-group list-inputtags small"><li class="list-group-item">Nothing found.</li></ul>'],
                            header: [ '<ul class="list-group list-inputtags small">' ],
                            suggestion: function (data) {
                                return '<li class="list-group-item list-inputtags small">' + data.text + '</li>'
                            }
                        }
                    }]         
    });  
    return inputTags;
}
var getPath = function(file){
    var l = file.length;
    var start = l-1;
    var end = l;
    var x = file.substring(start, end);
    if (x == "/"){
        //var _tmp = file.substring(0, start); 
        var _file = (file.indexOf(".php")>-1) ? file : file+"index.php";
    }else{
        var _file = (file.indexOf(".php")>-1) ? file : file+".php";
    }
    return _file;
}

var select2Ajax = function(_dir, _file, _id){
    if ($("#"+_id) != undefined){
        $("#"+_id).select2({
            ajax: {
                url: './?d='+_dir+'&f='+_file+'.php',
                dataType: 'json',
                data: function (params) {
                    var query = {
                      search: params.term,
                      type: 'public'
                    }
                    return query;
                }
            }
        });
    }
}


var setUploadFile = function (tagInputFile,tagInputHidden,tagShow,dir_,file_){
    $('#'+tagShow).html("<div class='spinner-border spinner-border-sm text-primary' role='status'><span class='visually-hidden'>Loading...</span></div>");
    var fd = new FormData();
    var files = $('#'+tagInputFile)[0].files[0];
    fd.append('file_', files);
    $.ajax({
        url: './?d='+dir_+'&f='+file_+'.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        success: function(response){
            if(response != 0){
                var x = JSON.parse(response);
                if (x.status=="success"){
                    $('#'+tagShow).html("<a class='btn btn-outline-dark btn-download btn-sm m-1' href='./assets/dokumen/"+x.fileName+"' target='_BLANK'>Unduh</a>");
                    $('#'+tagInputHidden).val(x.fileName);
                }else{
                    $('#'+tagShow).html("<div class='alert alert-danger'>"+x.pesan+"</div>");
                    $('#'+tagInputHidden).val('');
                }
            }else{
                showNotificationFloat('danger','Berkas Gagal Diunggah');
            }
        },
    });
}