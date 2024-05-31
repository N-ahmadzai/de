document.getElementById('contact-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Empêcher le comportement par défaut du formulaire

    // Récupérer les données du formulaire
    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var subject = document.getElementById('subject').value;
    var message = document.getElementById('message').value;


    // Valider les champs
    if (name === "") {
        alert("Le nom ne peut pas être vide.");
        return false;
    }
    if (name.length < 4) {
        alert("Le nom doit contenir au moins 5 caractères.");
        return false;
    }
    if (!/^[a-zA-Z\s]+$/.test(name)) {
        alert("Le nom ne doit contenir que des lettres et des espaces.");
        return false;
    }
    if (email === "") {
        alert("L'email ne peut pas être vide.");
        return false;
    }
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert("Veuillez entrer une adresse email valide.");
        return false;
    }
    if (subject === "") {
        alert("Le sujet ne peut pas être vide.");
        return false;
    }
    if (message === "") {
        alert("Le message ne peut pas être vide.");
        return false;
    }

    // Créer un objet FormData
    var formData = new FormData();
    formData.append('name', name);
    formData.append('email', email);
    formData.append('subject', subject);
    formData.append('message', message);

    // Envoyer les données du formulaire via AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../back-end/contact_form.php', true);
    xhr.onload = function () {
        var successMessage = document.getElementById('success-message');
        var errorMessage = document.getElementById('error-message');
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.status === 'success') {
                successMessage.style.display = 'block';
                errorMessage.style.display = 'none';
                // Réinitialiser le formulaire après un court délai
                setTimeout(function () {
                    successMessage.style.display = 'none';
                    document.getElementById('contact-form').reset();
                }, 3000); // 3000 ms = 3 secondes
            } else {
                errorMessage.textContent = response.message;
                errorMessage.style.display = 'block';
                successMessage.style.display = 'none';
            }
        } else {
            errorMessage.textContent = "Erreur lors de l'envoi de votre message.";
            errorMessage.style.display = 'block';
            successMessage.style.display = 'none';
        }
    };
    xhr.send(formData);
});



// Pré-remplir le champ d'email avec la valeur saisie par l'utilisateur
window.onload = function() {
    var emailInput = document.getElementById("email");
    var userEmail = localStorage.getItem("userEmail");

    if (userEmail) {
        emailInput.value = userEmail;
    }

    // Écouter les changements dans le champ d'email et sauvegarder la valeur dans le localStorage
    emailInput.addEventListener("input", function() {
        localStorage.setItem("userEmail", emailInput.value);
    });
};