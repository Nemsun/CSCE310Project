// Written by Patrick Keating

//Functions that are used to show and hide the modal when the add user button is pressed in the admin dashboard
const userDialog = document.getElementById('user-dialog');
const openUserModal = document.getElementById('open-user-modal');
const closeUserModal = document.getElementById('close-user-modal');

openUserModal.addEventListener('click', () => {
    userDialog.showModal();
});

closeUserModal.addEventListener('click', () => {
    userDialog.close();
});