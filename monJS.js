function modifGout(){
    document.getElementById('inputGout').disabled = false;
}

function showVal(newVal){
  document.getElementById("rangeBox").innerHTML=newVal;
}

function afficherMenu(choix, objet){
    if((document.getElementsByClassName("mesTrisCacher").length)==2){
        ouvrirListe(choix);
    } 
    else{
        if( objet.className == "listeTitreVisible"){
            fermerListe(0);
        }
        else{
            fermerListe(0);
            ouvrirListe(choix);
        }
    }   
}

function ouvrirListe(choix){
    document.getElementsByClassName("mesTrisCacher")[choix].className="mesTrisVisible";
    document.getElementsByClassName("imageArrow")[choix].className="imageArrowInverse";
    document.getElementsByClassName("listeTitreCacher")[choix].className="listeTitreVisible";
}

function fermerListe(choix){
    document.getElementsByClassName("mesTrisVisible")[choix].className="mesTrisCacher";
    document.getElementsByClassName("imageArrowInverse")[choix].className="imageArrow";
    document.getElementsByClassName("listeTitreVisible")[choix].className="listeTitreCacher";
}

function messageConfirm(){
    setTimeout(disparaitre,2000);
}

var opacity = 1;
function disparaitre(){
    opacity = opacity -0.1;  
    var dialog =document.getElementById("messageConfirm");
    dialog.style.opacity = opacity;
    if(opacity>0){
        setTimeout(disparaitre,50);
    }
    else{
        dialog.style.left = "-999em";
    }
}

function supprimer(ref, lien){
    var dialog = confirm("Voulez-vous vraiment supprimer le bonbon?");
    if(dialog){
        document.location.href="deleteBonbon.php?Reference="+ref+"&Lien="+lien;
    }
    else{
        document.location.href="toolBonbon.php";
    }
}

function gererFormat(){
    var format =document.getElementById('choixFormat').value;
    
    if(format==1){
        document.getElementById("format1").style.opacity ="1";
        document.getElementById("format2").style.opacity ="0";
    }
    else if(format==2){
        document.getElementById("format1").style.opacity ="1";
        document.getElementById("format2").style.opacity ="1";
    }
    else{
        document.getElementById("format1").style.opacity ="0";
        document.getElementById("format2").style.opacity ="0";
    }
}



  