//! Rechercher un élement dans une des tables HTML
function searchShortcut() {
    var input, filter, container, racourci, titreRacourci, i;
    input = document.getElementById("myInput");
    filter = input.value.toLowerCase();

    container = document.getElementById("racourci-container");
    racourci = document.getElementById("racourci-container").getElementsByClassName("racourci");
    totalOfRaccourcis = racourci.length;
    for(i = 0; i < racourci.length; i++) {
        titreRacourci = racourci[i].getElementsByClassName("racourci-title")[0];
        if(titreRacourci.innerHTML.toLowerCase().indexOf(filter)>-1){
            racourci[i].style.display ='';
        } else {
            racourci[i].style.display ='none';
            totalOfRaccourcis--;
        }

        if(totalOfRaccourcis == 0) {
            document.getElementById("noresult").style.display = "";
        } else {
            document.getElementById("noresult").style.display = "none";
        }
    }
}

//! CHhange la source de l'image lors de l'upload
function actualiserPhoto(element,img) {
    // var image = document.getElementById(img);
    var fReader = new FileReader();
    fReader.readAsDataURL(element.files[0]);
    fReader.onloadend = function(event) {
        var imgToChange = document.getElementById(img);
        imgToChange.src = event.target.result;
    }
}

//! Activer actualiserPhoto() lors du clique sur l'image a changer
function triggerClick(id) {
    document.querySelector(id).click();
}

//! Remettre l'image du formulaire a 0 quand envois annulé
function changeMoneyInput(element, target) {
    document.getElementById(target).innerHTML = element.toLocaleString();
}

function resetFormImage(target) {
    var imgToChange = document.getElementById(target);
    imgToChange.src = "./images/image-placeholder.png";
}

function askForBuying(nom,prix) {
    var result = confirm("Etes vous sur de vouloir acheter " + nom + " pour " + prix + " crédits (" + prix * 5 + " €)");
    if(result == false) {
        event.preventDefault();
    }
}


function passwordCheck(password, targetColor) {
    //! Element HTML a changer de couleur selon la validité ou non du mot de passe
    // var passwordInput = document.getElementById(targetColor);
    var textColorInput = document.getElementById(targetColor);
    // var textColorInput = passwordInput;
    //! Récupération de la donnée entrée par l'utilisateur
    text = password.value;
    nb_points = 10;
    nb_caractere = password.value.length;
    points_nbcarac = 0;
    points_complexite = 0;

    //! Vérification de la longueur du mot de passe
    if (nb_caractere >= 12) { points_nbcarac = 1; }
    //! Vérification des lettres minuscules
    if (text.match(/[a-z]/)) { points_complexite = points_complexite + 1; }
    //! Vérification des lettres majuscules
    if (text.match(/[A-Z]/)) { points_complexite = points_complexite + 2; }
    //! Vérification des chiffres
    if (text.match(/[0-9]/)) { points_complexite = points_complexite + 3; }
    //! Vérification des caractères spéciaux
    if (text.match(/\W/)) { points_complexite = points_complexite + 4; }

    resultat = points_nbcarac * points_complexite;

    if(resultat <= 4) { textColorInput.style.color = "red"; } 
    else if (resultat >4 && resultat < 8) { textColorInput.style.color = "orange"; } 
    else if (resultat > 8) { textColorInput.style.color = "green"; }
}
    

// Fonction qui change la couleur

// https://www.codingnepalweb.com/price-range-slider-html-css-javascript/
//! Double Range
const rangeInput = document.querySelectorAll(".range-input input"),
priceInput = document.querySelectorAll(".price-input input"),
range = document.querySelector(".slider .progress");
let priceGap = 1;

function updateRangeNavbar() {
    range.style.left = ((parseInt(rangeInput[0].value) / rangeInput[0].max) * 100) + "%";
    range.style.right = 100 - (parseInt(rangeInput[1].value) / rangeInput[1].max) * 100 + "%";
}
priceInput.forEach(input =>{
    input.addEventListener("input", e =>{
        let minPrice = parseInt(priceInput[0].value),
        maxPrice = parseInt(priceInput[1].value);
        
        if((maxPrice - minPrice >= priceGap) && maxPrice <= rangeInput[1].max){
            if(e.target.className === "input-min"){
                rangeInput[0].value = minPrice;
                range.style.left = ((minPrice / rangeInput[0].max) * 100) + "%";
            }else{
                rangeInput[1].value = maxPrice;
                range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
            }
        }
    });
});

rangeInput.forEach(input =>{
    input.addEventListener("input", e =>{
        let minVal = parseInt(rangeInput[0].value),
        maxVal = parseInt(rangeInput[1].value);
        
        console.log(minVal);

        if((maxVal - minVal) < priceGap){
            if(e.target.className === "range-min"){
                rangeInput[0].value = maxVal - priceGap
            }else{
                rangeInput[1].value = minVal + priceGap;
            }
        }else{
            priceInput[0].value = minVal;
            priceInput[1].value = maxVal;
            range.style.left = ((minVal / rangeInput[0].max) * 100) + "%";
            range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
        }
    });
});

//! Formulaires Bootstrap
(() => {
    'use strict'
    const forms = document.querySelectorAll('.needs-validation')
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

    form.classList.add('was-validated')
    }, false)
})
})()


// Fonction qui change la couleur des éléments HTML
function changeColor() {
    var elements = document.querySelectorAll('.white, .black');
    for (var i = 0; i < elements.length; i++) {
        if (elements[i].classList.contains('white')) {
        elements[i].classList.remove('white');
        elements[i].classList.add('black');
        } else {
        elements[i].classList.remove('black');
        elements[i].classList.add('white');
        }
    }
    
    var tables = document.querySelectorAll('.table-light, .table-dark');
    for (var j = 0; j < tables.length; j++) {
        if (tables[j].classList.contains('table-light')) {
        tables[j].classList.remove('table-light');
        tables[j].classList.add('table-dark');
        } else {
        tables[j].classList.remove('table-dark');
        tables[j].classList.add('table-light');
        }
    }

    var logos = document.querySelectorAll('.fa-moon, .fa-sun');
    for (var j = 0; j < logos.length; j++) {
        if (logos[j].classList.contains('fa-moon')) {
        logos[j].classList.remove('fa-moon');
        logos[j].classList.add('fa-sun');
        } else {
        logos[j].classList.remove('fa-sun');
        logos[j].classList.add('fa-moon');
        }
    }
    
    
    // Enregistrer l'état de la couleur dans le stockage local
    localStorage.setItem('color', document.querySelector('.white') ? 'white' : 'black');
    localStorage.setItem('table-color', document.querySelector('.table-dark') ? 'table-dark' : 'table-light');
    localStorage.setItem('logo', document.querySelector('.fa-moon') ? 'fa-moon' : 'fa-sun');
}

// Vérifier si l'état de la couleur est enregistré dans le stockage local et le charger si c'est le cas
var savedColor = localStorage.getItem('color');
if (savedColor) {
    document.body.classList.remove('white', 'black');
    document.body.classList.add(savedColor);
}

var savedTableColor = localStorage.getItem('table-color');
if (savedTableColor) {
    var tables = document.querySelectorAll('.table-light, .table-dark');
    for (var j = 0; j < tables.length; j++) {
        tables[j].classList.remove('table-light', 'table-dark');
        tables[j].classList.add(savedTableColor);
    }
}

var savedLogo = localStorage.getItem('logo');
if (savedLogo) {
    var tables = document.querySelectorAll('.fa-moon, .fa-sun');
    for (var j = 0; j < tables.length; j++) {
        tables[j].classList.remove('fa-moon', 'fa-sun');
        tables[j].classList.add(savedLogo);
    }
}

// Ajouter un événement de clic à l'élément avec l'ID 'colorChanger'
document.getElementById('colorChanger').addEventListener('click', changeColor);


