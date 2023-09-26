let addedaliments = [];

function search_aliment() {
    let input = document.getElementById('searchbar').value;
    input = input.toLowerCase();
    let aliments = document.getElementsByClassName('aliments');

    for (i = 0; i < aliments.length; i++) {
        let aliment = aliments[i].innerHTML.toLowerCase();
        if (aliment.includes(input)) {
            aliments[i].style.display = "list-item";
        } else {
            aliments[i].style.display = "none";
        }
    }
}

function add_aliment() {
    let input = document.getElementById('searchbar').value;

    // Vérifier si l'aliment a déjà été ajouté
    if (addedaliments.includes(input)) {
        alert("Cet aliment a déjà été ajouté.");
        return;
    }

    addedaliments.push(input);

    let addedalimentsDiv = document.getElementById('added-aliments');
    let alimentElement = document.createElement('p');
    alimentElement.classList.add('added-aliment');
    alimentElement.innerText = input;
    addedalimentsDiv.appendChild(alimentElement);

    document.getElementById('searchbar').value = "";
    search_aliment();

    // Masquer la liste des aliments
    let alimentList = document.getElementById('list');
    alimentList.style.display = "none";
}

// Vérifier si l'aliment ajouté est présent dans la liste
function validate_aliment() {
    let input = document.getElementById('searchbar').value;
    let aliments = document.getElementsByClassName('aliments');

    for (i = 0; i < aliments.length; i++) {
        let aliment = aliments[i].innerHTML.toLowerCase();
        if (aliment === input.toLowerCase()) {
            add_aliment();
            return;
        }
    }

    alert("Cet aliment n'est pas dans la liste.");
}

// Afficher la liste des aliments lorsqu'on clique à nouveau sur le champ de recherche
document.getElementById('searchbar').addEventListener('click', function () {
    let alimentList = document.getElementById('list');
    alimentList.style.display = "block";
});