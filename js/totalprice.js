function calculatePrice() {
    var rentFrom = new Date(document.getElementById("rent-from").value);
    var rentTo = new Date(document.getElementById("rent-to").value);
    var days = Math.ceil((rentTo - rentFrom) / (1000 * 60 * 60 * 24));
    var basePrice = parseFloat(document.querySelector('.product-price').getAttribute('data-price'));
    var weeks = Math.ceil(days / 7); // Calculate number of weeks
    var quantity = parseInt(document.getElementById("quantity").value);
    
    console.log("Rent from:", rentFrom);
    console.log("Rent to:", rentTo);
    console.log("Days:", days);
    console.log("Base price:", basePrice);
    console.log("Weeks:", weeks);
    console.log("Quantity:", quantity);

    if(isNaN(weeks)){
      var totalPrice = basePrice * quantity;
      console.log("total:", totalPrice);
      document.getElementById("total-price").innerText = "₱" + totalPrice.toFixed(2);
      document.getElementById("total-price-display").value = totalPrice.toFixed(2);
    } else {
      var totalPrice = basePrice * weeks * quantity;
      console.log("total:", totalPrice);
      document.getElementById("total-price").innerText = "₱" + totalPrice.toFixed(2);
      document.getElementById("total-price-display").value = totalPrice.toFixed(2);
      document.querySelector('.addtocart').setAttribute('onclick', 'addToCart(this)');
    }
    
  }

  function decrementQuantity() {
    var quantityInput = document.getElementById("quantity");
    if (parseInt(quantityInput.value) > 1) {
      quantityInput.value = parseInt(quantityInput.value) - 1;
      calculatePrice();
    }
  }

  function incrementQuantity() {
    var quantityInput = document.getElementById("quantity");
    quantityInput.value = parseInt(quantityInput.value) + 1;
    calculatePrice();
  }

  function addToCart() {
    // Implement add to cart functionality here
    alert("Added to cart!");
  }

  function disablePastDates() {
    var today = new Date().toISOString().split('T')[0];
    document.getElementById('rent-from').setAttribute('min', today);
    document.getElementById('rent-to').setAttribute('min', today);
    
    var rentFromDate = document.getElementById('rent-from').value;
    var rentToDateInput = document.getElementById('rent-to');
    var rentToDate = new Date(rentFromDate);
    rentToDate.setDate(rentToDate.getDate() + 1);
    var minDate = rentToDate.toISOString().split('T')[0];
    rentToDateInput.setAttribute('min', minDate);
  }

  window.onload = function() {
      disablePastDates();
  };

