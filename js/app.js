/* WRITTEN BY: NAMSON PHAM
   UIN: 530003416
*/
const appDialog = document.getElementById('app-dialog');
const openAppModal = document.getElementById('open-app-modal');
const closeAppModal = document.getElementById('close-app-modal');

openAppModal.addEventListener('click', () => {
    appDialog.showModal();
});

closeAppModal.addEventListener('click', () => {
    appDialog.close();
});