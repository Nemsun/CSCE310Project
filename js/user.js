// Written by Patrick Keating
const userDialog = document.getElementById('user-dialog');
const openUserModal = document.getElementById('open-user-modal');
const closeUserModal = document.getElementById('close-user-modal');

openUserModal.addEventListener('click', () => {
    userDialog.showModal();
});

closeUserModal.addEventListener('click', () => {
    userDialog.close();
});