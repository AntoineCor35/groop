import './bootstrap';

// Suppression d'Alpine car Livewire l'inclut déjà
// import Alpine from 'alpinejs';
// window.Alpine = Alpine;
// Alpine.start();

// Solution pour utiliser Alpine.js uniquement pour les éléments qui ne sont pas gérés par Livewire
// Cela permet d'éviter les conflits avec l'instance d'Alpine de Livewire
document.addEventListener('DOMContentLoaded', function() {
    // Initialisation du menu déroulant de l'utilisateur
    const userDropdownButton = document.querySelector('[data-dropdown-toggle="user-dropdown"]');
    const userDropdownMenu = document.querySelector('#user-dropdown');
    
    if (userDropdownButton && userDropdownMenu) {
        userDropdownButton.addEventListener('click', function() {
            const isHidden = userDropdownMenu.classList.contains('hidden');
            if (isHidden) {
                userDropdownMenu.classList.remove('hidden');
            } else {
                userDropdownMenu.classList.add('hidden');
            }
        });
        
        // Fermer le menu lorsqu'on clique ailleurs
        document.addEventListener('click', function(event) {
            if (!userDropdownButton.contains(event.target) && !userDropdownMenu.contains(event.target)) {
                userDropdownMenu.classList.add('hidden');
            }
        });
    }
});
