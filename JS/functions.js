/**
 * Created by Serban on 5/21/2016.
 */

function show_student_grades(){

    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
   
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("info_student").innerHTML = xmlhttp.responseText;
        }
   
    };
    xmlhttp.open("GET","get_grades.php",true);
    xmlhttp.send();

}

function show_student_info(){

    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("info_student").innerHTML = xmlhttp.responseText;
        }
    };
    xmlhttp.open("GET","get_info.php",true);
    xmlhttp.send();
    
}

function trigger_middle_Functions(){

    if("Catalog Note"==document.getElementById("catalog_profil_switch").innerHTML){

        show_student_grades();
        document.getElementById("catalog_profil_switch").innerHTML="Profilul meu";
        document.getElementById("actual_section").innerHTML="Catalog Note";

    }

     else{
        show_student_info();
        document.getElementById("catalog_profil_switch").innerHTML="Catalog Note";
        document.getElementById("actual_section").innerHTML="Profilul meu";

    }

}

function test_grade(){

   console.log(document.getElementById("info_student").innerHTML);
     



}

