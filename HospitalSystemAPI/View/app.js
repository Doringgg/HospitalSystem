// DOM Elements
const loginSection = document.getElementById('login-section');
const dashboardSection = document.getElementById('dashboard-section');
const loginForm = document.getElementById('login-form');
const loginError = document.getElementById('login-error');
const logoutBtn = document.getElementById('logout-btn');
const tabs = document.querySelectorAll('.tab');
const tabContents = document.querySelectorAll('.tab-content');

// API Base URL - Update this with your actual API URL
const API_BASE_URL = 'http://localhost/HospitalSystemAPI';

// Tab switching
tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        const tabId = tab.getAttribute('data-tab');
        
        // Update active tab
        tabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        
        // Update active content
        tabContents.forEach(content => content.classList.remove('active'));
        document.getElementById(`${tabId}-tab`).classList.add('active');
    });
});

// Doctor form toggles
document.getElementById('get-all-doctors').addEventListener('click', function() {
    fetchAllDoctors();
});
document.getElementById('get-doctor-by-id').addEventListener('click', () => toggleForm('get-doctor-form'));
document.getElementById('show-create-doctor').addEventListener('click', () => toggleForm('create-doctor-form'));
document.getElementById('show-update-doctor').addEventListener('click', () => toggleForm('update-doctor-form'));
document.getElementById('show-delete-doctor').addEventListener('click', () => toggleForm('delete-doctor-form'));

document.getElementById('get-all-patients').addEventListener('click', function() {
    fetchAllPatients();
});
document.getElementById('get-patient-by-id').addEventListener('click', () => toggleForm('get-patient-form'));
document.getElementById('show-create-patient').addEventListener('click', () => toggleForm('create-patient-form'));
document.getElementById('show-update-patient').addEventListener('click', () => toggleForm('update-patient-form'));
document.getElementById('show-delete-patient').addEventListener('click', () => toggleForm('delete-patient-form'));

document.getElementById('get-all-consultations').addEventListener('click', function() {
    fetchAllConsultations();
});
document.getElementById('get-consultation-by-id').addEventListener('click', () => toggleForm('get-consultation-form'));
document.getElementById('show-create-consultation').addEventListener('click', () => toggleForm('create-consultation-form'));
document.getElementById('show-update-consultation').addEventListener('click', () => toggleForm('update-consultation-form'));
document.getElementById('show-delete-consultation').addEventListener('click', () => toggleForm('delete-consultation-form'));


// Helper function to toggle forms
function toggleForm(formId) {
    // Hide all forms first
    const allForms = document.querySelectorAll('.card.hidden');
    allForms.forEach(form => {
        if (form.id.includes('form')) {
            form.classList.add('hidden');
        }
    });
    
    // Show the selected form
    const form = document.getElementById(formId);
    form.classList.toggle('hidden');
}


// Event listeners for login and logout
loginForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    
    fetch(`${API_BASE_URL}/login`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            user: {
                email: email,
                password: password
            }
        })
    })
    .then(response => {
        // First check if the response is JSON
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            return response.json().then(data => ({ data, status: response.status }));
        } else {
            return response.text().then(text => ({ text, status: response.status }));
        }
    })
    .then(result => {
        if (result.status >= 200 && result.status < 300) {
            // Success case
            if (result.data && result.data.success) {
                localStorage.setItem('authToken', result.data.data.token);
                
                loginSection.classList.add('hidden');
                dashboardSection.classList.remove('hidden');
                

            } else {
                showLoginError(result.data?.message || 'Login failed');
            }
        } else {
            // Error case
            if (result.data && result.data.message) {
                showLoginError(result.data.message);
            } else if (result.text) {
                showLoginError(`Server error: ${result.status} - ${result.text}`);
            } else {
                showLoginError(`Login failed with status: ${result.status}`);
            }
        }
    })
    .catch(error => {
        console.error('Login error:', error);
        showLoginError('Network error. Please try again.');
    });
});


function showLoginError(message) {
    loginError.textContent = message;
    loginError.classList.remove('hidden');
}


logoutBtn.addEventListener('click', function() {
    dashboardSection.classList.add('hidden');
    loginSection.classList.remove('hidden');
});

function displayDoctors(doctors) {
    const container = document.getElementById('doctors-table-container');
    const tbody = document.querySelector('#doctors-table tbody');
    
    tbody.innerHTML = '';
    
    let doctorsArray = [];
    
    doctorsArray = doctors.Doctors;
    
    if (doctorsArray.length === 0) {
        console.error('No doctors data found in response:', doctors);
        alert('No doctors data found in the response. Check console for details.');
        return;
    }
    
    doctorsArray.forEach(doctor => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${doctor.doctorID || doctor.id}</td>
            <td>${doctor.doctorName || doctor.name}</td>
            <td>${doctor.doctorEmail || doctor.email}</td>
            <td>${doctor.doctorPhoneNum || doctor.phone}</td>
            <td>${doctor.doctorCPF || doctor.cpf}</td>
            <td>${doctor.doctorDOB || doctor.dob}</td>
            </td>
        `;
        tbody.appendChild(row);
    });
    
    container.classList.remove('hidden');
}



function displayPatients(patients) {
    const container = document.getElementById('patients-table-container');
    const tbody = document.querySelector('#patients-table tbody');
    
    tbody.innerHTML = '';
    
    let patientsArray = [];
    
    patientsArray = patients.Patients;
    
    if (patientsArray.length === 0) {
        console.error('No patients data found in response:', patients);
        alert('No patients data found in the response. Check console for details.');
        return;
    }
    
    patientsArray.forEach(patient => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${patient.patientID || patient.id}</td>
            <td>${patient.patientName || patient.name}</td>
            <td>${patient.patientEmail || patient.email}</td>
            <td>${patient.patientPhoneNum || patient.phone}</td>
            <td>${patient.patientCPF || patient.cpf}</td>
            <td>${patient.patientDOB || patient.dob}</td>
            </td>
        `;
        tbody.appendChild(row);
    });
    
    container.classList.remove('hidden');
}


function displayConsultations(consultations) {
    const container = document.getElementById('consultations-table-container');
    const tbody = document.querySelector('#consultations-table tbody');
    
    tbody.innerHTML = '';
    
    let consultationsArray = [];
    
    consultationsArray = consultations.Consultations;
    
    if (consultationsArray.length === 0) {
        console.error('No consultations data found in response:', consultations);
        alert('No consultations data found in the response. Check console for details.');
        return;
    }
    
    consultationsArray.forEach(consultation => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${consultation.ConsultationID || consultation.id}</td>
            <td>${consultation.DoctorID || consultation.doctorId}</td>
            <td>${consultation.PatientID || consultation.patientId}</td>
            </td>
        `;
        tbody.appendChild(row);
    });
    
    container.classList.remove('hidden');
}

// Add similar event listeners for update forms and delete buttons

// Initialize the application
document.addEventListener('DOMContentLoaded', function() {
    // Check if user is already logged in
    const isLoggedIn = localStorage.getItem('isLoggedIn');
    if (isLoggedIn) {
        loginSection.classList.add('hidden');
        dashboardSection.classList.remove('hidden');
    }
});


// Add these event listeners for form submissions
document.getElementById('doctor-form').addEventListener('submit', function(e) {
    e.preventDefault();
    createDoctor();
});

document.getElementById('patient-form').addEventListener('submit', function(e) {
    e.preventDefault();
    createPatient();
});

document.getElementById('consultation-form').addEventListener('submit', function(e) {
    e.preventDefault();
    createConsultation();
});


// Create Doctor function
function createDoctor() {
    const authToken = localStorage.getItem('authToken');
    if (!authToken) {
        alert('Please login first');
        return;
    }

    const doctorData = {
        doctor: {
            doctorName: document.getElementById('doctor-name').value,
            doctorDOB: document.getElementById('doctor-dob').value,
            doctorEmail: document.getElementById('doctor-email').value,
            doctorPhoneNum: document.getElementById('doctor-phone').value,
            doctorCPF: document.getElementById('doctor-cpf').value,
            doctorPassword: document.getElementById('doctor-password').value
        }
    };

    fetch(`${API_BASE_URL}/Doctors`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        },
        body: JSON.stringify(doctorData)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Doctor created successfully!');
            document.getElementById('doctor-form').reset();
            toggleForm('create-doctor-form'); // Hide the form
        } else {
            alert('Error creating doctor: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error creating doctor:', error);
        alert('Error creating doctor: ' + error.message);
    });
}



// Create Patient function
function createPatient() {
    const authToken = localStorage.getItem('authToken');
    if (!authToken) {
        alert('Please login first');
        return;
    }

    const patientData = {
        patient: {
            patientName: document.getElementById('patient-name').value,
            patientDOB: document.getElementById('patient-dob').value,
            patientEmail: document.getElementById('patient-email').value,
            patientPhoneNum: document.getElementById('patient-phone').value,
            patientCPF: document.getElementById('patient-cpf').value
        }
    };

    fetch(`${API_BASE_URL}/Patients`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        },
        body: JSON.stringify(patientData)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Patient created successfully!');
            document.getElementById('patient-form').reset();
            toggleForm('create-patient-form'); // Hide the form
        } else {
            alert('Error creating patient: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error creating patient:', error);
        alert('Error creating patient: ' + error.message);
    });
}



// Create Consultation function
function createConsultation() {
    const authToken = localStorage.getItem('authToken');
    if (!authToken) {
        alert('Please login first');
        return;
    }

    const consultationData = {
        Consultation: {
            doctorID: parseInt(document.getElementById('consultation-doctor-id').value),
            patientID: parseInt(document.getElementById('consultation-patient-id').value)
        }
    };

    fetch(`${API_BASE_URL}/Consultations`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        },
        body: JSON.stringify(consultationData)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Consultation created successfully!');
            document.getElementById('consultation-form').reset();
            toggleForm('create-consultation-form'); // Hide the form
        } else {
            alert('Error creating consultation: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error creating consultation:', error);
        alert('Error creating consultation: ' + error.message);
    });
}



// Add event listeners for update forms
document.getElementById('doctor-update-form').addEventListener('submit', function(e) {
    e.preventDefault();
    updateDoctor();
});

document.getElementById('patient-update-form').addEventListener('submit', function(e) {
    e.preventDefault();
    updatePatient();
});

document.getElementById('consultation-update-form').addEventListener('submit', function(e) {
    e.preventDefault();
    updateConsultation();
});

// Add event listeners for delete buttons
document.getElementById('delete-doctor').addEventListener('click', function() {
    deleteDoctor();
});

document.getElementById('delete-patient').addEventListener('click', function() {
    deletePatient();
});

document.getElementById('delete-consultation').addEventListener('click', function() {
    deleteConsultation();
});



// Update Doctor function
function updateDoctor() {
    const authToken = localStorage.getItem('authToken');
    if (!authToken) {
        alert('Please login first');
        return;
    }

    const doctorId = document.getElementById('update-doctor-id').value;
    const doctorData = {
        doctor: {
            doctorID: parseInt(doctorId),
            doctorName: document.getElementById('update-doctor-name').value,
            doctorDOB: document.getElementById('update-doctor-dob').value,
            doctorEmail: document.getElementById('update-doctor-email').value,
            doctorPhoneNum: document.getElementById('update-doctor-phone').value,
            doctorCPF: document.getElementById('update-doctor-cpf').value,
            doctorPassword: document.getElementById('update-doctor-password').value
        }
    };

    fetch(`${API_BASE_URL}/Doctors/${doctorId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        },
        body: JSON.stringify(doctorData)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Doctor updated successfully!');
            document.getElementById('doctor-update-form').reset();
            toggleForm('update-doctor-form'); // Hide the form
        } else {
            alert('Error updating doctor: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error updating doctor:', error);
        alert('Error updating doctor: ' + error.message);
    });
}



// Update Patient function
function updatePatient() {
    const authToken = localStorage.getItem('authToken');
    if (!authToken) {
        alert('Please login first');
        return;
    }

    const patientId = document.getElementById('update-patient-id').value;
    const patientData = {
        patient: {
            patientID: parseInt(patientId),
            patientName: document.getElementById('update-patient-name').value,
            patientDOB: document.getElementById('update-patient-dob').value,
            patientEmail: document.getElementById('update-patient-email').value,
            patientPhoneNum: document.getElementById('update-patient-phone').value,
            patientCPF: document.getElementById('update-patient-cpf').value
        }
    };

    fetch(`${API_BASE_URL}/Patients/${patientId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        },
        body: JSON.stringify(patientData)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Patient updated successfully!');
            document.getElementById('patient-update-form').reset();
            toggleForm('update-patient-form'); // Hide the form
        } else {
            alert('Error updating patient: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error updating patient:', error);
        alert('Error updating patient: ' + error.message);
    });
}



// Update Consultation function
function updateConsultation() {
    const authToken = localStorage.getItem('authToken');
    if (!authToken) {
        alert('Please login first');
        return;
    }

    const consultationId = document.getElementById('update-consultation-id').value;
    const consultationData = {
        Consultation: {
            consultationID: parseInt(consultationId),
            doctorID: parseInt(document.getElementById('update-consultation-doctor-id').value),
            patientID: parseInt(document.getElementById('update-consultation-patient-id').value)
        }
    };

    fetch(`${API_BASE_URL}/Consultations/${consultationId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        },
        body: JSON.stringify(consultationData)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Consultation updated successfully!');
            document.getElementById('consultation-update-form').reset();
            toggleForm('update-consultation-form'); // Hide the form
        } else {
            alert('Error updating consultation: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error updating consultation:', error);
        alert('Error updating consultation: ' + error.message);
    });
}



// Delete Doctor function
function deleteDoctor() {
    const authToken = localStorage.getItem('authToken');
    if (!authToken) {
        alert('Please login first');
        return;
    }

    const doctorId = document.getElementById('delete-doctor-id').value;
    if (!doctorId) {
        alert('Please enter a doctor ID');
        return;
    }

    if (!confirm('Are you sure you want to delete this doctor?')) {
        return;
    }

    fetch(`${API_BASE_URL}/Doctors/${doctorId}`, {
        method: 'DELETE',
        headers: {
            'Authorization': `Bearer ${authToken}`
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Doctor deleted successfully!');
            document.getElementById('delete-doctor-id').value = '';
            toggleForm('delete-doctor-form'); // Hide the form
        } else {
            alert('Error deleting doctor: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error deleting doctor:', error);
        alert('Error deleting doctor: ' + error.message);
    });
}



// Delete Patient function
function deletePatient() {
    const authToken = localStorage.getItem('authToken');
    if (!authToken) {
        alert('Please login first');
        return;
    }

    const patientId = document.getElementById('delete-patient-id').value;
    if (!patientId) {
        alert('Please enter a patient ID');
        return;
    }

    if (!confirm('Are you sure you want to delete this patient?')) {
        return;
    }

    fetch(`${API_BASE_URL}/Patients/${patientId}`, {
        method: 'DELETE',
        headers: {
            'Authorization': `Bearer ${authToken}`
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Patient deleted successfully!');
            document.getElementById('delete-patient-id').value = '';
            toggleForm('delete-patient-form'); // Hide the form
        } else {
            alert('Error deleting patient: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error deleting patient:', error);
        alert('Error deleting patient: ' + error.message);
    });
}



// Delete Consultation function
function deleteConsultation() {
    const authToken = localStorage.getItem('authToken');
    if (!authToken) {
        alert('Please login first');
        return;
    }

    const consultationId = document.getElementById('delete-consultation-id').value;
    if (!consultationId) {
        alert('Please enter a consultation ID');
        return;
    }

    if (!confirm('Are you sure you want to delete this consultation?')) {
        return;
    }

    fetch(`${API_BASE_URL}/Consultations/${consultationId}`, {
        method: 'DELETE',
        headers: {
            'Authorization': `Bearer ${authToken}`
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Consultation deleted successfully!');
            document.getElementById('delete-consultation-id').value = '';
            toggleForm('delete-consultation-form'); // Hide the form
        } else {
            alert('Error deleting consultation: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error deleting consultation:', error);
        alert('Error deleting consultation: ' + error.message);
    });
}



// Update the fetch doctor by ID function
document.getElementById('fetch-doctor').addEventListener('click', function() {
    const doctorId = document.getElementById('doctor-id').value;
    if (!doctorId) {
        alert('Please enter a doctor ID');
        return;
    }
    
    const authToken = localStorage.getItem('authToken');
    if (!authToken) {
        alert('Please login first');
        return;
    }
    
    fetch(`${API_BASE_URL}/Doctors/${doctorId}`, {
        headers: {
            'Authorization': `Bearer ${authToken}`
        }
    })
    .then(response => {
        
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        
        
        return response.json();
    })
    .then(data => {
        console.log('API Response:', data); 
        
        
        if (data.success && data.data) {
            
            displayDoctors(data.data);
        }
    })
    .catch(error => {
        console.error('Error fetching doctors:', error);
        alert('Error fetching doctors: ' + error.message);
    });
});



// Add similar functionality for patients and consultations
document.getElementById('fetch-patient').addEventListener('click', function() {
    const patientId = document.getElementById('patient-id').value;
    if (!patientId) {
        alert('Please enter a patient ID');
        return;
    }
    
    const authToken = localStorage.getItem('authToken');
    if (!authToken) {
        alert('Please login first');
        return;
    }
    
    fetch(`${API_BASE_URL}/Patients/${patientId}`, {
        headers: {
            'Authorization': `Bearer ${authToken}`
        }
    })
    .then(response => {
        // Check if response is OK (status 200-299)
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        
        // Parse the response as JSON
        return response.json();
    })
    .then(data => {
        console.log('API Response:', data); // Debugging
        
        if (data.success && data.data) {

            displayPatients(data.data);
        }
    })
    .catch(error => {
        console.error('Error fetching patients:', error);
        alert('Error fetching patients: ' + error.message);
    });
});



document.getElementById('fetch-consultation').addEventListener('click', function() {
    const consultationId = document.getElementById('consultation-id').value;
    if (!consultationId) {
        alert('Please enter a consultation ID');
        return;
    }
    
    const authToken = localStorage.getItem('authToken');
    if (!authToken) {
        alert('Please login first');
        return;
    }
    
    fetch(`${API_BASE_URL}/Consultations/${consultationId}`, {
        headers: {
            'Authorization': `Bearer ${authToken}`
        }
    })
    .then(response => {

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        
        // Parse the response as JSON
        return response.json();
    })
    .then(data => {
        console.log('API Response:', data); // Debugging
        
        if (data.success && data.data) {

            displayConsultations(data.data);
        }
    })
    .catch(error => {
        console.error('Error fetching consultations:', error);
        alert('Error fetching consultations: ' + error.message);
    });
});



function fetchAllDoctors() {
    const authToken = localStorage.getItem('authToken');
    if (!authToken) {
        alert('Please login first');
        return;
    }
    
    fetch(`${API_BASE_URL}/Doctors`, {
        headers: {
            'Authorization': `Bearer ${authToken}`
        }
    })
    .then(response => {
        
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        
        
        return response.json();
    })
    .then(data => {
        console.log('API Response:', data); 
        
        
        if (data.success && data.data) {
            
            displayDoctors(data.data);
        }
    })
    .catch(error => {
        console.error('Error fetching doctors:', error);
        alert('Error fetching doctors: ' + error.message);
    });
}



function fetchAllPatients() {
    const authToken = localStorage.getItem('authToken');
    if (!authToken) {
        alert('Please login first');
        return;
    }
    
    fetch(`${API_BASE_URL}/Patients`, {
        headers: {
            'Authorization': `Bearer ${authToken}`
        }
    })
    .then(response => {
        // Check if response is OK (status 200-299)
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        
        // Parse the response as JSON
        return response.json();
    })
    .then(data => {
        console.log('API Response:', data); // Debugging
        
        if (data.success && data.data) {

            displayPatients(data.data);
        }
    })
    .catch(error => {
        console.error('Error fetching patients:', error);
        alert('Error fetching patients: ' + error.message);
    });
}

function fetchAllConsultations() {
    const authToken = localStorage.getItem('authToken');
    if (!authToken) {
        alert('Please login first');
        return;
    }
    
    fetch(`${API_BASE_URL}/Consultations`, {
        headers: {
            'Authorization': `Bearer ${authToken}`
        }
    })
    .then(response => {

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        
        // Parse the response as JSON
        return response.json();
    })
    .then(data => {
        console.log('API Response:', data); // Debugging
        
        if (data.success && data.data) {

            displayConsultations(data.data);
        }
    })
    .catch(error => {
        console.error('Error fetching consultations:', error);
        alert('Error fetching consultations: ' + error.message);
    });
}