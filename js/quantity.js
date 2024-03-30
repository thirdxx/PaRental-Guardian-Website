function incrementQuantity(quantityInput) {
  var currentValue = parseInt(quantityInput.value);
  quantityInput.value = currentValue + 1;
}

function decrementQuantity(quantityInput) {
  var currentValue = parseInt(quantityInput.value);
  if (currentValue > 1) {
    quantityInput.value = currentValue - 1;
  }
}
