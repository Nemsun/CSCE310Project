const eventDialog = document.getElementById('event-dialog');
const openEventModal = document.getElementById('open-event-modal');
const closeEventModal = document.getElementById('close-event-modal');

openEventModal.addEventListener('click', () => {
    eventDialog.showModal();
});

closeEventModal.addEventListener('click', () => {
    eventDialog.close();
});

function showEventTrackingDetails(eventId) {
    // Get the event tracking data from the hidden input field
    var eventTrackingData = JSON.parse(document.getElementById('eventTrackingData ' + eventId).value);
    console.log(eventTrackingData);
    // Update the table with the retrieved data
    updateEventTrackingTable(eventTrackingData);
    // Show the event tracking details div
    document.getElementById('eventTrackingDetails').style.display = 'block';
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
        var cell5 = row.insertCell(4);
        cell1.innerHTML = eventTrackingData[i].ET_Num;
        cell2.innerHTML = eventTrackingData[i].Event_Id;
        cell3.innerHTML = eventTrackingData[i].UIN;

        var editButton = document.createElement("button");
        editButton.innerHTML = "Edit";
        editButton.className = "table-btn edit-btn";
        cell4.appendChild(editButton);
        
        var deleteButton = document.createElement("button");
        deleteButton.innerHTML = "Delete";
        deleteButton.className = "table-btn delete-btn";
        cell5.appendChild(deleteButton);
    }
}