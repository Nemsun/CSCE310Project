/* WRITTEN BY: NAMSON PHAM
   UIN: 530003416
*/

// Grabbing the event dialog and the open and close buttons
const eventDialog = document.getElementById('event-dialog');
const openEventModal = document.getElementById('open-event-modal');
const closeEventModal = document.getElementById('close-event-modal');

// Adding event listeners to the open and close buttons
openEventModal.addEventListener('click', () => {
    eventDialog.showModal();
});

closeEventModal.addEventListener('click', () => {
    eventDialog.close();
});

// Grabbing the event tracking dialog and the open and close buttons
const eventUserDialog = document.getElementById('event-user-dialog');
const openEventUserModal = document.getElementById('open-event-user-modal');
const closeEventUserModal = document.getElementById('close-event-user-modal');

// Adding event listeners to the open and close buttons
openEventUserModal.addEventListener('click', () => {
    eventUserDialog.showModal();
});

closeEventUserModal.addEventListener('click', () => {
    eventUserDialog.close();
});

/**
 * This function parses the event tracking data from the hidden input field
 * and updates the event tracking table with the retrieved data
 * @param {*} eventId 
 */
function showEventTrackingDetails(eventId) {
    // Get the event tracking data from the hidden input field
    var eventTrackingData = JSON.parse(document.getElementById('eventTrackingData ' + eventId).value);
    // console.log(eventTrackingData);
    // Update the table with the retrieved data
    updateEventTrackingTable(eventTrackingData);
    // Show the event tracking details div
    document.getElementById('eventTrackingDetails').style.display = 'block';
    document.getElementById('eventTrackingDetails').preventDefault();
}

/**
 * This function updates the event tracking table with the retrieved data
 * @param {*} eventTrackingData 
 */
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
        var cell5 = row.insertCell(4);
        cell1.innerHTML = eventTrackingData[i].ET_Num;
        cell2.innerHTML = eventTrackingData[i].Event_Id;
        cell3.innerHTML = eventTrackingData[i].UIN;
        
        // Create a form for the edit button
        var editForm = document.createElement("form");
        editForm.method = "POST";
        editForm.action = "edit_event_tracking.php";
        var hiddenInput = document.createElement("input");
        hiddenInput.type = "hidden";
        hiddenInput.name = "edit_et_num";
        hiddenInput.value = eventTrackingData[i].ET_Num;
        var editButton = document.createElement("button");
        editButton.type = "submit";
        editButton.name = "edit_event_tracking_btn";
        editButton.innerHTML = "Edit";
        editButton.className = "table-btn edit-btn";
        editForm.appendChild(hiddenInput);
        editForm.appendChild(editButton);
        cell4.appendChild(editForm);

        // Create a form for the delete button
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
        cell5.appendChild(deleteForm);
    }
}