function calculatePrice() {
    var rentFrom = new Date(document.getElementById("rent-from").value);
    var rentTo = new Date(document.getElementById("rent-to").value);
    var days = Math.ceil((rentTo - rentFrom) / (1000 * 60 * 60 * 24));
    var basePrice = parseFloat(document.querySelector('.product-price').getAttribute('data-price'));
    var weeks = Math.ceil(days / 7); // Calculate number of weeks
    var quantity = parseInt(document.getElementById("quantity").value);
    var totalPrice = basePrice * weeks * quantity;

    document.getElementById("total-price").innerText = "Total Price: ₱" + totalPrice.toFixed(2);
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