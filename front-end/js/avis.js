 // Récupérer les éléments des messages de succès et d'erreur
 var successMessage = document.getElementById('success-message');
 var errorMessage = document.getElementById('error-message');

 // Vérifier si les messages sont affichés et les masquer après 5 secondes
 if (successMessage.innerText !== '') {
     setTimeout(function() {
         successMessage.style.display = 'none';
     }, 5000);
 }

 if (errorMessage.innerText !== '') {
     setTimeout(function() {
         errorMessage.style.display = 'none';
     }, 5000);
 }