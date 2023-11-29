const dialog = document.getElementById('event-dialog');
const openModal = document.getElementById('open-event-modal');
const closeModal = document.getElementById('close-event-modal');

openModal.addEventListener('click', () => {
    dialog.showModal();
});

closeModal.addEventListener('click', () => {
    dialog.close();
});