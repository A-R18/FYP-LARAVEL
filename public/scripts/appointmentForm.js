
// This function waits until the entire page is fully loaded before running the script
document.addEventListener('DOMContentLoaded', function () {
    // Gets the value of the hidden input field with the ID 'booked-slots-data', which contains booked time slots in JSON format
    const bookedSlotsData = document.getElementById('booked-slots-data').value;
    // Initializing an empty object to store booked slots after parsing the JSON data
    let bookedSlots = {};
    // Attempting to parse the JSON data into a JavaScript object
    try {
        bookedSlots = JSON.parse(bookedSlotsData); // Convert the JSON string into an object
    } catch (e) {
        console.error('Error parsing booked slots data:', e);  // Log an error if the JSON parsing fails
    }
    // Getting the values of various elements related to the doctor's status and available time slots
    // Doctor's availability status (e.g., 'available')
    const doctorStatus = document.getElementById('doctor-status').value;
    // Doctor's starting time for appointments
    const doctorStartTime = document.getElementById('doctor-start-time').value;
    // Doctor's ending time for appointments
    const doctorEndTime = document.getElementById('doctor-end-time').value;
    // The dropdown element where available time slots will be populated
    const timingSelect = document.getElementById('timing');
    // The input field where the user selects the appointment date
    const apdateInput = document.getElementById('apdate');
    // Function to generate 15-minute time slots between the doctor's start and end times
    function generateTimeSlots(start, end) {
        let slots = []; // Array to store the generated time slots
        let startTime = new Date(`1970-01-01T${start}Z`);   // Create a Date object for the start time
        let endTime = new Date(`1970-01-01T${end}Z`);  // Create a Date object for the end time
        // Loop to generate time slots until the start time is less than the end time
        while (startTime < endTime) {
            let slot = startTime.toISOString().substr(11, 5); // Extract the 'hh:mm' part of the time
            slots.push(slot); // Add the time slot to the array
            startTime.setMinutes(startTime.getMinutes() + 15); // Increment the start time by 15 minutes
        }

        return slots;  // Return the array of generated time slots
    }

    // Function to populate the time slots dropdown for the selected date
    function populateTimeSlots(date) {
        timingSelect.innerHTML = '';  // Clear any existing options in the dropdown
        // Generate the time slots based on the doctor's start and end times
        let slots = generateTimeSlots(doctorStartTime, doctorEndTime);
        const bookedSlotsForDate = bookedSlots[date] || []; // Get the booked slots for the selected date

        let hasAvailableSlots = false; // Flag to check if there are any available slots

        slots.forEach(slot => {
            const slotWithoutSeconds = slot + ':00'; // Add seconds to match the format of booked slots
            if (!bookedSlotsForDate.includes(slotWithoutSeconds)) {  // Check if the slot is not booked
                let option = document.createElement('option');  // Create a new <option> element
                option.value = slot;  // Set the value of the option to the time slot
                option.textContent = slot; // Set the display text of the option
                timingSelect.appendChild(option); // Add the option to the dropdown
                hasAvailableSlots = true; // Mark that there is at least one available slot
            }
        });
        // If no slots are available, show an alert and disable the dropdown
        if (!hasAvailableSlots) {
            alert('No more available slots for the selected date.');
            timingSelect.disabled = true; // Disable select if no slots are available
        } else {
            timingSelect.disabled = false; // Enable select if slots are available
        }
    }

    // Function to check if the doctor is available
    function isDoctorAvailable() {
        return doctorStatus === 'available'; // Return true if the doctor is available
    }

    // Function to check if the selected date is today or a future date
    function isFutureDate(date) { // Getting today's date
        const today = new Date(); // Convert the selected date string into a Date object
        const selectedDate = new Date(date);  // Convert the selected date string into a Date object
        today.setHours(0, 0, 0, 0);  // Reset today's time to midnight to compare only the dates
        return selectedDate >= today; // Return true if the selected date is today or in the future
    }
    // Add an event listener to the date input field to detect when the date changes
    apdateInput.addEventListener('change', function () {
        let selectedDate = this.value; // Get the selected date
        if (!isDoctorAvailable()) {
            alert('Doctor is not available.');
            timingSelect.innerHTML = '<option>Doctor is not available</option>';
            timingSelect.disabled = true;
            // If the selected date is in the past, display an alert and disable the dropdown
        } else if (!isFutureDate(selectedDate)) {
            alert('You cannot book an appointment for a past date.');
            timingSelect.innerHTML = '<option>You cannot book an appointment for a past date</option>';
            timingSelect.disabled = true;
            // Otherwise, populate the available time slots for the selected date
        } else {
            populateTimeSlots(selectedDate);
        }
    });
    // If there is already a date selected and it's in the future, populate the time slots
    if (apdateInput.value && isFutureDate(apdateInput.value)) {
        populateTimeSlots(apdateInput.value);
    }
});
