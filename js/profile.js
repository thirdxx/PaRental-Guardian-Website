// Populate dropdowns with options
const dayDropdown = document.getElementById('dayDropdownContent');
const monthDropdown = document.getElementById('monthDropdownContent');
const yearDropdown = document.getElementById('yearDropdownContent');

for (let i = 1; i <= 31; i++) {
  const option = document.createElement('a');
  option.textContent = i;
  option.onclick = function() {
    document.getElementById('dayDropdown').textContent = this.textContent;
  };
  dayDropdown.appendChild(option);
}

const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
months.forEach((month, index) => {
  const option = document.createElement('a');
  option.textContent = month;
  option.onclick = function() {
    document.getElementById('monthDropdown').textContent = this.textContent;
  };
  monthDropdown.appendChild(option);
});

const currentYear = new Date().getFullYear();
for (let i = currentYear; i >= 1910; i--) {
  const option = document.createElement('a');
  option.textContent = i;
  option.onclick = function() {
    document.getElementById('yearDropdown').textContent = this.textContent;
  };
  yearDropdown.appendChild(option);
}

// Toggle dropdown content
document.addEventListener('click', function(event) {
  const dropdowns = document.getElementsByClassName('dropdown-content');
  for (let i = 0; i < dropdowns.length; i++) {
    const dropdownContent = dropdowns[i];
    if (event.target.matches('.dropbtn') && event.target.nextElementSibling === dropdownContent) {
      dropdownContent.classList.toggle('show');
    } else {
      dropdownContent.classList.remove('show');
    }
  }
});

function addBirthday() {
  const day = document.getElementById('dayDropdown').textContent;
  const month = document.getElementById('monthDropdown').textContent;
  const year = document.getElementById('yearDropdown').textContent;
  if (day === 'Day' || month === 'Month' || year === 'Year') {
    alert('Please select a valid date.');
    return;
  }
  const birthday = `${month} ${day}, ${year}`;
  const birthdayList = document.getElementById('birthdayList');
  const birthdayItem = document.createElement('li');
  birthdayItem.textContent = birthday;
  birthdayList.appendChild(birthdayItem);
}
