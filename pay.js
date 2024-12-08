// List of all countries
const countries = [
    "Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua and Barbuda", "Argentina", "Armenia", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria", "Burkina Faso", "Burundi", "Cabo Verde", "Cambodia", "Cameroon", "Canada", "Central African Republic", "Chad", "Chile", "China", "Colombia", "Comoros", "Congo (Congo-Brazzaville)", "Costa Rica", "Croatia", "Cuba", "Cyprus", "Czechia (Czech Republic)", "Democratic Republic of the Congo", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Eswatini (fmr. Swaziland)", "Ethiopia", "Fiji", "Finland", "France", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Grenada", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Honduras", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, North", "Korea, South", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia", "Montenegro", "Morocco", "Mozambique", "Myanmar (formerly Burma)", "Namibia", "Nauru", "Nepal", "Netherlands", "New Zealand", "Nicaragua", "Niger", "Nigeria", "North Macedonia", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Qatar", "Romania", "Russia", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Sudan", "Spain", "Sri Lanka", "Sudan", "Suriname", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Timor-Leste", "Togo", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States of America", "Uruguay", "Uzbekistan", "Vanuatu", "Vatican City (Holy See)", "Venezuela", "Vietnam", "Yemen", "Zambia", "Zimbabwe"
];

// Initialize country dropdown
const countrySelect = document.getElementById("country");
countries.forEach(country => {
    const option = document.createElement("option");
    option.value = country;
    option.textContent = country;
    countrySelect.appendChild(option);
});
M.FormSelect.init(countrySelect);

// Initialize Materialize Components
document.addEventListener("DOMContentLoaded", function () {
    M.Datepicker.init(document.querySelectorAll('.datepicker'), { format: 'yyyy-mm-dd' });
    M.Timepicker.init(document.querySelectorAll('.timepicker'));
    M.FormSelect.init(document.querySelectorAll('select'));
});

// Update total cost based on selected services
const serviceCheckboxes = document.querySelectorAll('.service-checkbox');
const totalCostElement = document.getElementById("totalCost");
let totalCost = 0;

serviceCheckboxes.forEach(checkbox => {
    checkbox.addEventListener("change", function () {
        if (this.checked) {
            totalCost += parseInt(this.getAttribute('data-price'));
        } else {
            totalCost -= parseInt(this.getAttribute('data-price'));
        }
        totalCostElement.textContent = `$${totalCost}`;
        validateForm(); // Revalidate form when service selection changes
    });
});

// Enable or disable submit button based on verification checkbox
const verificationCheckbox = document.getElementById("verificationCheckbox");
const submitBtn = document.getElementById("submitBtn");

verificationCheckbox.addEventListener("change", function () {
    validateForm(); // Revalidate form when checkbox changes
});

// Enable/disable submit button based on form validation
function validateForm() {
    const isFormValid = bookingForm.checkValidity();
    const areServicesSelected = document.querySelectorAll('.service-checkbox:checked').length > 0;
    const isVerificationChecked = verificationCheckbox.checked;

    // All conditions must be true to enable the submit button
    submitBtn.disabled = !(isFormValid && areServicesSelected && isVerificationChecked);
}

// Monitor form inputs for validation
const bookingForm = document.getElementById("bookingForm");
bookingForm.addEventListener("input", validateForm);

// Handle form submission
bookingForm.addEventListener("submit", function (event) {
    event.preventDefault();

    if (submitBtn.disabled) {
        M.toast({ html: 'Please fill in all required fields, select at least one service, and confirm the details.' });
        return;
    }

    // Capture form data
    const selectedServices = [];
    serviceCheckboxes.forEach(checkbox => {
        if (checkbox.checked) {
            selectedServices.push(checkbox.value);
        }
    });

    // Store form data in sessionStorage for passing to the payment summary page
    sessionStorage.setItem('userData', JSON.stringify({
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        address: document.getElementById('address').value,
        country: document.getElementById('country').value,
        state: document.getElementById('state').value,
        date: document.getElementById('date').value,
        time: document.getElementById('time').value,
        services: selectedServices,
        totalCost: totalCost
    }));

    // Redirect to payment summary page
    window.location.href = 'payment_summary.html'; // Change the URL to your actual payment summary page
});

// Handle form submission process and UI reset
bookingForm.addEventListener("submit", function (event) {
    event.preventDefault();

    if (submitBtn.disabled) {
        M.toast({ html: 'Please fill in all required fields, select at least one service, and confirm the details.' });
        return;
    }

    M.toast({ html: 'Booking successful! We will contact you shortly.' });

    // Clear the form and reset the UI
    bookingForm.reset();

    // Reinitialize Materialize components after reset
    M.updateTextFields();
    M.FormSelect.init(countrySelect);
    totalCost = 0;
    totalCostElement.textContent = `$${totalCost}`;
    submitBtn.disabled = true;
});
