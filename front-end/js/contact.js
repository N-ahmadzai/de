
document.getElementById('contact-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Empêche l'envoi du formulaire

    // Récupérer les valeurs des champs
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const subject = document.getElementById('subject').value;
    const message = document.getElementById('message').value;

    // Validation basique
    if (!name || !email || !subject || !message) {
        displayMessage('error', 'Tous les champs sont obligatoires.');
        return;
    }

    // Envoi du formulaire via AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', this.action, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
    console.log(xhr.responseText); // Affiche la réponse du serveur dans la console
    if (xhr.status === 200) {
        try {
            const response = JSON.parse(xhr.responseText);
            if (response.status === 'success') {
                displayMessage('success', response.message);
                document.getElementById('contact-form').reset();
            } else if (response.status === 'error') {
                displayMessage('error', response.message);
            } else {
                displayMessage('error', 'Réponse inattendue du serveur.');
            }
        } catch (error) {
            displayMessage('error', 'Réponse inattendue du serveur.');
        }
    } else {
        displayMessage('error', 'Erreur lors de l\'envoi du formulaire.');
    }
};


    xhr.send(`name=${encodeURIComponent(name)}&email=${encodeURIComponent(email)}&subject=${encodeURIComponent(subject)}&message=${encodeURIComponent(message)}`);
});

function displayMessage(type, message) {
    const successMessage = document.getElementById('success-message');
    const errorMessage = document.getElementById('error-message');

    if (type === 'success') {
        successMessage.textContent = message;
        successMessage.style.display = 'block';
        errorMessage.style.display = 'none';
    } else {
        errorMessage.textContent = message;
        errorMessage.style.display = 'block';
        successMessage.style.display = 'none';
    }
}
