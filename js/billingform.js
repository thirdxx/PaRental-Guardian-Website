 document.addEventListener('DOMContentLoaded', function() {
    var textareas = document.querySelectorAll('textarea');
    textareas.forEach(function(textarea) {
      textarea.addEventListener('input', function() {
        if (this.validity.valid) {
          this.classList.remove('error');
        } else {
          this.classList.add('error');
        }
      });
    });
  });
  document.addEventListener('DOMContentLoaded', function() {
    var textareas = document.querySelectorAll('textarea');
    textareas.forEach(function(textarea) {
      textarea.addEventListener('input', function() {
        if (this.value.trim() !== '') {
          this.classList.add('filled');
        } else {
          this.classList.remove('filled');
        }
      });
    });
  });
  