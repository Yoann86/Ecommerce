// script.js

const text = "Bienvenue sur...";

let index = 0;

const speed = 50; // Vitesse de frappe en millisecondes

 

function typeText() {

    if (index < text.length) {

        document.querySelector(".typing-text").textContent += text.charAt(index);

        index++;

        setTimeout(typeText, speed);

    }

}

 

// Démarrer l'effet de typing lorsque la page est chargée

window.addEventListener("load", () => {

    typeText();

});