function addToCart(button) {
  var icon = button.querySelector("i");

  // Toggle text and icon
  if (button.classList.contains("added-to-cart")) {
    button.innerHTML = "Add to cart <i class='fas fa-arrow-right'></i>";
    button.classList.remove("added-to-cart");
  } else {
    button.innerHTML = "Added to cart <i class='fas fa-check'></i>";
    button.classList.add("added-to-cart");
  }
  // Implement add to cart functionality here
  alert("Added to cart!");
    // Get the cart count element
  var cartCountElement = document.getElementById('cartCount');
  
  // Increment the cart count by 1
  var cartCount = parseInt(cartCountElement.innerText);
  cartCountElement.innerText = cartCount + 1;
}

// function addToCart(button) {
//   // Get the cart count element
//   var cartCountElement = document.getElementById('cartCount');
  
//   // Increment the cart count by 1
//   var cartCount = parseInt(cartCountElement.innerText);
//   cartCountElement.innerText = cartCount + 1;
// }