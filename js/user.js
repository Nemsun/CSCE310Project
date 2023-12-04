const eventUserDialog = document.getElementById('user-dialog');
const openEventUserModal = document.getElementById('open-user-modal');
const closeEventUserModal = document.getElementById('close-user-modal');

openEventUserModal.addEventListener('click', () => {
    eventUserDialog.showModal();
});

closeEventUserModal.addEventListener('click', () => {
    eventUserDialog.close();
});