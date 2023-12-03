const eventDialog = document.getElementById('event-dialog');
const openEventModal = document.getElementById('open-event-modal');
const closeEventModal = document.getElementById('close-event-modal');

openEventModal.addEventListener('click', () => {
    eventDialog.showModal();
});

closeEventModal.addEventListener('click', () => {
    eventDialog.close();
});

const eventUserDialog = document.getElementById('event-user-dialog');
const openEventUserModal = document.getElementById('open-event-user-modal');
const closeEventUserModal = document.getElementById('close-event-user-modal');

openEventUserModal.addEventListener('click', () => {
    eventUserDialog.showModal();
});

closeEventUserModal.addEventListener('click', () => {
    eventUserDialog.close();
});

function showEventTrackingDetails(eventId) {
    // Get the event tracking data from the hidden input field
    var eventTrackingData = JSON.parse(document.getElementById('eventTrackingData ' + eventId).value);
    console.log(eventTrackingData);
    // Update the table with the retrieved data
    updateEventTrackingTable(eventTrackingData);
    // Show the event tracking details div
    document.getElementById('eventTrackingDetails').style.display = 'block';
    document.getElementById('eventTrackingDetails').preventDefault();
}

function updateEventTrackingTable(eventTrackingData) {
    var tableBody = document.getElementById("eventTrackingTableBody");
    // Clear existing table rows
    tableBody.innerHTML = "";
    // Populate the table with the retrieved data
    for (var i = 0; i < eventTrackingData.length; i++) {
        var row = tableBody.insertRow(i);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        cell1.innerHTML = eventTrackingData[i].ET_Num;
        cell2.innerHTML = eventTrackingData[i].Event_Id;
        cell3.innerHTML = eventTrackingData[i].UIN;
        
        var deleteForm = document.createElement("form");
        deleteForm.method = "POST";
        deleteForm.action = "../includes/process_event.php";
        var hiddenInput = document.createElement("input");
        hiddenInput.type = "hidden";
        hiddenInput.name = "delete_uin_id";
        hiddenInput.value = eventTrackingData[i].UIN;
        var deleteButton = document.createElement("button");
        deleteButton.type = "submit";
        deleteButton.name = "delete_event_user_btn";
        deleteButton.innerHTML = "Delete";
        deleteButton.className = "table-btn delete-btn";
        deleteForm.appendChild(hiddenInput);
        deleteForm.appendChild(deleteButton);
        cell4.appendChild(deleteForm);
    }
}